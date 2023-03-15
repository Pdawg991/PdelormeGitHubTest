<?php
Class Category {
    private $conn;
    private $table = 'categories';

    public $category;
    public $id;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read(){
        $query = 'SELECT id, category FROM ' . $this->table . ' ORDER BY category';
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
    }

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
    $query = 'UPDATE ' . $this->table . '
    SET category = :category
    WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':category', $this->category);
        
        if($stmt->execute()){
            return true;
        }
        printf("Error: %s. \n", $stmt->error);
        return false;
}

public function delete(){
$query = 'DELETE FROM ' . $this->table . '
WHERE id = :id';

$stmt = $this->conn->prepare($query);

$this->id = htmlspecialchars(strip_tags($this->id));
$stmt->bindParam(':id', $this->id);

if($stmt->execute()){
    return true;
}
printf("Error: %s. \n", $stmt->error);
return false;
}
}