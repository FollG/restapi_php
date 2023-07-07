<?php

class Article {

    private $conn;
    private $table_name = "Articles";

    public $ID;
    public $Author;
    public $CreateDate;
    public $Tag;
    public $Text;
    public $Title;

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

    // метод для создания товаров
    function create()
    {   
    // запрос для вставки (создания) записей
        $query = "INSERT INTO ".$this->table_name." 
        SET
        Author=:Author, Tag=:Tag, Title=:Title, Text=:Text, CreateDate=:CreateDate";

    // подготовка запроса
        $stmt = $this->conn->prepare($query);

    // очистка
        $this->Author = htmlspecialchars(strip_tags($this->Author));
        $this->Tag = htmlspecialchars(strip_tags($this->Tag));
        $this->Title = htmlspecialchars(strip_tags($this->Title));
        $this->Text = htmlspecialchars(strip_tags($this->Text));
        $this->CreateDate = htmlspecialchars(strip_tags($this->CreateDate));

    // привязка значений
        $stmt->bindParam(":Author", $this->Author);
        $stmt->bindParam(":Tag", $this->Tag);
        $stmt->bindParam(":Title", $this->Title);
        $stmt->bindParam(":Text", $this->Text);
        $stmt->bindParam(":CreateDate", $this->CreateDate);

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

    // метод для поиска товаров
    function search($keyword)
    {
    // поиск записей 
        $query = "SELECT * FROM Articles WHERE ID = ?;";

    // подготовка запроса
        $stmt = $this->conn->prepare($query);

    // очистка
        $keywords = htmlspecialchars(strip_tags($keyword));
        $keywords = "%{$keywords}%";

    // привязка
        $stmt->bindParam(1, $keyword);

    // выполняем запрос
        $stmt->execute();

        return $stmt;
    }
    // получение товаров с пагинацией

    // TODO здесь тоже заменить запрос
    public function readPaging($from_record_num, $records_per_page)
    {
        // выборка
        $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY p.created DESC
            LIMIT ?, ?";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // свяжем значения переменных
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        // выполняем запрос
        $stmt->execute();

        // вернём значения из базы данных
        return $stmt;
}

// данный метод возвращает кол-во товаров
public function count()
{
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row["total_rows"];
}
}