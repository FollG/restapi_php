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
    // выбираем все записи
        $query = "SELECT * FROM ".$this->table_name.";";

    // подготовка запроса
        $stmt = $this->conn->prepare($query);

    // выполняем запрос
        $stmt->execute();
        return $stmt;
    }

    // метод для создания 
    function create()
    {   
    // запрос для вставки (создания) записей
        $query = "INSERT INTO
           " . $this->table_name . "
        SET
            username=:username, password=:password";

    // подготовка запроса
        $stmt = $this->conn->prepare($query);

    // очистка
        $this->username = strip_tags($this->username);
        $this->password = strip_tags($this->password);

    // привязка значений
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);

    // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function delete()
    {
    // запрос для удаления записи 
        $query = "DELETE FROM ".$this->table_name." WHERE id = ?";

    // подготовка запроса
        $stmt = $this->conn->prepare($query);

    // очистка
        $this->ID = htmlspecialchars(strip_tags($this->ID));

    // привязываем id записи для удаления
        $stmt->bindParam(1, $this->ID);

    // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function readOne()
    {
    // запрос для чтения одной записи (товара)
        $query = "SELECT * FROM ".$this->table_name." WHERE ID = ?;";
            
        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // привязываем id товара, который будет получен
        $stmt->bindParam(1, $this->ID);

        // выполняем запрос
        $stmt->execute();

        // получаем извлеченную строку
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // установим значения свойств объекта
        $this->ID = $row["ID"];
        $this->username = $row["username"];
        $this->password = $row["password"];
    }
}