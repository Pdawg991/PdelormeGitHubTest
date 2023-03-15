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
        if (isset($_GET["id"])){
            include_once '../authors/read_single.php';
        }
        else{
        include_once '../authors/read.php';
        }
    }
    if ($method === 'POST'){
        echo $method;
        include_once '../authors/create.php';
    }
    if ($method === 'PUT'){
        include_once '../authors/update.php';
        echo $method;
    }
    if ($method === 'DELETE'){
        echo $method;
        include_once '../authors/delete.php';
    }
?>
