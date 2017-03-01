<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Blade::setContentTags('<%', '%>');        // for variables and all things Blade
Blade::setEscapedContentTags('<%%', '%%>');   // for escaped data

Route::get('/login', function (){return view('login');});
Route::post('doLogin', 'AccountController@login');
Route::get('logout',  'AccountController@logout');

   

//requiere auth
Route::group(['middleware' => 'auth'], function () {
	Route::get('/', function (){return view('user');});
	Route::get('/user','userRESTController@index');
	Route::get('/user/{id}','userRESTController@show');
});

//requiere admin, ver app/Http/Middleware/AdminMiddleware.php
Route::post('/user','userRESTController@store')->middleware('admin');
Route::put('/user/{id}','userRESTController@update')->middleware('admin');
Route::delete('/user/{id}','userRESTController@destroy')->middleware('admin');



/* EJEMPLOS
//Route::resource('user','userRESTController');//RESTful

Route::get('/', 'userRESTController@test');


Route::get('ID/{id}',function($id){
   echo 'ID: '.$id;
});

Route::get('/user/{name?}',function($name = 'no value:'){
   echo "Name: ".$name;
});*/
