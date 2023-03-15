<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);
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

$quote->read_single($idSet, $authorIdSet, $categoryIdSet);
$quote_arr = array('id'=> $quote->id, 'quote' => $quote->quote, 'author' => $quote->author, 'category' => $quote->category);
echo json_encode($quote_arr);