<?php

// установим HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение файлов
include_once "../config/core.php";
include_once "../shared/utilities.php";
include_once "../config/database.php";
include_once "../objects/article.php";

// utilities
$utilities = new Utilities();

// создание подключения
$database = new Database();
$db = $database->getConnection();

// инициализация объекта
$article = new Article($db);

// запрос товаров
$stmt = $article->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();

// если больше 0 записей
if ($num > 0) {

    // массив товаров
    $article_arr = array();
    $article_arr["records"] = array();
    $article_arr["paging"] = array();

    // получаем содержимое нашей таблицы
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        // извлечение строки
        extract($row);
        $product_item = array(
            "ID" => $ID,
            "Title" => $Title,
            "Tag" => $Tag,
            "CreateDate" => $CreateDate,
            "Text" => $Text,
            "Author" => $Author
        );
        array_push($article_arr["records"], $article_item);
    }

    // подключим пагинацию
    $total_rows = $article->count();
    $page_url = "{$home_url}article/read_paging.php?";
    $paging = $utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $article_arr["paging"] = $paging;

    // установим код ответа - 200 OK
    http_response_code(200);

    // вывод в json-формате
    echo json_encode($article_arr);
} else {

    // код ответа - 404 Ничего не найдено
    http_response_code(404);

    // сообщим пользователю, что товаров не существует
    echo json_encode(array("message" => "Страницы статей не найдены"), JSON_UNESCAPED_UNICODE);
}