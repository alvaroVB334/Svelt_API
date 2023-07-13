<?php

namespace Queries;
use PDO;
use PDOException;
use responses;

require_once("./responses/responses.class.php");

class User
{
    /**
     * Get de todas los Usuarios
     * @param conexPDO-> Objeto de conexión a base de datos
     */
    public function getUsers($conexPDO)
    {

        if ($conexPDO != null) {
            try {
                $query = $conexPDO->prepare("SELECT * FROM svelt.user");

                $query->execute(); // Ejecutamos sentencia
                return $query->fetchAll(); //Devolvemos los datos al cliente
            } catch (PDOException $e) {
                print("Error al acceder a la BD" . $e->getMessage());
            }
        }
    }
    /**
     * Get de Users por su user_code
     * @param conexPDO-> Objeto de conexión a BD
     * @param userCode-> Codigo de usuario a buscar
     */
    public function getUser($userCode, $conexPDO)
    {
        if (isset($conexPDO) && is_numeric($userCode)) {
            try {
                $query = $conexPDO->prepare("SELECT * FROM svelt.user WHERE user_code=?");
                $query->bindParam(1, $userCode); //Asigamos la interrogación a el valor en concreto

                $query->execute();
                return $query->fetch(); //Devolvemos los datos de de la cartelera según la ID introducida
            } catch (PDOException $e) {
                print("Error al acceder a la BD" . $e->getMessage());
            }
        }
    }
    public function getUserByEmail($email, $conexPDO)
    {
        if (isset($conexPDO) && is_string($email)) {
            try {
                $query = $conexPDO->prepare("SELECT * FROM svelt.user WHERE email=?");
                $query->bindParam(1, $email); //Asigamos la interrogación a el valor en concreto

                $query->execute();
                return $query->fetch();
            } catch (PDOException $e) {
                print("Error al acceder a la BD" . $e->getMessage());
            }
        }
    }
    /**
     * Post de Users
     * @param User-> Usuario (array) a introducir
     * @param conexPDO-> Objeto de conexión a la Base de Datos
     */
    public function postUser($user, $conexPDO)
    {
        $result = null;
        $_responses=new responses;
        $user=json_decode($user,true);

        if (isset($user) && $conexPDO != null) {
            try {
                //Preparamos sentencia
                $query = $conexPDO->prepare("INSERT INTO svelt.user(balance,name,lastName,dni,salt,activation_code,isActive,email,password) values(:balance,:name,:lastName,:dni,:salt,:activation_code,:isActive,:email,:password)");

                //Le asociamos los Parametros
                $query->bindParam(":balance", $user["balance"]);
                $query->bindParam(":name", $user["name"]);
                $query->bindParam(":lastName", $user["lastName"]);
                $query->bindParam(":dni", $user["dni"]);
                $query->bindParam(":salt", $user["salt"]);
                $query->bindParam(":activation_code", $user["activation_code"]);
                $query->bindParam(":isActive", $user["isActive"]);
                $query->bindParam(":email", $user["email"]);
                $query->bindParam(":password", $user["password"]);

                //Ejecutamos
                $result = $query->execute();

                if($result){
                    $respuesta=$_responses->response;
                    $respuesta["result"]=array(
                        "activation_code"=>$user["activation_code"],
                        "isActive"=>$user["isActive"]
                    );
                    return $respuesta;
                }else{
                    return $_responses->error_500();
                }
            } catch (PDOException $e) {
                print("Error al conectar a la BD " . $e->getMessage());
            }

            return $result;
        }
    }

    /**
     * Elimina un Usuario según su user_code
     * 
     * @param user_code-> codigo del usuario a eliminar
     * @param conexPDO-> Objeto de conexión a base de datos
     */
    public function deleteUser($user_code, $conexPDO)
    {
        $result = null;
        if ($conexPDO != null && is_numeric($user_code)) {
            try {
                $query = $conexPDO->prepare("DELETE FROM svelt.user WHERE user_code=?");
                $query->bindParam(1, $user_code);
                $query->execute();
                
                $result=$query->fetch();
            } catch (PDOException $e) {
                print("Error al conectar a la BD " . $e->getMessage());
            }
        }
        return $result;
    }
    /**
     * Put de vehiculos, modifica el usuario que le pasemos
     * @param user-> User que contiene el user_code a cambiar y sus nuevos atributos
     * @param conexPDO-> Objeto de conexión a la base de datos
     */
    public function putUser($user, $conexPDO)
    {
        $result = null;
        if ($conexPDO != null && isset($user) && is_numeric($user["user_code"])) {
            try {
                $query = $conexPDO->prepare("UPDATE svelt.user set balance=:balance,name=:name,lastName=:lastName,Vehicle_registration=:Vehicle_registration,SuperUser_idSuperUser=:SuperUser_idSuperUser,dni=:dni,salt=:salt,activation_code=:activation_code,isActive=:isActive,email=:email,password=:password,usingParking=:usingParking where user_code=:user_code");

                $query->bindParam(":balance", $user["balance"]);
                $query->bindParam(":name", $user["name"]);
                $query->bindParam(":lastName", $user["lastName"]);
                $query->bindParam(":Vehicle_registration", $user["Vehicle_registration"]);
                $query->bindParam(":SuperUser_idSuperUser", $user["SuperUser_idSuperUser"]);
                $query->bindParam(":dni", $user["dni"]);
                $query->bindParam(":salt", $user["salt"]);
                $query->bindParam(":activation_code", $user["activation_code"]);
                $query->bindParam(":isActive", $user["isActive"]);
                $query->bindParam(":email", $user["email"]);
                $query->bindParam(":password", $user["password"]);
                $query->bindParam(":user_code", $user["user_code"]);
                $query->bindParam(":usingParking", $user["usingParking"]);

                $result = $query->execute();
            } catch (PDOException $e) {
                print("Error al conectar a la BD " . $e->getMessage());
            }
        }
        return $result;
    }
}
