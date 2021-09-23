<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


Route::group(['prefix' =>'users', 'namespace' =>'Api'] , function(){
    Route::get('/','UserController@index')->name('index');
    Route::get('/{user}','UserController@show')->name('show');
});
// mở trên post man
Route::group(['prefix' =>'posts', 'namespace' =>'Api'] , function(){
    Route::get('/','PostController@index')->name('index');
    Route::get('/{post}','PostController@show')->name('show');
});

Route::group(['prefix' =>'comments', 'namespace' =>'Api'] , function(){
    Route::get('/','CommentController@index')->name('index');
    Route::get('/{comment}','CommentController@show')->name('show');
});


Route::group(['middleware' => 'api'] , function(){

    Route::group(['prefix' => 'auth'], function () {

        Route::group(['middleware' => 'auth.jwt'], function () {

            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/refresh', [AuthController::class, 'refresh']);
            Route::get('/user-profile', [AuthController::class, 'userProfile']);
            Route::post('/change-pass', [AuthController::class, 'changePassword']);

            // 1.Posts Api
            Route::group(['prefix' =>'posts', 'namespace' =>'Api'] , function(){
                Route::post('/','PostController@store')->name('store');
                Route::put('/{post}','PostController@update')->name('update');
                Route::delete('/{post}','PostController@delete')->name('delete');
            });
            // Users Api
            Route::group(['prefix' =>'users', 'namespace' =>'Api'] , function(){
                // Route::post('/','UserController@store')->name('store');
                Route::put('/{user_id}','UserController@update')->name('update');
                Route::patch('/{user}','UserController@update1')->name('update1');
                Route::delete('/{user}','UserController@delete')->name('delete');
            });
            // Comment Api
            Route::group(['prefix' =>'comments', 'namespace' =>'Api'] , function(){
                Route::post('/','CommentController@store')->name('store');
                Route::put('/{comment}','CommentController@update')->name('update');
                Route::delete('/{comment}','CommentController@delete')->name('delete');
            });

        });
        // Not Auth
        Route::group(['prefix' =>'users', 'namespace' =>'Api'] , function(){
            Route::post('/','UserController@store')->name('store');
        });
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);

    });

});

// Route::get('/redis','DemoRedisController@index')->name('index');
// Route::get('/{post_id}','DemoRedisController@show')->name('show');
// Route::post('/redis','DemoRedisController@store')->name('store');
// Route::post('/{post_id}','DemoRedisController@update')->name('update');
// Route::delete('/{post}','DemoRedisController@delete')->name('delete');


// Route::get('/listRedis','RedisController@index')->name('index');
// Route::get('/{post_id}','RedisController@show')->name('show');
// Route::post('/listRedis','RedisController@store')->name('store');
// Route::post('/{post_id}','RedisController@update')->name('update');
// Route::delete('/{post}','RedisController@delete')->name('delete');
