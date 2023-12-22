<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $title = "Dashboard";

        $totalUser = User::count();

        $totals = [
            'totalUser' => $totalUser,
        ];

        return view('admin.index', compact('title', 'totals'));
    }
}
