<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
	 public $timestamps = false;
	 protected $fillable = ['first_name', 'last_name', 'state','username'];
     protected $hidden = ['password'];//for json
     protected $table = 'user';


     public function profiles(){
     	return $this->belongsToMany('App\Profile','user_profile','user_id','profile_id');
    }

  // not supported - eliminar token de db
  public function getRememberToken(){return null;}

  public function setRememberToken($value){}

  public function getRememberTokenName(){return null;}

  /**
   * Overrides the method to ignore the remember token.
   */
  public function setAttribute($key, $value){
    $isRememberTokenAttribute = $key == $this->getRememberTokenName();
    if (!$isRememberTokenAttribute){parent::setAttribute($key, $value);}
  }

}
