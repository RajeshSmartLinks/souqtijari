<?php

namespace App\Http\Controllers\Api\V1;

use App\Currency;
use App\Deal;
use App\Http\Controllers\Api\BaseApiController;
use App\Mail\CreateAd;
use App\Models\Ad;
use App\Models\Area;
use App\Models\Favourite;
use App\Models\User;
use App\Payment;
use App\Post;
use App\Product;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\Types\Self_;

class AdController extends BaseApiController
{
    /**
     * Listing of the products with the search
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $strLang = app()->getLocale();
        $sessionId = $request->device_token;

        $recommendedRq = $request->recommended;
        $featuredRq = $request->featured;

        $lists = Ad::select(
            'ads.*',
            'areas.name_en as location_en', 'areas.name_ar as location_ar',
            'ads_images.ads_image',
            'users.name', 'users.first_name', 'users.last_name', 'users.mobile', 'users.avatar',
            'pc.name_en as parent_cat_en', 'pc.name_ar as parent_cat_ar', 'pc.slug as parent_cat_slug',
            'sc.name_en as sub_cat_en', 'sc.name_ar as sub_cat_ar')
            ->leftJoin('areas', 'ads.ad_location_area', '=', 'areas.id')
            ->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')
            ->leftJoin('users', 'ads.ad_user_id', '=', 'users.id')
            ->leftjoin('categories as pc', 'ads.ad_category_id', '=', 'pc.id')
            ->leftjoin('categories as sc', 'ads.ad_sub_category_id', '=', 'sc.id');

        if ($request->q) {
            $lists = $lists->where(function ($lists) use ($request) {
                $lists->where('ads.ad_title', 'like', "%{$request->q}%")->orWhere('ads.ad_description', 'like', "%{$request->q}%");
            });
        }

        if ($request->category_id) {
            $lists = $lists->where('ads.ad_category_id', '=', $request->category_id);
        }
        if ($request->sub_category_id) {
            $lists = $lists->where('ads.ad_sub_category_id', '=', $request->sub_category_id);
        }
        if ($request->brand_id) {
            $lists = $lists->where('ads.ad_brand_id', '=', $request->brand_id);
        }

        if ($request->location) {
            $lists = $lists->where('ads.ad_location_area_cat', '=', $request->location);
        }

        if ($request->user_id) {
            $lists = $lists->where('ads.ad_user_id', '=', $request->user_id);
        }

        if ($featuredRq) {
            $lists = $lists->where('ads.ad_is_featured', '1');
        }
        if ($recommendedRq) {
            $lists = $lists->where('ads.ad_priority', '1');
        }

        $lists = $lists->orderBy('updated_at', 'desc');
        $lists = $lists->groupBy('id');

        $lists_per_page = BaseApiController::API_PAGINATION;

        $lists = $lists->paginate($lists_per_page);

        if ($lists->count() == 0) {
            $results = array("data" => [], 'pagination' => (object)[], 'message' => trans('app.success'));
            return $this->sendResponse(self::HTTP_OK, $results);
        }

        $populatedLists = $this->populateAdsList($sessionId, $lists, 1, $strLang);
        $result = $populatedLists['result'];
        $paginateSection = $populatedLists['pagination'];

        $results = array("data" => $result, 'pagination' => $paginateSection, 'message' => trans('app.success'));

        return $this->sendResponse(self::HTTP_OK, $results);

    }

    /**
     * To derive the details of the Particular product
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request, $edit = 0)
    {
        $strLang = app()->getLocale();

        $bearerToken = $request->header('Authorization');

        $deviceToken = $request->device_token;
        $deviceType = $request->device_type;
        $userId = 0;

        // Get the User id by device token
        if ($deviceToken) {
            $grabThing = User::whereDeviceToken($deviceToken)->first();
            if ($grabThing) {
                $userId = $grabThing->id;
            }
            $userId = Auth::check() ? Auth::user()->id : $userId;
        }

        $id = $request->id;

        if (!$id) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => 'Enter Ad Id']);
        }

        $detail = Ad::select(
            'ads.*',
            'areas.name_en as location_en', 'areas.name_ar as location_ar',
            'users.avatar', 'users.facebook', 'users.twitter', 'users.created_at as userdate',
            'pc.name_en as parent_cat_en', 'pc.name_ar as parent_cat_ar', 'pc.slug as parent_cat_slug',
            'sc.name_en as sub_cat_en', 'sc.name_ar as sub_cat_ar',
            'brands.name_en as brand_en', 'brands.name_ar as brand_ar'
        )
            ->leftjoin('areas', 'ads.ad_location_area', '=', 'areas.id')
            ->leftjoin('users', 'ads.ad_user_id', '=', 'users.id')
            ->leftjoin('categories as pc', 'ads.ad_category_id', '=', 'pc.id')
            ->leftjoin('categories as sc', 'ads.ad_sub_category_id', '=', 'sc.id')
            ->leftjoin('brands', 'ads.ad_brand_id', '=', 'brands.id')
            ->where('ads.id', '=', $request->id)->first();

        if ($detail) {
            if (!$edit) {
                $detail->ad_views = $detail->ad_views + 1;
                $detail->save();
            }

            $result = $this->populateDetail($detail, $strLang, $deviceToken, $userId, $edit);
            return $this->sendResponse(self::HTTP_OK, ['data' => $result, 'message' => trans('app.success')]);
        }

        return $this->sendResponse(self::HTTP_ERR, ['message' => self::FAILED_MSG]);
    }

    public function edit(Request $request)
    {
        return $this->detail($request, 1);
    }

    public function update(Request $request)
    {
        $rules = [
            'device_token' => 'required',
            'device_type' => 'required|in:ios,android',
            'ad_id' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'area_id' => 'required',
            'condition' => 'required',
            'price' => 'required',
            'seller_name' => 'required',
            'seller_email' => 'email',
            'seller_phone' => 'required',
        ];
        $valid = Validator::make($request->all(), $rules);
        $errorMessages = $valid->messages()->all();

        if ($valid->fails()) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => $errorMessages[0]]);
        }

        $data = array();
        $img_url = [];


        $ad = Ad::find($request->ad_id);
        if (!$ad) {
            return $this->sendResponse(self::HTTP_ERR, ['data' => [], 'message' => self::FAILED_MSG]);
        }

        $ad->ad_category_id = $request->category_id;
        $ad->ad_sub_category_id = $request->sub_category_id;
        $ad->ad_brand_id = $request->brand_id;
        $ad->ad_title = $request->title;
        $ad->ad_description = $request->description;
        $ad->ad_location_area = $request->area_id;
        $ad_location_area_cat = Area::where('id', $request->area_id)->first();
        $ad->ad_location_area_cat = $ad_location_area_cat->area_id;
        $ad->ad_condition = $request->condition;
        $ad->ad_price = $request->price;
        if ($request->is_negotiable) {
            $ad->ad_is_negotiable = $request->is_negotiable;
        }
        $ad->ad_seller_name = $request->seller_name;
        $ad->ad_seller_email = $request->seller_email;
        $ad->ad_seller_phone = $request->seller_phone;
        $ad->ad_seller_whatsapp = $request->seller_whatsapp;
        $ad->ad_seller_address = $request->seller_address;

        $user = auth()->user();
        $userId = $user->id;

        $ad->ad_user_id = $user->id;

        $updated_ad = $ad->save();

        // Grab the old Image and show
        $adsimages = DB::table('ads_images')
            ->select('*')
            ->where('ads_ad_id', '=', $ad->id)
            ->orderby('is_feature', 'desc')
            ->get();
        foreach ($adsimages as $media) {
            $img_url[] = [
                "id" => $media->id,
                "image_url" => asset(Ad::$imageThumbUrl . $media->ads_image),
                "is_feature" => (int)$media->is_feature,
            ];
        }

        // Upload Images
        if (isset($request->images)) {
            $images = $request->images;
            $imagesCount = count($images);

            if ($imagesCount > 0) {
                for ($im = 0; $im < $imagesCount; $im++) {
                    $image = $images[$im];

                    $imageInfo = getimagesizefromstring(base64_decode($image));

                    $mime = $imageInfo['mime'];

                    $extension = explode('/', $mime)[1];

                    $newFileName = sha1(date('YmdHis') . rand(10, 90)) . "." . $extension;
                    $originalPath = Ad::$imagePath;
                    $mediumPath = Ad::$imageMediumPath;
                    $thumbPath = Ad::$imageThumbPath;

                    // Image Upload Process
                    $processImage = Image::make(base64_decode($image));
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

                    DB::insert('INSERT INTO ' . DB::getTablePrefix() . 'ads_images (`ads_ad_id`,`ads_user_id`, `ads_image`,  `created_at`, `updated_at`) VALUES (?,?,?,?,?)', [$request->ad_id, $userId, $newFileName, now(), now()]);
                    $insertId = DB::getPdo()->lastInsertId();

                    $img_url[] = [
                        "id" => $insertId,
                        "image_url" => asset(Ad::$imageThumbUrl . $newFileName),
                        "is_feature" => 0,
                    ];
                }
            }
        }


        return $this->sendResponse(self::HTTP_OK, ['data' => [], 'message' => trans('app.success')]);
    }

    public function makeFavourite(Request $request)
    {
        $rules = [
            'device_token' => 'required',
            'device_type' => 'required|in:ios,android',
            'ad_id' => 'required',
        ];
        $valid = Validator::make($request->all(), $rules);
        $errorMessages = $valid->messages()->all();

        if ($valid->fails()) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => $errorMessages[0]]);
        }

        $ad_id = $request->ad_id;
        $user = Auth::user();
        $newStatus = 1;

        $favourite = Favourite::where(['ads_ad_id' => $ad_id, 'user_id' => $user->id])->first();

        if ($favourite) {
            $newStatus = 1 - $favourite->status;
        }

        $data = [
            'ads_ad_id' => $ad_id,
            'user_id' => $user->id,
        ];
        $data_update = [
            'status' => $newStatus,
        ];

        if (Favourite::updateOrCreate($data, $data_update)) {
            $result = [
                'ad_id' => $ad_id,
                'is_fav' => $newStatus,
            ];
            return $this->sendResponse(self::HTTP_OK, ['data' => $result, 'message' => trans('app.success')]);
        }
    }

    public function uploadAdsImage(Request $request)
    {
        $strLang = app()->getLocale();

        $rules = [
            'device_token' => 'required',
            'device_type' => 'required|in:ios,android',
            'images' => 'required',
        ];
        $valid = Validator::make($request->all(), $rules);
        $errorMessages = $valid->messages()->all();

        if ($valid->fails()) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => $errorMessages[0]]);
        }

        $userId = Auth::user()->id;
        $images = $request->images;

        if ($userId) {
            $imagesCount = count($images);

            if ($imagesCount > 0) {
                for ($im = 0; $im < $imagesCount; $im++) {
                    $image = $images[$im];

                    $imageInfo = getimagesizefromstring(base64_decode($image));

                    $mime = $imageInfo['mime'];

                    $extension = explode('/', $mime)[1];

                    $newFileName = sha1(date('YmdHis') . rand(10, 90)) . "." . $extension;
                    $originalPath = Ad::$imagePath;
                    $mediumPath = Ad::$imageMediumPath;
                    $thumbPath = Ad::$imageThumbPath;

                    // Image Upload Process
                    $processImage = Image::make(base64_decode($image));
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

                    DB::insert('INSERT INTO ' . DB::getTablePrefix() . 'ads_images (`ads_user_id`, `ads_image`,  `created_at`, `updated_at`) VALUES (?,?,?,?)', [$userId, $newFileName, now(), now()]);
                    $insertId = DB::getPdo()->lastInsertId();

                    $img_url[] = [
                        "id" => $insertId,
                        "image_url" => asset(Ad::$imageThumbUrl . $newFileName),
                        "is_feature" => 0,
                    ];
                }

                return $this->sendResponse(self::HTTP_OK, ['data' => $img_url, 'message' => trans('app.success')]);
            }
        }
        return $this->sendResponse(205, ['data' => '', 'info' => "Upload Image Error", 'message' => self::FAILED_MSG]);
    }

    public function makeFeatureMedia(Request $request)
    {
        $rules = [
            'device_token' => 'required',
            'device_type' => 'required|in:ios,android',
            'id' => 'required',
        ];
        $valid = Validator::make($request->all(), $rules);
        $errorMessages = $valid->messages()->all();

        if ($valid->fails()) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => $errorMessages[0]]);
        }

        $user_id = Auth::user()->id;
        $media_id = $request->id;
        $ad_id = $request->ad_id;

        if (!empty($ad_id)) {
            DB::table('ads_images')->where(['ads_user_id' => $user_id, 'ads_ad_id' => $ad_id])->update(['is_feature' => '0']);
            DB::table('ads_images')->where(['id' => $media_id])->update(['is_feature' => '1']);
        } else {
            DB::table('ads_images')->where(['ads_user_id' => $user_id, 'ads_ad_id' => null])->update(['is_feature' => '0']);
            DB::table('ads_images')->where(['id' => $media_id])->update(['is_feature' => '1']);
        }

        $status = DB::table('ads_images')->where(['id' => $media_id])->first();
        return $this->sendResponse(self::HTTP_OK, ['data' => ['status' => (int)$status->is_feature], 'info' => trans('app.success'), 'message' => self::SUCCESS_MSG]);
    }

    public function deleteMediAd($id)
    {
        if (!$id) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => "Choose Image"]);
        }

        if ($id > 0) {
            $adimages = DB::table('ads_images')->find($id);
            if ($adimages) {
                $imageName = $adimages->ads_image;
                $this->deleteImageBuddy(Ad::$imagePath, $imageName);
                $this->deleteImageBuddy(Ad::$imageMediumPath, $imageName);
                $this->deleteImageBuddy(Ad::$imageThumbPath, $imageName);
                DB::table('ads_images')->where('id', $adimages->id)->delete();
                return $this->sendResponse(self::HTTP_OK, ['data' => ['status' => 1], 'info' => trans('app.success'), 'message' => self::SUCCESS_MSG]);
            } else {
                return $this->sendResponse(self::HTTP_ERR, ['message' => "No Image to Delete"]);
            }

        }
    }

    public function grabMediaImages(Request $request)
    {
        $userId = Auth::user()->id;
        $adId = $request->ad_id ? $request->ad_id : null;

        $ads_images = DB::table('ads_images')->where(['ads_user_id' => $userId, 'ads_ad_id' => $adId])->get();
        $dataImage = array();
        if ($ads_images->count() > 0) {
            foreach ($ads_images as $ads_image) {
                $dataImage[] = [
                    "id" => $ads_image->id,
                    "is_feature" => (int)$ads_image->is_feature,
                    "adimage_url" => asset(Ad::$imageThumbUrl . $ads_image->ads_image),
                ];
            }
        }
        return $this->sendResponse(self::HTTP_OK, ['data' => $dataImage, 'info' => trans('app.success'), 'message' => self::SUCCESS_MSG]);
    }

    public function createAd(Request $request)
    {
        $rules = [
            'device_token' => 'required',
            'device_type' => 'required|in:ios,android',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'area_id' => 'required',
            'condition' => 'required',
            'price' => 'required',
            'seller_name' => 'required',
            'seller_email' => 'email',
            'seller_phone' => 'required',
        ];
        $valid = Validator::make($request->all(), $rules);
        $errorMessages = $valid->messages()->all();

        if ($valid->fails()) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => $errorMessages[0]]);
        }

        $data = array();

        $data['ad_category_id'] = $request->category_id;
        $data['ad_sub_category_id'] = $request->sub_category_id;
        $data['ad_brand_id'] = $request->brand_id;
        $data['ad_title'] = $request->title;
        $data['slug'] = unique_slug($request->title, 'Ad');
        $data['ad_description'] = $request->description;
        $data['ad_location_area'] = $request->area_id;
        $ad_location_area_cat = Area::where('id', $request->area_id)->first();
        $data['ad_location_area_cat'] = $ad_location_area_cat->area_id;
        $data['ad_condition'] = $request->condition;
        $data['ad_price'] = $request->price;
        if ($request->is_negotiable) {
            $data['ad_is_negotiable'] = $request->is_negotiable;
        }
        $data['ad_seller_name'] = $request->seller_name;
        $data['ad_seller_email'] = $request->seller_email;
        $data['ad_seller_phone'] = $request->seller_phone;
        $data['ad_seller_whatsapp'] = $request->seller_whatsapp;
        $data['ad_seller_address'] = $request->seller_address;

        $user = auth()->user();
        $data['ad_user_id'] = $user->id;

        $create_Ad = Ad::create($data);

        if ($create_Ad) {
            $totalTempFeatureCount = DB::table('ads_images')->where(['ads_user_id' => $user->id, 'ads_ad_id' => null, 'is_feature' => 1])->count();

            if ($totalTempFeatureCount == 0) {
                $ads_images = DB::table('ads_images')->where(['ads_user_id' => $userId, 'ads_ad_id' => null])->first();
                DB::table('ads_images')->where(['ads_user_id' => $user->id, 'ads_ad_id' => null, 'id' => $ads_images->id])->update(['is_feature' => 1]);
            }

            //Attach all unused media with this ad
            DB::table('ads_images')->where(['ads_user_id' => $user->id, 'ads_ad_id' => null])->update(['ads_ad_id' => $create_Ad->id]);

            // Mail
            $userdetails = \App\Models\User::find($user->id);
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

            return $this->sendResponse(self::HTTP_OK, ['data' => '', 'info' => trans('app.success'), 'message' => self::SUCCESS_MSG]);
        }

        return $this->sendResponse(self::HTTP_ERR, ['data' => '', 'info' => trans('app.failed'), 'message' => self::FAILED_MSG]);
    }

}
