<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Hash::make('smart@admin'));
        $titles = ['title' => 'Manage Operator', 'subTitle' => 'Add Operator', 'listTitle' => 'Operator List'];

        if (!auth()->user()->can('operator-view')) {
            return view('admin.abort', compact('titles'));
        }
        $deleteRouteName = "admin.destroy";

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
}
