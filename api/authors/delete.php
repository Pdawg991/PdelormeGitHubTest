<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Set header for allowed method
header('Access-Control-Allow-Methods: DELETE');

// Set header for allowed headers
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Include necessary files
include_once '../../config/database.php';
include_once '../../models/Author.php';

// Create database connection
$database = new Database();
$db = $database->connect();

// Create Author object
$post = new Author($db);

// Decode input data
$data = json_decode(file_get_contents("php://input"));

// Set Author object ID from input data
$post->id = $data->id;

// Check if post is deleted successfully and return appropriate response
if ($post->delete()){
    echo json_encode(array('id'=> $post->id));
}
else {
    echo json_encode(array('message' => 'Post Not Deleted'));
}