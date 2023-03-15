<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$result = $category->read();

$num = $result->rowCount();

if ($num > 0){
$categories_arr = array();
$categories_arr['data'] = array();

while($row = $result->fetch(PDO::FETCH_ASSOC)){
extract($row);

$category_item = array('category' => $category);

array_push($categories_arr['data'], $category_item);

}
echo json_encode($categories_arr['data']);
}
else{
echo json_encode(array('message'=> 'No Posts Found'));
}
