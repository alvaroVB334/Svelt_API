<?php

use Queries\User_token;

require_once("responses/responses.class.php");
require_once("entities/Queries/Vehicles.class.php");
require_once("config/DataBase.php");

$conexPDO=Database::connect();
$_responses = new responses;
$gestorTokens = new User_token;

if ($_SERVER['REQUEST_METHOD'] == 'GET') { //Get User By Token
    if (isset($_GET['user'])) {
        $result=$gestorTokens->getUserByToken($_GET['user'],$conexPDO);
        
        if ($result) {
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo json_encode($result);
            http_response_code(200);
        } else {
            $_responses->error_500();
        }
    }else $_responses->error_405();
}