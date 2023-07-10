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
    $query = "SELECT * FROM ".$this->table_name.";";

    $stmt = $this->conn->prepare($query);

    $stmt->execute();
        return $stmt;
    }

    function create()
    {   
        $query = "INSERT INTO ".$this->table_name." 
        SET
        Author=:Author, Tag=:Tag, Title=:Title, Text=:Text, CreateDate=:CreateDate";

        $stmt = $this->conn->prepare($query);

        $this->Author = htmlspecialchars(strip_tags($this->Author));
        $this->Tag = htmlspecialchars(strip_tags($this->Tag));
        $this->Title = htmlspecialchars(strip_tags($this->Title));
        $this->Text = htmlspecialchars(strip_tags($this->Text));
        $this->CreateDate = htmlspecialchars(strip_tags($this->CreateDate));

        $stmt->bindParam(":Author", $this->Author);
        $stmt->bindParam(":Tag", $this->Tag);
        $stmt->bindParam(":Title", $this->Title);
        $stmt->bindParam(":Text", $this->Text);
        $stmt->bindParam(":CreateDate", $this->CreateDate);

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

    function search($keyword)
    {
        $query = "SELECT * FROM Articles WHERE ID = ?;";

        $stmt = $this->conn->prepare($query);

        $keywords = htmlspecialchars(strip_tags($keyword));
        $keywords = "%{$keywords}%";

        $stmt->bindParam(1, $keyword);

        $stmt->execute();

        return $stmt;
    }

    public function readPaging($from_record_num, $records_per_page)
    {
        // выборка
        $query = "SELECT * FROM Article";

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