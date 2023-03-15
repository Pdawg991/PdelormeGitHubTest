<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$post = new Author($db);

$data = json_decode(file_get_contents("php://input"));
//Set ID to update
if(empty($data->id) || empty($data->author)){
    echo json_encode(array('message' => 'Missing Required Parameters'));
}
else{
$post->id = $data->id;
$post->author = $data->author;
if ($post->update()){
    echo json_encode(array('id'=> $post->id,  'author' => $post->author));
}
}