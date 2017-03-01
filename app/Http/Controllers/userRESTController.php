<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class userRESTController extends Controller{
	//GET
	public function index(){return UserService::getAll();}

    //POST user
	public function store(Request $request){return UserService::insert($request);}
	//GET {id}
	public function show($id){return UserService::getById($id);}

    //PUT {id}"url" + user "body"
	public function update(Request $request, $id){return UserService::update($id,$request);}
    //DELETE {id}
	public function destroy($id){return UserService::delete($id);}
}
