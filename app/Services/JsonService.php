<?php
namespace App\Services;
class JsonService{
	static function ok($array){return JsonService::response($array,200);}
	static function error($array){return JsonService::response($array,403);}
	static function Unauthorized($array){return JsonService::response($array,401);}
	static function response($array,$status){
		return response()->json($array,$status)
			->header('Content-Type', 'application/json;charset=UTF-8');;
	}
}
?>