<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include necessary files
include_once '../../config/database.php';
include_once '../../models/Quote.php';

// Create database connection and quote object
$database = new Database();
$db = $database->connect();
$quote = new Quote($db);

// Retrieve all quotes from database and check row count
$result = $quote->read();
$num = $result->rowCount();

// Print quotes as JSON objects
if ($num > 0){
    $quotes_arr = array('data' => array());
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        // Extract variables from row for easier access
        extract($row);

        // Create quote item array and add to quotes array
        $quote_item = array('id' => $id, 'quote' => $quote, 'category' => $category, 'author' => $author);
        array_push($quotes_arr['data'], $quote_item);
    }
    echo json_encode($quotes_arr['data']);
} else {
    // If no quotes found, print error message
    echo json_encode(array('message'=> 'No Quotes Found'));
}