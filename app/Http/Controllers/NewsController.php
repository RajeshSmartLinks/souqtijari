<?php
// DI CODE - Start
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Visitor;
use Illuminate\Http\Request;

class NewsController extends Controller
{
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
        $titles = [
            "title" => __('app.news'),
        ];
        $lists = Post::whereType('post')->paginate(9);
        return view('front.content.index', compact('titles', 'lists'));
    }

    public function getSingle($lang, $slug)
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
		
        $title = $this->myTitle;
        $description = $this->myDescription;

        if ($slug) {
            $details = Post::whereSlug($slug)->first();
            if ($details) {
                $titles = [
                    'title' => $details->$title,
                    'description' => strip_tags($details->$description),
                ];
                $data['created'] = $details->created_at->diffForHumans();
                $data['slug'] = $details->slug;
                $data['title'] = $details->$title;
                $data['description'] = $details->$description;
                $data['image'] = $details->image_name ? asset(Post::$imageUrl . $details->image_name) : '';

                return view('front.content.view', compact('data', 'titles'));
            }
        }
        return redirect(route('home', app()->getLocale()));
    }

    public function aboutUs($lang, $slug = 'about-us')
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
		
        $title = $this->myTitle;
        $description = $this->myDescription;
        if ($slug) {
            $details = Post::whereSlug($slug)->first();
            if ($details) {
                $titles = [
                    'title' => $details->$title,
                    'description' => strip_tags($details->$description),
                ];
                $data['created'] = $details->created_at->diffForHumans();
                $data['slug'] = $details->slug;
                $data['title'] = $details->$title;
                $data['description'] = $details->$description;
                $data['image'] = $details->image_name ? asset(Post::$imageUrl . $details->image_name) : '';
                return view('front.content.view', compact('data','titles'));
            }

        }
        return redirect(route('home', app()->getLocale()));
    }

    public function privacyPolicy($lang, $slug = 'privacy-policy')
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
		
        $title = $this->myTitle;
        $description = $this->myDescription;
        if ($slug) {
            $details = Post::whereSlug($slug)->first();
            if ($details) {
				$titles = [
                    'title' => $details->$title,
                    'description' => strip_tags($details->$description),
                ];
                $data['slug'] = $details->slug;
                $data['title'] = $details->$title;
                $data['description'] = $details->$description;
                $data['created'] = $details->created;
                $data['image'] = $details->image_name ? asset(Post::$imageUrl . $details->image_name) : '';
                return view('front.content.view', compact('data','titles'));
            }
        }
        return redirect(route('home', app()->getLocale()));
    }

    public function terms($lang, $slug = 'terms-and-condition')
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
		
        $title = $this->myTitle;
        $description = $this->myDescription;
        if ($slug) {
            $details = Post::whereSlug($slug)->first();
            if ($details) {
				$titles = [
                    'title' => $details->$title,
                    'description' => strip_tags($details->$description),
                ];
                $data['slug'] = $details->slug;
                $data['title'] = $details->$title;
                $data['description'] = $details->$description;				
                $data['created'] = $details->created;
                $data['image'] = $details->image_name ? asset(Post::$imageUrl . $details->image_name) : '';

                return view('front.content.view', compact('data','titles'));
            }
        }
        return redirect(route('home', app()->getLocale()));
    }
}
// DI CODE - End