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
if(!isset($data->author_id)&& isset($data->category_id) && isset($data->quote)){
    echo json_encode(array('message' => 'author_id Not Found'));
}
else if(isset($data->author_id)&& !isset($data->category_id) && isset($data->quote)){
    echo json_encode(array('message' => 'category_id Not Found'));
}
else if(!isset($data->author_id)&& isset($data->category_id) && isset($data->quote)){
    $post->quote = $data->quote;
    $post->category_id = $data->category_id;
    $post->author_id = $data->author_id;
    if ($post->create()){
        $post->getID($post->quote);
        $arr = array('id' => $post->id, 'quote'=> $post->quote, 'author_id' => $post->author_id, 'category_id' => $post->category_id);
        echo json_encode($arr);
    }
}
else{
    echo json_encode(array('message' => 'Missing Required Parameters'));
}