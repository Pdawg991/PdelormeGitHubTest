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

// Set boolean variables based on query parameters
$idSet = false;
$categoryIdSet = false;
$authorIdSet = false;

if(isset($_GET['id'])){
    $idSet = true;
    $quote->id = $_GET['id'];
}

if(isset($_GET['author_id'])){
    $authorIdSet = true;
    $quote->author_id = $_GET['author_id'];
}

if(isset($_GET['category_id'])){
    $categoryIdSet = true;
    $quote->category_id = $_GET['category_id'];
}

// Retrieve quotes from database and check row count
$result = $quote->read_single($idSet, $authorIdSet, $categoryIdSet);
$num = $result->rowCount();

// Print quotes as JSON objects
if ($num == 1){
    echo json_encode($result->fetch(PDO::FETCH_ASSOC), JSON_FORCE_OBJECT);
} else if ($num > 1){
    $quotes_arr = array('data' => array());
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $quote_item = array('id' => $row['id'], 'quote' => $row['quote'], 'category' => $row['category'], 'author' => $row['author']);
        array_push($quotes_arr['data'], $quote_item);
    }
    echo json_encode($quotes_arr['data']);
} else{
    echo json_encode(array('message'=> 'No Quotes Found'));
}