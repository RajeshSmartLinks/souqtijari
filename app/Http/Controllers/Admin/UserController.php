<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

// DI CODE - Start
use Illuminate\Support\Facades\Hash;
// DI CODE - End

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = ['title' => 'Manage User', 'subTitle' => 'User List', 'listTitle' => 'User List'];
        $deleteRouteName = "user.destroy";

        $users = User::get();
        $noImage = asset(Config::get('constants.NO_IMG_ADMIN'));

        return view('admin.user.index', compact('titles', 'users', 'noImage', 'deleteRouteName'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		// DI CODE - Start
        $titles = ['title' => 'Manage User', 'subTitle' => 'User Details', 'listTitle' => 'User List'];
		$editUser = User::find($id);
		
        return view('admin.user.edit', compact('titles', 'editUser'));
		// DI CODE - End
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		// DI CODE - Start
		$this->validate($request, [
            'confirm_password'	=> 'same:password',
        ]);	
		
		$userdetails = User::find($id);
        if (!empty($request->password)) {
            $userdetails->password = Hash::make($request->password);
        }
		
		$userdetails->save();
		return redirect()->back()->with('success', trans('app.updated_successfully'));
		//return redirect()->route('admin.user.edit')->with('success', trans('app.updated_successfully'));
		// DI CODE - End
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
		$title = 'Delete';

        $deleteId = $request->delete_id;
        $user = User::find($deleteId);
		
        if ($deleteId) {
			$user->delete();
            return redirect()->route('user.index')->with('success', 'Deleted Successfully');
        }
    }
	
    public function importOldUser()
    {
        $users = DB::table('old_users')->get();
        if ($users->count() > 0) {
            foreach ($users as $key => $user) {
                $userEmail = $user->email ? $user->email : 'noemail@' . $key;
                $data = [
                    'name' => $user->name,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $userEmail,
                    'username' => $user->user_name,
                    'mobile' => $user->phone,
                    'password' => $user->password,
                    'gender' => $user->gender,
                    'address' => $user->address,
                    'website' => $user->website,
                    'admin_type' => 'user',
                    'avatar' => $user->photo,
                    'country_code' => '+965',
                    'mobile_verify' => 0,
                    'new_user' => 1,
                    'status' => 1,
                    'last_login' => $user->last_login,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ];
                User::updateOrInsert(['email' => $userEmail, 'name' => $user->name], $data);
            }

        }
    }
	
	// DI CODE - Start
	public function userblock(Request $request)
	{
		$user_id = $request->user_id;
        $user = User::find($user_id);
		
		if($user->status==1)
		{
			$user->status	= '0';
			$returnValue = ' Blocked';
		}
		else if($user->status==0)
		{
			$user->status	= '1';
			$returnValue = ' Not Blocked';
		}
		
        if($user->save())
		{
			return $returnValue;
		}
	}
	
	public function userblocklist()
	{
		
		$titles = ['title' => 'Manage User', 'subTitle' => 'User List', 'listTitle' => 'User List'];
        $deleteRouteName = "user.destroy";

        $users = User::where('status','0')->get();
        $noImage = asset(Config::get('constants.NO_IMG_ADMIN'));

        return view('admin.user.blocklist', compact('titles', 'users', 'noImage', 'deleteRouteName'));
	}
	// DI CODE - End
}
