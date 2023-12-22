<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $loggedIn = 0;

        // Validate form data
        $this->validate($request,
            [
                'username' => 'required|string',
                'password' => 'required|string|min:6'
            ]
        );

        // Attempt to login as admin
        if (Auth::guard('admin')->attempt(['mobile' => $request->username, 'password' => $request->password, 'is_admin' => 1], $request->remember)) {
            $loggedIn = 1;
        }
        if (Auth::guard('admin')->attempt(['email' => $request->username, 'password' => $request->password, 'is_admin' => 1], $request->remember)) {
            $loggedIn = 1;
        }

        if ($loggedIn) {
            return redirect()->intended(route('admin.dashboard'));
        }

        // If unsuccessful then redirect back to login page with email and remember fields
        return redirect()->back()->withInput($request->only('username', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('admin');
    }
}
