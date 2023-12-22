<?php
// DI CODE - Start
namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Newly Added
use App\Models\Newsletter;

class NewsletterController extends Controller
{
	public function index(Request $request)
	{
		session()->forget(['search_text', 'categoryval', 'ad_condition_new', 'ad_condition_used', 'minprice', 'maxprice']);
        // Validate form data
       $errors = $this->validate($request,
            [
                //'newsletter_email'			=> 'email:rfc|required|string|unique:newsletters,email'
                //'newsletter_email'			=> 'required|email:rfc|unique:newsletters,email'
                'newsletter_email'			=> 'required|email|unique:newsletters,email'
            ]
        );		 
        $data['email']		= $request->newsletter_email;
		
        if($create_Ad = Newsletter::create($data))
		{
			return true;
		}
	}
}
// DI CODE - End