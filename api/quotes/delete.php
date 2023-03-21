<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$delete = new Quote($db);

$data = json_decode(file_get_contents("php://input"));
if(!$delete->idExists($data->id)){
    echo json_encode(array('message' => 'No Quotes Found'));
}
else if ($delete->delete()){
    $delete->id = $data->id;
    echo json_encode(array('id'=> $delete->id));
}
else {
    echo json_encode(array('message' => 'Post Not Deleted'));
}