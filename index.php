<?php namespace App;

error_reporting( E_ALL );

header("Content-Type: application/json");
require_once "controller/CardController.php";
use \App\Controller;

$index = new Controller\CardController;



$routers = $_GET['key'] ?? 'index/index';
$separator = explode("/", $routers);
$controller = $separator[0];
$method = $_SERVER["REQUEST_METHOD"];

echo $index->get(); die;


switch ($method) {
    case "GET":
        echo $index->get();
        break;
    case "DELETE":
        echo "\$index->delete()";
        break;
    case "POST":
        $body = file_get_contents('php://input');
        echo json_encode($body);
        break;
            
    default:
        # code...
        break;
}

// echo json_encode(array(
//     "\$index"  => "->select()",
//     "\$router" => $routers,
//     "\$controller" => $controller,
//     "\$method" => $method
// ));