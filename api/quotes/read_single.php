<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$quote->id = isset($_GET['id']) ? $_GET['id'] : die();
//$quote->authorId = isset($_GET['authorId']) ? $_GET['authorId'] : die();
//$quote->categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : die();

$quote->read_single();
$quote_arr = array(
'id'=> $quote->id, 
'quote' => $quote->quote, 
'author_id' => $quote->authorId,
'category_id' => $quote->categoryId
);

print_r(json_encode($quote_arr));