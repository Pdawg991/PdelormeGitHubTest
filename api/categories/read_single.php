<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$category->id = isset($_GET['id']) ? $_GET['id'] : die();


try{
    $category->read_single();
        if (!isset($category->category) ||!isset($category->id)){
        throw new Exception();
    }
    else{
    $category_arr = array('id'=> $category->id, 'category' => $category->category);
    print_r(json_encode($category_arr));
    }
    }
    catch (Exception $e){
        echo json_encode(array('message'=> 'category_id Not Found'));
    }