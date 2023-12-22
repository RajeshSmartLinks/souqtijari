<?php
// DI CODE - Start
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Newly Added
use Illuminate\Support\Facades\Config;
use App\Models\Newsletter;

class NewsletterController extends Controller
{
    public function index()
	{
		$titles = ['title' => 'Manage Newsletter', 'subTitle' => 'Newsletter List', 'listTitle' => 'Newsletter List'];
        $deleteRouteName = "newsletter.destroy";

        $newsletters = Newsletter::orderby('id','desc')->get();
        $noImage = asset(Config::get('constants.NO_IMG_ADMIN'));

        return view('admin.newsletter.index', compact('titles', 'newsletters', 'noImage', 'deleteRouteName'));
	}
	
	public function newsletterunsubcribe(Request $request)
	{
		$newsletter_id = $request->newsletter_id;
        $newsletter = Newsletter::find($newsletter_id);
		
		if($newsletter->status==1)
		{
			$newsletter->status	= '0';
			$returnValue = ' Un Subcribed';
		}
		else if($newsletter->status==0)
		{
			$newsletter->status	= '1';
			$returnValue = ' Subcribed';
		}
		
        if($newsletter->save())
		{
			return $returnValue;
		}
	}
	
	public function destroy(Request $request)
    {
        $title = 'Delete';

        $deleteId = $request->delete_id;
        $newsletter = Newsletter::find($deleteId);
		
        if ($deleteId) {
			$newsletter->delete();
            return redirect()->route('newsletter')->with('success', 'Deleted Successfully');
        }
    }
}
// DI CODE - End