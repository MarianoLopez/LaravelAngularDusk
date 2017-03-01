<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profile';
    
    protected $hidden = ['pivot'];//for json
    
    public function users(){
        return $this->belongsToMany('App\User','user_profile','user_id','profile_id');
    }
}
