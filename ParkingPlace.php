<?php
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");

use Queries\ParkingPlace;

require_once("responses/responses.class.php");
require_once("entities/Queries/ParkingPlace.class.php");
require_once("config/DataBase.php");

$conexPDO = DataBase::connect();
$_responses = new responses;
$gestorParking = new ParkingPlace;

if ($_SERVER['REQUEST_METHOD'] == 'GET') { //Get By id
    if (isset($_GET['idParkingPlace'])) {
        $result = $gestorParking->getParking($_GET['idParkingPlace'], $conexPDO);
        if ($result) {
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo json_encode($result);
            http_response_code(200);
        } else {
            $_responses->error_500();
        }
    } else if (isset($_GET['ciudad'])) { //Get bi ciudad
        $result = $gestorParking->getParkingByCity($_GET['ciudad'], $conexPDO);
        if ($result) {
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo json_encode($result);
            http_response_code(200);
        } else $_responses->error_500();

    } else if(isset($_GET['SuperUserID'])){
        $result=$gestorParking->getBySuperUserID($_GET['SuperUserID'], $conexPDO);
        if ($result) {
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo json_encode($result);
            http_response_code(200);
        } else $_responses->error_500();

    }else if(isset($_GET['calle'])){
        $result=$gestorParking->getByCalle($_GET['calle'], $conexPDO);
        if ($result) {
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo json_encode($result);
            http_response_code(200);
        } else $_responses->error_500();

        
    }else{ //Get todos los parkings
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $result = $gestorParking->getParkingPlaces($conexPDO);
        echo json_encode($result);
        http_response_code(200);
    }
}else if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $postBody=file_get_contents("php://input");
    $datos = json_decode($postBody, true);

    $result=$gestorParking->postParking($datos,$conexPDO);
    header('Content-Type: application/json');

    if(isset($result["result"]["error_id"])){
        $responseCode=$result["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }

    echo json_encode($result);
}else if($_SERVER['REQUEST_METHOD']=='DELETE'){
    $postBody=file_get_contents("php://input");
    if(isset($_GET['idParkingPlace'])){
        $result=$gestorParking->deleteParking($_GET['idParkingPlace'],$conexPDO);
        header('Content-Type: application/json');
        echo json_encode($result);
        http_response_code(200);
    }else{
        $_responses->error_400();
    }
}
