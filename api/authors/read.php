<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include necessary files and initialize objects
include_once '../../config/database.php';
include_once '../../models/Author.php';
$database = new Database();
$db = $database->connect();
$author = new Author($db);

// Read all authors from the database and count the number of rows
$result = $author->read();
$num = $result->rowCount();

// If there are authors in the database, create an array of author data
if ($num > 0){
    $authors_arr = array();
    $authors_arr['data'] = array();

    // Loop through each author and add their data to the array
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $author_item = array('id' => $id, 'author' => $author);
        array_push($authors_arr['data'], $author_item);
    }

    // Return the array of author data in JSON format
    echo json_encode($authors_arr['data']);
}
else{
    // If there are no authors in the database, return a JSON error message
    echo json_encode(array('message'=> 'No Posts Found'));
}