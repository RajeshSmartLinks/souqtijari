<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpseclib3\Crypt\Hash;

class ImportController extends Controller
{
    public function importOldUser()
    {
        $added = 0;
        // Fetching the data from the OLD DB
        $adsLists = DB::connection('mysql_2')->table('ads as a')
            ->leftJoin('users as b', 'a.user_id', '=', 'b.id')
            ->leftJoin('categories as c', 'a.category_id', '=', 'c.id')
            ->whereDate('a.created_at', '>=', '2022-04-01')
            ->groupBy('a.user_id')
            ->get();

        if ($adsLists->count() > 0) {
            foreach ($adsLists as $adsList) {
                $sellerMobile = $adsList->seller_phone;
                $sellerEmail = $adsList->seller_email;
                $userMobile = $adsList->phone;
                $userFullName = $adsList->name;
                $userFirstName = $adsList->first_name;
                $userLastName = $adsList->last_name;
                $userPassword = $adsList->password;
                $userGender = $adsList->gender;

                $sellerMobileLength = strlen($sellerMobile);
                if ($sellerMobileLength >= 8) {
                    // Touching the Mobile to add in the New DB
                    $newMobile = substr($sellerMobile, -8);

                    $userData = [
                        "mobile" => $newMobile,
                        "username" => $newMobile,
                        "password" => $userPassword ?? bcrypt($newMobile),
                        "country_code" => '+965',
                    ];
                }

                /*if (!empty($sellerEmail)) {
                    $userData['email'] = $sellerEmail;
                }*/
                if (!empty($userFullName)) {
                    $userData['name'] = $userFullName;
                }
                if (!empty($userFirstName)) {
                    $userData['first_name'] = $userFirstName;
                }
                if (!empty($userLastName)) {
                    $userData['last_name'] = $userLastName;
                }
                if (!empty($userGender)) {
                    $userData['gender'] = $userGender;
                }

                User::updateOrCreate(['email' => $sellerEmail], $userData);
                $added++;
            }
        }
        echo "Updated {$added} Users";
    }


    public function importOldAds()
    {
        $added = 0;
        // Fetching the data from the OLD DB
        $adsLists = DB::connection('mysql_2')->table('ads as a')
            ->select(['a.*', 'c.category_slug', 'sc.category_slug as sub_slug'])
            // ->select(['c.category_slug', 'sc.category_slug as sub_slug'])
            ->join('users as b', 'a.user_id', '=', 'b.id')
            ->join('categories as c', 'c.id', '=', 'a.category_id')
            ->join('categories as sc', 'sc.id', '=', 'a.sub_category_id')
            ->whereDate('a.created_at', '>=', '2022-04-01')
            // ->groupBy('a.category_id')
            ->orderBy('a.id', 'asc')
            ->get();

        // dd($adsLists);

        $insArr = [];
        if ($adsLists->count() > 0) {
            foreach ($adsLists as $adsList) {

                $categorySlug = $adsList->category_slug;
                $subCategorySlug = $adsList->sub_slug;

                // Replace the Arrays
                $catReplaceArr = array(
                    "mobile-phones" => "mobile-phones",
                    "fashion-women" => "women-fashion-1",
                    "jobs" => "jobs-1",
                    "home-garden-camp" => "home-decor-1",
                    "car-vehicles" => "cars-vehicles-1",
                    "education" => "others-4",
                    "food-supplements" => "food-supplements",
                    "video-games-consoles" => "sports-games-1",
                    "electronics" => "electronics-1",
                    "services" => "services-1",
                    "business-services-industry" => "construction-1",
                    "pets-animals" => "pets-animals-1",
                    "other" => "others-4",
                    "property" => "construction-1",
                    "health" => "health-1",
                );

                $subCatReplaceArr = array(
                    "mobiles" => "smart-phones",
                    "women-clothing" => "clothing",
                    "skilled-workers" => "freelancers",
                    "bed-matresses-textile" => "other-6",
                    "auto-parts-accessories" => "accessories-5",
                    "education-teaching" => "miscellaneous-1",
                    "ready-cooked-meals" => "other-11",
                    "consoles" => "games",
                    "smart-phone" => "other-2",
                    "movers-packers" => "packers-movers",
                    "construction" => "contractor",
                    "birds" => "birds",
                    "miscellaneous" => "miscellaneous-1",
                    "commercial-space" => "contractor",
                    "healthcare" => "health-care",
                );


                $newCategorySlug = strtr($categorySlug, $catReplaceArr);
                $newCategoryId = Category::whereSlug($newCategorySlug)->first();

                $newSubCategorySlug = strtr($subCategorySlug, $subCatReplaceArr);
                $newSubCategoryId = Category::whereSlug($newSubCategorySlug)->first();

                if (!$newSubCategoryId) {
                    $subId = Category::whereCategoryId($newCategoryId->id)->first();
                    if($subId){
                        $newSubCategoryId = $subId;
                    }
                }

                $sellerName = $adsList->seller_name;
                $sellerMobile = $adsList->seller_phone;
                $sellerEmail = $adsList->seller_email;

                $adID = $adsList->id;
                $adTitle = $adsList->title;
                $adSlug = $adsList->slug;
                $adDescription = $adsList->description;
                $adBrandId = $adsList->brand_id;
                $adType = $adsList->type;
                $adCondition = $adsList->ad_condition;
                $adPrice = $adsList->price;
                $adIsNegotiable = $adsList->is_negotiable;
                $adCountryId = $adsList->country_id;
                $adStateId = $adsList->state_id;
                $adCityId = $adsList->city_id;
                $adAddress = $adsList->address;
                $adView = $adsList->view;
                $adCreatedAt = $adsList->created_at;
                $adUpdatedAt = $adsList->updated_at;

                $userId = User::whereEmail($sellerEmail)->first();

                /*if ($adID == '13929') {
                    echo $newSubCategorySlug;
                    exit;
                }*/

                if (!empty($adSlug) && $userId) {
                    $adData = [
                        "ad_title" => $adTitle,
                        "slug" => $adSlug,
                        "ad_description" => $adDescription,
                        "ad_category_id" => $newCategoryId->id,
                        "ad_sub_category_id" => $newSubCategoryId->id,
                        "ad_condition" => $adCondition ?? 'new',
                        "ad_price" => $adPrice ?? '0',
                        "ad_is_negotiable" => $adIsNegotiable ?? 0,
                        "ad_location_area_cat" => 4,
                        "ad_location_area" => 66,
                        "ad_views" => $adView,
                        "ad_user_id" => $userId->id,
                        "ad_seller_name" => $sellerName,
                        "ad_seller_email" => $sellerEmail,
                        "ad_seller_phone" => $sellerMobile,
                        "ad_seller_address" => $adAddress,
                        "created_at" => $adCreatedAt,
                        "updated_at" => $adUpdatedAt,
                    ];

                    $ad = Ad::updateOrCreate(['slug' => $adSlug], $adData);
                    $insArr[] = $adID;

                    print_r($insArr);

                    // Image Processing Things
                    $adImageLists = DB::connection('mysql_2')->table('media as m')
                        ->select(['m.media_name', 'm.created_at', 'm.updated_at'])
                        ->join('ads as a', 'm.ad_id', '=', 'a.id')
                        ->where('m.ad_id', '=', $adID)
                        ->get();

                    foreach ($adImageLists as $k => $adImageList) {

                        $isFeature = 0;
                        $mediaName = $adImageList->media_name;

                        if ($k == 0) {
                            $isFeature = 1;
                        }

                        DB::connection('mysql')->table('ads_images')->updateOrInsert(
                            ['ads_image' => $mediaName],
                            ['ads_ad_id' => $ad->id, 'is_feature' => $isFeature, 'ads_user_id' => $userId->id, 'created_at' => $adImageList->created_at, 'updated_at' => $adImageList->updated_at]
                        );
                    }
                    $added++;
                }
            }
        }
        echo "Updated {$added} Ads";
    }


}
