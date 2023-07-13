<?php
use Queries\User_token;
require_once("entities/Queries/User_token.class.php");
class Utils
{
    
    public static function encrypt($string){
        return md5($string);
    }
    public static function insertToken($user_code,$conexPDO){
     $token=[
        "user_code"=>$user_code,
        "Token"=>bin2hex(openssl_random_pseudo_bytes(16,$val)),
        "isActive"=>1,
        "Fecha"=>date("Y-m-d H:i")
     ];
     $gestorTokens=new User_token;
     $result=$gestorTokens->postUser_token($token,$conexPDO);
     if($result){
        return $token;
     }else{
        return 0;
     }
    }
}
