<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Controler of the page used to change a forgotten password
 * 
 *  !! https://laravel.com/docs/8.x/passwords !!
 * 
 * @Author Elliot Faugier
 * @Date 22/03/2021
 * 
 * @TODO validation error/success message
 * 
 */
class PasswordResetting extends Controller
{
    /**
     * used for the GET side of the page (display the form)
     */
    public function form($token)
    {
        return view('security.passwordReset', ['token' => $token]);
    }

    /**
     * used for the POST side of the page (form validation and password modification int the DB)
     */
    public function formSubmission(Request $request)
    {

        //dd($request->session());

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);


    

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );

        
    
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('logIn')
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
