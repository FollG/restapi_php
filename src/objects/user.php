<?php

class User {

    private $conn;
    private $table_name = "users";

    public $ID;
    public $username;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    function read()
    {
        $query = "SELECT * FROM ".$this->table_name.";";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }

    function create()
    {   

        $query = "INSERT INTO
           " . $this->table_name . "
        SET
            username=:username, password=:password";

        $stmt = $this->conn->prepare($query);

        $this->username = strip_tags($this->username);
        $this->password = strip_tags($this->password);

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);

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

        $this->ID = $row["ID"];
        $this->username = $row["username"];
        $this->password = $row["password"];
    }
}