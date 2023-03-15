<?php
Class Quote {
    private $conn;
    private $table = 'quotes';

    public $quote;
    public $id;
    public $author;
    public $category;
    public $author_id;
    public $category_id;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read(){
    $query = 'SELECT q.id, q.quote, a.author as author, c.category as category 
    FROM ' . $this->table . ' q 
    LEFT JOIN authors a ON q.author_id = a.id 
    LEFT JOIN categories c ON q.category_id = c.id 
    ORDER BY quote';
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
    }

public function read_single($idSet, $authorIdSet, $categoryIdSet){
    $query;
    $stmt;
    if($categoryIdSet && !$authorIdSet && !$idSet){
        $query = 'SELECT quotes.id, quotes.quote, categories.category, authors.author 
        FROM quotes 
        INNER JOIN categories ON quotes.category_id = categories.id 
        INNER JOIN authors ON quotes.author_id = authors.id 
        WHERE categories.id = :category_id 
        OFFSET 0 LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->execute();
    }
    
    if($authorIdSet && !$categoryIdSet && !$idSet){
        $query = 'SELECT quotes.id, quotes.quote, categories.category, authors.author 
        FROM quotes 
        INNER JOIN authors ON quotes.author_id = authors.id 
        INNER JOIN categories ON quotes.category_id = categories.id 
        WHERE authors.id = :author_id 
        OFFSET 0 LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":author_id", $this->author_id);
        $stmt->execute();
    }
    
    if($idSet && !$categoryIdSet && !$authorIdSet){
        $query = 'SELECT quotes.id, quotes.quote, categories.category, authors.author 
        FROM quotes 
        INNER JOIN categories ON quotes.category_id = categories.id 
        INNER JOIN authors ON quotes.author_id = authors.id 
        WHERE quotes.id = :id 
        OFFSET 0 LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
    }
    
    if($categoryIdSet && $authorIdSet && !$idSet){
        $query = 'SELECT quotes.id, quotes.quote, categories.category, authors.author 
        FROM quotes 
        INNER JOIN authors ON quotes.author_id = authors.id 
        INNER JOIN categories ON quotes.category_id = categories.id 
        WHERE authors.id = :author_id AND categories.id = :category_id 
        OFFSET 0 LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":author_id", $this->author_id);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->execute();
    }
    
    if($categoryIdSet && !$authorIdSet && $idSet){
        $query = 'SELECT quotes.id, quotes.quote, categories.category, authors.author 
        FROM quotes 
        INNER JOIN categories ON quotes.category_id = categories.id 
        INNER JOIN authors ON quotes.author_id = authors.id 
        WHERE quotes.id = :id AND categories.id = :category_id 
        OFFSET 0 LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->execute();
    }
    
    if(!$categoryIdSet && $authorIdSet && $idSet){
        $query = 'SELECT quotes.id, quotes.quote, categories.category, authors.author 
        FROM quotes 
        INNER JOIN authors ON quotes.author_id = authors.id 
        INNER JOIN categories ON quotes.category_id = categories.id 
        WHERE quotes.id = :id AND authors.id = :author_id 
        OFFSET 0 LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":author_id", $this->author_id);
        $stmt->execute();
    }
    
    if($categoryIdSet && $authorIdSet && $idSet){
        $query = 'SELECT quotes.id, quotes.quote, categories.category, authors.author 
            FROM quotes 
            INNER JOIN authors ON quotes.author_id = authors.id 
            INNER JOIN categories ON quotes.category_id = categories.id 
            WHERE quotes.id = :id AND authors.id = :author_id 
            AND categories.id = :category_id OFFSET 0 LIMIT 1';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":author_id", $this->author_id);
            $stmt->bindParam(":category_id", $this->category_id);
            $stmt->execute();   
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    try{
    if(!isset($row['quote'])){
        throw new Exception();
    }
    else{
    $this->quote = $row['quote'];
    $this->category = $row['category'];
    $this->author = $row['author'];
    $this->id = $row['id'];
    }
    }
    catch (Exception $e){

    }
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

public function getId($quote){
    $query = 'SELECT id FROM ' . $this->table . '
    WHERE quote = :quote';
    $stmt = $this->conn->prepare($query);
    $stmt->bindparam(":quote", $quote);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->id = $row['id'];
}


}