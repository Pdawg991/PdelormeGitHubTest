<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$result = $quote->read();

$num = $result->rowCount();

if ($num > 0){
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
echo json_encode(array('message'=> 'No Posts Found'));
}
