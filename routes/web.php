<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Security\askForPasswordReset;
use App\Http\Controllers\Security\PasswordResetting;
use App\Http\Controllers\RideController;


use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//user account creation
Route::get('login',[UserAuthController::class, 'login'])->name('login'); //route pour la page de connexion
Route::get('register',[UserAuthController::class, 'register']); //route pour la page d'inscription
Route::get('logout',[UserAuthController::class, 'logout']);//route pour la "page" de déconnexion
Route::post('create',[UserAuthController::class, 'create'])->name('auth/create');//route pour la vérification du formulaire d'inscription

//Route::post('create','App\Http\Controllers\Auth\RegisterController@register')->name('auth/create');//route pour la vérification du formulaire d'inscription
Route::post('check',[UserAuthController::class, 'check'])->name('auth/check');//route pour la vérification du formulaire de connexion
Route::get('dashboard',[UserAuthController::class, 'dashboard'])->middleware('isLogged');//route pour la page de bievenue de l'utilisateur
//user data edit
Route::get('user/edit',[UserController::class, 'form']) -> name("editUser")->middleware('isLogged');;
Route::post('user/edit',[UserController::class, 'formSubmit']) -> name("editUserSubmit");
Route::get('user/delete',[UserController::class, 'deleteUserAccount']) -> name("deleteUser");


//BEGINING OF 'CHANGE PASSWORD' ROUTES (Edit by FAUGIER Elliot 22/03/2021)
Route::get('change-password', [askForPasswordReset::class, 'form']);
Route::post('change-password', [askForPasswordReset::class, 'formSubmission']);
Route::get('reset-password/{token}', [PasswordResetting::class, 'form']);
Route::post('reset-password/', [PasswordResetting::class, 'formSubmission']);
//END OF 'CHANGE PASSWORD'  ROUTES (Edit by FAUGIER Elliot 22/03/2021)

//create trip
Route::get('create_trip',[RideController::class, 'create_ride_form'])->middleware('isLogged');
Route::post('create_trip',[RideController::class, 'create_ride_form_submission'])->name('trip/create');

//trajet en attend
Route::get('trip_in_waiting',[RideController::class,'show_trip_in_waiting'])->name('trip/waiting');
//retrait de trajet
Route::post('quit_trip',[UserController::class,'quit_trip'])->name('trip/quit');


//email verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/profile', function () {
    // Only verified users may access this route...
})->middleware('verified');
