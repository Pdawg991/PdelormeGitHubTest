<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    
        exit();
    } 
    if($method ==='GET'){
        if (isset($_GET["id"]) ||isset($_GET["author_id"]) ||isset($_GET["category_id"] )){
            include_once '../quotes/read_single.php';
        }
        else{
        include_once '../quotes/read.php';
        }
    }
    if ($method === 'POST'){
        include_once '../quotes/create.php';
    }
    if ($method === 'PUT'){
        include_once '../quotes/update.php';
    }
    if ($method === 'DELETE'){
        include_once '../quotes/delete.php';
    }
?>
