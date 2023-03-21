<?php
class Author {
    private $conn; // database connection
    private $table = 'authors'; // table name

    public $author; // author name
    public $id; // author id

    // constructor that sets the database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // method to read all authors from the database
    public function read(){
        $query = 'SELECT id, author FROM ' . $this->table . ' ORDER BY author';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // method to read a single author from the database by id
    public function read_single(){
        $query = 'SELECT id, author FROM ' . $this->table . ' 
        WHERE id= ? 
        OFFSET 0
        LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        // get the author's name from the result and set it to the object property
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

    // method to create a new author in the database
    public function create(){
        $query = 'INSERT INTO ' . $this->table . '(author) VALUES(:author)';
        $stmt = $this->conn->prepare($query);

        // sanitize the author's name and bind it to the prepared statement
        $this->author = htmlspecialchars(strip_tags($this->author));
        $stmt->bindParam(':author', $this->author);

        // execute the query and return true if successful, otherwise return false
        if($stmt->execute()){
            return true;
        }
        printf("Error: %s. \n", $stmt->error);
        return false;
    }

    // method to update an author in the database by id
    public function update(){

        $query = 'UPDATE ' . $this->table . '
        SET author = :author
        WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        // sanitize the author's name and id and bind them to the prepared statement
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':author', $this->author);

        // execute the query and return true if successful, otherwise return false
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // method to delete an author from the database by id
    public function delete(){

        $query = 'DELETE FROM ' . $this->table . '
        WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        // sanitize the id and bind it to the prepared statement
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        // execute the query and return true if successful, otherwise return false
        if($stmt->execute()){
            return true;
        }
        printf("Error: %s. \n", $stmt->error);
        return false;
    }
    // method to get the ID when given the author
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