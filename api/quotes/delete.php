<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Include necessary files
include_once '../../config/database.php';
include_once '../../models/Quote.php';

// Instantiate Database object and establish connection to database
$database = new Database();
$db = $database->connect();

// Instantiate Quote object
$delete = new Quote($db);

// Get data from request payload
$data = json_decode(file_get_contents("php://input"));

// Check if quote with specified ID exists
if (!$delete->idExists($data->id)) {
    echo json_encode(array('message' => 'No Quotes Found'));
} 
// If quote with specified ID exists, delete the quote
else if ($delete->idExists($data->id)) {
    $delete->id = $data->id;
    $delete->delete();
    echo json_encode(array('id'=> $delete->id));
} 
// If quote was not deleted for some reason, return an error message
else {
    echo json_encode(array('message' => 'Post Not Deleted'));
}