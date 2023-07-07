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
    // выбираем все записи
        $query = "SELECT ID, TagName FROM ".$this->table_name.";";

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
        TagName=:TagName";

    // подготовка запроса
        $stmt = $this->conn->prepare($query);

    // очистка
        $this->TagName = htmlspecialchars(strip_tags($this->TagName));

    // привязка значений
        $stmt->bindParam(":FirstName", $this->TagName);

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
        $this->TagName = $row["TagName"];
    }

}