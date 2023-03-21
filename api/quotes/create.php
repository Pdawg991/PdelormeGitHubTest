<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, quoteization, X-Requested-With');

// Include necessary files
include_once '../../config/database.php';
include_once '../../models/Quote.php';

// Create database object and connect to database
$database = new Database();
$db = $database->connect();

// Create quote object
$post = new Quote($db);

// Get data from HTTP request body as JSON and decode it
$data = json_decode(file_get_contents("php://input"));

// Check if all required parameters are present, if not, output an error message as JSON
if(!isset($data->author_id)|| !isset($data->category_id) || !isset($data->quote)){
    echo json_encode(array('message' => 'Missing Required Parameters'));
}
// Check if author with given ID exists, if not, output an error message as JSON
else if(!$post->authorExists($data->author_id)){
    echo json_encode(array('message' => 'author_id Not Found'));
}
// Check if category with given ID exists, if not, output an error message as JSON
else if(!$post->categoryExists($data->category_id)){
    echo json_encode(array('message' => 'category_id Not Found'));
}
// If all required parameters are present and author/category exist, create new quote
else if(isset($data->author_id) && isset($data->category_id) && isset($data->quote)){
    $post->quote = $data->quote;
    $post->category_id = $data->category_id;
    $post->author_id = $data->author_id;
    if ($post->create()){
        // If quote is created successfully, output created data as JSON
        $post->getID($post->quote);
        $arr = array('id' => $post->id, 'quote'=> $post->quote, 'author_id' => $post->author_id, 'category_id' => $post->category_id);
        echo json_encode($arr);
    }
}
// If none of the above conditions are met, output an error message as JSON
else
{
    echo json_encode(array('message' => 'Missing Required Parameters')); 
}