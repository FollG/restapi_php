<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

// подключение базы данных и файл, содержащий объекты
include_once "../config/database.php";
include_once "../objects/author.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$author = new Author($db);
 
$stmt = $author->read(); //read
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей
if ($num > 0) {
    // массив авторов
    $authors_arr = array();
    $authors_arr["records"] = array();

    // получаем содержимое нашей таблицы
    // fetch() быстрее, чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // извлекаем строку
        extract($row);
        $authors_item = array(
            "ID" => $ID,
            "FirstName" => $FirstName,
            "LastName" => $LastName,
        );
        array_push($authors_arr["records"], $authors_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные о товаре в формате JSON
    echo json_encode($authors_arr);
} else {
    // установим код ответа - 404 Не найдено
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены
    echo json_encode(array("message" => "Авторы не найдены."), JSON_UNESCAPED_UNICODE);
}