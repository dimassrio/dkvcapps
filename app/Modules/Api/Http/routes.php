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

Routed::version('v1', function($api){
	$api->get('/video', '\App\Modules\Api\Http\Controllers\VideoController@getAll');
	$api->get('/video/{id}', '\App\Modules\Api\Http\Controllers\VideoController@getEntity');
	$api->post('/video', '\App\Modules\Api\Http\Controllers\VideoController@postEntity');
	$api->put('/video/{id}', '\App\Modules\Api\Http\Controllers\VideoController@putEntity');
	$api->delete('/video/{id}', '\App\Modules\Api\Http\Controllers\VideoController@deleteEntity');
	$api->post('/video/{id}/like', '\App\Modules\Api\Http\Controllers\VideoController@toggleLike');
	$api->get('/video/{id}/like', '\App\Modules\Api\Http\Controllers\VideoController@getAllLike');
	$api->get('/video/{id}/like-count','\App\Modules\Api\Http\Controllers\VideoController@getLikeCount');
	$api->get('/video/{id}/comments', 'App\Modules\Api\Http\Controllers\CommentsController@getAll');
	$api->post('/video/{id}/comments', 'App\Modules\Api\Http\Controllers\CommentsController@postEntity');
	$api->get('/video/{id}/users', 'App\Modules\Api\Http\Controllers\CommentsController@getUsers');
	$api->get('/comments/{id}', 'App\Modules\Api\Http\Controllers\CommentsController@getEntity');
	$api->delete('/comments/{id}', 'App\Modules\Api\Http\Controllers\CommentsController@deleteEntity');
	$api->post('/comments/{id}/flag', 'App\Modules\Api\Http\Controllers\CommentsController@toggleFlag');

	$api->get('/company', 'App\Modules\Api\Http\Controllers\CompanyController@getAll');
	$api->get('/company/{id}', 'App\Modules\Api\Http\Controllers\CompanyController@getEntity');

});