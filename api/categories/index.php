<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

// Handle preflight requests
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
} 

// Handle GET requests
if($method ==='GET'){
    if (isset($_GET["id"])){
        include '../categories/read_single.php';
    }
    else{
        include '../categories/read.php';
    }
}

// Handle POST requests
if ($method === 'POST'){
    include_once '../categories/create.php';
}

// Handle PUT requests
if ($method === 'PUT'){
    include_once '../categories/update.php';
}

// Handle DELETE requests
if ($method === 'DELETE'){
    include_once '../categories/delete.php';
}