<?php

// index.php en el directorio raíz

require_once 'config/dbconfig.php';
require_once 'lib/MySQL.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/UserController.php';


$mysql = new MySQL();
$mysqlConnection = $mysql->getConnection();
$page = isset($_GET['page']) ? $_GET['page'] : 'home';



switch ($page) {
    case 'home':

        include 'views/homeView.php';
        break;
    case 'admin':
        $administrativos = $mysqlConnection->query("SELECT * FROM administrativos");
        $docentes = $mysqlConnection->query("SELECT * FROM docentes");

        $distinciones = $mysqlConnection->query("SELECT distincion FROM distinciones");
        $distinciones1 = $mysqlConnection->query("SELECT distincion FROM distinciones");
        $dependencias = $mysqlConnection->query("SELECT dependencia FROM dependencias");
        $dependencias1 = $mysqlConnection->query("SELECT dependencia FROM dependencias");

        $asistencias = $mysqlConnection->query("SELECT * FROM invitaciones WHERE accepted = true");

        include 'views/superadminView.php';
        break;
    case 'user':


        include 'views/userView.php';
        break;
//    case 'products':
//        // Controlador para productos
//        $productController = new ProductController($mysqlConnection);
//        $productController->index();
//        break;
//    default:
//        // Página no encontrada
//        include 'views/404View.php';
//        break;
}
