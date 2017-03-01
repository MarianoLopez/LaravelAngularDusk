<?php
namespace App\Services;
use App\User;
use Validator;
use App\Services\JsonService;
use App\Profile;
use Illuminate\Support\Facades\DB;

//capa de servicio de User
class UserService {
  public static function getAll(){
    return User::with('profiles')->get();//get all incluyendo profiles "many to many"
  }

  public static function getById($id){
    //return User::with('profiles')->where('username', '=', $id)->get();//ej where
    return User::with('profiles')->find($id);
  }

  public static function insert($request){
    //Body:x-www Ej: [{"id":3,"first_name":"Mariano","last_name":"Lopez","state":1,"username":"Mariano","profiles":[{"id":1,"type":"ADMIN"},{"id":2,"type":"USER"}]}]
    $data = $request->all();//request to array
    $v = UserService::validateUserInsert($data);//validator obj con reglas de insert
    if($v->fails()){
      return JsonService::error(['message'=>json_encode($v->errors())]);
    }else{
      $user = UserService::getUserForInsert($data);//new user
      try {
        DB::beginTransaction();
        $user->save();
        //perfiles json_decode($data['profiles'], true)
        foreach ($data['profiles'] as $key => $value) {
          $user->profiles()->save(Profile::findOrFail($value['id']));
        }
        DB::commit();
        return JsonService::ok(['message'=>'Usuario '.$user->username.' añadido','data'=>User::with('profiles')->find($user->id)]);
      }catch (\Exception $e) {
        DB::rollback();
        return JsonService::error(['message'=>json_encode($e->getMessage())]);
      }
    }
  }

  public static function update($id,$request){
    $user = User::find($id);
    if(!is_null($user)){
      $data = $request->all();
      $v = UserService::validateUserUpdate($data);//validator obj con reglas de update
      if($v->fails()){
        return JsonService::error(['message'=>json_encode($v->errors())]);
      }else{
        UserService::getUserForUpdate($user,$data);//modifica atributos "en memoria"
        try {
          DB::beginTransaction();
          $user->save();
          //perfiles json_decode($data['profiles'], true)
          $profiles_id = array();
          foreach ($data['profiles'] as $key => $value) {array_push($profiles_id, $value['id']);}
            $user->profiles()->sync($profiles_id);//MERGE 
            DB::commit();
            return JsonService::ok(['message'=>'Usuario '.$user->username.' modficado','data'=>User::with('profiles')->find($user->id)]);
        } catch (\Exception $e) {
          DB::rollback();
          return JsonService::error(['message'=>json_encode($e->getMessage())]);
        }
      }
    }else{
      return JsonService::ok(['message'=>'No se encontró usuario con ese ID']);
    }
  }

  public static function delete($id){
    $user = User::find($id);
    if(!is_null($user)){
      $profiles = $user->profiles();
      if(!is_null($profiles)){
        $profiles->detach();//kill 'em all'
      }
      $user->delete();
      return JsonService::ok(['message'=>'Usuario '.$user->username.' eliminado','data'=>$user]);
    }else{
      return JsonService::ok(['message'=>'No se encontró usuario con ese ID']);
    }
  }

/******* funciones auxiliares***********/

  //validar para insert
  public static  function validateUserInsert($data){
   return Validator::make($data, [
    'first_name' => 'required|max:255',
    'last_name' => 'required',
    'password'=>'required|min:6',
    'state'=>'required',
    'username'=>'required|unique:user',
    'profiles'=>'required'
    ]);
 }
   //new User desde array
   public static function getUserForInsert($data) {
    $instance = new User;
    $instance->first_name=$data['first_name'];
    $instance->last_name=$data['last_name'];
    $instance->password=bcrypt($data['password']);
    $instance->state=$data['state'];
    $instance->username=$data['username'];
    return $instance;
  }
    //validar para update
  public static  function validateUserUpdate($data){
    return Validator::make($data, [
      'first_name' => 'required|max:255',
      'last_name' => 'required',
      'state'=>'required',
      'profiles'=>'required'
      ]);
  }
   //modificar atributos del usuario desde array
  public static function getUserForUpdate($user,$data){
   $user->first_name=$data['first_name'];
   $user->last_name=$data['last_name'];
   $user->state=$data['state'];
   if(isset($data['password']) && ($data['password']!=null)){$user->password=bcrypt($data['password']);}
  }
}