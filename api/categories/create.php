<?php
// Set necessary headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Include files
include_once '../../config/database.php';
include_once '../../models/Category.php';

// Connect to database
$database = new Database();
$db = $database->connect();

// Create new Category model instance
$post = new Category($db);

// Get JSON data from client
$data = json_decode(file_get_contents("php://input"));

// Check if 'category' field is missing from data
if(!isset($data->category)){
    // If missing, return error message
    echo json_encode(array('message' => 'Missing Required Parameters'));
}
else{
    // If 'category' field is present, set Category model's 'category' property
    $post->category = $data->category;
    
    // Attempt to create new category in database using Category model's 'create' method
    if ($post->create()){
        // If successful, get category ID and name and return in JSON format
        $post->getID($post->category);
        $a = array('id' => $post->id,'category'=> $post->category);
        echo json_encode($a, JSON_FORCE_OBJECT);
    }
}