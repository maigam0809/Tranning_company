<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('admin/login','Auth\LoginController@getLoginForm')->name('auth.getLoginForm');

Route::post('admin/login','Auth\LoginController@login')->name('auth.login');

// Logout
Route::get('admin/logout','Auth\LoginController@logout')->name('auth.logout');

//Register
Route::get('register','Auth\RegisterController@register')->name('register');
Route::post('register','Auth\RegisterController@store')->name('registerStore');
Route::get('register/verify/{code}','Auth\RegisterController@verify')->name('register.vertify');

Route::group(['middleware'=>['check_login']],function(){

    Route::group(['prefix' =>'admin','as' => 'admin.','namespace' =>'Admin'],function(){

        Route::group(['prefix' =>'users','as' => 'users.'],function(){

            Route::get('/','UserController@index')->name('index');
            Route::get('/{id}','UserController@show')->name('show');
            Route::get('/{user}','UserController@delete')->name('delete');

        });

      
    });
});

use App\Http\Controllers\Auth\LoginController;
// Google login
Route::get('/login/google',[LoginController::class,'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback',[LoginController::class,'handleGoogleCallback']);

// Facebook login
Route::get('/login/facebook',[LoginController::class,'redirectToFacebook'])->name('login.facebook');
Route::get('/login/facebook/callback',[LoginController::class,'handleFacebookCallback']);

// Github login
Route::get('/login/github',[LoginController::class,'redirectToGithub'])->name('login.github');
Route::get('/login/github/callback',[LoginController::class,'handleGithubCallback']);




