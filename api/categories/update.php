<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Include necessary files
include_once '../../config/database.php';
include_once '../../models/Category.php';

// Create database object and connect to database
$database = new Database();
$db = $database->connect();

// Create category object
$category = new Category($db);

// Read all categories
$result = $category->read();

// Get number of rows returned
$num = $result->rowCount();

// If there are categories, create an array and loop through them
if ($num > 0){
    $categories_arr = array();
    $categories_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        // Create category item and add to array
        $category_item = array('id' => $id,'category' => $category);
        array_push($categories_arr['data'], $category_item);
    }
    // Output categories array as JSON
    echo json_encode($categories_arr['data']);
}
// If there are no categories, output an error message as JSON
else{
    echo json_encode(array('message'=> 'Missing Required Parameters'));
}