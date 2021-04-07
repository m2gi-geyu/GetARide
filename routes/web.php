<?php

use App\Http\Controllers\TravelSearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Security\askForPasswordReset;
use App\Http\Controllers\Security\PasswordResetting;
use App\Http\Controllers\RideController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\notifications;



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
Route::get('logout',[UserAuthController::class, 'logout'])->name('logout');//route pour la "page" de déconnexion
Route::post('create',[UserAuthController::class, 'create'])->name('auth/create');//route pour la vérification du formulaire d'inscription

//Route::post('create','App\Http\Controllers\Auth\RegisterController@register')->name('auth/create');//route pour la vérification du formulaire d'inscription
Route::post('check',[UserAuthController::class, 'check'])->name('auth/check');//route pour la vérification du formulaire de connexion
Route::get('dashboard',[UserAuthController::class, 'dashboard'])->middleware('isLogged')->name("dashboard");//route pour la page de bievenue de l'utilisateur
//user data edit
Route::get('user/edit',[UserController::class, 'form']) -> name("editUser")->middleware('isLogged');
Route::post('user/edit',[UserController::class, 'formSubmit']) -> name("editUserSubmit");
Route::get('user/delete',[UserController::class, 'deleteUserAccount']) -> name("deleteUser");
//user search edit
Route::get('user/search', [UserController::class, 'searchUser_view'])->name('user/search');//route pour la recherche d'utilisateur
Route::get('user/searchSubmit', [UserController::class, 'searchUser'])->name('user/searchSubmit');


//BEGINING OF 'CHANGE PASSWORD' ROUTES (Edit by FAUGIER Elliot 22/03/2021)
Route::get('change-password', [askForPasswordReset::class, 'form']);
Route::post('change-password', [askForPasswordReset::class, 'formSubmission']);
Route::get('reset-password/{token}', [PasswordResetting::class, 'form']);
Route::post('reset-password/', [PasswordResetting::class, 'formSubmission']);
//END OF 'CHANGE PASSWORD'  ROUTES (Edit by FAUGIER Elliot 22/03/2021)

//create trip
Route::get('create_trip',[RideController::class, 'create_ride_form'])->middleware('isLogged');
Route::post('create_trip',[RideController::class, 'create_ride_form_submission'])->name('trip/create');

//modifier trajet
Route::post('my_created_trips',[RideController::class, 'modified_trip'])->name('trip/modified');


//trajet en attend
Route::get('trip/trip_in_waiting',[RideController::class,'show_trip_in_waiting'])->name('trip/waiting');
//retrait de trajet
Route::get('trip/quit_trip/{idRide}',[PassengerController::class,'deleteJoinedRide'])->name('trip/quit');
//annulation de réponse
Route::get('trip/cancel_trip/{idRide}',[PassengerController::class,'deletdAnswerRide'])->name('trip/cancel');
//enlever de user d'un trajet
Route::get('trip/delete/{id}/{idRide}',[RideController::class,'delete_user_from_ride'])->name('trip/delete_user');

//to visualize trip which are created by the user
Route::get('my_created_trips',[RideController::class,'view_my_created_trips'])->name('my_created_trips');

//to delete one trip by his id
Route::get('trip/delete_trip/{id}',[RideController::class,'delete_trip'])->name('trip/delete')->middleware('isLogged');



//email verification
Route::get('email/verify', function () {
    return view('auth/verify-email');
})->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/welcome');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


//BEGINING OF NOTIFICATIONS ROUTES (Edit by FAUGIER Elliot 29/03/2021)
Route::get('notifications', [notifications::class, 'view'])->name('notification');
Route::post('notificationsDelete', [notifications::class, 'deleteNotification'])->name('notification.delete');
Route::post('notificationsRead', [notifications::class, 'readNotification'])->name('notification.read');
//END OF NOTIFICATIONS ROUTES (Edit by FAUGIER Elliot 29/03/2021)

//notifications suite
Route::get('notifications/all/delete', [notifications::class, 'deleteAllNotifications'])->name('notifications.delete')->middleware('isLogged');
Route::get('notifications/all/desactivate', [notifications::class, 'desactivateAllNotifications'])->name('notifications.desactivate')->middleware('isLogged');


//routes linked to groups
Route::get('creategroup',[GroupController::class, 'group_form'])->middleware('hasVehicle'); //route for the view with the group creation form
Route::get('/group/search', [GroupController::class, 'search_user'])->name('group/search')->middleware('hasVehicle');//route for search an user with the search bar
Route::post('group/create',[GroupController::class, 'create_new_group'])->name('group/create');//route for create a new group with post method
Route::get('group/addingmembers',[GroupController::class,'adding_members_view'])->name('group/addingmembers');//route for the view used to adding members to the newest group
Route::get('group/add_member/{id}',[GroupController::class,'add_member'])->name('group/add_member');//route to the function which adds a members by his id to the newest group of the user
Route::get('mycreatedgroups',[GroupController::class,'view_my_created_groups'])->name('mycreatedgroups'); //route to visualize groups which are created by the current user
Route::get('group/delete_group/{id}',[GroupController::class,'delete_group'])->name('group/delete')->middleware('isLogged');//route used to delete a group

//routes linked to trips searching
Route::get('trip/search_trip',[TravelSearchController::class, 'search_trip_view'])->name('trip/search_trip');
Route::get('trip/search',[TravelSearchController::class, 'search'])->name('trip/search');

// routes liées au refus / acceptation d'une requête
// Accepter "userID" sur le trajet "tripID"
Route::get('trip/acceptTripRequest/{userID)/{tripID}', [RideController::class,'acceptTripRequest']) -> name('trip.acceptRequest');
// Refuser "userID" sur le trajet "tripID"
Route::get('trip/refuseTripRequest/{userID)/{tripID}', [RideController::class,'refuseTripRequest']) -> name('trip.refuseRequest');
Route::get('trip/join_trip/{id}', [TravelSearchController::class, 'sendTripRequest'])->name('trip.joinTrip');
