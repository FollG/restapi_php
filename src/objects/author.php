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
    // выбираем все записи
    $query = "SELECT ID, FirstName, LastName FROM ".$this->table_name.";";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // выполняем запрос
    $stmt->execute();
    return $stmt;
    }

    // метод для создания товаров
    function create()
    {   
    // запрос для вставки (создания) записей
        $query = "INSERT INTO ".$this->table_name." 
        SET
        FirstName=:FirstName, LastName=:LastName";

    // подготовка запроса
        $stmt = $this->conn->prepare($query);

    // очистка
        $this->FirstName = htmlspecialchars(strip_tags($this->FirstName));
        $this->LastName = htmlspecialchars(strip_tags($this->LastName));

    // привязка значений
        $stmt->bindParam(":FirstName", $this->FirstName);
        $stmt->bindParam(":LastName", $this->LastName);

    // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function delete()
    {
    // запрос для удаления записи (товара)
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
}