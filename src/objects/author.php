<?php

class Author {

    private $conn;
    private $table_name = "Authors";

    public $ID;
    public $FirstName;
    public $LastName;

    public function __construct($db) 
    {
        $this->conn = $db;
    }

    function read()
    {
    $query = "SELECT ID, FirstName, LastName FROM ".$this->table_name.";";

    $stmt = $this->conn->prepare($query);

    $stmt->execute();
    return $stmt;
    }

    function create()
    {   
        $query = "INSERT INTO ".$this->table_name." 
        SET
        FirstName=:FirstName, LastName=:LastName";

        $stmt = $this->conn->prepare($query);

        $this->FirstName = htmlspecialchars(strip_tags($this->FirstName));
        $this->LastName = htmlspecialchars(strip_tags($this->LastName));

        $stmt->bindParam(":FirstName", $this->FirstName);
        $stmt->bindParam(":LastName", $this->LastName);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function delete()
    {
        $query = "DELETE FROM ".$this->table_name." WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $this->ID = htmlspecialchars(strip_tags($this->ID));

        $stmt->bindParam(1, $this->ID);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}