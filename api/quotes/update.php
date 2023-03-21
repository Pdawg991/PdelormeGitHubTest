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
if(empty($data->id) || empty($data->quote)
empty($data->id) || empty($data->quote)
empty($data->id) || empty($data->quote)){
    echo json_encode(array('message' => 'Missing Required Parameters'));
}
else{
$put->id = $data->id;
$put->quote = $data->quote;
if ($put->update()){
    echo json_encode(array('id'=> $put->id,  'quote' => $put->quote));
}
}