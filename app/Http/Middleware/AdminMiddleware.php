<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use App\Services\JsonService;
class AdminMiddleware{ //agregar admin alias en Kernel.php
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    //ataja el request
    public function handle($request, Closure $next){
        if(Auth::check()){
            if($this->hasRole('ADMIN')){
                return $next($request);//continuar    
            }else{
                return JsonService::Unauthorized(['message'=>'Unauthorized']);
            }
        }else{
            return redirect('/login');    
        }
        
    }

    //buscar rol en profiles
    public function hasRole($role){
        $needle = false;
        foreach (Auth::user()->profiles as $key => $value) {
           if($value->type == $role){
                $needle = true;
                break;
           }
          }
        return $needle;
    }
}
