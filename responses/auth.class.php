<?php
require_once("Utils/Utils.php");
require_once("config/DataBase.php");
require_once("responses.class.php");
require_once("entities/Queries/User.class.php");
// require_once("entities/Queries/User_token.php");
use Queries\User;

class auth extends DataBase
{

    public function login($json,$conexPDO)
    {
        $_responses = new responses;
        $datos = json_decode($json, true); //Convierte el json a array y con el true a asociativo
        if (!isset($datos['email']) || !isset($datos['password'])) { //Error en los campos
            return $_responses->error_400();
        } else {
            //todobien
            $email = $datos['email'];
            $password = Utils::encrypt($datos['password']);
            $datos = $this->getUserData($email,$conexPDO);
            if ($datos) {
                if ($password == $datos['password']) {
                    if ($datos['isActive'] == 1) {
                        $verificar = Utils::insertToken($datos['user_code'], $conexPDO);
                        if ($verificar) {

                            $result = $_responses->response;
                            $result["result"] = array(
                                "token" => $verificar
                            );
                            return $result;
                        } else {
                            return $_responses->error_200("Error interno, no hemos podido guardar");
                        }
                    } else {
                        return $_responses->error_200("Usuario Inactivo"); //USUARIO NO ACTIVO -> VER MAS TARDE para mandar correos etc
                    }
                } else {
                    return $_responses->error_405("Password incorrecta");
                }
            } else {
                return $_responses->error_401("El usuario " . $email . " no existe");
            }
        }
    }

    private function getUserData($email,$conexPDO)
    {
        $gestorUser = new User;
        $datos = $gestorUser->getUserByEmail($email, $conexPDO);
        if ($datos) {
            return $datos;
        } else return 0;
    }
}
