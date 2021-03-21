<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;

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

Route::get('login',[UserAuthController::class, 'login']); //route pour la page de connexion
Route::get('register',[UserAuthController::class, 'register']); //route pour la page d'inscription
Route::get('logout',[UserAuthController::class, 'logout']);//route pour la "page" de déconnexion
Route::post('create',[UserAuthController::class, 'create'])->name('auth/create');//route pour la vérification du formulaire d'inscription
Route::post('check',[UserAuthController::class, 'check'])->name('auth/check');//route pour la vérification du formulaire de connexion
Route::get('dashboard',[UserAuthController::class, 'dashboard'])->middleware('isLogged');//route pour la page de bievenue de l'utilisateur

Route::get('user/edit',[UserController::class, 'editUser']);
