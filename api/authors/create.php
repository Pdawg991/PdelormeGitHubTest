<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Include database configuration and Author model
include_once '../../config/database.php';
include_once '../../models/Author.php';

// Create database connection and Author object
$database = new Database();
$db = $database->connect();
$post = new Author($db);

// Get JSON data from request body and check if required parameter is present
$data = json_decode(file_get_contents("php://input"));
if(!isset($data->author)){
echo json_encode(array('message' => 'Missing Required Parameters'));
}
else{
// Set Author object property and attempt to create new record in database
$post->author = $data->author;
if ($post->create()){
// If creation is successful, get the new author ID and send a JSON response with the new ID and author name
$post->getID($post->author);
$a = array('id' => $post->id,'author'=> $post->author);
echo json_encode($a, JSON_FORCE_OBJECT);
}
}
