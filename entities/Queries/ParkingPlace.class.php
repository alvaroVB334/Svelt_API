<?php

namespace Queries;
use \PDO;
use \PDOException;
use responses;

require_once("./responses/responses.class.php");
require_once("User_token.class.php");
//FUNCIONAN TODAS
class ParkingPlace{

    /**
     * Get de todas las plazas de aparcamiento
     * @param conexPDO-> Objeto de conexión a base de datos
     */
    public function getParkingPlaces($conexPDO)
    {

        if ($conexPDO != null) {
            try {

                $query = $conexPDO->prepare("SELECT * FROM svelt.parkingplace");

                $query->execute(); 
                return $query->fetchAll();
            } catch (PDOException $e) {
                print("Error al acceder a la BD" . $e->getMessage());
            }
        }
    }
    /**
     * Get de plaza por su ID (int numeric AI)
     * @param conexPDO-> Objeto de conexión a BD
     * @param idParkingPlace-> id a buscar
     */
    public function getParking($idParkingPlace,$conexPDO)
    {
        $result=null;
        if (isset($conexPDO) && is_numeric($idParkingPlace)) {
            try {
                $query = $conexPDO->prepare("SELECT * FROM svelt.parkingplace WHERE idparkingPlace=?"); 
                $query->bindParam(1, $idParkingPlace); 

                $query->execute();
                return $query->fetch();
            } catch (PDOException $e) {
                print("Error al acceder a la BD" . $e->getMessage());
            }
        }
    }
    /**
     * Get de plaza por su ID (int numeric AI)
     * @param conexPDO-> Objeto de conexión a BD
     * @param idParkingPlace-> ciudad a buscar
     */
    public function getParkingByCity($ciudad,$conexPDO)
    {
        $result=null;
        if (isset($conexPDO) && is_string($ciudad)) {
            try {
                $query = $conexPDO->prepare("SELECT * FROM svelt.parkingplace WHERE ciudad=?"); 
                $query->bindParam(1, $ciudad); 

                $query->execute();
                return $query->fetchAll();
            } catch (PDOException $e) {
                print("Error al acceder a la BD" . $e->getMessage());
            }
        }
    }

    /**
     * Get by SuperUsuario
     * @param superUserID-> ID Del superUsuario
     * @param conexPDO-> Objeto de Conexión a BD
     */
    public function getBySuperUserID($superUserID,$conexPDO){
        if (isset($conexPDO) && isset($superUserID)) {
            try {
                $query = $conexPDO->prepare("SELECT * FROM svelt.parkingplace WHERE SuperUser_idSuperUser=?"); 
                $query->bindParam(1, $superUserID); 

                $query->execute();
                return $query->fetchAll();
            } catch (PDOException $e) {
                print("Error al acceder a la BD" . $e->getMessage());
            }
        }
    }
    public function getByCalle($calle,$conexPDO){
        if(isset($conexPDO) && isset($calle)){
            try {
                $query = $conexPDO->prepare("SELECT idparkingPlace FROM svelt.parkingplace WHERE calle=?"); 
                $query->bindParam(1, $calle); 

                $query->execute();
                return $query->fetchAll();
            } catch (PDOException $e) {
                print("Error al acceder a la BD" . $e->getMessage());
            }
        }
    }
    
    public function postParking($parking,$conexPDO){
        $result=null;
        if(isset($conexPDO)){
            try {
                //Preparamos sentencia
                $query = $conexPDO->prepare("INSERT INTO svelt.parkingplace(ciudad,calle,isTemporally,state,SuperUser_idSuperUser,latitud,longitud,Referencia) values(:ciudad,:calle,:isTemporally,:state,:SuperUser_idSuperUser,:latitud,:longitud,:Referencia)");

                //Le asociamos los Parametros
                $query->bindParam(":ciudad", $parking["ciudad"]);
                $query->bindParam(":calle", $parking["calle"]);
                $query->bindParam(":isTemporally", $parking["isTemporally"]);
                $query->bindParam(":state", $parking["state"]);
                $query->bindParam(":SuperUser_idSuperUser", $parking["SuperUser_idSuperUser"]);
                $query->bindParam(":latitud", $parking["latitud"]);
                $query->bindParam(":longitud", $parking["longitud"]);
                $query->bindParam(":Referencia", $parking["Referencia"]);


                //Ejecutamos
                $result = $query->execute();
            } catch (PDOException $e) {
                print("Error al conectar a la BD " . $e->getMessage());
            }

            return $result;
        }
    }

    public function deleteParking($parkingID,$conexPDO){
        $result = null;
        $_responses=new responses;
        if ($conexPDO != null && isset($parkingID)) {
            try {
                $query = $conexPDO->prepare("DELETE FROM svelt.parkingplace WHERE idparkingPlace=?");
                $query->bindParam(1, $parkingID);
                $result = $query->execute();
                if($result){
                    $respuesta=$_responses->response;
                    $respuesta["result"]=array(
                        "idParkingPlace"=>$parkingID
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