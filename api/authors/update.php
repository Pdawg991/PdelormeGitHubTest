<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Include necessary files and initialize objects
include_once '../../config/database.php';
include_once '../../models/Author.php';
$database = new Database();
$db = $database->connect();
$post = new Author($db);

// Get JSON data from the request body and set ID to update
$data = json_decode(file_get_contents("php://input"));
if(!isset($data->id) || !isset($data->author)){
    // If ID or author data is missing, return a JSON error message
    echo json_encode(array('message' => 'Missing Required Parameters'));
}
else{
    // Else, update the post in the database and return the updated data in JSON format
    $post->id = $data->id;
    $post->author = $data->author;
    if ($post->update()){
        echo json_encode(array('id'=> $post->id,  'author' => $post->author));
    }
}