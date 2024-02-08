<?php
// DI CODE - Start
namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Newly Added
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassword;
use App\Mail\WelcomeContent;
use App\Models\Ad;
use App\Models\User;
use App\Models\Favourite;
use App\Models\Post;
use App\Models\Visitor;
use App\Models\Setting;

class UserController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }*/
    public function userlogin()
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

        $myPrev = session()->get('_previous')['url'];
        $urlBreakUp = explode("/",$myPrev);
        foreach($urlBreakUp as $segments){
            if($segments == 'password-reset-status'){
                $myPrev = route('user.dashboard',app()->getLocale());
            }
        }


        session()->put('mytake', $myPrev);

        $user = Auth::user();
        if (empty($user)) {
            session()->forget(['search_text', 'categoryval', 'ad_condition_new', 'ad_condition_used', 'minprice', 'maxprice']);
            $titles = [
                "title" => trans("app.login"),
            ];
            return view('front.user.login', compact('titles'));
        }
        return redirect()->route('home', app()->getLocale());
    }

    public function login(Request $request)
    {

        $loggedIn = 0;
        // Validate form data
        $this->validate($request,
            [
                'email' => 'required|string',
                'password' => 'required|string|min:8'
            ]
        );

        $userlogin = User::where('mobile', $request->email)->orWhere('email', $request->email)->first();
        if ($userlogin) {

            if ($userlogin->status == '1') {
                // Attempt to login
                if (Auth::attempt(['mobile' => $request->email, 'password' => $request->password, 'status' => '1'], $request->remember)) {
                    $loggedIn = 1;
                }
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => '1'], $request->remember)) {
                    $loggedIn = 1;
                }
                if ($loggedIn) {
                    // return redirect()->intended(route('home', app()->getLocale()));
                    return redirect(url(session()->get('mytake')));
                    // return redirect()->intended();
                }
            } elseif ($userlogin->status == '0') {
                return redirect()->back()->with('error', trans('app.user_blocked_login_details'))->withInput($request->only('email', 'remember'));
            }
        }
        // If unsuccessful then redirect back to login page with email and remember fields
        return redirect()->back()->with('error', trans('app.check_your_login_details'))->withInput($request->only('email', 'remember'));
    }

    public function loginpoup(Request $request)
    {
        $loggedIn = 0;
        // Validate form data
        $this->validate($request,
            [
                'email' => 'required|string',
                'password' => 'required|string|min:8'
            ]
        );
        // Attempt to login
        if (Auth::attempt(['mobile' => $request->email, 'password' => $request->password], $request->remember)) {
            $loggedIn = 1;
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $loggedIn = 1;
        }
        if ($loggedIn) {
            return true;
        }
        $val = 'check details';
    }

    public function register(Request $request)
    {
        // Validate form data
        $errors = $this->validate($request,
            [
                'name' => 'required|string',
                'mobile' => 'required|string|unique:users,mobile,',
                'email' => 'unique:users,email',
                'regpassword' => 'required|string|min:8'
            ]
        );
        $data['name'] = $request->name;
        $data['mobile'] = $request->mobile;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->regpassword);

        if ($create_Ad = User::create($data)) {
            // Mail
            $settingsDetail = Setting::find(1);
            if (!empty($request->email)) {
                $maildetails = [
                    'subject' => trans("app.register_mail_subject"),
                    'title' => trans("app.register_mail_title"),
                    'name' => $request->name,
                    'note' => trans("app.register_mail_note"),
                    'content' => trans("app.register_mail_content") . '<a href="mailto:' . $settingsDetail->contact_email . '" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#3D5CA3">' . $settingsDetail->contact_email . '</a>',
                    'lang' => app()->getLocale(),
                ];
                Mail::to($request->email)->send(new WelcomeContent($maildetails));
            }
            return true;
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
        //return redirect(app()->getLocale());
    }
    /* mobile otp forgotpassword */
    // public function viewforgot()
    // {
    //     $user = Auth::user();
    //     if (empty($user)) {
    //         $titles = [
    //             "title" => trans("app.forgot"),
    //         ];
    //         return view('front.user.forgot_mobile', compact('titles'));
    //     }
    //     return redirect()->route('home', app()->getLocale());
    // }



    public function viewforgot()
    {
        $user = Auth::user();
        if (empty($user)) {
            $titles = [
                "title" => trans("app.forgot"),
            ];
            return view('front.user.forgot', compact('titles'));
        }
        return redirect()->route('home', app()->getLocale());
    }

    public function forgot(Request $request)
    {
        $this->validate($request,
            [
                'mobile' => 'required|numeric'
            ]
        );
        session()->put('userforgotmobile', $request->mobile);
        $user = User::select('*')->where('mobile', $request->mobile)->first();
        if ($user) {
            $userupdate = User::where('id', $user->id)->update(['mobile_otp' => rand(10000000, 99999999)]);
            return redirect()->route('userforgototp', app()->getLocale());
        }
        return redirect()->back()->withErrors(trans('app.check_your_mobile'))->withInput($request->only('mobile'));
    }

    public function viewforgototp()
    {
        $titles = [
            "title" => trans("app.forgot"),
        ];
        return view('front.user.forgototp', compact('titles'));
    }

    public function forgototp(Request $request)
    {
        $this->validate($request,
            [
                'otp' => 'required|numeric',
                'password' => 'required|string|min:8',
                'confirm_password' => 'required|same:password'
            ]
        );
        $userforgotmobile = session()->get('userforgotmobile');
        $user = User::select('*')->where(['mobile' => $userforgotmobile], ['mobile_otp' => $request->otp])->first();
        $titles = [
            "title" => trans("app.forgot"),
        ];
        if ($user) {
            $userupdate = User::where('id', $user->id)->update(['password' => Hash::make($request->password)]);
            session()->forget('userforgotmobile');
            // Mail
            if (!empty($user->email)) {
                if (!empty($user->first_name) && !empty($user->last_name)) {
                    $fullname = $user->first_name . ' ' . $user->last_name;
                } else {
                    $fullname = $user->name;
                }

                $lang = app()->getLocale();
                $title = 'title_' . $lang;
                $description = 'description_' . $lang;
                $safetytips = Post::whereSlug('safety-tips-for-buyers')->first();

                $maildetails = [
                    'subject' => trans("app.forgot_mail_subject"),
                    'title' => trans("app.forgot_mail_title"),
                    'name' => $fullname,
                    'note' => trans("app.forgot_mail_note"),
                    'content' => trans("app.forgot_mail_content"),
                    'lang' => app()->getLocale(),
                    'safety_slug' => $safetytips->slug,
                    'safety_title' => $safetytips->$title,
                    'safety_description' => explode('|', strip_tags($safetytips->$description)),
                ];
                Mail::to($user->email)->send(new ForgotPassword($maildetails));
            }
            return redirect()->route('userlogin', app()->getLocale())->with('message', trans("app.forgot_mail_success_message"));
        }
        return redirect()->back()->withErrors(trans('app.check_your_details'));
    }

    public function dashboard()
    {
        $titles = [
            "title" => trans("app.dashboard"),
        ];
        $user = auth()->user();
        $userdetails = User::find($user->id);

        if (!empty($userdetails->first_name) && !empty($userdetails->last_name)) {
            $fullname = $userdetails->first_name . ' ' . $userdetails->last_name;
        } else {
            $fullname = $userdetails->name;
        }

        $lang = app()->getLocale();
        $title = 'title_' . $lang;
        $description = 'description_' . $lang;
        $safetytips = Post::whereSlug('safety-tips-for-buyers')->first();

        $data = [
            'name' => $userdetails->name,
            'first_name' => $userdetails->first_name,
            'last_name' => $userdetails->last_name,
            'full_name' => $fullname,
            'email' => $userdetails->email,
            'mobile' => $userdetails->mobile,
            'whatsapp' => $userdetails->whatsapp,
            'gender' => $userdetails->gender,
            'facebook' => $userdetails->facebook,
            'twitter' => $userdetails->twitter,
            'address' => $userdetails->address,
            'avatar' => !empty($userdetails->avatar) ? asset(User::$imageThumbUrl . $userdetails->avatar) : asset(User::$noImageUrl),
            'safety_slug' => $safetytips->slug,
            'safety_title' => $safetytips->$title,
            'safety_description' => explode('|', strip_tags($safetytips->$description)),
        ];
        return view('front.user.dashboard', compact('titles', 'data'));
    }

    public function userupdate(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            //'email'				=> 'email|unique:users,email',
            'email' => 'email|unique:users,email,' . $user->id,
            'confirm_password' => 'same:password',
            'avatar' => 'image|mimes:jpg,png,jpeg',
        ]);

        $userdetails = User::find($user->id);

        $userdetails->first_name = $request->first_name;
        $userdetails->last_name = $request->last_name;
        $userdetails->email = $request->email;
        $userdetails->mobile = $request->mobile;
        $userdetails->whatsapp = $request->whatsapp;
        $userdetails->gender = $request->gender;
        $userdetails->facebook = $request->facebook;
        $userdetails->twitter = $request->twitter;
        $userdetails->address = $request->address;

        $originalImage = $request->file('avatar');

        if ($originalImage != NULL) {
            $newFileName = time() . $originalImage->getClientOriginalName();
            $thumbnailPath = User::$imageThumbPath;
            $originalPath = User::$imagePath;

            // Delete the previous image
            $this->deleteImageBuddy(User::$imagePath, $userdetails->avatar);
            $this->deleteImageBuddy(User::$imageThumbPath, $userdetails->avatar);

            // Image Upload Process
            $thumbnailImage = Image::make($originalImage);

            $thumbnailImage->save($originalPath . $newFileName);
            $thumbnailImage->resize(150, 150);
            $thumbnailImage->save($thumbnailPath . $newFileName);

            $userdetails->avatar = $newFileName;
        }

        if (!empty($request->password)) {
            $userdetails->password = Hash::make($request->password);
        }

        $userdetails->save();
        return redirect()->route('user.dashboard', app()->getLocale())->with('success', trans('app.updated_successfully'));
    }

    public function myads(Request $request)
    {
        $titles = ["title" => trans("app.myads"),];
        $user = auth()->user();

        // All Ads
        $alluserads = DB::table('ads')
            ->join('categories as cat', 'ads.ad_category_id', '=', 'cat.id')
            ->join('categories as sub_cat', 'ads.ad_sub_category_id', '=', 'sub_cat.id')
            //->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')
            ->select('ads.*', 'cat.name_en as category_name', 'sub_cat.name_en as sub_category_name'
            //,'ads_images.ads_image'
            )
            ->where('ads.ad_user_id', '=', $user->id)
            ->whereNull('ads.deleted_at')
            ->groupBy('ads.id')
            ->orderBy('created_at', 'desc')
            ->get();

        $dataAllUserAds = array();
        if ($alluserads->count() > 0) {
            foreach ($alluserads as $alluserad) {
                $ad_price = explode('.', $alluserad->ad_price);
                $adfeatureimage = DB::table('ads_images')->where(['ads_ad_id' => $alluserad->id, 'is_feature' => '1', 'deleted_at' => null,])->first();
                if ($adfeatureimage) {
                    $adimage = $adfeatureimage;
                } else {
                    $adfeatureimage = DB::table('ads_images')->where(['ads_ad_id' => $alluserad->id, 'deleted_at' => null,])->first();
                    $adimage = $adfeatureimage;
                }
                $dataAllUserAds[] = [
                    "id" => $alluserad->id,
                    "name" => $alluserad->ad_title,
                    "slug" => $alluserad->slug,
                    "price" => $ad_price[0],
                    "category_name" => $alluserad->category_name,
                    "sub_category_name" => $alluserad->sub_category_name,
                    "status" => $alluserad->status,
                    "featured" => $alluserad->ad_is_featured,
                    "createdate" => date('d-M-Y', strtotime($alluserad->created_at)),
                    "image" => !empty($adimage->ads_image) ? asset(Ad::$imageThumbUrl . $adimage->ads_image) : asset(Ad::$noImageUrl),
                ];
            }
        }
        $data['alluserads'] = $dataAllUserAds;

        // Approved Ads
        $appproveduserads = DB::table('ads')
            ->join('categories as cat', 'ads.ad_category_id', '=', 'cat.id')
            ->join('categories as sub_cat', 'ads.ad_sub_category_id', '=', 'sub_cat.id')
            //->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')
            ->select('ads.*', 'cat.name_en as category_name', 'sub_cat.name_en as sub_category_name'
            //, 'ads_images.ads_image'
            )
            ->where('ads.ad_user_id', '=', $user->id)
            ->where('ads.status', '=', '1')
            ->whereNull('ads.deleted_at')
            ->groupBy('ads.id')
            ->orderBy('created_at', 'desc')
            ->get();

        $dataApprovedUserAds = array();
        if ($appproveduserads->count() > 0) {
            foreach ($appproveduserads as $appproveduserad) {
                $ad_price = explode('.', $appproveduserad->ad_price);
                $adfeatureimage = DB::table('ads_images')->where(['ads_ad_id' => $appproveduserad->id, 'is_feature' => '1', 'deleted_at' => null,])->first();
                if ($adfeatureimage) {
                    $adimage = $adfeatureimage;
                } else {
                    $adfeatureimage = DB::table('ads_images')->where(['ads_ad_id' => $appproveduserad->id, 'deleted_at' => null,])->first();
                    $adimage = $adfeatureimage;
                }
                $dataApprovedUserAds[] = [
                    "id" => $appproveduserad->id,
                    "name" => $appproveduserad->ad_title,
                    "slug" => $appproveduserad->slug,
                    "price" => $ad_price[0],
                    "category_name" => $appproveduserad->category_name,
                    "sub_category_name" => $appproveduserad->sub_category_name,
                    "status" => $appproveduserad->status,
                    "createdate" => date('d-M-Y', strtotime($appproveduserad->created_at)),
                    "image" => !empty($adimage->ads_image) ? asset(Ad::$imageThumbUrl . $adimage->ads_image) : asset(Ad::$noImageUrl),
                ];
            }
        }
        $data['appproveduserads'] = $dataApprovedUserAds;

        // UnApproved Ads
        $unappproveduserads = DB::table('ads')
            ->join('categories as cat', 'ads.ad_category_id', '=', 'cat.id')
            ->join('categories as sub_cat', 'ads.ad_sub_category_id', '=', 'sub_cat.id')
            //->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')
            ->select('ads.*', 'cat.name_en as category_name', 'sub_cat.name_en as sub_category_name'
            //, 'ads_images.ads_image'
            )
            ->where('ads.ad_user_id', '=', $user->id)
            ->where('ads.status', '=', '0')
            ->whereNull('ads.deleted_at')
            ->groupBy('ads.id')
            ->orderBy('created_at', 'desc')
            ->get();

        $dataUnApprovedUserAds = array();
        if ($unappproveduserads->count() > 0) {
            foreach ($unappproveduserads as $unappproveduserad) {
                $ad_price = explode('.', $unappproveduserad->ad_price);
                $adfeatureimage = DB::table('ads_images')->where(['ads_ad_id' => $unappproveduserad->id, 'is_feature' => '1', 'deleted_at' => null,])->first();
                if ($adfeatureimage) {
                    $adimage = $adfeatureimage;
                } else {
                    $adfeatureimage = DB::table('ads_images')->where(['ads_ad_id' => $unappproveduserad->id, 'deleted_at' => null,])->first();
                    $adimage = $adfeatureimage;
                }
                $dataUnApprovedUserAds[] = [
                    "id" => $unappproveduserad->id,
                    "name" => $unappproveduserad->ad_title,
                    "slug" => $unappproveduserad->slug,
                    "price" => $ad_price[0],
                    "category_name" => $unappproveduserad->category_name,
                    "sub_category_name" => $unappproveduserad->sub_category_name,
                    "status" => $unappproveduserad->status,
                    "createdate" => date('d-M-Y', strtotime($unappproveduserad->created_at)),
                    "image" => !empty($adimage->ads_image) ? asset(Ad::$imageThumbUrl . $adimage->ads_image) : asset(Ad::$noImageUrl),
                ];
            }
        }
        $data['unappproveduserads'] = $dataUnApprovedUserAds;

        // Featured Ads
        $featureduserads = DB::table('ads')
            ->join('categories as cat', 'ads.ad_category_id', '=', 'cat.id')
            ->join('categories as sub_cat', 'ads.ad_sub_category_id', '=', 'sub_cat.id')
            //->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')
            ->select('ads.*', 'cat.name_en as category_name', 'sub_cat.name_en as sub_category_name'
            //, 'ads_images.ads_image'
            )
            ->where('ads.ad_user_id', '=', $user->id)
            ->where('ads.ad_is_featured', '=', '1')
            ->whereNull('ads.deleted_at')
            ->groupBy('ads.id')
            ->orderBy('created_at', 'desc')
            ->get();

        $dataFeaturedUserAds = array();
        if ($featureduserads->count() > 0) {
            foreach ($featureduserads as $featureduserad) {
                $ad_price = explode('.', $featureduserad->ad_price);
                $adfeatureimage = DB::table('ads_images')->where(['ads_ad_id' => $featureduserad->id, 'is_feature' => '1', 'deleted_at' => null,])->first();
                if ($adfeatureimage) {
                    $adimage = $adfeatureimage;
                } else {
                    $adfeatureimage = DB::table('ads_images')->where(['ads_ad_id' => $featureduserad->id, 'deleted_at' => null,])->first();
                    $adimage = $adfeatureimage;
                }
                $dataFeaturedUserAds[] = [
                    "id" => $featureduserad->id,
                    "name" => $featureduserad->ad_title,
                    "slug" => $featureduserad->slug,
                    "price" => $ad_price[0],
                    "category_name" => $featureduserad->category_name,
                    "sub_category_name" => $featureduserad->sub_category_name,
                    "status" => $featureduserad->status,
                    "createdate" => date('d-M-Y', strtotime($featureduserad->created_at)),
                    "image" => !empty($adimage->ads_image) ? asset(Ad::$imageThumbUrl . $adimage->ads_image) : asset(Ad::$noImageUrl),
                ];
            }
        }
        $data['featureduserads'] = $dataFeaturedUserAds;

        $lang = app()->getLocale();
        $title = 'title_' . $lang;
        $description = 'description_' . $lang;
        $safetytips = Post::whereSlug('safety-tips-for-buyers')->first();

        $data['safety_slug'] = $safetytips->slug;
        $data['safety_title'] = $safetytips->$title;
        $data['safety_description'] = explode('|', strip_tags($safetytips->$description));

        return view('front.user.myads', compact('titles', 'data'));
    }

    public function myfavourites(Request $request)
    {
        $titles = ["title" => trans("app.myfavourites"),];
        $user = auth()->user();

        $alluserfavs = Favourite::select('ads.*', 'cat.name_en as category_name', 'sub_cat.name_en as sub_category_name', 'ads_images.ads_image')
            ->leftjoin('ads', 'favourites.ads_ad_id', '=', 'ads.id')
            ->leftjoin('categories as cat', 'ads.ad_category_id', '=', 'cat.id')
            ->leftjoin('categories as sub_cat', 'ads.ad_sub_category_id', '=', 'sub_cat.id')
            ->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')
            ->where('user_id', $user->id)
            ->where('favourites.status', '1')
            ->groupBy('favourites.id')
            ->get();

        $dataAllUserFavourite = array();
        if ($alluserfavs->count() > 0) {
            foreach ($alluserfavs as $alluserfav) {
                $ad_price = explode('.', $alluserfav->ad_price);
                $dataAllUserFavourite[] = [
                    "id" => $alluserfav->id,
                    "name" => $alluserfav->ad_title,
                    "slug" => $alluserfav->slug,
                    "price" => $ad_price[0],
                    "category_name" => $alluserfav->category_name,
                    "sub_category_name" => $alluserfav->sub_category_name,
                    "status" => $alluserfav->status,
                    "featured" => $alluserfav->ad_is_featured,
                    "createdate" => date('d-M-Y', strtotime($alluserfav->created_at)),
                    "image" => !empty($alluserfav->ads_image) ? asset(Ad::$imageThumbUrl . $alluserfav->ads_image) : asset(Ad::$noImageUrl),
                ];
            }
        }
        $data['alluserfavourites'] = $dataAllUserFavourite;

        $lang = app()->getLocale();
        $title = 'title_' . $lang;
        $description = 'description_' . $lang;
        $safetytips = Post::whereSlug('safety-tips-for-buyers')->first();

        $data['safety_slug'] = $safetytips->slug;
        $data['safety_title'] = $safetytips->$title;
        $data['safety_description'] = explode('|', strip_tags($safetytips->$description));

        return view('front.user.myfavourite', compact('titles', 'data'));
    }
}
// DI CODE - End
