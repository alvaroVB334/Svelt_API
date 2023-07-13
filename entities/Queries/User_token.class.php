<?php
namespace Queries;
use PDO;
use PDOException;
class User_token{
    public function getUser_tokens($conexPDO)
    {

        if ($conexPDO != null) {
            try {
                $query = $conexPDO->prepare("SELECT * FROM svelt.user_tokens");

                $query->execute(); // Ejecutamos sentencia
                return $query->fetchAll(); //Devolvemos los datos al cliente
            } catch (PDOException $e) {
                print("Error al acceder a la BD" . $e->getMessage());
            }
        }
    }
    public function getToken($Token,$conexPDO){
        if (isset($Token)) {
            try {
                $query = $conexPDO->prepare("SELECT * FROM svelt.user_tokens where Token=? and isActive=1");

                $query->bindParam(1,$Token);
                $query->execute(); // Ejecutamos sentencia
                return $query->fetchAll(); //Devolvemos los datos al cliente
            } catch (PDOException $e) {
                print("Error al acceder a la BD" . $e->getMessage());
            }
        }
    }
    public function getUserByToken($token, $conexPDO)
    {
        if (isset($conexPDO) && is_string($token)) {
            try {
                $query = $conexPDO->prepare("SELECT user.*, user_tokens.token
                FROM user
                JOIN user_tokens ON user.user_code = user_tokens.user_code
                WHERE user_tokens.token =:user");
                $query->bindParam(":user", $token);

                $query->execute();
                return $query->fetch(); //Devolvemos los datos de de la cartelera según la ID introducida
            } catch (PDOException $e) {
                print("Error al acceder a la BD" . $e->getMessage());
            }
        }
    }
    public function postUser_token($token, $conexPDO)
    {
        $result = null;

        if (isset($token) && $conexPDO != null) {
            try {
                //Preparamos sentencia
                $query = $conexPDO->prepare("INSERT INTO svelt.user_tokens(user_code,isActive,Token,Fecha) values(:user_code,:isActive,:Token,:Fecha)");

                //Le asociamos los Parametros
                $query->bindParam(":user_code", $token["user_code"]);
                $query->bindParam(":isActive", $token["isActive"]);
                $query->bindParam(":Token", $token["Token"]);
                $query->bindParam(":Fecha", $token["Fecha"]);

                //Ejecutamos
                $result = $query->execute();
            } catch (PDOException $e) {
                print("Error al conectar a la BD " . $e->getMessage());
            }

            return $result;
        }
    }
    public function updateToken($tokenId,$conexPDO){
        $date=date("Y-m-d H:i");
        try {
            $query=$conexPDO->prepare("UPDATE svelt.user_tokens SET Fecha=:Fecha where tokenId=:tokenId and ");

            $query->bindParam(":Fecha",$date);
            $query->bindParam(":tokenId",$tokenId);

            return $query->execute();
        } catch (PDOException $e) {
            print("Error al conectar a la BD ".$e->getMessage());
        }
    }
    public function deleteTokenByUserCode($userCode,$conexPDO){
        try{
            $query=$conexPDO->prepare("DELETE FROM svelt.user_tokens where user_code=:user_code");

            $query->bindParam(":user_code",$userCode);

            $query->execute();
            return $query->fetch();
        }catch(PDOException $e){
            print("Error al conectar a la  BD".$e->getMessage());
        }

    }
}