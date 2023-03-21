<?php
class Quote {
    private $conn;
    private $table = 'quotes'; 

    // Properties that correspond to the columns in the quotes table
    public $quote;
    public $id;
    public $author;
    public $category;
    public $author_id;
    public $category_id;

    // Constructor function that sets the database connection object
    public function __construct($db){
        $this->conn = $db;
    }

    // Reads all quotes from the database
    public function read(){
        // SQL query to select quotes and their corresponding author and category
        $query = 'SELECT q.id, q.quote, a.author as author, c.category as category 
        FROM ' . $this->table . ' q 
        LEFT JOIN authors a ON q.author_id = a.id 
        LEFT JOIN categories c ON q.category_id = c.id 
        ORDER BY quote';
        // Prepare the SQL query
        $stmt = $this->conn->prepare($query);
        // Execute the SQL query
        $stmt->execute();
        // Return the results of the SQL query
        return $stmt;
    }
// Returns all quotes from given id
public function read_single($idSet, $authorIdSet, $categoryIdSet){
    $query;
    $stmt;
    //If statement for each condition based on what id is set
    if($categoryIdSet && !$authorIdSet && !$idSet){
        $query = 'SELECT quotes.id, quotes.quote, categories.category, authors.author 
        FROM quotes 
        INNER JOIN categories ON quotes.category_id = categories.id 
        INNER JOIN authors ON quotes.author_id = authors.id 
        WHERE categories.id = :category_id ';
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
        ';
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
        ';
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
        ';
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
        ';
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
        ';
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
            AND categories.id = :category_id ';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":author_id", $this->author_id);
            $stmt->bindParam(":category_id", $this->category_id);
            $stmt->execute();   
    }
    return $stmt;
    }
// Creates a new Quote
public function create(){
    $query = 'INSERT INTO ' . $this->table . '(quote, author_id, category_id) VALUES(:quote, :author_id, :category_id)';
    $stmt = $this->conn->prepare($query);
    
    $this->quote = htmlspecialchars(strip_tags($this->quote));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->author_id = htmlspecialchars(strip_tags($this->author_id));

    $stmt->bindParam(':quote', $this->quote);
    $stmt->bindParam(':category_id', $this->category_id);
    $stmt->bindParam(':author_id', $this->author_id);
    if($stmt->execute()){
        return true;
    }
    printf("Error: %s. \n", $stmt->error);
    return false;
}
// Updates quote of ids given
public function update() {
    $query = 'UPDATE ' . $this->table . '
                SET quote = :quote, author_id = :author_id, category_id = :category_id 
                WHERE id = :id';
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    $stmt->bindParam(':quote', $this->quote, PDO::PARAM_STR);
    $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
    $stmt->bindParam(':author_id', $this->author_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        return true;
    }

    return false;
}
// Deletes quote from id given
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
// Gets id of quote
public function getId($quote){
    $query = 'SELECT id FROM ' . $this->table . '
    WHERE quote = :quote';
    $stmt = $this->conn->prepare($query);
    $stmt->bindparam(":quote", $quote);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->id = $row['id'];
}
// Checks if author exists
public function authorExists($authorId){
    $query = 'SELECT author_id FROM ' . $this->table . '
    WHERE author_id = :author_id';
    $stmt = $this->conn->prepare($query);
    $stmt->bindparam(":author_id", $authorId);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($row['author_id'])){
        return true;
        }
        else{
        return false;
        }
}
// Checks if category exists
public function categoryExists($categoryId){
    $query = 'SELECT category_id FROM ' . $this->table . '
    WHERE category_id = :category_id';
    $stmt = $this->conn->prepare($query);
    $stmt->bindparam(":category_id", $categoryId);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($row['category_id'])){
        return true;
        }
        else{
        return false;
        }
}
// Checks if id exists
public function idExists($idExists){
    $query = 'SELECT id FROM ' . $this->table . '
    WHERE id = :id';
    $stmt = $this->conn->prepare($query);
    $stmt->bindparam(":id", $idExists);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($row['id'])){
        return true;
        }
        else{
        return false;
        }
}
}