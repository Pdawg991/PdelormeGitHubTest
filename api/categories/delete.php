<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Include necessary files and initialize objects
include_once '../../config/database.php';
include_once '../../models/Category.php';
$database = new Database();
$db = $database->connect();
$post = new Category($db);

// Get JSON data from the request body and set the ID to delete
$data = json_decode(file_get_contents("php://input"));
$post->id = $data->id;

// Delete the post with the specified ID and return a success or error message in JSON format
if ($post->delete()){
    echo json_encode(array('id'=> $post->id));
}
else {
    echo json_encode(array('message' => 'Post Not Deleted'));
}