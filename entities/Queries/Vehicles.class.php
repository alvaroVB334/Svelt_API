<?php

namespace Queries;
use \PDO;
use \PDOException;
use responses;
use Queries\User_token;

require_once("./responses/responses.class.php");
require_once("User_token.class.php");
//FUNCIONAN TODAS
class Vehicles{

    /**
     * Get de todas los vehiculos
     * @param conexPDO-> Objeto de conexión a base de datos
     */
    public function getVehicles($conexPDO)
    {

        if ($conexPDO != null) {
            try {
                //Introducimos la sentencia con prepared statement y luego ponemos los valores
                $query = $conexPDO->prepare("SELECT * FROM svelt.vehicle");

                $query->execute(); // Ejecutamos sentencia
                return $query->fetchAll(); //Devolvemos los datos al cliente
            } catch (PDOException $e) {
                print("Error al acceder a la BD" . $e->getMessage());
            }
        }
    }
    /**
     * Get de vehiculos por su ID (Matricula)
     * @param conexPDO-> Objeto de conexión a BD
     * @param registration-> Matricula a buscar
     */
    public function getVehicle($registration,$conexPDO)
    {
        $result=null;
        if (isset($conexPDO) && is_string($registration)) {
            try {
                $query = $conexPDO->prepare("SELECT * FROM svelt.vehicle WHERE registration=?"); //Preparamos la query
                $query->bindParam(1, $registration); //Asigamos la interrogación a el valor en concreto

                $query->execute();
                return $query->fetch(); //Devolvemos los datos de de la cartelera según la ID introducida
            } catch (PDOException $e) {
                print("Error al acceder a la BD" . $e->getMessage());
            }
        }
    }
    /**
     * Post de vehiculos
     * @param vehicle-> Vehiculo (array) a introducir
     * @param conexPDO-> Objeto de conexión a la Base de Datos
     */
    public function postVehicle($vehicle,$conexPDO)
    {
        $result = null;
        $_responses=new responses;
        $vehicle=json_decode($vehicle,true);

        if(!isset($vehicle['token'])){ //Si no existe el token
            return $_responses->error_401();
            exit();
        }else{  //Si existe
            $gestorToken=new User_token;
            $arrayToken=$gestorToken->getToken($vehicle['token'],$conexPDO); //Comprobamos si existe en BD

            if($arrayToken){ //Si existe hacemos la logica del insert INTO
                if (isset($vehicle["registration"]) && isset($vehicle["color"]) && isset($vehicle["model"])) {
                    try {
                        //Preparamos sentencia
                        $query = $conexPDO->prepare("INSERT INTO svelt.vehicle(registration,color,model,ceroconsumo) values(:registration,:color,:model,:ceroconsumo)");
        
                        //Le asociamos los Parametros
                        $query->bindParam(":registration", $vehicle["registration"]);
                        $query->bindParam(":color", $vehicle["color"]);
                        $query->bindParam(":model", $vehicle["model"]);
                        $query->bindParam(":ceroconsumo", $vehicle["ceroconsumo"]);
        
                        //Ejecutamos
                        $result = $query->execute();
        
                        if($result){ //Mandamos la respuesta etc
                            $respuesta=$_responses->response;
                            $respuesta["result"]=array(
                                "registration"=>$vehicle["registration"]
                            );
                            return $respuesta;
                        }else{
                            return $_responses->error_500();
                        }
                    } catch (PDOException $e) {
                        print("Error al conectar a la BD " . $e->getMessage());
                    }
        
                    return $result;
                }else{ 
                    return $_responses->error_400();
                }
            }else{ //Si no existe token invalido    
                return $_responses->error_401("El token enviado es invalido o ha caducado");
            }
        }



    
    }

    /**
     * Elimina un Vehiculo según su Matricula
     * 
     * @param registration-> Matricula del coche a eliminar
     * @param conexPDO-> Objeto de conexión a base de datos
     */
    public function deleteVehicle($registration,$conexPDO)
    {
        $result = null;
        $_responses=new responses;
        if ($conexPDO != null && is_string($registration)) {
            try {
                $query = $conexPDO->prepare("DELETE FROM svelt.vehicle WHERE registration=?");
                $query->bindParam(1, $registration);
                $result = $query->execute();
                if($result){
                    $respuesta=$_responses->response;
                    $respuesta["result"]=array(
                        "registration"=>$registration
                    );
                    return $respuesta;
                }else{
                    return $_responses->error_500();
                }
            } catch (PDOException $e) {
                print("Error al conectar a la BD " . $e->getMessage());
            }
        }else{
            return $_responses->error_400();
        }
        return $result;
    }
    /**
     * Put de vehiculos, modifica el vehiculo que le pasemos
     * @param vehicle-> Vehiculo que contiene la id a cambiar y sus nuevos atributos
     * @param conexPDO-> Objeto de conexión a la base de datos
     */
    public function putVehicle($vehicle, $conexPDO)
    {
        $result = null;
        $_responses=new responses;
        if (isset($vehicle["registration"]) && is_string($vehicle["registration"])) {
            try {
                $query = $conexPDO->prepare("UPDATE svelt.vehicle set model=:model,color=:color,ceroconsumo=:ceroconsumo where registration=:registration");

                $query->bindParam(":model", $vehicle["model"]);
                $query->bindParam(":color", $vehicle["color"]);
                $query->bindParam(":ceroconsumo", $vehicle["ceroconsumo"]);
                $query->bindParam(":registration", $vehicle["registration"]);

                $result = $query->execute();
                
                if($result){
                    $respuesta=$_responses->response;
                    $respuesta["result"]=array(
                        "registration"=>$vehicle["registration"]
                    );
                    return $respuesta;
                }else{
                    return $_responses->error_500();
                }
            } catch (PDOException $e) {
                print("Error al conectar a la BD " . $e->getMessage());
            }
        }else{
            return $_responses->error_400();
        }
        return $result;
    }
}



?>