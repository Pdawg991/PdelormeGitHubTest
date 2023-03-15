<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$post = new Author($db);

$data = json_decode(file_get_contents("php://input"));

$post->author = $data->author;

if ($post->create()){
    echo json_encode(array('message'=> 'Post Created'));
}
else {
    echo json_encode(array('message' => 'Post Not Created'));
}