<?php 
// Set headers to allow cross-origin resource sharing and set content type to JSON
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Get the HTTP request method
$method = $_SERVER['REQUEST_METHOD'];

// If the request method is OPTIONS, set headers for allowed methods and exit
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// If the request method is GET, determine if the query parameters include id, author_id, or category_id
if ($method ==='GET'){
    if (isset($_GET["id"]) ||isset($_GET["author_id"]) ||isset($_GET["category_id"] )){
        // If any of the query parameters are present, include the file to read a single quote
        include_once '../quotes/read_single.php';
    }
    else{
        // If none of the query parameters are present, include the file to read all quotes
        include_once '../quotes/read.php';
    }
}

// If the request method is POST, include the file to create a new quote
if ($method === 'POST'){
    include_once '../quotes/create.php';
}

// If the request method is PUT, include the file to update an existing quote
if ($method === 'PUT'){
    include_once '../quotes/update.php';
}

// If the request method is DELETE, include the file to delete an existing quote
if ($method === 'DELETE'){
    include_once '../quotes/delete.php';
}