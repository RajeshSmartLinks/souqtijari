<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ResetsPasswords;

class CustomResetPasswordController extends Controller
{
    use ResetsPasswords;
    protected $redirectTo = '/'; 

    // Custom view for showing the password reset form
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.custom-reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    // Custom logic for handling the password reset
    protected function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        // Your custom logic to reset the password
        $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
                // Log out the user after a successful password reset
                Auth::logout();
            }
        );

        // Redirect the user after a successful password reset
        return redirect()->route('password.reset.status',app()->getLocale());
    }

    public function resetstatus(){

        return view('auth.passwords.reset-sucessfully');

    }
}
