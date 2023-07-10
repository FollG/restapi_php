<?php

class Tag {

    private $conn;
    private $table_name = "Tags";
    public $ID;
    public $TagName;

    public function __construct($db) {
        $this->conn = $db;
    }

    function read()
    {
        $query = "SELECT ID, TagName FROM ".$this->table_name.";";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }

    function create()
    {   

        $query = "INSERT INTO ".$this->table_name." 
        SET
        TagName=:TagName";

        $stmt = $this->conn->prepare($query);

        $this->TagName = htmlspecialchars(strip_tags($this->TagName));

        $stmt->bindParam(":FirstName", $this->TagName);

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

    function readOne()
    {

        $query = "SELECT * FROM ".$this->table_name." WHERE ID = ?;";
            
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->ID);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->TagName = $row["TagName"];
    }

}