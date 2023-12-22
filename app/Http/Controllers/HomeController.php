<?php
// DI CODE - Start
namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Newly Added
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\GeneralMail;
use App\Mail\WelcomeContent;
use App\Models\Category;
use App\Models\Ad;
use App\Models\User;
use App\Models\Post;
use App\Models\Feedback;
use App\Models\Favourite;
use App\Models\Area;
use App\Models\Faq;
use App\Models\Setting;
use App\Models\Visitor;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
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

        Visitor::updateOrCreate($data,$data_update);
        //Visitor::Create($data);
		// Visitors Count - End
		
		session()->forget(['search_text', 'categoryval', 'ad_condition_new', 'ad_condition_used', 'minprice', 'maxprice']);
        $lang = app()->getLocale();
		
        $data			= array();
		$dataCategory	= array();		
        $dataAds		= array();		
        $dataFeatureAds = array();		
        $dataPriorityAds= array();		
        $dataNews		= array();
        $dataLocations	= array();
		
		$name			= 'name_' . $lang;
        $title			= 'title_' . $lang;
        $description	= 'description_' . $lang;
		$location		= 'location_' . $lang;
		
		// Sliders
		$dataSlider = array();
        $sliders = Category::whereNotNull('slide_image')->where('status','1')->get();
		if ($sliders->count() > 0) {
            foreach ($sliders as $slider) {
                $dataSlider[] = [
                    "detail_url" => route('ad.category.list', [app()->getLocale(), $slider->slug]),
                    "image" => asset(Category::$imageUrl .''. $slider->slide_image),
                ];
            }
        }
        $data['sliders'] = $dataSlider;
		
		// Categories
		$categoryImageBase = Category::$imageUrl;	
		$categories = Category::select('categories.id', 'categories.name_en', 'categories.name_ar', 'categories.slug', 'categories.image', DB::raw('COUNT('.DB::getTablePrefix().'ads.ad_category_id) as catcount'))
			->leftJoin('ads', 'categories.id', '=', 'ads.ad_category_id')
			->where('categories.category_id','0')
			->where('ads.status','1')
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
                    "image" => !empty($category->image) ? asset($categoryImageBase . $category->image) : asset(Category::$noImageUrl),
					"adsCountCategory" => $category->catcount,
                ];
            }
        }
        $data['categories'] = $dataCategory;
		
		
		// Latest Ads
		/*$latestAds = Ad::select('ads.*', 'areas.name_en as location_en', 'areas.name_ar as location_ar', 'ads_images.ads_image')
			->leftJoin('areas', 'ads.ad_location_area', '=', 'areas.id')
			->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')			
			->where('ads.status','1')
			->groupBy('ads.id')
			->orderBy('id', 'desc')->limit(10)->get();		
		
        if ($latestAds->count() > 0) {
            foreach ($latestAds as $latestAd) {
				// Logged in user - Favourite Ads 
				$user = auth()->user();
				$fav_val='';
				if($user)
				{
					$favourite = Favourite::where(['status'=>'1', 'ads_ad_id'=>$latestAd->id, 'user_id'=>$user->id])->first();
					if($favourite)
					{
						$fav_val = 'Favourite';
					}
				}	
				$ad_price = explode('.',$latestAd->ad_price);
                $dataAds[] = [
					'detail_url'	=> route('viewad', [app()->getLocale(), $latestAd->slug]),
                    "id" => $latestAd->id,
                    "name" => $latestAd->ad_title,
                    "slug" => $latestAd->slug,
                    "price" => $ad_price[0],
                    "location" => $latestAd->$location,
                    "description" => strip_tags(substr($latestAd->ad_description, 0, 55)).' ...',
                    "featured" => $latestAd->ad_is_featured,
					//"image" => asset(Ad::$imageUrl . $latestAd->ads_image),
					"image" => !empty($latestAd->ads_image) ? asset(Ad::$imageThumbUrl . $latestAd->ads_image) : asset(Ad::$noImageUrl),
                    "favourite" => $fav_val,
                ];
            }
        }
        $data['latestAds'] = $dataAds;*/		
		$latestAds = Ad::select('ads.*', 'areas.name_en as location_en', 'areas.name_ar as location_ar', 
								//'ads_images.ads_image', 
								'users.name', 'users.first_name', 'users.last_name', 'users.mobile', 'users.avatar')
			->leftJoin('areas', 'ads.ad_location_area', '=', 'areas.id')
			//->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')	
			->leftJoin('users', 'ads.ad_user_id', '=', 'users.id')					
			->where('ads.status','1')
			->groupBy('ads.id')
			->orderBy('id', 'desc')->limit(10)->get();		
		
        if ($latestAds->count() > 0) {
            foreach ($latestAds as $latestAd) {
				// Logged in user - Favourite Ads 
				$user = auth()->user();
				$fav_val='';
				if($user)
				{
					$favourite = Favourite::where(['status'=>'1', 'ads_ad_id'=>$latestAd->id, 'user_id'=>$user->id])->first();
					if($favourite)
					{
						$fav_val = 'Favourite';
					}
				}	
				$ad_price = explode('.',$latestAd->ad_price);
				$adfeatureimage = DB::table('ads_images')->where(['ads_ad_id'=>$latestAd->id, 'is_feature'=>'1', 'deleted_at'=>null, ])->first();
				if($adfeatureimage)
				{
					$adimage = $adfeatureimage;
				}
				else
				{
					$adfeatureimage = DB::table('ads_images')->where(['ads_ad_id'=>$latestAd->id, 'deleted_at'=>null, ])->first();
				 	$adimage = $adfeatureimage;
				}
                $dataAds[] = [
					'detail_url'	=> route('viewad', [app()->getLocale(), $latestAd->slug]),
                    "id" => $latestAd->id,
                    "name" => $latestAd->ad_title,
                    "slug" => $latestAd->slug,
                    "price" => $ad_price[0],
                    "views" => !empty($latestAd->ad_views) ? $latestAd->ad_views : '0',
                    "location" => $latestAd->$location,
                    "description" => strip_tags(substr($latestAd->ad_description, 0, 50)).' ...',
                    "featured" => $latestAd->ad_is_featured,
					//"image" => asset(Ad::$imageUrl . $latestAd->ads_image),
					"image" => !empty($adimage->ads_image) ? asset(Ad::$imageThumbUrl . $adimage->ads_image) : asset(Ad::$noImageUrl),
                    "createddate" => $latestAd->created_at->diffForHumans(),
                    //"user_name" => !empty($latestAd->first_name && $latestAd->last_name) ? ($latestAd->first_name.' '.$latestAd->last_name) : $latestAd->name,
                    "user_name" => !empty($latestAd->first_name) ? ($latestAd->first_name) : $latestAd->name,
                    "user_mobile" => $latestAd->mobile,
					"user_avatar" => !empty($latestAd->avatar) ? asset(User::$imageThumbUrl . $latestAd->avatar) : asset(User::$noImageUrl),
                    "favourite" => $fav_val,
                ];
            }
        }
        $data['latestAds'] = $dataAds;
		
		
		// Recommended/Priority Ads
		$priorityAds = Ad::select('ads.*', 'areas.name_en as location_en', 'areas.name_ar as location_ar',
								  //'ads_images.ads_image', 
								  'users.name', 'users.first_name', 'users.last_name', 'users.mobile', 'users.avatar')
			->leftJoin('areas', 'ads.ad_location_area', '=', 'areas.id')
			//->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')
			->leftJoin('users', 'ads.ad_user_id', '=', 'users.id')			
			->where('ads.ad_priority','1')
			->where('ads.status','1')
			->groupBy('ads.id')
			->orderBy('id', 'desc')->limit(10)->get();				
        if ($priorityAds->count() > 0) {
            foreach ($priorityAds as $priorityAd) {
				$ad_price = explode('.',$priorityAd->ad_price);
				$adfeatureimage = DB::table('ads_images')->where(['ads_ad_id'=>$priorityAd->id, 'is_feature'=>'1', 'deleted_at'=>null, ])->first();
				if($adfeatureimage)
				{
					$adimage = $adfeatureimage;
				}
				else
				{
					$adfeatureimage = DB::table('ads_images')->where(['ads_ad_id'=>$priorityAd->id, 'deleted_at'=>null, ])->first();
				 	$adimage = $adfeatureimage;
				}
                $dataPriorityAds[] = [
					'detail_url'	=> route('viewad', [app()->getLocale(), $priorityAd->slug]),
                    "id" => $priorityAd->id,
                    "name" => $priorityAd->ad_title,
                    "slug" => $priorityAd->slug,
                    "price" => $ad_price[0],
                    "views" => !empty($priorityAd->ad_views) ? $priorityAd->ad_views : '0',
                    "location" => $priorityAd->$location,
                    "description" => strip_tags(substr($priorityAd->ad_description, 0, 50)).' ...',
                    "featured" => $priorityAd->ad_is_featured,
					//"image" => asset(Ad::$imageUrl . priorityAd->ads_image),
					"image" => !empty($adimage->ads_image) ? asset(Ad::$imageThumbUrl . $adimage->ads_image) : asset(Ad::$noImageUrl),
                    "createddate" => $priorityAd->created_at->diffForHumans(),
                    //"user_name" => !empty($priorityAd->first_name && $priorityAd->last_name) ? ($priorityAd->first_name.' '.$priorityAd->last_name) : $priorityAd->name,
                    "user_name" => !empty($priorityAd->first_name) ? ($priorityAd->first_name) : $priorityAd->name,
                    "user_mobile" => $priorityAd->mobile,
					"user_avatar" => !empty($priorityAd->avatar) ? asset(User::$imageThumbUrl . $priorityAd->avatar) : asset(User::$noImageUrl),
                ];
            }
        }
        $data['priorityAds'] = $dataPriorityAds;
		
		// Featured Ads
        //$featureAds = Ad::active()->with('categories', 'brands')->whereIsFeature(1)->limit(4)->get();
		$featureAds = Ad::select('ads.*', 'areas.name_en as location_en', 'areas.name_ar as location_ar', 
								 //'ads_images.ads_image',
								 'users.name', 'users.first_name', 'users.last_name', 'users.mobile', 'users.avatar')
			->leftJoin('areas', 'ads.ad_location_area', '=', 'areas.id')
			//->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')
			->leftJoin('users', 'ads.ad_user_id', '=', 'users.id')			
			->where('ads.ad_is_featured','1')
			->where('ads.status','1')
			->groupBy('ads.id')
			->orderBy('id', 'desc')->limit(10)->get();				
        if ($featureAds->count() > 0) {
            foreach ($featureAds as $featureAd) {
				$ad_price = explode('.',$featureAd->ad_price);
				$adfeatureimage = DB::table('ads_images')->where(['ads_ad_id'=>$featureAd->id, 'is_feature'=>'1', 'deleted_at'=>null, ])->first();
				if($adfeatureimage)
				{
					$adimage = $adfeatureimage;
				}
				else
				{
					$adfeatureimage = DB::table('ads_images')->where(['ads_ad_id'=>$featureAd->id, 'deleted_at'=>null, ])->first();
				 	$adimage = $adfeatureimage;
				}
                $dataFeatureAds[] = [
					'detail_url'	=> route('viewad', [app()->getLocale(), $featureAd->slug]),
                    "id" => $featureAd->id,
                    "name" => $featureAd->ad_title,
                    "slug" => $featureAd->slug,
                    "price" => $ad_price[0],
                    "views" => !empty($featureAd->ad_views) ? $featureAd->ad_views : '0',
                    "location" => $featureAd->$location,
                    "description" => strip_tags(substr($featureAd->ad_description, 0, 50)).' ...',
                    "featured" => $featureAd->ad_is_featured,
					//"image" => asset(Ad::$imageUrl . featureAd->ads_image),
					"image" => !empty($adimage->ads_image) ? asset(Ad::$imageThumbUrl . $adimage->ads_image) : asset(Ad::$noImageUrl),
                    "createddate" => $featureAd->created_at->diffForHumans(),
                    //"user_name" => !empty($featureAd->first_name && $featureAd->last_name) ? ($featureAd->first_name.' '.$featureAd->last_name) : $featureAd->name,
                    "user_name" => !empty($featureAd->first_name) ? ($featureAd->first_name) : $featureAd->name,
                    "user_mobile" => $featureAd->mobile,
					"user_avatar" => !empty($featureAd->avatar) ? asset(User::$imageThumbUrl . $featureAd->avatar) : asset(User::$noImageUrl),
                ];
            }
        }
        $data['featureAds'] = $dataFeatureAds;
		
		
		// Latest News
        //$posts = Post::whereType('post')->limit(3)->get();
        $posts = Post::whereType('post')->orderby('id','desc')->get();
        if ($posts->count() > 0) {
            foreach ($posts as $post) {
                $dataNews[] = [
                    "id" => $post->id,
                    "slug" => $post->slug,
                    "name" => $post->$title,
                    "description" => strip_tags(substr($post->$description, 0, 100)).' ...',
                    "image" => !empty($post->image_name) ? asset(Post::$imageMediumUrl . $post->image_name) : asset(Post::$noImageUrl),
                    "date" => date('M-d-Y', strtotime($post->post_date)),
                    "when" => $post->post_date->diffForHumans(),
                ];
            }
        }
        $data['news'] = $dataNews;
		
		
		// Ads by locations
		/*$locations = Area::select('areas.name_en as location_en','areas.name_ar as location_ar','areas.slug', 'areas.image', DB::raw('COUNT('.DB::getTablePrefix().'ads.id) as countvalue'))
			->leftjoin('ads','areas.id', '=', 'ads.ad_location_area_cat')
			->where(['areas.area_id'=>'0', 'areas.status'=>'1', 'ads.status'=>'1'])
			->whereNull('ads.deleted_at')
			->groupby('areas.id')
			->get();*/
		$locations = Area::select('areas.id', 'areas.name_en as location_en','areas.name_ar as location_ar','areas.slug', 'areas.image')
			->where(['areas.area_id'=>'0', 'areas.status'=>'1'])
			->groupby('areas.id')
			->get();
        if ($locations->count() > 0) {
            foreach ($locations as $locationlist) {
				$ads = Ad::select(DB::raw('COUNT('.DB::getTablePrefix().'ads.id) as countvalue'))
					->where(['ads.status'=>'1', 'ads.ad_location_area_cat'=>$locationlist->id])
					->whereNull('ads.deleted_at')
					->first();
                $dataLocations[] = [
                    "name"		=> $locationlist->$location,
                    "slug"		=> $locationlist->slug,
                    "image"		=> !empty($locationlist->image) ? asset(Area::$imageMediumUrl . $locationlist->image) : asset(Area::$noImageUrl),
                    "countvalue"=> $ads->countvalue,
                ];
            }
        }
        $data['locations'] = $dataLocations;
		
		// Visitors
		$total_visitors = Visitor::get();
		$data['total_visitors'] = count($total_visitors)>0 ? count($total_visitors) : '0';
		
		// Total Users
		$total_users = User::get();
		$data['total_users'] = count($total_users)>0 ? count($total_users) : '0';
		
		// Total Ads
		$total_ads = Ad::get();
		$data['total_ads'] = count($total_ads)>0 ? count($total_ads) : '0';
        
        return view('home', compact('data'));
    }
	
	public function contactUs()
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

        Visitor::updateOrCreate($data,$data_update);
        //Visitor::Create($data);
		// Visitors Count - End
		
        $titles = [
            'title' => __('app.contact_us')
        ];
        return view('contact', compact('titles'));
    }

    public function contactSubmit(Request $request)
    {
        $validator = $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $data = [
            "name" => $request->name,
            "email" => $request->email,
            "subject" => $request->subject,
            "message" => $request->message,
        ];

        Feedback::updateOrCreate($data);
		
		// Send to user
		if(!empty($request->email))
		{
			$maildetails = [					
				'subject'	=> trans("app.contact_user_mail_subject"),
				'title'		=> trans("app.contact_user_mail_title"),
				'name'		=> $request->name,
				'note'		=> trans("app.contact_user_mail_note"),
				'content'	=> trans("app.contact_user_mail_content"),
				'lang'		=> app()->getLocale(),
			];
			Mail::to($request->email)->send(new WelcomeContent($maildetails));	
		}
		// Send to Contact - Settings in Back End
		$settingsDetails = Setting::find(1);
		if(!empty($settingsDetails->contact_email))
		{
			$maildetails = [					
				'subject'	=> 'Received a contact us mail from'.env('APP_NAME'),
				'title'		=> 'Hi',
				'name'		=> 'Admin',
				'note'		=> 'Received a contact us form details',
				'content'	=> '<table>
									<tr><td style="border: 1px solid black;">Name</td><td style="border: 1px solid black;">'.$request->name.'</td>
									<tr><td style="border: 1px solid black;">Email</td><td style="border: 1px solid black;">'.$request->email.'</td></tr>
									<tr><td style="border: 1px solid black;">Subject</td><td style="border: 1px solid black;">'.$request->subject.'</td></tr>
									<tr><td style="border: 1px solid black;">Message</td><td style="border: 1px solid black;">'.$request->message.'</td></tr>
								</table>',
				'lang'		=> app()->getLocale(),
			];
			Mail::to($settingsDetails->contact_email)->send(new GeneralMail($maildetails));	
		}
		
		
        //return ["status" => 200, "message" => "Success"];
		return redirect()->route('contact', app()->getLocale())->with('success', trans("app.sent_successfully"));
    }
	
	public function categories()
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

        Visitor::updateOrCreate($data,$data_update);
        //Visitor::Create($data);
		// Visitors Count - End
		
		$lang = app()->getLocale();
		
        $data			= array();	
		$dataCategory	= array();
		
		$name			= 'name_' . $lang;
		
		$categories = Category::select('categories.id', 'categories.name_en', 'categories.name_ar', 'categories.slug', 'categories.banner_image' )		
			->where('categories.category_id','0')
			->orderBy('categories.id')
			->get();	
        if ($categories->count() > 0) {
            foreach ($categories as $category) {
				$adsCountCategory = Ad::select(DB::raw('COUNT('.DB::getTablePrefix().'ads.ad_category_id) as catcount'))->where('ads.status','1')->where('ad_category_id',$category->id)->first();
                $dataCategory[] = [
                    "name" => $category->$name,
                    "slug" => $category->slug,
                    "image" => !empty($category->banner_image) ? asset(Category::$imageMediumUrl . $category->banner_image) : asset(Category::$noImageUrl),
					"adsCountCategory" => $adsCountCategory->catcount,
                ];
            }
        }
		
		$titles		= ["title" => 'Categories' ];
		$data = [
			'categories' => $dataCategory,
		];
		
		return view('front.ad.categories', compact('titles', 'data'));
	}
	
	public function faq()
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

        Visitor::updateOrCreate($data,$data_update);
        //Visitor::Create($data);
		// Visitors Count - End
		
		$lang = app()->getLocale();
		
		$name = 'faq_title_'.$lang;
		$description = 'faq_description_'.$lang;
		
		$dataFaq = array();
		$faqs = Faq::where('status','1')->orderby('id','desc')->get();
		if ($faqs->count() > 0) {
            foreach ($faqs as $faq) {
                $dataFaq[] = [
                    "title"			=> $faq->$name,
                    "slug"			=> $faq->slug,
                    "description"	=> $faq->$description,
                ];
            }
        }
		$titles = [ 'title' => __('app.faq') ];
		$data['faqs'] = $dataFaq;
		
        return view('front.content.faq', compact('titles', 'data'));
	}
}
// DI CODE - End