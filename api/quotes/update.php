<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, quoteization, X-Requested-With');

include_once '../../config/database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$put = new Quote($db);

$data = json_decode(file_get_contents("php://input"));
//Set ID to update
if(!isset($data->id)|| !isset($data->author_id)|| !isset($data->category_id) || !isset($data->quote)){
    echo json_encode(array('message' => 'Missing Required Parameters'));
}
else if(!$put->authorExists($data->author_id)){
    echo json_encode(array('message' => 'author_id Not Found'));
}
else if(!$put->categoryExists($data->category_id)){
    echo json_encode(array('message' => 'category_id Not Found'));
}
else if (isset($data->author_id) && isset($data->category_id) && isset($data->quote)){
    $put->id = $data->id;
    $put->quote = $data->quote;
    $put->category_id = $data->category_id;
    $put->author_id = $data->author_id;
    if ($put->update()){
    echo json_encode(array('id'=> $put->id,  'quote' => $put->quote,  
    'category_id' => $put->category_id,  'author_id' => $put->author_id));
}
}
else
{
    echo json_encode(array('message' => 'Missing Required Parameters')); 
}