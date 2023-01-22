<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'App\Http\Controllers\Auth', 'middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::post('/me', 'AuthController@me');
    });
});
Route::group(['namespace' => 'App\Http\Controllers\Auth', 'middleware' => 'api', 'prefix' => 'registration'],
    function () {
        Route::get('/', 'RegistrationController@index');
        Route::post('/', 'RegistrationController@store');
        Route::post('/reset_password', 'RegistrationController@resetPassword');

        Route::group(['middleware' => 'jwt.auth'], function () {
            Route::post('/password', 'RegistrationController@updatePassword');
            Route::post('/account', 'RegistrationController@updateAccount');
        });
    });

Route::group(['namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['jwt.auth'], 'prefix' => 'admin'],
    function () {
        Route::get('/', 'IndexController@index');

        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', 'CategoryController@index');
            Route::get('/show', 'CategoryController@show');
            Route::post('/', 'CategoryController@store');
            Route::patch('/{category}', 'CategoryController@update');
            Route::delete('/{category}', 'CategoryController@destroy');
        });

        Route::group(['prefix' => 'countries'], function () {
            Route::get('/', 'CountryController@index');
            Route::post('/', 'CountryController@store');
            Route::patch('/{country}', 'CountryController@update');
            Route::delete('/{country}', 'CountryController@destroy');
        });

        Route::group(['prefix' => 'posts'], function () {
            Route::get('/{category}', 'PostController@index');
            Route::post('/', 'PostController@store');
            Route::get('/show/{post}', 'PostController@show');
            Route::post('/update/{post}', 'PostController@update');
            Route::delete('/{post}', 'PostController@destroy');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'UserController@index');
            Route::get('/{user}', 'UserController@block');
            Route::delete('/{user}', 'UserController@destroy');
        });

        Route::group(['prefix' => 'comments'], function () {
            Route::delete('/{comment}', 'CommentController@destroy');
        });
    });

Route::group(['namespace' => 'App\Http\Controllers\Basic', 'middleware' => 'api'], function () {
    Route::group(['prefix'=>'home'], function (){
       Route::get('/', 'HomeController@index');
    });

    Route::group(['prefix'=>'likes'], function (){
       Route::get('/{post}', 'LikeController@like');
    });

    Route::group(['prefix'=>'search'], function (){
       Route::post('/', 'SearchController');
    });


    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'CategoryController@index');
    });

    Route::group(['prefix' => 'comments'], function () {
        Route::post('/', 'CommentController@store');
    });

    Route::group(['prefix' => 'chat'], function () {
        Route::get('/', 'ChatController@index');
        Route::post('/', 'ChatController@store');
    });

    Route::group(['prefix' => 'posts'], function () {
        Route::get('/{category}', 'PostController@index');
        Route::post('/', 'PostController@store');
        Route::get('/show/{post}', 'PostController@show');
        Route::get('/reviews_count/{post}', 'PostController@updateReviewsCount');
    });
});
