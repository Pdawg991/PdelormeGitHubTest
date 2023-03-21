<?php
class Category {

private $conn;
private $table = 'categories';

// Object properties
public $category;
public $id;

// Constructor with database connection
public function __construct($db){
    $this->conn = $db;
}

// Read all categories
public function read(){
    $query = 'SELECT id, category FROM ' . $this->table . ' ORDER BY category';
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}

// Read single category
public function read_single(){
    $query = 'SELECT id, category FROM ' . $this->table . ' 
    WHERE id= ? 
    OFFSET 0
    LIMIT 1';
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    try{
        if(!isset($row['category'])){
            throw new Exception();
        }
        else{
        $this->category = $row['category'];
        }
    }
    catch (Exception $e){

    }
}

// Create new category
public function create(){
    $query = 'INSERT INTO ' . $this->table . '(category) VALUES(:category)';
    $stmt = $this->conn->prepare($query);

    $this->category = htmlspecialchars(strip_tags($this->category));
    $stmt->bindParam(':category', $this->category);
    if($stmt->execute()){
        return true;
    }
    printf("Error: %s. \n", $stmt->error);
    return false;
}

public function update(){
    // SQL query to update category in the database
    $query = 'UPDATE ' . $this->table . '
    SET category = :category
    WHERE id = :id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Sanitize data and bind parameters
    $this->category = htmlspecialchars(strip_tags($this->category));
    $this->id = htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':category', $this->category);

    // Execute the query
    if($stmt->execute()){
        return true;
    }
    return false;
}

public function delete(){
    // SQL query to delete a category from the database
    $query = 'DELETE FROM ' . $this->table . '
    WHERE id = :id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Sanitize data and bind parameters
    $this->id = htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(':id', $this->id);

    // Execute the query
    if($stmt->execute()){
        return true;
    }
    printf("Error: %s. \n", $stmt->error);
    return false;
}

public function getId($category){
    // SQL query to get category ID from the database
    $query = 'SELECT id FROM ' . $this->table . '
    WHERE category = :category';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind parameter
    $stmt->bindparam(":category", $category);

    // Execute the query
    if (!$stmt->execute()) {
        return false;
    }

    // Get the result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // If the category doesn't exist, return false
    if (!$row) {
        return false;
    }

    // Set the category ID and return it
    $this->id = $row['id'];
    return $this->id;
}
}