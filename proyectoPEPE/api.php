<?php


require_once 'config/dbconfig.php';
require_once 'lib/MySQL.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/UserController.php';

$mysql = new MySQL();
$mysqlConnection = $mysql->getConnection();

$authController = new AuthController($mysqlConnection);
$userController = new UserController($mysqlConnection);

$data = json_decode(file_get_contents('php://input'), true);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($data['action'])) {
        switch ($data['action']) {
            case 'login':
                $result = $authController->login($data);
                echo json_encode($result);
                break;
            case 'register':
                $result = $authController->register($data);
                echo json_encode($result);
                break;
            case 'addNewUser':
                $result = $userController->addNewUser($data);
                echo json_encode($result);
                break;
            case 'deleteUser':
                $result = $userController->deleteUser($data);
                echo json_encode($result);
                break;
            case 'editUser':
                $result = $userController->editUser($data);
                echo json_encode($result);
                break;
            case 'logout':
                $result = $userController->logout($data);
                echo json_encode($result);
                break;
            case 'validateToken':
                $result = $userController->validateToken($data);
                echo json_encode($result);
                break;
            case 'validateTokenAdmin':
                $result = $userController->validateTokenAdmin($data);
                echo json_encode($result);
                break;
            case 'getUserData':
                $result = $userController->getUserData($data);
                echo json_encode($result);
                break;
            case 'acceptInvitation':
                $result = $userController->acceptInvitation($data);
                echo json_encode($result);
                break;
            // Puedes añadir más casos aquí
        }
    }
}
