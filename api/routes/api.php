<?php

use Illuminate\Http\Request;

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


Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');

Route::group(['prefix' => 'posts'], function() {
	Route::get('/','Api\PostController@index');
	Route::get('/{slug}','Api\PostController@show');

	Route::group(['prefix' => '{slug}/comments'], function() {
	    Route::get('/', 'Api\CommentController@index');
	});
});

Route::group(['middleware' => 'auth:api'], function() {

    Route::post('logout', 'Api\AuthController@logout');

	Route::group(['prefix' => 'posts'], function() {
	    Route::post('/', 'Api\PostController@store');
	    Route::patch('/{slug}','Api\PostController@update');
	    Route::delete('/{slug}','Api\PostController@delete');

		Route::group(['prefix' => '{slug}/comments'], function() {
		    Route::post('/', 'Api\CommentController@store');
		    Route::patch('/{id}','Api\CommentController@update');
		    Route::delete('/{id}','Api\CommentController@delete');
		});
	});

});