<?php namespace App;

error_reporting( E_ALL );

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

require_once "controller/CardController.php";

use \App\Controller;

$index = new Controller\CardController;



$routers = $_GET['key'] ?? 'index/index';
$separator = explode("/", $routers);
$controller = $separator[0];
$resource = $separator[1];
$method = $_SERVER["REQUEST_METHOD"];

// echo $index->get("*", [ "where" => [ "list_state = 'TODO'" ] ] ); die;
// echo $index->put(6);
// echo $index->delete(6);
// echo $index->post(file_get_contents('php://input'));

switch ($method) {
    case "GET":
        if($resource == "index") :
            echo $index->get();
        else:
            echo $index->get("*", [ "where" => ["card_id = $resource"] ]);
        endif;
        break;
    case "DELETE":
        echo $index->put($resource, true);
        break;
    case "POST":
        if(count($separator) === 3 && $separator[2] == "move"){ //$option = $separator[2];
            // echo "$controller/$resource/$option"; die;
            echo $index->put($resource);
        }else if(count($separator) === 3 && $separator[2] == "archive"){ //$option = $separator[2];
            // echo "$controller/$resource/$option"; die;
            echo $index->put($resource, true);
        }else{
            echo $index->post(file_get_contents('php://input'));
        }
        break;
    case "PUT": echo "OK"; die;
        echo $index->put($resource, ($resource !== "index"));
        break;
    default:
        echo json_encode([
            "title" => "Labfy",
            "version" => 1.0,
            "developer" => "Neto Jocelino <@netojocelino>",
            "licence" => "MIT",
            "methods" => [
                "GET" => [
                    [
                    "route" => "/",
                    "query" => "?key=index/index",
                    "body" => "{ \"title\": string, \"content\": string, \"label\": enum, \"created_by\": string }"
                    ],[
                        "route" => "/",
                        "query" => "?key=index/{id}",
                        "body" => ""
                    ],
                ],
                "POST" => [
                    "route" => "/",
                    "query" => "?key=index/index",
                    "body" => ""
                ],
                "PUT" => [
                    "route" => "/",
                    "query" => "?key=index/{id}",
                    "body" => ""
                ],
                "DELETE" => [
                    "method" => "GET",
                    "route" => "/",
                    "query" => "?key=index/{id}",
                    "body" => ""
                ],
            ]
        ]);
        break;
}
