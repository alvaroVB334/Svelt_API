<?php
header("Access-Control-Allow-Methods: PUT,POST, DELETE,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

use Queries\Vehicles;

require_once("responses/responses.class.php");
require_once("entities/Queries/Vehicles.class.php");
require_once("config/DataBase.php");

$conexPDO=Database::connect();
$_responses = new responses;
$gestorVehiculos = new Vehicles;

//con $_GET para get by 1 sola id
if ($_SERVER['REQUEST_METHOD'] == 'GET') { //GET VEHICLE/{registration}
    
    if(isset($_GET['registration'])){
        $result=$gestorVehiculos->getVehicle($_GET['registration'],$conexPDO);
        if($result){

            header('Content-Type: application/json');
            echo json_encode($result);
            http_response_code(200);
        }else{
            $_responses->error_500();
        }
    }else{
        header('Content-Type: application/json');
        $result=$gestorVehiculos->getVehicles($conexPDO);
        echo json_encode($result);
        http_response_code(200);
    }

} else if ($_SERVER['REQUEST_METHOD'] == 'POST') { //POST VEHICLE

    $postBody=file_get_contents("php://input");
    $result=$gestorVehiculos->postVehicle($postBody,$conexPDO);
    header('Content-Type: application/json');

    if(isset($result["result"]["error_id"])){
        $responseCode=$result["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }

    echo json_encode($result);
    

} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $postBody=file_get_contents("php://input");
    $result=$gestorVehiculos->putVehicle(json_decode($postBody,true),$conexPDO);
    header('Content-Type: application/json');
    if(isset($result["result"]["error_id"])){
        $responseCode=$result["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($result);


}else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') { //DELETE
    $postBody=file_get_contents("php://input");
    if(isset($_GET['registration'])){
        $result=$gestorVehiculos->deleteVehicle($_GET['registration'],$conexPDO);
        header('Content-Type: application/json');
        echo json_encode($result);
        http_response_code(200);
    }else{
        $_responses->error_400();
    }

} else {
    header('Content-Type: application/json');
    $datosArray = $_responses->error_405();
    echo json_encode($datosArray);  
}
