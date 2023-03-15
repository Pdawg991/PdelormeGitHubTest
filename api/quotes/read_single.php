<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/quote.php';

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


//try{
$quote->read_single($idSet, $authorIdSet, $categoryIdSet);
    //if (!isset($quote->quote) ||!isset($quote->id)){
    //throw new Exception();
//}
//else{
    //PRINT THE VARS RETUIRNED
$quote_arr = array('id'=> $quote->id, 'quote' => $quote->quote, 'author' => $quote->author, 'category' => $quote->category);

print_r(json_encode($quote_arr));
//}

//}
//catch (Exception $e){
  //  echo json_encode(array('message'=> 'quote_id Not Found'));
//}
