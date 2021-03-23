<?php
namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

/**
 * Controler of the page used to ask for a new password
 * 
 * !! https://laravel.com/docs/8.x/passwords !!
 * 
 * @Author Elliot Faugier
 * @Date 22/03/2021
 * 
 * @TODO validation error/success message
 */
class askForPasswordReset extends Controller
{
    /**
     * used for the GET side of the page (display the form)
     */
    public function form()
    {
        return view('security.askForNewPassword');
    }

    /**
     * used for the POST side of the page (form validation, mail sending)
     */
    public function formSubmission(Request $request)
    {
        $request->validate(['email' => 'required|email']);



        $status = Password::sendResetLink(
            $request->only('email')
        );

        //if the email is linked to an account, then an email is sent with a link to reset the password
        //else we're back to the same page 
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);

    }
}
