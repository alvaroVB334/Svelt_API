<?php
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

use Queries\SuperUser;

require_once("config/DataBase.php");
require_once("Utils/Utils.php");
require_once("responses/responses.class.php");
require_once("entities/Queries/SuperUser.class.php");

$conexPDO = Database::connect();
$_responses = new responses;
$gestorSuperUser=new SuperUser;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $postBody=file_get_contents("php://input");
    $datos = json_decode($postBody, true);

    $result=$gestorSuperUser->postSuperUser($datos["idSuperUsuario"],$conexPDO);
    header('Content-Type: application/json');

    if(isset($result["result"]["error_id"])){
        $responseCode=$result["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }

    echo json_encode($result);
}