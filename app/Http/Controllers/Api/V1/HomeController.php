<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Ad;
use App\Models\Area;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Favourite;
use App\Models\Post;
use App\Models\User;
use Dotenv\Result\Success;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class HomeController extends BaseApiController
{
    public function index(Request $request, $sessionId = 'sample')
    {
        $strLang = app()->getLocale();

        $sessionId = $request->device_token;

        $title = "title_" . $strLang;
        $name = 'name_' . $strLang;
        $description = 'description_' . $strLang;
        $location = 'location_' . $strLang;

        // Categories
        $banners = Category::ActiveParent()->where('slide_image', '!=', '')->orderBy($name, 'asc')->get();
        $categories = Category::ActiveParent()->with('child')->orderBy($name, 'asc')->get();

        $bannerList = array();
        $categoryList = array();
        $locationDatalist = array();
        $dataFeatureAds = array();
        $dataPriorityAds = array();
        $dataAds = array();

        // Banners
        if ($banners->count() > 0) {
            foreach ($banners as $banner) {
                $imageName = $banner['slide_image'];

                if (!empty($imageName)) {
                    $imageUrl = asset(Category::$imageUrl . $imageName);
                    $bannerList[] = array(
                        "id" => $banner['id'],
                        "name" => $banner['name_' . $strLang],
                        "image" => $imageUrl,
                    );
                }
            }
        }

        // Categories
        if ($categories->count() > 0) {
            foreach ($categories as $category) {
                $sublist = array();

                $all = ($strLang == 'en') ? 'All' : 'الكل';

                $imageName = $category['image'];

                $sublist[] = array(
                    "id" => 0,
                    "name" => $all,
                );

                if ($category->child->count() > 0) {
                    foreach ($category->child as $subCat) {
                        $sublist[] = array(
                            "id" => $subCat['id'],
                            "name" => $subCat['name_' . $strLang],
                        );
                    }
                }

                $imageUrl = asset(Category::$imageUrl . $category['banner_image']);
                $iconUrl = asset(Category::$imageUrl . $category['image']);

                $categoryList[] = array(
                    "id" => $category['id'],
                    "name" => $category['name_' . $strLang],
                    "image" => $imageUrl,
                    "icon" => $iconUrl,
                    "sub_category" => $sublist,
                );

            }
        }

        // Recommended/Priority Ads
        $priorityAds = Ad::select('ads.*', 'areas.name_en as location_en', 'areas.name_ar as location_ar', 'ads_images.ads_image', 'users.name', 'users.first_name', 'users.last_name', 'users.mobile', 'users.avatar', 'pc.name_en as parent_cat_en', 'pc.name_ar as parent_cat_ar', 'pc.slug as parent_cat_slug', 'sc.name_en as sub_cat_en', 'sc.name_ar as sub_cat_ar')
            ->leftJoin('areas', 'ads.ad_location_area', '=', 'areas.id')
            ->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')
            ->leftJoin('users', 'ads.ad_user_id', '=', 'users.id')
            ->leftjoin('categories as pc', 'ads.ad_category_id', '=', 'pc.id')
            ->leftjoin('categories as sc', 'ads.ad_sub_category_id', '=', 'sc.id')
            ->where('ads.ad_priority', '1')
            ->where('ads.status', '1')
            ->groupBy('ads.id')
            ->orderBy('updated_at', 'desc')->limit(10)->get();

        $dataPriorityAds = $this->populateAdsList($sessionId, $priorityAds, 0, $strLang);
        $dataPriorityAds = $dataPriorityAds['result'];

        // Feature Ads
        $featureAds = Ad::select('ads.*', 'areas.name_en as location_en', 'areas.name_ar as location_ar', 'ads_images.ads_image', 'users.name', 'users.first_name', 'users.last_name', 'users.mobile', 'users.avatar', 'pc.name_en as parent_cat_en', 'pc.name_ar as parent_cat_ar', 'pc.slug as parent_cat_slug', 'sc.name_en as sub_cat_en', 'sc.name_ar as sub_cat_ar')
            ->leftJoin('areas', 'ads.ad_location_area', '=', 'areas.id')
            ->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')
            ->leftJoin('users', 'ads.ad_user_id', '=', 'users.id')
            ->leftjoin('categories as pc', 'ads.ad_category_id', '=', 'pc.id')
            ->leftjoin('categories as sc', 'ads.ad_sub_category_id', '=', 'sc.id')
            ->where('ads.ad_is_featured', '1')
            ->where('ads.status', '1')
            ->groupBy('ads.id')
            ->orderBy('updated_at', 'desc')->limit(10)->get();

        $dataFeatureAds = $this->populateAdsList($sessionId, $featureAds, 0, $strLang);
        $dataFeatureAds = $dataFeatureAds['result'];

        // Latest Ads
        $latestAds = Ad::select('ads.*', 'areas.name_en as location_en', 'areas.name_ar as location_ar', 'ads_images.ads_image', 'users.name', 'users.first_name', 'users.last_name', 'users.mobile', 'users.avatar', 'pc.name_en as parent_cat_en', 'pc.name_ar as parent_cat_ar', 'pc.slug as parent_cat_slug', 'sc.name_en as sub_cat_en', 'sc.name_ar as sub_cat_ar')
            ->leftJoin('areas', 'ads.ad_location_area', '=', 'areas.id')
            ->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')
            ->leftJoin('users', 'ads.ad_user_id', '=', 'users.id')
            ->leftjoin('categories as pc', 'ads.ad_category_id', '=', 'pc.id')
            ->leftjoin('categories as sc', 'ads.ad_sub_category_id', '=', 'sc.id')
            ->where('ads.status', '1')
            ->groupBy('ads.id')
            ->orderBy('id', 'desc')->limit(10)->get();

        $dataAds = $this->populateAdsList($sessionId, $latestAds, 0, $strLang);
        $dataAds = $dataAds['result'];


        // Location Ads
        $locations = Area::select('areas.id', 'areas.name_en as location_en', 'areas.name_ar as location_ar', 'areas.slug', 'areas.image')
            ->where(['areas.area_id' => '0', 'areas.status' => '1'])
            ->groupby('areas.id')
            ->get();

        if ($locations->count() > 0) {
            foreach ($locations as $locationlist) {
                $ads = Ad::select(DB::raw('COUNT(' . DB::getTablePrefix() . 'ads.id) as countvalue'))
                    ->where(['ads.status' => '1', 'ads.ad_location_area_cat' => $locationlist->id])
                    ->whereNull('ads.deleted_at')
                    ->first();
                $locationDatalist[] = [
                    "id" => $locationlist->id,
                    "name" => $locationlist->$location,
                    "slug" => $locationlist->slug,
                    "image_medium" => !empty($locationlist->image) ? asset(Area::$imageMediumUrl . $locationlist->image) : asset(Area::$noImageUrl),
                    "image" => !empty($locationlist->image) ? asset(Area::$imageUrl . $locationlist->image) : asset(Area::$noImageUrl),
                    "countvalue" => $ads->countvalue,
                ];
            }
        }

        $results = array(
            "banners" => $bannerList,
            "categories" => $categoryList,
            "locations" => $locationDatalist,
            "features" => ['heading' => 'Feature Ads', 'ads' => $dataFeatureAds],
            "recommended" => ['heading' => 'Recommended Ads', 'ads' => $dataPriorityAds],
            "latest" => ['heading' => 'Latest Ads', 'ads' => $dataAds],
        );

        return $this->sendResponse(200, ['data' => $results, 'message' => trans('app.success')]);
    }

    public function categories(Request $request)
    {
        $strLang = app()->getLocale();
        $catId = $request->cat_id ?? 0;

        $all = ($strLang == 'en') ? 'All' : 'الكل';

        $categories = Category::whereCategoryId($catId)->with('child')->orderBy($this->getMyName(), 'asc')->get();

        foreach ($categories as $category) {
            $sublists = array();
            $categoryId = $category['id'];
            $title = $category['name_' . $strLang];
            $imageUrl = $category->banner_image ? asset(Category::$imageUrl . $category->banner_image) : '';
            $iconUrl = $category->image ? asset(Category::$imageUrl . $category->image) : '';

            $sublists[] = array(
                "id" => 0,
                "name" => $all,
            );

            if ($category->child->count() > 0) {
                foreach ($category->child as $subCat) {
                    $sublists[] = array(
                        "id" => $subCat['id'],
                        "name" => $subCat['name_' . $strLang],
                    );
                }
            }

            $lists[] = array(
                "id" => $categoryId,
                "name" => $title,
                "image" => $imageUrl,
                "icon" => $iconUrl,
                "sub_category" => $sublists,
            );

        }

        return $this->sendResponse(200, ['data' => $lists, 'message' => self::SUCCESS_MSG, 'info' => self::SUCCESS_MSG]);
    }


    public function brands(Request $request)
    {
        $strLang = app()->getLocale();

        $brands = Brand::orderBy($this->getMyName(), 'asc')->get();
        $lists = [];

        foreach ($brands as $brand) {
            $title = $brand['name_' . $strLang];
            $imageUrl = $brand->image ? asset(Brand::$imageUrl . $brand->image) : asset(Config::get('constants.NO_IMG_ADMIN'));;

            $lists[] = array(
                "id" => $brand->id,
                "category_id" => $brand->category_id,
                "name" => $title,
                "image" => $imageUrl
            );
        }

        return $this->sendResponse(200, ['data' => $lists, 'message' => self::SUCCESS_MSG, 'info' => self::SUCCESS_MSG]);
    }

    public function getContentPage($keyword)
    {
        $strLang = app()->getLocale();
        if (!$keyword) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => 'Enter Keyword']);
        }

        $content = Post::whereType('page')->whereStatus(1)->whereSlug($keyword)->first();
        if ($content) {
            $result = array(
                "id" => $content['id'],
                "title" => $content['title_' . $strLang],
                "description" => $content['description_' . $strLang],
            );
            return $this->sendResponse(self::HTTP_OK, ['data' => $result, 'message' => trans('app.success')]);
        }
        return $this->sendResponse(self::HTTP_ERR, ['message' => trans('app.failed')]);
    }

    public function areas($stateId = '')
    {

        $strLang = app()->getLocale();

        if ($stateId) {
            $areas = Area::whereAreaId($stateId)->get();
        } else {
            $areas = Area::activeParent()->get();
        }

        $lists = array();

        foreach ($areas as $area) {
            $sublists = array();
            $areaId = $area['id'];
            $title = $area['name_' . $strLang];

            if ($area->child->count() > 0) {
                foreach ($area->child as $subArea) {
                    $sublists[] = array(
                        "id" => $subArea['id'],
                        "parent" => 0,
                        "child" => 1,
                        "name" => $subArea['name_' . $strLang],
                    );
                }
            }

            $lists[] = array(
                "id" => $areaId,
                "name" => $title,
                "parent" => 1,
                "child" => 0,
                "sub_area" => $sublists,
            );
        }

        return $this->sendResponse(self::HTTP_OK, ['data' => $lists, 'message' => trans('app.success')]);

        // return $this->sendResponse(self::HTTP_ERR, ['message' => trans('app.failed')]);
    }


    public function faq()
    {
        $strLang = app()->getLocale();

        $name = 'faq_title_' . $strLang;
        $description = 'faq_description_' . $strLang;

        $lists = array();

        $faqs = Faq::where('status', '1')->orderby('id', 'desc')->get();
        if ($faqs->count() > 0) {
            foreach ($faqs as $faq) {
                $lists[] = array(
                    "title" => $faq->$name,
                    "description" => $faq->$description,
                );
            }

            return $this->sendResponse(self::HTTP_OK, ['data' => $lists, 'message' => trans('app.success')]);
        }
        return $this->sendResponse(self::HTTP_ERR, ['message' => trans('app.failed')]);
    }


}
