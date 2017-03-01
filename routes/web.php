<?php
//Route::get('/', 'userRESTController@index');
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




Route::get('/login', function (){return view('login');});
Route::post('doLogin', 'AccountController@login');
Route::get('logout',  'AccountController@logout');

   Route::get('/user','userRESTController@index');

//requiere auth
Route::group(['middleware' => 'auth'], function () {
	Route::get('/', function (){return view('user');});
	
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