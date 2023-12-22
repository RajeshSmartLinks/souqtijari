<?php
// DI CODE - Start
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Newly Added
//use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = ['title' => 'Manage Push Notification', 'subTitle' => 'Add Push Notification', 'listTitle' => 'Push Notification List'];
        $deleteRouteName = "notification.destroy";

        //$notifications = Notification::get();
		$notifications = DB::table('posts')
            ->select('*')
			->where('type','=','notification')
            ->get();

		return view('admin.notification.create', compact('titles', 'notifications', 'deleteRouteName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title_en'			=> 'required',
            'title_ar'			=> 'required',
            'description_en'	=> 'required',
            'description_ar'	=> 'required',
        ]);
		
        $data = array();

        $data['title_en']			= $request->title_en;
		//$data['slug']				= unique_slug($request->title_en, 'Faq');
		$data['slug']				= unique_slug($request->title_en);
        $data['title_ar']			= $request->title_ar;
        $data['description_en']		= $request->description_en;
        $data['description_ar']		= $request->description_ar;
		
		DB::insert('INSERT INTO '.DB::getTablePrefix().'posts (`slug`, `type`, `title_en`, `title_ar`, `description_en`, `description_ar`, `created_at`, `updated_at`) VALUES (?,?,?,?,?,?,?,?)', [$data['slug'], 'notification', $data['title_en'], $data['title_ar'], $data['description_en'], $data['description_ar'], now(), now()]);
		
        return redirect()->route('notification.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$titles = ['title' => 'Edit Push Notification'];
		
		/*$editNotification = DB::table('posts')
            ->select('*')
			->where('id',$id)
			->where('type','notification')
            ->get();*/
		$editNotification = DB::table('posts')
            ->select('*')
			->where('type','notification')
            ->find($id);
		
		return view('admin.notification.edit', compact('titles', 'editNotification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$this->validate($request, [
            'title_en'			=> 'required',
            'title_ar'			=> 'required',
            'description_en'	=> 'required',
            'description_ar'	=> 'required',
        ]);
		
        $data = array();
		
		$editNotification = DB::table('posts')
            ->select('*')
			->where('type','notification')
            ->find($id);
		
		
		if($editNotification)
		{
			$slug = unique_slug($request->title_en);

			DB::update('UPDATE `'.DB::getTablePrefix().'posts` SET `slug`="'.$slug.'", `title_en`="'.$request->title_en.'", `title_ar`="'.$request->title_ar.'", `description_en`="'.$request->description_en.'", `description_ar`="'.$request->description_ar.'", `updated_at`="'.now().'" WHERE `id`= ? ', [$id]);

			return redirect()->route('notification.index')->with('success', 'Updated Successfully');
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $title = 'Delete';

        $deleteId = $request->delete_id;
        
		$Notification = DB::table('posts')
            ->select('*')
			->where('type','notification')
            ->find($deleteId);
		
        if ($Notification) {
            DB::delete('DELETE FROM `'.DB::getTablePrefix().'posts` WHERE `id`='.$deleteId);
            return redirect()->route('notification.index')->with('success', 'Deleted Successfully');

        }
    }
}
// DI CODE - End