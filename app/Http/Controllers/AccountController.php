<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Input;
use Auth;
use Session;
use App\User_;
use App\Profile;

//controller para login y logout
class AccountController extends Controller {
  public function login() {
    // Getting all post data
    $data = Input::all();
    // Applying validation rules.
    $rules = array('username' => 'required','password' => 'required|min:6',);

    $validator = Validator::make($data, $rules);
    if ($validator->fails()){
      // If validation falis redirect back to login.
      //Session::flash('error', $validator->errors()); 
      return Redirect::to('/login')->withInput(Input::except('password'))->with('error',$validator->errors());
    }
    else {
      $userdata = array('username' => Input::get('username'),'password' => Input::get('password'),'state' => 1);
      // doing login.
      if (Auth::validate($userdata)) {
        if (Auth::attempt($userdata)) {
          return Redirect::intended('/');
          //return redirect('/');
        }
      } 
      else {
        // if any error send back with message.
        //Session::flash('error', 'Credenciales incorrectas'); 
        return Redirect::to('login')->with('error','Credenciales incorrectas');
      }
    }
  }

  public function logout() {
  Auth::logout(); // logout user
  return Redirect::to('login'); //redirect back to login
}
}