<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Favourite;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BaseApiController extends Controller
{
    const API_PAGINATION = 25;
    const SUCCESS_MSG = "Success";
    const FAILED_MSG = "Failed";
    const HTTP_OK = 200;
    const HTTP_ERR = 205;

    public function __construct()
    {
        /*if (\request()->get('lang')) {
            app()->setLocale(strtolower(request()->get('lang')));
        }
        $setting = \config('settings');
        view()->share(['_setting' => $setting]);*/

    }

    public function sendResponse($status, $keyVal)
    {
        $arrayResponse = [];
        $arrayResponse['status'] = $status;
        foreach ($keyVal as $key => $value) {
            $arrayResponse[$key] = $this->nonul($value);
        }
        return response()->json($arrayResponse);
    }

    public function nonul($value)
    {
        if ($value == NULL || $value == '' || empty($value)) {
            $value = array();
        }
        return $value;
    }

    public function emptyObject()
    {
        return $emptyObj = (object)NULL;
    }

    public function showPrice($value)
    {
        $strLang = app()->getLocale();
        $finalValue = trans('api.kd') . ' ' . $value;
        if ($strLang == 'ar') {
            $finalValue = $value . ' ' . trans('api.kd');
        }
        return $finalValue;
    }


    public function sendFcmNotification($titleAr, $titleEn, $contentAr, $contentEn, $token, $userId = null)
    {

        /*if ($userId != null) {
            if (is_array($userId)) {
                foreach ($userId as $item) {
                    \DB::table('notifications')->insert(['user_id' => $item, 'titleEn' => $titleEn, 'contentEn' => $contentEn, 'titleAr' => $titleAr, 'contentAr' => $contentAr]);
                }
            } else {
                \DB::table('notifications')->insert(['user_id' => $userId, 'titleEn' => $titleEn, 'contentEn' => $contentEn, 'titleAr' => $titleAr, 'contentAr' => $contentAr]);
            }
        }*/

        $url = "https://fcm.googleapis.com/fcm/send";
        $serverKey = env('FCM_KEY');
        $notification = array('title' => $titleEn, 'text' => $contentEn, 'sound' => 'default', 'badge' => '1');
        $arrayToSend = array('to' => $token, 'notification' => $notification, 'priority' => 'high');
        $json = json_encode($arrayToSend);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $serverKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//Send the request
        $response = curl_exec($ch);

        // print_r($response);exit;
//Close request
        if ($response === FALSE) {
            curl_close($ch);
            return false;
            //die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return true;


    }

    function generateAPIToken()
    {
        return $token = hash('sha256', Str::random(60));
    }

    function populateAds($ads, $page = 0, $strLang = 'en')
    {
        $result = array();
        $paginateSection = array();

        if ($page) {
            $perPage = $ads->perPage();
            $firstPage = $ads->perPage();
            $lastPage = $ads->lastPage();
            $currentPage = $ads->currentPage();
            $nextPage = $ads->nextPageUrl();
            $prevPage = $ads->previousPageUrl();
            $total = $ads->total();

            $paginateSection['current_page'] = $currentPage;
            $paginateSection['last_page'] = $lastPage;
            $paginateSection['next_page_url'] = $nextPage;
            $paginateSection['per_page'] = $perPage;
            $paginateSection['prev_page_url'] = $prevPage;
            $paginateSection['total'] = $total;
        }

        // var_dump($ads);exit;
        $counts = count($ads);

        if ($counts > 0) {
            foreach ($ads as $ad) {
                $mediaImages = $ad->medias ? $ad->medias : array();
                $unitItems = $ad->units ? $ad->units : array();

                // $new['share_url'] = route('single_ad', $slug);
                $titleName = 'title_' . $strLang;
                $description = 'description_' . $strLang;
                $name = 'name_' . $strLang;

                $new['id'] = $ad->id;
                $new['title'] = $ad->$titleName;
                $new['sku'] = $ad->sku;
                $new['description'] = $ad->$description;
                $new['origin_id'] = $ad->country->id;
                $new['origin_name'] = $ad->country->$name;
                $new['category_id'] = $ad->category->id;
                $new['sub_category_id'] = $ad->sub_category_id;
                $new['category_name'] = $ad->category->$name;
                $new['sub_category_name'] = $ad->sub_category[$name];

                $new['origin'] = !empty($ad->country_id) ? ['id' => $ad->country->id, "country_name" => $ad->country->$name] : $this->emptyObject(); // Country
                $new['category'] = !empty($ad->category_id) ? ['id' => $ad->category->id, "category_name" => $ad->category->$name] : $this->emptyObject(); // Currency Detail
                $new['sub_category'] = !empty($ad->sub_category_id) ? ['id' => $ad->sub_category_id, "sub_category_name" => $ad->sub_category[$name]] : $this->emptyObject(); // Currency Detail
                $new['brand'] = !empty($ad->brand_id) ? ['id' => $ad->brand_id, "brand_name" => $ad->brand->$name] : $this->emptyObject(); // Currency Detail

                // Media Image
                $media = array();
                if (count($mediaImages) > 0) {
                    foreach ($mediaImages as $mk => $mediaImage) {
                        $media[$mk]['id'] = $mediaImage['id'];
                        $media[$mk]['image_url'] = asset(Product::$imagePath . $mediaImage['image_name']);
                    }
                }
                $new['gallery'] = (count($media) > 0) ? $media : array(); // Feature image

                // Units and Prices
                $unit = array();
                if (count($unitItems) > 0) {
                    foreach ($unitItems as $mk => $unitItem) {
                        $unit[$mk]['id'] = $unitItem['id'];
                        $unit[$mk]['unit_id'] = $unitItem->pivot['unit_id'];
                        $unit[$mk]['quantity'] = $unitItem->pivot['quantity'];
                        $unit[$mk]['price'] = $this->currency($unitItem->pivot['price'], $strLang);
                        $unit[$mk]['offer_price'] = $this->currency($unitItem->pivot['offer_price'], $strLang);
                    }
                }
                $new['gallery'] = (count($media) > 0) ? $media : array(); // Gallery image
                $new['unit'] = (count($unit) > 0) ? $unit : array(); // Units

                array_push($result, $new);
            }
        }

        $out['result'] = ($counts > 0) ? $result : array();
        $out['pagination'] = $paginateSection;
        return $out;
    }

    function populateAdsList($sessionId, $products, $page = 0, $strLang = 'en')
    {
        $result = array();
        $paginateSection = array();
        $isComingSoon = 1;

        if ($page) {
            $perPage = $products->perPage();
            $firstPage = $products->perPage();
            $lastPage = $products->lastPage();
            $currentPage = $products->currentPage();
            $nextPage = $products->nextPageUrl();
            $prevPage = $products->previousPageUrl();
            $total = $products->total();

            $paginateSection['current_page'] = $currentPage;
            $paginateSection['last_page'] = $lastPage;
            $paginateSection['next_page_url'] = $nextPage;
            $paginateSection['per_page'] = $perPage;
            $paginateSection['prev_page_url'] = $prevPage;
            $paginateSection['total'] = $total;
        }

        // var_dump($ads);exit;
        $counts = count($products);

        $title = "title_" . $strLang;
        $name = 'name_' . $strLang;
        $description = 'description_' . $strLang;
        $location = 'location_' . $strLang;

        if ($counts > 0) {
            foreach ($products as $product) {

                if(isset($product->ads_image)){
                    $imageName = !empty($product->ads_image) ? $product->ads_image : '';

                    $imageUrl = !empty($imageName) ? asset(Ad::$imageUrl . $imageName) : asset(Ad::$noImageUrl);
                    $imageMediumUrl = !empty($imageName) ? asset(Ad::$imageMediumUrl . $imageName) : asset(Ad::$noImageUrl);
                    $imageThumbUrl = !empty($imageName) ? asset(Ad::$imageThumbUrl . $imageName) : asset(Ad::$noImageUrl);
                }else{
                    $adfeatureimage = DB::table('ads_images')->where(['ads_ad_id' => $product->id, 'is_feature' => '1', 'deleted_at' => null,])->first();

                    if ($adfeatureimage) {
                        $adimage = $adfeatureimage->ads_image;
                    } else {
                        $adfeatureimage = DB::table('ads_images')->where(['ads_ad_id' => $product->id, 'deleted_at' => null,])->first();
                        if($adfeatureimage){
                            $adimage = $adfeatureimage->ads_image;
                        }
                    }

                    $imageName = !empty($adimage) ? $adimage : '';
                    $imageUrl = !empty($imageName) ? asset(Ad::$imageUrl . $imageName) : asset(Ad::$noImageUrl);
                    $imageMediumUrl = !empty($imageName) ? asset(Ad::$imageMediumUrl . $imageName) : asset(Ad::$noImageUrl);
                    $imageThumbUrl = !empty($imageName) ? asset(Ad::$imageThumbUrl . $imageName) : asset(Ad::$noImageUrl);
                }


                $categoryName = 'name_' . $strLang;
                $titleName = 'title_' . $strLang;
                $parent_cat = 'parent_cat_' . $strLang;
                $sub_cat = 'sub_cat_' . $strLang;

                // Logged in user - Favourite Ads
                $user = auth()->user();
                $fav_val = '';
                if ($user) {
                    $favourite = Favourite::where(['status' => '1', 'ads_ad_id' => $product->id, 'user_id' => $user->id])->first();
                    if ($favourite) {
                        $fav_val = 'Favourite';
                    }
                }
                $ad_price = explode('.', $product->ad_price);

                $new = array(
                    "id" => $product->id,
                    'category_id' => $product->ad_category_id,
                    'sub_category_id' => $product->ad_sub_category_id,
                    'category_name' => $product->$parent_cat,
                    'sub_category_name' => $product->$sub_cat,
                    "title" => $product->ad_title,
                    "price" => $this->showPrice($ad_price[0]),
                    "views" => !empty($product->ad_views) ? $product->ad_views : 0,
                    "location" => $product->$location,
                    "featured" => (int)$product->ad_is_featured,
                    "image" => $imageUrl,
                    "image_medium" => $imageMediumUrl,
                    "image_thumb" => $imageThumbUrl,
                    "createddate" => $product->created_at->diffForHumans(),
                    "user_name" => !empty($product->first_name && $product->last_name) ? ($product->first_name . ' ' . $product->last_name) : $product->name,
                    "user_mobile" => $product->mobile,
                    "user_avatar" => !empty($product->avatar) ? asset(User::$imageThumbUrl . $product->avatar) : asset(User::$noImageUrl),
                );
                array_push($result, $new);
            }
        }

        $out['result'] = ($counts > 0) ? $result : array();
        $out['pagination'] = $paginateSection;
        return $out;
    }

    public function populateDetail($detail, $strLang = 'en', $sessionId = '', $userId = 1, $edit = 0)
    {
        $location = 'location_' . $strLang;
        $parent_cat = 'parent_cat_' . $strLang;
        $sub_cat = 'sub_cat_' . $strLang;
        $brand = 'brand_' . $strLang;

        $related = array();
        $gallery = array();

        $is_fav = 0;

        if ($userId) {
            $favourite = Favourite::where(['status' => '1', 'ads_ad_id' => $detail->id, 'user_id' => $userId])->first();
            if ($favourite) {
                $is_fav = 1;
            }
        }

        // Ads Images
        $adsimages = DB::table('ads_images')
            ->select('*')
            ->where('ads_ad_id', '=', $detail->id)
            ->orderby('is_feature', 'desc')
            ->get();

        foreach ($adsimages as $media) {
            $imageName = $media->ads_image;

            $imageUrl = !empty($imageName) ? asset(Ad::$imageUrl . $imageName) : asset(Ad::$noImageUrl);
            $imageMediumUrl = !empty($imageName) ? asset(Ad::$imageMediumUrl . $imageName) : asset(Ad::$noImageUrl);
            $imageThumbUrl = !empty($imageName) ? asset(Ad::$imageThumbUrl . $imageName) : asset(Ad::$noImageUrl);

            $imageList = [
                "id" => $media->id,
                "image" => $imageUrl,
                "medium_image" => $imageMediumUrl,
                "thumb_image" => $imageThumbUrl,
            ];

            $gallery[] = $imageList;
        }

        // Related Ads
        $relatedAds = Ad::select('ads.*', 'areas.name_en as location_en', 'areas.name_ar as location_ar', 'users.name as username', 'users.mobile as usermobile', 'pc.name_en as parent_cat_en', 'pc.name_ar as parent_cat_ar', 'sc.name_en as sub_cat_en', 'sc.name_ar as sub_cat_ar', 'brands.name_en as brand_en', 'brands.name_ar as brand_ar', 'ads_images.ads_image')
            ->leftjoin('areas', 'ads.ad_location_area', '=', 'areas.id')
            ->leftjoin('users', 'ads.ad_user_id', '=', 'users.id')
            ->leftjoin('categories as pc', 'ads.ad_category_id', '=', 'pc.id')
            ->leftjoin('categories as sc', 'ads.ad_sub_category_id', '=', 'sc.id')
            ->leftjoin('brands', 'ads.ad_brand_id', '=', 'brands.id')
            ->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')
            ->where('ads.ad_sub_category_id', '=', $detail->ad_sub_category_id)
            ->groupBy('ads.id')->take(6)->get();

        $relatedAdList = $this->populateAdsList($sessionId, $relatedAds, 0, $strLang);

        $userIds = array();
        $deviceUsers = $this->getDeviceUsers($sessionId);
        foreach ($deviceUsers as $deviceUser) {
            $userIds[] = $deviceUser->id;
        }

        $result = array(
            "id" => $detail['id'],
            "category_id" => $detail['ad_category_id'],
            "sub_category_id" => $detail['ad_sub_category_id'],
            "category_name" => $detail->$parent_cat,
            "sub_category_name" => $detail->$sub_cat ? $detail->$sub_cat : '',
            "brand_id" => $detail->ad_brand_id,
            "brand_name" => $detail->$brand,
            "area_id" => (int)$detail->ad_location_area,
            "location" => $detail->$location,
            "condition" => ucfirst($detail->ad_condition),
            "title" => $detail->ad_title,
            "description" => strip_tags($detail->ad_description),
            "views" => !empty($detail->ad_views) ? $detail->ad_views : 0,
            "price" => currency($detail->ad_price, $strLang),
            "is_negotiable" => $detail->ad_is_negotiable,
            'user_avatar' => showAvatar($detail->avatar),
            'user_facebook' => $detail->facebook,
            'user_twitter' => $detail->twitter,
            'createddate' => $detail->created_at->diffForHumans(),
            'userdate' => Carbon::parse($detail->userdate)->diffForHumans(),
            'seller_name' => $detail->ad_seller_name,
            'seller_email' => $detail->ad_seller_email,
            'seller_phone' => $detail->ad_seller_phone,
            'seller_whatsapp' => $detail->ad_seller_whatsapp,
            'seller_address' => $detail->ad_seller_address,
            "is_fav" => $is_fav,
            "media" => $gallery,
            "user_id" => $detail->ad_user_id,
        );
        if (!$edit) {
            $result['related_ads'] = $relatedAdList['result'];
        }
        return $result;
    }

    public function getDeviceUser($deviceToken)
    {
        $userData = User::whereDeviceToken($deviceToken)->first();
        return $userData;
    }

    public function getDeviceUsers($deviceToken)
    {
        $userData = User::whereDeviceToken($deviceToken)->get();
        return $userData;
    }

}
