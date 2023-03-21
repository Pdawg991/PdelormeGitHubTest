<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include necessary files and initialize objects
include_once '../../config/database.php';
include_once '../../models/Author.php';
$database = new Database();
$db = $database->connect();
$author = new Author($db);

// Get the author ID from the request URL or exit if it's not provided
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

try{
    // Read the author data and check if both author and id are set
    $author->read_single();
    if (!isset($author->author) ||!isset($author->id)){
        // If author or id is not set, throw an exception
        throw new Exception();
    }
    else{
        // If author and id are both set, return them in a JSON object
        $author_arr = array('id'=> $author->id, 'author' => $author->author);
        print_r(json_encode($author_arr));
    }
}
catch (Exception $e){
    // If an exception is thrown, return a JSON error message
    echo json_encode(array('message'=> 'author_id Not Found'));
}