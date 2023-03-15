<?php
Class Quote {
    private $conn;
    private $table = 'quotes';

    public $quote;
    public $authorId;
    public $categoryId;
    public $id;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read(){
        $query = 'SELECT quote FROM ' . $this->table . ' ORDER BY quote';
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
    }

public function read_single(){
    $query = 'SELECT id, quote, author_id, category_id FROM ' . $this->table . ' 
    WHERE id = :id
    OFFSET 0
    LIMIT 1';
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":id", $this->id);
    //$stmt->bindParam(":author_id", $this->authorId);
    //$stmt->bindParam(":category_id", $this->categoryId);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->id = $row['id'];
    $this->quote = $row['quote'];
    $this->authorId = $row['author_id'];
    $this->categoryId = $row['category_id'];
}

public function create(){
    $query = 'INSERT INTO ' . $this->table . '(quote) VALUES(:quote)';
        $stmt = $this->conn->prepare($query);

        $this->quote = htmlspecialchars(strip_tags($this->quote));

        $stmt->bindParam(':quote', $this->quote);

        if($stmt->execute()){
            return true;
        }
        printf("Error: %s. \n", $stmt->error);
        return false;
    }

public function update(){
    $query = 'UPDATE ' . $this->table . '
    SET quote = :quote
    WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':quote', $this->quote);
        
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