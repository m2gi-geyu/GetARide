<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

       // $this->middleware('guest')->except('logout');
    }

    /**
     * Fonction permettant à un utilisateur ayant déjà un compte de se connecter
     * @param Request $request requête de l'utilisateur (données du formulaire de donnexion)
     * @return . la page de bienvenue la connexion s'est bien faite, un message d'erreur sinon
     */
    function check(Request $request){
        $request->validate([
            'email' => 'required',
            'password'=>'required| min:8'
        ]);

        $user = User::where('email','=', $request->email)->first();
        if($user==null){
            //return back()->with('fail','user is null');
            $user = User::where('username','=', $request->email)->first();
        }

        if($user){
            if(Hash::check($request->password, $user->password)){
                $request->session()->put("LoggedUser", $user->username); //LoggedUser est la variable de session
                $request->session()->put("LoggedUserPic", $user->profile_pic);
                $request->session()->put("LoggedUserID",$user->id);
                return redirect('dashboard');
            }else{
                return back()->with('fail','Invalid password');
            }
        }else{
            return back()->with('fail','No account found for this email/username');
        }
    }
    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            [
                'email'=>$request->email,
                'password'=>$request->password,
                'is_activity'=>1,
            ], $request->filled('remember')
        );
    }
}
