<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, quoteization, X-Requested-With');

// Include necessary files
include_once '../../config/database.php';
include_once '../../models/Quote.php';

// Create database connection and Quote object
$database = new Database();
$db = $database->connect();
$put = new Quote($db);

// Decode the JSON input
$data = json_decode(file_get_contents("php://input"));

// Check if required fields are present and if they exist in the database
if(!isset($data->author_id)|| !isset($data->category_id) || !isset($data->quote)){
    echo json_encode(array('message' => 'Missing Required Parameters'));
} else if(!$put->authorExists($data->author_id)){
    echo json_encode(array('message' => 'author_id Not Found'));
} else if(!$put->categoryExists($data->category_id)){
    echo json_encode(array('message' => 'category_id Not Found'));
} else if(!$put->idExists($data->id)){
    echo json_encode(array('message' => 'No Quotes Found'));
} else if (isset($data->author_id) && isset($data->category_id) && isset($data->quote)){
    // Update the specified quote if all required fields are present and exist
    $put->id = $data->id;
    $put->quote = $data->quote;
    $put->category_id = $data->category_id;
    $put->author_id = $data->author_id;
    if ($put->update()){
        echo json_encode(array('id'=> $put->id,  'quote' => $put->quote, 'category_id' => $put->category_id,  'author_id' => $put->author_id));
    }
} 
else {
    // If no fields are present or don't exist, print error message
    echo json_encode(array('message' => 'Missing Required Parameters')); 
}