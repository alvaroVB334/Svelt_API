<?php
require_once("responses/auth.class.php");
require_once("responses/responses.class.php");
require_once("config/DataBase.php");

$_auth = new auth;
$_responses = new responses;

$conexPDO = DataBase::connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    //recibir datos
    $postBody = file_get_contents("php://input");
    //enviamos los datos al manejador
    $datosArray = $_auth->login($postBody, $conexPDO);

    //devolvemos una respuesta
    header('Content-Type: application/json');
    if (isset($datosArray["result"]["errorId"])) {
        $responseCode = $datosArray["result"]["errorId"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} else {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    $datosArray = $_responses->error_405();
    echo json_encode($datosArray);  
}
