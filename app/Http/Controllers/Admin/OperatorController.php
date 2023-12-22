<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = ['title' => 'Manage Operator', 'subTitle' => 'Add Operator', 'listTitle' => 'Operator List'];

        $deleteRouteName = "operator.destroy";

        $loggedAdminId = auth()->user()->id;

        if ($loggedAdminId === 1) {
            $operators = User::with('roles')->get();
            $roles = Role::all();
        } else {
            $operators = User::with('roles')->nonSmartOnly()->get();
            $roles = Role::NonSmart()->get();
        }

        return view('admin.operator.create', compact('titles', 'operators', 'roles', 'deleteRouteName'));
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
        $rules = [
            'name' => 'required|string',
            'mobile' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'role_id' => 'required|integer',
            'password' => 'required|min:8|confirmed'
        ];
        $this->validate($request, $rules);

        $data = array(
            'name' => $request->name,
            'username' => empty($request->username) ? $request->mobile : $request->username,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        );

        $admin = User::create($data);
        $admin->assignRole($request->role_id);
        return redirect()->route('operator.index')->with('success', 'Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $titles = ['title' => 'Manage Operator', 'subTitle' => 'Edit Operator'];

        $loggedAdminId = auth()->user()->id;
        if ($loggedAdminId <> 1 && $id === 1) {
            return route('admin.operator.index');
        }

        if ($loggedAdminId === 1) {
            $roles = Role::all();
        } else {
            $roles = Role::nonSmart()->get();
        }
        $operator = User::with('roles')->find($id);

        return view('admin.operator.edit', compact('titles', 'operator', 'roles'));
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
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email',
            'mobile' => 'required|string',
            'role_id' => 'required|integer'
        ];

        if (!empty($request->password)) {
            $rules['password'] = 'min:8';
        }
        $this->validate($request, $rules);

        $data = [
            'name' => $request->name,
            'username' => empty($request->username) ? $request->mobile : $request->username,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ];
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $admin = User::find($request->operator_id);

        $this->detachRole($admin);
        $admin->assignRole($request->role_id);
        $admin->update($data);
        return redirect()->route('operator.index')->with('success', 'Updated Successfully');
    }

    public function detachRole($admin)
    {
        // Grab all the Roles and detach first
        $allRoles = Role::all();
        $admin->roles()->detach($allRoles);
        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
