<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once "../config/database.php";
include_once "../objects/article.php";

$database = new Database();
$db = $database->getConnection();

$article = new Article($db);
 
$stmt = $article->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $article_arr = array();
    $article_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $article_item = array(
            "ID" => $ID,
            "Author" => $Author,
            "Tag" => $Tag,
            "Title" => $Title,
            "Text" => $Text,
            "CreateDate" => $CreateDate,
        );
        array_push($article_arr["records"], $article_item);
    }

    http_response_code(200);

    echo json_encode($article_arr);
} else {
    http_response_code(404);

    echo json_encode(array("message" => "Статьи не найдены."), JSON_UNESCAPED_UNICODE);
}