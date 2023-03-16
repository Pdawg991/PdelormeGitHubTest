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

    $result = $quote->read_single($idSet, $authorIdSet, $categoryIdSet);
    $num = $result->rowCount();

if ($num == 1){
    echo json_encode($result->fetch(PDO::FETCH_ASSOC), JSON_FORCE_OBJECT);
}
else if ($num > 1){
$quotes_arr = array();
$quotes_arr['data'] = array();

while($row = $result->fetch(PDO::FETCH_ASSOC)){
extract($row);

$quote_item = array('id' => $id, 'quote' => $quote, 'category' => $category, 'author' => $author);
array_push($quotes_arr['data'], $quote_item);
}
echo json_encode($quotes_arr['data']);
}
else{
echo json_encode(array('message'=> 'No Quotes Found'));
}


/*
    if ((!isset($quote->id)) ||!isset($quote->author)||!isset($quote->category))
        {
        throw new Exception();
        }
    else {
    $quote_arr = array('id'=> $quote->id, 'quote' => $quote->quote, 'author' => $quote->author, 'category' => $quote->category);
    echo json_encode($quote_arr);
    }
}
    catch (Exception $e){
        echo json_encode(array('message'=> 'No Quotes Found'));
    }
*/