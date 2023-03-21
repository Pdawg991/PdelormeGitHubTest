<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle options request to set allowed methods and headers
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
} 

// Handle GET requests with or without an ID parameter
if($method ==='GET'){
    if (isset($_GET["id"])){
        include_once '../authors/read_single.php';
    }
    else{
    include_once '../authors/read.php';
    }
}

// Handle POST request to create a new resource
if ($method === 'POST'){
    include_once '../authors/create.php';
}

// Handle PUT request to update an existing resource
if ($method === 'PUT'){
    include_once '../authors/update.php';
}

// Handle DELETE request to delete an existing resource
if ($method === 'DELETE'){
    include_once '../authors/delete.php';
}