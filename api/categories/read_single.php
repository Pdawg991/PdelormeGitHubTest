<?php
// Include necessary files
include_once '../../config/database.php';
include_once '../../models/Category.php';

// Create database object and connect to database
$database = new Database();
$db = $database->connect();

// Create category object
$category = new Category($db);

// Get category ID from URL parameter
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Try to read category with given ID
try{
    $category->read_single();

    // Check if category and ID are set, otherwise throw an exception
    if (!isset($category->category) ||!isset($category->id)){
        throw new Exception();
    }
    // If category and ID are set, create array with data and output as JSON
    else{
        $category_arr = array('id'=> $category->id, 'category' => $category->category);
        print_r(json_encode($category_arr));
    }
}
// If an exception is thrown, output an error message as JSON
catch (Exception $e){
    echo json_encode(array('message'=> 'category_id Not Found'));
}