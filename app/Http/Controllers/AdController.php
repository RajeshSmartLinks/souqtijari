<?php
// DI CODE - Start
namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Newly Added
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;
use App\Mail\CreateAd;
use App\Models\Ad;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Area;
use App\Models\User;
use App\Models\Favourite;
use App\Models\Post;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

// For Date Format

class AdController extends Controller
{
    public function index(Request $request)
    {
        //Visitors Count - Start
        $data = [
            "sessionid" => session()->getId(),
            "ipaddress" => request()->ip(),
            "date" => date('Y-m-d'),
        ];
        $data_update = [
            "sessionid" => session()->getId(),
            "ipaddress" => request()->ip(),
        ];

        Visitor::updateOrCreate($data, $data_update);
        //Visitor::Create($data);
        // Visitors Count - End

        $lang = app()->getLocale();
        $cat_name = 'parentcat_' . $lang;
        $location = 'location_' . $lang;
        $name = 'name_' . $lang;

        $catslug = $request->catname;
        $userid = $request->user;
        $locslug = $request->location;
        $inpage = '';
        $ad_condition_value = '';

        $searchtext = '';

        $ad_condition_used = $request->session()->get('ad_condition_used');
        $ad_condition_new = $request->session()->get('ad_condition_new');

        $minprice = $request->session()->get('minprice');
        $maxprice = $request->session()->get('maxprice');

        $allads = Ad::select('ads.*', 'pc.name_en as parentcat_en', 'pc.name_ar as parentcat_ar',
            //'ads_images.ads_image',
            'areas.name_en as location_en', 'areas.name_ar as location_ar')
            //->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')
            ->leftjoin('areas', 'ads.ad_location_area', '=', 'areas.id')
            ->leftjoin('categories as pc', 'ads.ad_category_id', '=', 'pc.id');


        // User - Listing
        if (isset($userid)) {
            $inpage = 'userid';
            if (is_numeric($userid)) {
                if (empty($request->session()->get('categoryval'))) { // For Search Filer to show all records
                    $allads = $allads->where('ads.ad_user_id', $userid);
                }
            } else {
                $allads = $allads->where('ads.ad_user_id');
            }
        }
        // Location - Listing
        if (isset($locslug)) {
            $inpage = 'locslug';
            $locations = Area::where('slug', $locslug)->first();
            if ($locations) {
                if (empty($request->session()->get('categoryval'))) { // For Search Filer to show all records
                    $allads = $allads->where('ads.ad_location_area_cat', $locations->id);
                }
            } else {
                $allads = $allads->where('ads.ad_location_area_cat');
            }
        }

        // Search Filters - Search Keyword
        if (!empty($request->session()->get('search_text'))) {
            $searchtext = $request->session()->get('search_text');
            $allads = $allads->where('ads.ad_title', 'like', '%' . $searchtext . '%')->orWhere('ads.ad_description', 'like', '%' . $searchtext . '%');
            //$request->session()->forget('search_text');
        }

        // Search Filters - Categories
        $categoryval = array();
        $catarray = array();
        if (!empty($request->session()->get('categoryval'))) {
            $inpage = 'searchpage';
            $categoryval = $request->session()->get('categoryval');

            foreach ($categoryval as $catslugname) {
                $categories = Category::where('slug', $catslugname)->first();
                $catarray[] = $categories->id;
            }
            $allads = $allads->whereIn('ads.ad_category_id', $catarray);
            //$request->session()->forget('categoryval');
        } else if (isset($catslug)) {
            //echo $name = Route::currentRouteName();
            if (Route::currentRouteName() != 'ad.search') {
                // Category - Listing
                $inpage = 'catslug';
                $categories = Category::where('slug', $catslug)->first();
                if ($categories) {
                    $allads = $allads->where('ads.ad_category_id', $categories->id);
                } else {
                    $allads = $allads->where('ads.ad_category_id');
                }
            }

        }

        // Search Filters - Condition
        if (!empty($ad_condition_new) || !empty($ad_condition_used)) {
            if (!empty($ad_condition_new)) {
                $allads = $allads->where('ads.ad_condition', $ad_condition_new);
                $ad_condition_value = $ad_condition_new;
                //$request->session()->forget('ad_condition_new');
            }
            if (!empty($ad_condition_used)) {
                $allads = $allads->where('ads.ad_condition', $ad_condition_used);
                $ad_condition_value = $ad_condition_used;
                //$request->session()->forget('ad_condition_used');
            }
        }

        // Search Filters - Price Range
        if (!empty($minprice) && !empty($maxprice)) {
            $allads = $allads->whereBetween('ads.ad_price', [$minprice, $maxprice]);
            //$request->session()->forget('minprice');
            //$request->session()->forget('maxprice');
        }

        //$allads = $allads->where('ads.status','1')->groupBy('ads.id')->orderbydesc('ads.id')->dd();
        $allads = $allads->where('ads.status', '1')->groupBy('ads.id')->orderbydesc('ads.ad_priority')->Paginate(25);
        //$allads = $allads->where('ads.status','1')->groupBy('ads.id')->orderbydesc('ads.id')->simplePaginate(9);


        $ad = array();
        if ($allads) {
            foreach ($allads as $allad) {
                // Logged in user - Favourite Ads
                $user = auth()->user();
                $fav_val = '';
                if ($user) {
                    $favourite = Favourite::where(['status' => '1', 'ads_ad_id' => $allad->id, 'user_id' => $user->id])->first();
                    if ($favourite) {
                        $fav_val = 'Favourite';
                    }
                }

                $ad_price = explode('.', $allad->ad_price);
                $image = asset(Ad::$noImageUrl);
                $adfeatureimage = DB::table('ads_images')->where(['ads_ad_id' => $allad->id, 'is_feature' => '1', 'deleted_at' => null,])->first();
                if ($adfeatureimage && File::exists(public_path(Ad::$imageThumbUrl.$adfeatureimage->ads_image))) {
                    //$adimage = $adfeatureimage;
                    $image = asset(Ad::$imageThumbUrl . $adfeatureimage->ads_image);
                } else {
                    $adImages = DB::table('ads_images')->where(['ads_ad_id' => $allad->id, 'deleted_at' => null,])->get();
                    foreach($adImages as $indiviualimage){
                        if(File::exists(public_path(Ad::$imageThumbUrl.$indiviualimage->ads_image))){
                            $image = asset(Ad::$imageThumbUrl . $indiviualimage->ads_image);
                            break;
                        }
                    }
                    //$adimage = $adfeatureimage;
                }

                $ad[] = [
                    'detail_url' => route('viewad', [app()->getLocale(), $allad->slug]),
                    'ad_id' => $allad->id,
                    'ad_title' => $allad->ad_title,
                    'ad_description' => strip_tags(substr($allad->ad_description, 0, 150)) . ' ...',
                    'ad_price' => $ad_price[0],
                    'ad_condition' => ucfirst($allad->ad_condition),
                    'ad_location' => $allad->$location,
                    'ad_is_featured' => $allad->ad_is_featured,
                    //"ad_image" => !empty($adimage->ads_image) ? asset(Ad::$imageThumbUrl . $adimage->ads_image) : asset(Ad::$noImageUrl),
                    "ad_image" => $image,
                    'ad_cat_name' => $allad->$cat_name,
                    "favourite" => $fav_val,
                ];
            }
        }

        // Categories List
        $dataCategory = array();
        $categories = Category::select('categories.id', 'categories.name_en', 'categories.name_ar', 'categories.slug', 'categories.image', DB::raw('COUNT(' . DB::getTablePrefix() . 'ads.ad_category_id) as catcount'))
            ->leftJoin('ads', 'categories.id', '=', 'ads.ad_category_id')
            ->where('categories.category_id', '0')
            ->where('ads.status', '1')
            ->whereNull('ads.deleted_at')
            ->groupBy('categories.id')
            ->orderByDesc('catcount')
            ->get();
        if ($categories->count() > 0) {
            foreach ($categories as $category) {
                $dataCategory[] = [
                    "id" => $category->id,
                    "name" => $category->$name,
                    "slug" => $category->slug,
                    "adsCountCategory" => $category->catcount,
                ];
            }
        }

        $allads_price = Ad::select('ads.*')->where('ads.status', '1')->get();
        $adprice = array();
        foreach ($allads_price as $alladprice) {
            $adprice[] = $alladprice->ad_price;
        }
        $minpricevalue = min($adprice);
        $maxpricevalue = max($adprice);

        // Default Price Range without --- Search Filters - Price Range
        if (empty($minprice) && empty($maxprice)) {
            $minprice = $minpricevalue;
            $maxprice = $maxpricevalue;
            //$request->session()->forget('minprice');
            //$request->session()->forget('maxprice');
        }

        $titles = ["title" => 'Ads List'];
        $data = [
            'allads' => $ad,
            'alladspagination' => $allads,
            'inpage' => $inpage,
            'catname' => $request->catname,
            'user' => $request->user,
            'location' => $request->location,
            'ad_condition_value' => $ad_condition_value,
            'categories' => $dataCategory,
            'categoryval' => $categoryval,
            'minpricevalue' => $minpricevalue,
            'maxpricevalue' => $maxpricevalue,
            'minprice' => $minprice,
            'maxprice' => $maxprice,
            'searchtext' => $searchtext,
        ];

        return view('front.ad.list', compact('titles', 'data'));
    }

    public function doSearch(Request $request)
    {
        $request->session()->put('search_text', $request->search_text);
        $request->session()->put('categoryval', $request->categoryval);
        //$request->session()->push('categoryval', 'developers');
        $request->session()->put('minprice', $request->minprice);
        $request->session()->put('maxprice', $request->maxprice);
        $request->session()->put('ad_condition_new', $request->ad_condition_new);
        $request->session()->put('ad_condition_used', $request->ad_condition_used);
        //session()->getId();

        return ["status" => 200, "message" => trans("app.success")];
    }

    //public function viewad(Request $request, $lang, $id)
    public function viewad(Request $request)
    {
        //Visitors Count - Start
        $data = [
            "sessionid" => session()->getId(),
            "ipaddress" => request()->ip(),
            "date" => date('Y-m-d'),
        ];
        $data_update = [
            "sessionid" => session()->getId(),
            "ipaddress" => request()->ip(),
        ];

        Visitor::updateOrCreate($data, $data_update);
        //Visitor::Create($data);
        // Visitors Count - End

        $lang = app()->getLocale();

        $location = 'location_' . $lang;
        $parent_cat = 'parent_cat_' . $lang;
        $sub_cat = 'sub_cat_' . $lang;
        $brand = 'brand_' . $lang;

        //$Ad			= Ad::find($request->id);
        $Ad = Ad::select('ads.*', 'areas.name_en as location_en', 'areas.name_ar as location_ar', 'users.avatar', 'users.facebook', 'users.twitter', 'users.created_at as userdate', 'pc.name_en as parent_cat_en', 'pc.name_ar as parent_cat_ar', 'pc.slug as parent_cat_slug', 'sc.name_en as sub_cat_en', 'sc.name_ar as sub_cat_ar', 'brands.name_en as brand_en', 'brands.name_ar as brand_ar')
            ->leftjoin('areas', 'ads.ad_location_area', '=', 'areas.id')
            ->leftjoin('users', 'ads.ad_user_id', '=', 'users.id')
            ->leftjoin('categories as pc', 'ads.ad_category_id', '=', 'pc.id')
            ->leftjoin('categories as sc', 'ads.ad_sub_category_id', '=', 'sc.id')
            ->leftjoin('brands', 'ads.ad_brand_id', '=', 'brands.id')
            //->where('ads.id', '=', $request->id)->first();
            ->where('ads.status', '=', '1')
            ->where('ads.slug', '=', $request->id)->first();
        if ($Ad) {
            $Ad->ad_views = $Ad->ad_views + 1;
            $Ad->save();

            // Ads Images
            $adsimages = DB::table('ads_images')
                ->select('*')
                ->where('ads_ad_id', '=', $Ad->id)
                ->orderby('is_feature', 'desc')
                ->get();
            $gallery = array();
            foreach ($adsimages as $media) {
                $imageMainUrl = Ad::$imageUrl;
                if(file_exists($imageMainUrl . $media->ads_image)){
                    $gallery[] = $media->ads_image;

                    // Check the Medium and thumb is there
                    $mediumPath = Ad::$imageMediumPath;
                    if (!file_exists($mediumPath . $media->ads_image)) {
                        // Make the Medium Image
                        try {
                            $processImage = Image::make(Ad::$imagePath . $media->ads_image);
                        } catch (NotReadableException $e) {
                            // If error, stop and continue looping to next iteration
                            continue;
                        }
                        // resize the image to a width of 500 and constrain aspect ratio (auto height)
                        $processImage->resize(500, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $processImage->save($mediumPath . $media->ads_image);
                    }

                }
                
            }

            // Related Ads
            $relatedAds = Ad::select('ads.*', 'areas.name_en as location_en', 'areas.name_ar as location_ar', 'users.name as username', 'users.mobile as usermobile', 'pc.name_en as parent_cat_en', 'pc.name_ar as parent_cat_ar', 'sc.name_en as sub_cat_en', 'sc.name_ar as sub_cat_ar', 'brands.name_en as brand_en', 'brands.name_ar as brand_ar', 'ads_images.ads_image')
                ->leftjoin('areas', 'ads.ad_location_area', '=', 'areas.id')
                ->leftjoin('users', 'ads.ad_user_id', '=', 'users.id')
                ->leftjoin('categories as pc', 'ads.ad_category_id', '=', 'pc.id')
                ->leftjoin('categories as sc', 'ads.ad_sub_category_id', '=', 'sc.id')
                ->leftjoin('brands', 'ads.ad_brand_id', '=', 'brands.id')
                ->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')
                ->where('ads.ad_sub_category_id', '=', $Ad->ad_sub_category_id)
                ->groupBy('ads.id')->take(6)->get();
            $related = array();
            if ($relatedAds) {
                foreach ($relatedAds as $relatedAd) {
                    $ad_price = explode('.', $relatedAd->ad_price);
                    // $adfeatureimage = DB::table('ads_images')->where(['ads_ad_id' => $relatedAd->id, 'is_feature' => '1', 'deleted_at' => null,])->first();
                    // if ($adfeatureimage) {
                    //     $adimage = $adfeatureimage;
                    // } else {
                    //     $adfeatureimage = DB::table('ads_images')->where(['ads_ad_id' => $relatedAd->id, 'deleted_at' => null,])->first();
                    //     $adimage = $adfeatureimage;
                    // }
                    $image = asset(Ad::$noImageUrl);
                    $adfeatureimage = DB::table('ads_images')->where(['ads_ad_id' => $relatedAd->id, 'is_feature' => '1', 'deleted_at' => null])->first();
                    if ($adfeatureimage && File::exists(public_path(Ad::$imageThumbUrl.$adfeatureimage->ads_image))) {
                        //$adimage = $adfeatureimage;
                        $image = asset(Ad::$imageThumbUrl . $adfeatureimage->ads_image);
                    } else {
                        $adImages = DB::table('ads_images')->where(['ads_ad_id' => $relatedAd->id, 'deleted_at' => null,])->get();
                        foreach($adImages as $indiviualimage){
                            if(File::exists(public_path(Ad::$imageThumbUrl.$indiviualimage->ads_image))){
                                $image = asset(Ad::$imageThumbUrl . $indiviualimage->ads_image);
                                break;
                            }
                        }
                        //$adimage = $adfeatureimage;
                    }
                    $related[] = [
                        'detail_url' => route('viewad', [app()->getLocale(), $relatedAd->slug]),
                        'ad_title' => $relatedAd->ad_title,
                        'ad_location' => $relatedAd->$location,
                        'ad_created' => Carbon::parse($relatedAd->created_at)->diffForHumans(),
                        'ad_price' => $ad_price[0],
                        'ad_description' => strip_tags(substr($relatedAd->ad_description, 0, 90)) . '...',
                        'ad_is_featured' => $relatedAd->ad_is_featured,
                        'ad_username' => $relatedAd->username,
                        'ad_usermobile' => $relatedAd->usermobile,
                        //"ad_image" => !empty($adimage->ads_image) ? asset(Ad::$imageThumbUrl . $adimage->ads_image) : asset(Ad::$noImageUrl),
                        'ad_image' => $image,
                    ];
                }
            }

            // Logged in user - Favourite Ads
            $user = auth()->user();
            $fav_val = '';
            if ($user) {
                $favourite = Favourite::where(['status' => '1', 'ads_ad_id' => $Ad->id, 'user_id' => $user->id])->first();
                if ($favourite) {
                    $fav_val = 'Favourite';
                }
            }

            $breacrumbs = '<a href="' . route('ad.category.list', [app()->getLocale(), $Ad->parent_cat_slug]) . '">' . $Ad->$parent_cat . ' / ' . $Ad->$sub_cat . '</a>';
            $titles = ["title" => $Ad->ad_title, "breadcrumbs" => $breacrumbs];

            $lang = app()->getLocale();
            $title = 'title_' . $lang;
            $description = 'description_' . $lang;
            $safetytips = Post::whereSlug('safety-tips-for-buyers')->first();

            $ad_price = explode('.', $Ad->ad_price);

            $data = [
                'detail_url' => route('viewad', [app()->getLocale(), $Ad->slug]),
                'ad_id' => $Ad->id,
                'ad_title' => $Ad->ad_title,
                'ad_location' => $Ad->$location,
                'ad_cat' => $Ad->$parent_cat,
                'ad_subcat' => $Ad->$sub_cat,
                'ad_brand' => $Ad->$brand,
                'ad_condition' => ucfirst($Ad->ad_condition),
                'ad_created' => $Ad->created_at->diffForHumans(),
                'ad_views' => !empty($Ad->ad_views) ? $Ad->ad_views : '0',
                'ad_price' => $ad_price[0],
                'ad_description' => strip_tags($Ad->ad_description),
                'ad_is_negotiable' => $Ad->ad_is_negotiable,
                'ad_user_avatar' => showAvatar($Ad->avatar),
                'ad_user_facebook' => $Ad->facebook,
                'ad_user_twitter' => $Ad->twitter,
                //'ad_userdate'			=> $Ad->userdate->diffForHumans(),
                'ad_userdate' => Carbon::parse($Ad->userdate)->diffForHumans(),
                'ad_seller_name' => $Ad->ad_seller_name,
                'ad_seller_email' => $Ad->ad_seller_email,
                'ad_seller_phone' => $Ad->ad_seller_phone,
                'ad_seller_whatsapp' => $Ad->ad_seller_whatsapp,
                'ad_seller_address' => $Ad->ad_seller_address,
                'adsimages' => $gallery,
                'related_ads' => $related,
                "favourite" => $fav_val,
                'user_url' => route('ad.user.list', [app()->getLocale(), $Ad->ad_user_id]),
                'safety_slug' => $safetytips->slug,
                'safety_title' => $safetytips->$title,
                'safety_description' => explode('|', strip_tags($safetytips->$description)),

            ];

            return view('front.ad.view', compact('titles', 'data'));
        }
        //abort(404);
        return redirect()->route('home', app()->getLocale());
    }

    public function createad(Request $request)
    {
        $titles = ["title" => trans("app.adpost"),];

        $categories = Category::with('parent')->get();
        $areas = Area::with('parent')->get();

        $user = auth()->user();
        $userdetails = User::find($user->id);

        if (!empty($userdetails->first_name) && !empty($userdetails->last_name)) {
            $fullname = $userdetails->first_name . ' ' . $userdetails->last_name;
        } else {
            $fullname = $userdetails->name;
        }

        $ads_images = DB::table('ads_images')->where(['ads_user_id' => $user->id, 'ads_ad_id' => null])->get();
        $dataImage = array();
        if ($ads_images->count() > 0) {
            foreach ($ads_images as $ads_image) {
                $dataImage[] = [
                    "id" => $ads_image->id,
                    "is_feature" => $ads_image->is_feature,
                    "adimage" => $ads_image->ads_image,
                    "adimage_url" => asset(Ad::$imageThumbUrl . $ads_image->ads_image),
                ];
            }
        }

        $lang = app()->getLocale();
        $title = 'title_' . $lang;
        $description = 'description_' . $lang;
        $safetytips = Post::whereSlug('safety-tips-for-buyers')->first();

        $data = [
            'categories' => $categories,
            'areas' => $areas,
            'ads_images' => $dataImage,
            'user_seller_name' => $fullname,
            'user_seller_email' => $userdetails->email,
            'user_seller_mobile' => $userdetails->mobile,
            'user_seller_whatsapp' => $userdetails->whatsapp,
            'user_seller_address' => $userdetails->address,
            'safety_slug' => $safetytips->slug,
            'safety_title' => $safetytips->$title,
            'safety_description' => explode('|', strip_tags($safetytips->$description)),
        ];
        return view('front.ad.create', compact('titles', 'data'));
    }

    public function adcreate(Request $request)
    {
        $this->validate($request, [
            'ad_category_id' => 'required',
            'ad_sub_category_id' => 'required',
            'ad_title' => 'required',
            'ad_description' => 'required',
            'ad_location_area' => 'required',
            'ad_condition' => 'required',
            'ad_price' => 'required',
            'ad_seller_name' => 'required',
            'ad_seller_email' => 'email',
            'ad_seller_phone' => 'required',
            //'ad_image.*' => 'image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $data = array();

        $data['ad_category_id'] = $request->ad_category_id;
        $data['ad_sub_category_id'] = $request->ad_sub_category_id;
        $data['ad_brand_id'] = $request->ad_brand_id;
        $data['ad_title'] = $request->ad_title;
        $data['slug'] = unique_slug($request->ad_title, 'Ad');
        $data['ad_description'] = $request->ad_description;
        $data['ad_location_area'] = $request->ad_location_area;
        $ad_location_area_cat = Area::where('id', $request->ad_location_area)->first();
        $data['ad_location_area_cat'] = $ad_location_area_cat->area_id;
        $data['ad_condition'] = $request->ad_condition;
        $data['ad_price'] = $request->ad_price;
        if ($request->ad_is_negotiable) {
            $data['ad_is_negotiable'] = $request->ad_is_negotiable;
        }
        $data['ad_seller_name'] = $request->ad_seller_name;
        $data['ad_seller_email'] = $request->ad_seller_email;
        $data['ad_seller_phone'] = $request->ad_seller_phone;
        $data['ad_seller_whatsapp'] = $request->ad_seller_whatsapp;
        $data['ad_seller_address'] = $request->ad_seller_address;

        $user = auth()->user();
        $data['ad_user_id'] = $user->id;

        $create_Ad = Ad::create($data);

        //Add Images
        /*$images = $request->file('ad_image');
        if ($images) {
            for ($i = 0; $i < count($images); $i++) {
                $image = $images[$i];
                if ($image != NULL) {
                    $newFileName = sha1(date('YmdHis')) . '-' . $image->getClientOriginalName();
                    $originalPath = Ad::$imagePath;
                    $mediumPath = Ad::$imageMediumPath;
                    $thumbPath = Ad::$imageThumbPath;

                    // Image Upload Process
                    $processImage = Image::make($image);
                    $processImage->save($originalPath . $newFileName);

                    // resize the image to a width of 500 and constrain aspect ratio (auto height)
                    $processImage->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $processImage->save($mediumPath . $newFileName);

                    // resize the image to a width of 250 and constrain aspect ratio (auto height)
                    $processImage->resize(250, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $processImage->save($thumbPath . $newFileName);

					DB::insert('INSERT INTO '.DB::getTablePrefix().'ads_images (`ads_ad_id`, `ads_user_id`, `ads_image`, `created_at`, `updated_at`) VALUES (?,?,?,?,?)', [$create_Ad->id, $user->id, $newFileName, now(), now()]);
                }
            }
        }*/


        if ($create_Ad) {
            //Attach all unused media with this ad
            DB::table('ads_images')->where(['ads_user_id' => $user->id, 'ads_ad_id' => null])->update(['ads_ad_id' => $create_Ad->id]);

            // Mail
            $userdetails = User::find($user->id);
            if (!empty($userdetails->first_name) && !empty($userdetails->last_name)) {
                $fullname = $userdetails->first_name . ' ' . $userdetails->last_name;
            } else {
                $fullname = $userdetails->name;
            }
            $adsimages = DB::table('ads_images')->select('*')->where('ads_ad_id', '=', $create_Ad->id)->first();
            if ($adsimages) {
                $ad_image = asset(Ad::$imageThumbUrl . $adsimages->ads_image);
            } else {
                $ad_image = '';
            }

            if (!empty($userdetails->email)) {
                $maildetails = [
                    'subject' => trans("app.createad_mail_subject"),
                    'title' => trans("app.createad_mail_title"),
                    'name' => $fullname,
                    'note' => trans("app.createad_mail_note"),
                    'content' => '',
                    'lang' => app()->getLocale(),
                    'ad_title' => $request->ad_title,
                    'ad_image' => $ad_image,
                    'ad_price' => $request->ad_price,
                    'ad_url' => route('viewad', [app()->getLocale(), $create_Ad->slug]),
                    'user_url' => route('ad.user.list', [app()->getLocale(), $create_Ad->ad_user_id]),
                ];
                Mail::to($userdetails->email)->send(new CreateAd($maildetails));
            }
        }

        return redirect()->route('user.ads', app()->getLocale())->with('success', trans("app.created_successfully"));
        //return redirect()->route('createad', app()->getLocale())->with('success', 'Created Successfully');
    }

    public function showedit(Request $request)
    {
        $titles = ['title' => 'Edit Ad'];
        $editAd = Ad::find($request->id);
        $categories = Category::with('parent')->get();
        $subcategories = Category::with('child')->where('category_id', '=', $editAd->ad_category_id)->get();
        $areas = Area::with('parent')->get();
        $brands = Brand::select('*')
            ->where('category_id', '=', $editAd->ad_sub_category_id)
            ->get();
        $adsimages = DB::table('ads_images')
            ->select('*')
            ->where('ads_ad_id', '=', $editAd->id)
            ->get();
        // Preview the image directly in the page
        $user = auth()->user();
        $ads_images = DB::table('ads_images')->where(['ads_user_id' => $user->id, 'ads_ad_id' => null])->get();
        $dataImage = array();
        if ($ads_images->count() > 0) {
            foreach ($ads_images as $ads_image) {
                $dataImage[] = [
                    "id" => $ads_image->id,
                    "is_feature" => $ads_image->is_feature,
                    "adimage" => $ads_image->ads_image,
                    "adimage_url" => asset(Ad::$imageThumbUrl . $ads_image->ads_image),
                ];
            }
        }

        $lang = app()->getLocale();
        $title = 'title_' . $lang;
        $description = 'description_' . $lang;
        $safetytips = Post::whereSlug('safety-tips-for-buyers')->first();

        $data = [
            'categories' => $categories,
            'subcategories' => $subcategories,
            'areas' => $areas,
            'brands' => $brands,
            'adsimages' => $adsimages,
            'ads_images' => $dataImage, // Preview the image directly in the page
            'safety_slug' => $safetytips->slug,
            'safety_title' => $safetytips->$title,
            'safety_description' => explode('|', strip_tags($safetytips->$description)),
        ];
        return view('front.ad.edit', compact('titles', 'data', 'editAd'));
    }

    public function doedit(Request $request)
    {
        $this->validate($request, [
            'ad_category_id' => 'required',
            'ad_sub_category_id' => 'required',
            'ad_title' => 'required',
            'ad_description' => 'required',
            'ad_location_area' => 'required',
            'ad_condition' => 'required',
            'ad_price' => 'required',
            'ad_seller_name' => 'required',
            'ad_seller_email' => 'required|email',
            'ad_seller_phone' => 'required',
            //'ad_image.*' => 'image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $data = array();


        $ad = Ad::find($request->ad_id);

        $ad->ad_category_id = $request->ad_category_id;
        $ad->ad_sub_category_id = $request->ad_sub_category_id;
        $ad->ad_brand_id = $request->ad_brand_id;
        $ad->ad_title = $request->ad_title;
        //$ad->slug				= unique_slug($request->ad_title, 'Ad');
        $ad->ad_description = $request->ad_description;
        $ad->ad_location_area = $request->ad_location_area;
        $ad_location_area_cat = Area::where('id', $request->ad_location_area)->first();
        $ad->ad_location_area_cat = $ad_location_area_cat->area_id;
        $ad->ad_condition = $request->ad_condition;
        $ad->ad_price = $request->ad_price;
        if ($request->ad_is_negotiable) {
            $ad->ad_is_negotiable = $request->ad_is_negotiable;
        }
        $ad->ad_seller_name = $request->ad_seller_name;
        $ad->ad_seller_email = $request->ad_seller_email;
        $ad->ad_seller_phone = $request->ad_seller_phone;
        $ad->ad_seller_whatsapp = $request->ad_seller_whatsapp;
        $ad->ad_seller_address = $request->ad_seller_address;

        $user = auth()->user();
        /*$ad->ad_user_id	= $user->id;*/

        $updated_ad = $ad->save();

        //Add Images
        /*$images = $request->file('ad_image');
        if ($images) {
            for ($i = 0; $i < count($images); $i++) {
                $image = $images[$i];
                if ($image != NULL) {
                    $newFileName = sha1(date('YmdHis')) . '-' . $image->getClientOriginalName();
                    $originalPath = Ad::$imagePath;
                    $mediumPath = Ad::$imageMediumPath;
                    $thumbPath = Ad::$imageThumbPath;

                    // Image Upload Process
                    $processImage = Image::make($image);
                    $processImage->save($originalPath . $newFileName);

                    // resize the image to a width of 500 and constrain aspect ratio (auto height)
                    $processImage->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $processImage->save($mediumPath . $newFileName);

                    // resize the image to a width of 250 and constrain aspect ratio (auto height)
                    $processImage->resize(250, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $processImage->save($thumbPath . $newFileName);

					DB::insert('INSERT INTO '.DB::getTablePrefix().'ads_images (`ads_ad_id`, `ads_user_id`, `ads_image`, `created_at`, `updated_at`) VALUES (?,?,?,?,?)', [$ad->id, $user->id, $newFileName, now(), now()]);
                }
            }
        }*/
        if ($updated_ad) {
            //Attach all unused media with this ad
            DB::table('ads_images')->where(['ads_user_id' => $user->id, 'ads_ad_id' => null])->update(['ads_ad_id' => $ad->id]);
        }

        return redirect()->route('user.ads', app()->getLocale())->with('success', trans("app.updated_successfully"));
    }

    public function getsubcategory(Request $request)
    {
        $cat_id = $request->cat_id;
        $category = Category::where('category_id', $cat_id)->get();
        if (count($category) > 0) {
            $category_val = array();
            foreach ($category as $categoryval) {
                $category_val[$categoryval->id] = $categoryval->name_en;
            }
            echo json_encode($category_val);
        } else {
            return false;
        }
    }

    public function getbrandname(Request $request)
    {
        $cat_id = $request->cat_id;
        $brand = Brand::where('category_id', $cat_id)->get();
        if (count($brand) > 0) {
            $brand_val = array();
            foreach ($brand as $brandval) {
                //$brand_val[]  = '<option value="'.$brandval->id.'">'.$brandval->name_en.'</option>';
                $brand_val[$brandval->id] = $brandval->name_en;
            }
            echo json_encode($brand_val);
        } else {
            return false;
        }
    }

    public function deleteMediAd(Request $request)
    {
        if ($request->delId) {
            $adimages = DB::table('ads_images')->find($request->delId);
            if ($adimages) {
                $imageName = $adimages->ads_image;
                $this->deleteImageBuddy(Ad::$imagePath, $imageName);
                $this->deleteImageBuddy(Ad::$imageMediumPath, $imageName);
                $this->deleteImageBuddy(Ad::$imageThumbPath, $imageName);
                DB::table('ads_images')->where('id', $adimages->id)->delete();
            }
            return json_encode(['status' => 1]);
        }
    }

    public function deletead($id, Request $request)
    {
        $title = 'Delete';

        $deleteId = $request->delete_id;
        $ad = Ad::find($deleteId);

        if ($deleteId) {
            // Delete the ads image
            /*$adimages = DB::table('ads_images')->find($ad->id);

            if ($adimages) {
                $imageName = $adimages->ads_image;
                $this->deleteImageBuddy(Ad::$imagePath, $imageName);
                $this->deleteImageBuddy(Ad::$imageMediumPath, $imageName);
                $this->deleteImageBuddy(Ad::$imageThumbPath, $imageName);
                DB::table('ads_images')->where('ads_ad_id', $adimages->id)->delete();
            }*/
            if ($ad->delete()) {
                return true;
            }
        }
    }

    public function adfavourite(Request $request)
    {
        $ad_id = $request->ad_id;
        $user = auth()->user();
        $favourite = Favourite::where(['ads_ad_id' => $ad_id, 'user_id' => $user->id])->first();

        if ($favourite) {
            if ($favourite->status == 1) {
                $status = '0';
                $returnValue = ' Not Favourite';
            } else if ($favourite->status == 0) {
                $status = '1';
                $returnValue = ' Favourite';
            }
        } else {
            $status = '1';
            $returnValue = ' Favourite';
        }

        $data = [
            'ads_ad_id' => $ad_id,
            'user_id' => $user->id,
        ];
        $data_update = [
            'status' => $status,
        ];

        if (Favourite::updateOrCreate($data, $data_update)) {
            return $returnValue;
        }
    }

    public function uploadAdsImage(Request $request)
    {
        $user_id = Auth::user()->id;

        if ($request->hasFile('ad_image')) {
            $images = $request->file('ad_image');
            if ($images) {
                for ($i = 0; $i < count($images); $i++) {
                    $image = $images[$i];
                    if ($image != NULL) {

                        /*$valid_extensions = ['jpg','jpeg','png'];

                        if ( ! in_array(strtolower($image->getClientOriginalExtension()), $valid_extensions) ){
                            return ['success' => 0, 'msg' => implode(',', $valid_extensions).' '.trans('app.valid_extension_msg')];
                        }*/

                        $newFileName = sha1(date('YmdHis')) . '-' . $image->getClientOriginalName();
                        $originalPath = Ad::$imagePath;
                        $mediumPath = Ad::$imageMediumPath;
                        $thumbPath = Ad::$imageThumbPath;

                        // Image Upload Process
                        $processImage = Image::make($image);
                        $processImage->save($originalPath . $newFileName);

                        // resize the image to a width of 500 and constrain aspect ratio (auto height)
                        $processImage->resize(500, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $processImage->save($mediumPath . $newFileName);

                        // resize the image to a width of 250 and constrain aspect ratio (auto height)
                        $processImage->resize(250, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $processImage->save($thumbPath . $newFileName);

                        /*try{*/
                        //Save image name into db
                        //$created_img_db = Media::create(['user_id' => $user_id, 'media_name'=>$image_name, 'type'=>'image', 'storage' => get_option('default_storage'), 'ref'=>'ad']);
                        $created_img_db[] = DB::insert('INSERT INTO ' . DB::getTablePrefix() . 'ads_images (`ads_user_id`, `ads_image`,  `created_at`, `updated_at`) VALUES (?,?,?,?)', [$user_id, $newFileName, now(), now()]);


                        //$img_url = media_url($created_img_db, false);
                        $img_url[] = Ad::$imageThumbUrl . $newFileName;
                        /*} catch (\Exception $e){
                            return $e->getMessage();
                        }*/
                    }
                }
                if ($created_img_db) {
                    return ['success' => 1, 'img_url' => $img_url];
                } else {
                    return ['success' => 0];
                }
            }
        }
    }

    public function appendMediaImage()
    {
        $user_id = Auth::user()->id;
        $ads_images = DB::table('ads_images')->where(['ads_user_id' => $user_id, 'ads_ad_id' => null])->get();
        $dataImage = array();
        if ($ads_images->count() > 0) {
            foreach ($ads_images as $ads_image) {
                $dataImage[] = [
                    "id" => $ads_image->id,
                    "is_feature" => $ads_image->is_feature,
                    "adimage" => $ads_image->ads_image,
                    "adimage_url" => asset(Ad::$imageThumbUrl . $ads_image->ads_image),
                ];
            }
        }
        $data['ads_images'] = $dataImage;
        return view('front.ad.append_media', compact('data'));
    }

    public function featureMediaCreatingAds(Request $request)
    {
        $user_id = Auth::user()->id;
        $media_id = $request->media_id;
        $ad_id = $request->ad_id;
        if (!empty($ad_id)) {
            DB::table('ads_images')->where(['ads_user_id' => $user_id, 'ads_ad_id' => $ad_id])->update(['is_feature' => '0']);
            DB::table('ads_images')->where(['id' => $media_id])->update(['is_feature' => '1']);
        } else {
            DB::table('ads_images')->where(['ads_user_id' => $user_id, 'ads_ad_id' => null])->update(['is_feature' => '0']);
            DB::table('ads_images')->where(['id' => $media_id])->update(['is_feature' => '1']);
        }
        return ['success' => 1, 'msg' => trans('app.media_featured_msg')];
    }

}
// DI CODE - End
