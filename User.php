<?php
header("Access-Control-Allow-Methods: PUT, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


use Queries\User;
use Queries\User_token;

require_once("Utils/Utils.php");
require_once("responses/responses.class.php");
require_once("entities/Queries/User.class.php");
require_once("entities/Queries/User_token.class.php");
require_once("config/DataBase.php");

$conexPDO = Database::connect();
$_responses = new responses;
$gestorUser = new User;
$gestorToken = new User_token;

//con $_GET para get by 1 sola id
if ($_SERVER['REQUEST_METHOD'] == 'GET') { //GET User/{id}

    if (isset($_GET['userCode'])) {
        $result = $gestorUser->getUser($_GET["userCode"], $conexPDO);
        if ($result) {

            header('Content-Type: application/json');
            echo json_encode($result);
            http_response_code(200);
        } else {
            $_responses->error_500();
        }
    } else if (isset($_GET['email'])) {
        $result = $gestorUser->getUserByEmail($_GET["email"], $conexPDO);
        if ($result) {
            header('Content-Type: application/json');
            echo json_encode($result);
            http_response_code(200);
        } else {
            $_responses->error_500();
        }
    } else {
        header('Content-Type: application/json');
        $result = $gestorUser->getUsers($conexPDO);
        echo json_encode($result);
        http_response_code(200);
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    header('Content-Type: application/json');
    $postBody = file_get_contents("php://input");
    $datos = json_decode($postBody, true);
    // echo $postBody;
    // var_dump($datos);

    if (isset($datos["token"])) {

        $validUserToken = $gestorToken->getUserByToken($datos["token"], $conexPDO);

        if ($validUserToken) {

            if (isset($datos["passwordChange"]) && $datos["passwordChange"] == 1) { //En caso de que el user modifique la contraseña hay que volverla a encriptar
                $datos["password"] = Utils::encrypt($datos["password"]);
                echo $datos["password"];
            }

            $result = $gestorUser->putUser($datos, $conexPDO);
            http_response_code(200);
            echo $postBody;
        } else {
            $_responses->error_401();
        }
    } else if ($datos["user_code"]) { //Significa que estamos haciendo un put de isActive
        $result = $gestorUser->putUser($datos, $conexPDO);
        http_response_code(200);
        echo $postBody;
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'DELETE') { //DELETE

    $postBody=file_get_contents("php://input");
    
    if(isset($_GET['userCode'])){
        echo "hola";
        $resultToken=$gestorToken->deleteTokenByUserCode($_GET['userCode'],$conexPDO);
        $result=$gestorUser->deleteUser($_GET['userCode'],$conexPDO);

        header('Content-Type: application/json');
        echo json_encode($result);
        http_response_code(200);
    }else{
        $_responses->error_400();
    }

    echo json_encode($result);
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postBody = file_get_contents("php://input");
    $result = $gestorUser->postUser($postBody, $conexPDO);
    header('Content-Type: application/json');

    if (isset($result["result"]["error_id"])) {
        $responseCode = $result["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }

    echo json_encode($result);
} else {
    header('Content-Type: application/json');
    $datosArray = $_responses->error_405();
    echo json_encode($datosArray);
}
