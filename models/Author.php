<?php
Class Author {
    private $conn;
    private $table = 'authors';

    public $author;
    public $id;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read(){
        $query = 'SELECT id, author FROM ' . $this->table . ' ORDER BY author';
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
    }

public function read_single(){
    $query = 'SELECT id, author FROM ' . $this->table . ' 
    WHERE id= ? 
    OFFSET 0
    LIMIT 1';
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    try{
    if(!isset($row['author'])){
        throw new Exception();
    }
    else{
    $this->author = $row['author'];
    }
    }
    catch (Exception $e){

    }
}
public function create(){
    $query = 'INSERT INTO ' . $this->table . '(author) VALUES(:author)';
        $stmt = $this->conn->prepare($query);

        $this->author = htmlspecialchars(strip_tags($this->author));

        $stmt->bindParam(':author', $this->author);
        if($stmt->execute()){
            return true;
        }
        printf("Error: %s. \n", $stmt->error);
        return false;
    }

public function update(){

    $query = 'UPDATE ' . $this->table . '
    SET author = :author
    WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':author', $this->author);
        if(empty($this->id) || empty($this->author)){
            return false;
        }
        if($stmt->execute()){
            return true;
        }
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

public function getId($author){
    $query = 'SELECT id FROM ' . $this->table . '
    WHERE author = :author';
    $stmt = $this->conn->prepare($query);
    $stmt->bindparam(":author", $author);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->id = $row['id'];
}
}