<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$author = new Author($db);

$author->id = isset($_GET['id']) ? $_GET['id'] : die();
try{
$author->read_single();
    if (!isset($author->author) ||!isset($author->id)){
    throw new Exception();
}
else{
$author_arr = array('id'=> $author->id, 'author' => $author->author);
print_r(json_encode($author_arr));
}
}
catch (Exception $e){
    echo json_encode(array('message'=> 'author_id Not Found'));
}
