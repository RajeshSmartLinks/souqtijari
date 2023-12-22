<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use App\Models\Country;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class DataMigrationController extends Controller
{
    public function DumpCountries(){
        $oldCountries =    DB::select('select * from countries where is_migrate =0');
        foreach ($oldCountries as $key => $value) {
            $Createdata = array(
                'code'=>$value->country_code,
                'name_en'=>$value->country_name,
                'name_ar'=>$value->country_name_ar,
                'status'=>$value->email,
            );
            //dd($Createdata);
            if( Country::create($Createdata))
            {
                DB::select('UPDATE `countries` SET `is_migrated` = 1 WHERE `users`.`id` = ?',[$value->id]);
            }

        }

    }
    public function DumpUsers(){
        $oldusers =    DB::select('select * from users where is_migrate =0');
        foreach ($oldusers as $key => $value) {
            $Createdata = array(
                'first_name'=>$value->first_name,
                'last_name'=>$value->last_name,
                'name'=>$value->name,
                'email'=>$value->email,
                'password'=>$value->password,
                'mobile'=>$value->mobile,
                'gender'=>$value->gender,
                'address'=>$value->address,
                'country_id'=>$value->country_id,
                'website'=>$value->website,
                'avatar'=>$value->photo,
                'admin_type'=>$value->user_type,
                'status'=>$value->active_status,
                'activation_code'=>$value->activation_code,
                'last_login'=>$value->last_login,
                'remember_token'=>$value->remember_token,
                'created_at'=>$value->created_at,
                'updated_at'=>$value->updated_at
            );
            dd($Createdata);
            if( User::create($Createdata))
            {
                DB::select('UPDATE `users` SET `is_migrated` = 1 WHERE `users`.`id` = ?',[$value->id]);
            }

        }
        dd($oldusers);
        
    }

    
    public function uploadOldAds(){

        $oldAds = DB::table('old_ads')->select('*')->where('is_moved', 0)->limit(300)->get();
        foreach ($oldAds as $key => $value) {

                //category
                $category = Category::where('name_en' , $value->category_name)->first();


                if(empty($category))
                {
                    $categoryArray = [
                        'category_id' => 0,
                        'name_en'=> $value->category_name,
                        'name_ar'=> $value->category_name_ar,
                        'slug' => unique_slug($value->category_name,'Category'),
                        'status'    => 1,
                        'is_migrated' => 1
                    ];

                    
                    $category = Category::create($categoryArray);
                    
                    $categoryId = $category->id;
                }else{
                    $categoryId = $category->id;
                }
                //subcategory
                $subcategory = Category::where('name_en' , $value->sub_category_name)->where('category_id' , $categoryId)->first();
                if(empty($subcategory))
                {
                    $subcategoryArray = [
                        'category_id' => $categoryId,
                        'name_en'=> $value->sub_category_name,
                        'name_ar'=> $value->sub_category_name_ar,
                        'slug' => unique_slug($value->sub_category_name,'Category'),
                        'status'    => 1,
                        'is_migrated' => 1
                    ];
                    $subcategory = Category::create($subcategoryArray);
                    $subcategoryId = $subcategory->id;
                }else{
                    $subcategoryId = $subcategory->id;
                }
                $adArray =[
                'ad_title' => $value->title,
                'slug' =>  unique_slug($value->slug, 'Ad'),
                'ad_description' => $value->description,
                'ad_category_id' => $categoryId,
                'ad_sub_category_id' => $subcategoryId,
                'ad_brand_id' => NULL,
                'ad_condition' => $value->ad_condition,
                'ad_price' => $value->price,
                'ad_is_negotiable' => !empty($value->is_negotiable)? $value->is_negotiable : '',
                'ad_location_area_cat' => 4,
                'ad_location_area' => 66,
                'ad_user_id' => 122, 
                'ad_seller_name' => $value->seller_name,
                'ad_seller_email' => $value->seller_email,
                'ad_seller_phone' => $value->seller_phone,
                'ad_seller_whatsapp' => null,
                'ad_seller_address' => null,
                'ad_views' => 0,
                'ad_is_featured' => 0,
                'ad_priority' => 0,
                'status' => $value->status,
                'is_migrated' => 1
            ];
            $ad = Ad::create($adArray);

           //images insert
           if(!empty($value->imagePath))
           {

           
            $images = explode("," ,$value->imagePath);
            
            foreach ($images as $ke => $image) {
               
                $main_from = '/home/customer/www/v1.souqtijari.net/public_html/uploads/images/'.$image;
                $main_to = '/home/customer/www/kw.souqtijari.net/public_html/uploads/ad/old/'.$image;

                $medium_from = '/home/customer/www/v1.souqtijari.net/public_html/uploads/images/'.$image;
                $medium_to = '/home/customer/www/kw.souqtijari.net/public_html/uploads/ad/old/'.$image;

                //copying from old path to new path
                try{
                     if(copy($main_from, $main_to) && copy($medium_from, $medium_to))
                    {
                        DB::insert('insert into sls_ads_images (ads_ad_id,ads_user_id,ads_image) values (?, ?, ?)', [$ad->id, 20, 'old/'.$image]);
                    }
                } catch (Exception $e) {



                }
                
               
                
            };
           }

            //updating is_moved key
            DB::update('UPDATE `sls_old_ads` SET `is_moved` = 1 WHERE `id` = ?',[$value->id]);
        }
    }

    public function uploadOldUsers(){
        $oldAds = DB::table('old_users')->select('*')->where('is_moved', 0)
         ->Where(function ($query) {
                $query->whereNotNull('email')
                      ->whereNotNull('password');
            })->limit(1000)->get();
        foreach ($oldAds as $key => $value) {
            $userInfo = User::where('email' , $value->email)->first();
            if(empty($userInfo))
            {
                DB::enableQueryLog();
                $userInfo = User::create([
                    'device_token' => null,
                    'device_type' => null,
                    'name' => empty($value->user_name) ? '' :$value->user_name,
                    'first_name' => $value->first_name,
                    'last_name' => $value->last_name,
                    'email' => $value->email,
                    'email_verified_at' => null,
                    'username' => null,
                    'mobile' => $value->mobile,
                    'password' =>$value->password,
                    'admin_type' => $value->user_type,
                    'status' => $value->active_status,
                    'new_user' => 1,
                    'is_migrated' => 1,
                    'is_admin' => $value->user_type == 'admin' ? 1 : 0,
                    ]);
            }
            //updating is_moved key
            DB::update('UPDATE `sls_old_users` SET `is_moved` = 1 WHERE `id` = ?',[$value->id]);
            # code...
        }

    }
   
}
