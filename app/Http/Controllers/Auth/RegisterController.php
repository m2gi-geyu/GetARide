<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Date;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        return User::create([
            'name' => $data['name'],
            'surname'=>$data['surname'],
            'activity_token'=>\Str::random(60),
            'activity_expire'=>Date::now('+1 days'),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'username' => $data['username'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'vehicle' => false
        ]);
    }

    public function register(Request $request)
    {
        $request ->validate([
            'username'=> 'required|unique:users',
            'surname'=> 'required',
            'name'=> 'required|',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|unique:users',
            'gender' => 'required',
            'vehicle' => 'required'
        ]);

        $user= new User; //création d'un user et récolte des données entrées

        $user->username = $request->username;
        $user->surname = $request->surname;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->gender = $request->gender;

        if($request->vehicle == 'non')
        {
            $user->vehicle = false;
        }
        else
        {
            $user->vehicle = true;
        }
        $user->activity_token=\Str::random(60);
        $user->activity_expire=Date::now('+1 days');
        //$this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        Mail::raw(
            'cliquer et valider votre email avant'.$user->activity_expire.route('user.activity',['token'=>$user->activity_token])
            ,function($message) use($user){
            $message->from('getaride123456@gmail.com','lamortdelekip')
                ->subject('email verification')
                ->to($user->email);
        });
        return view('auth.registed',['user'=>$user]);
    }


    function activity($token){
        $user = User::find(['activity_token'=>$token]);
        $res = false;
        if($user && strtotime($user->activity_expire)>time())
        {
            $user->is_activity = 1;
            $res = $user->save();
        }
        return view('auth.activityres',['res'=>$res]);
    }
}
