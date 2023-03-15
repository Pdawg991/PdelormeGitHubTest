<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$author = new Author($db);

$result = $author->read();

$num = $result->rowCount();

if ($num > 0){
$authors_arr = array();
$authors_arr['data'] = array();

while($row = $result->fetch(PDO::FETCH_ASSOC)){
extract($row);

$author_item = array('author' => $author);

array_push($authors_arr['data'], $author_item);

}
echo json_encode($authors_arr['data']);
}
else{
echo json_encode(array('message'=> 'No Posts Found'));
}
