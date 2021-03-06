<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['prefix' => 'frontend'], function() {
	Route::get('/', function() {
		dd('This is the Frontend module index page.');
	});
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
// Route::get('/login', ['uses'=>'\App\Modules\Frontend\Http\Controllers\FrontendControllers@getLogin']);
// Route::post('/login', ['uses'=>'\App\Modules\Frontend\Http\Controllers\FrontendController@postLogin']);

Route::get('/auth/login', '\App\Http\Controllers\Auth\AuthController@getLogin');
Route::post('/auth/login', '\App\Http\Controllers\Auth\AuthController@postLogin');

Route::group(['middleware'=>['auth']], function(){
	// only logout after login
	Route::get('/auth/logout', '\App\Http\Controllers\Auth\AuthController@getLogout');

	// video management
	Route::get('/dashboard/video', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardVideoIndex');
	Route::get('/dashboard/video/{id}/delete', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardVideoDelete');
	Route::get('/dashboard/create/video', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardVideoCreate');
	Route::post('/dashboard/video', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardVideoPost');
	Route::post('/dashboard/video/{id}', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardVideoPut');
	Route::get('/dashboard/video/{id}/edit', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardVideoEdit');

	// users management
	Route::get('/dashboard/users', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardUsersIndex');
	Route::get('/dashboard/create/users', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardUsersCreate');
	Route::post('/dashboard/users', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardUsersPost');
	Route::get('/dashboard/users/{id}/delete', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardUsersDelete');
	Route::get('/dashboard/users/{id}/edit', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardUsersEdit');
	Route::post('/dashboard/users/{id}', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardUsersPut');

	//cobrand management
	Route::get('/dashboard/cobrands', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardVendorIndex');
	Route::post('/dashboard/cobrands', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardVendorPost');
	Route::post('/dashboard/cobrands/{id}', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardVendorPut');
	Route::get('/dashboard/create/cobrands', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardVendorCreate');
	Route::get('/dashboard/cobrands/{id}/delete', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardVendorDelete');
	Route::get('/dashboard/cobrands/{id}/edit', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardVendorEdit');

	//comment management
	Route::get('/dashboard/comments/{id}', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardCommentsIndex');
	Route::get('/dashboard/comments/delete/{id}', '\App\Modules\Frontend\Http\Controllers\FrontendControllers@dashboardCommentsDelete');


});
Route::group(['prefix' => 'frontend', 'middleware' => ['web']], function () {
	//
});
