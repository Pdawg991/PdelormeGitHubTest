<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, quoteization, X-Requested-With');

include_once '../../config/database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$post = new Quote($db);

$data = json_decode(file_get_contents("php://input"));
if(empty($data->quote)){
    echo json_encode(array('message' => 'Missing Required Parameters'));
}
else{
$post->quote = $data->quote;
if ($post->create()){
    $post->getID($post->quote);
    $a = array('id' => $post->id,'quote'=> $post->quote);
    echo json_encode($a, JSON_FORCE_OBJECT);
    
}
}