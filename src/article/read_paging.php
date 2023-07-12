<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/core.php";
include_once "../shared/utilities.php";
include_once "../config/database.php";
include_once "../objects/article.php";

$utilities = new Utilities();

$database = new Database();
$db = $database->getConnection();

$article = new Article($db);

$stmt = $article->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();

if ($num > 0) {

    $article_arr = array();
    $article_arr["records"] = array();
    $article_arr["paging"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

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

    $total_rows = $article->count();
    $page_url = "{$home_url}article/read_paging.php?";
    $paging = $utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $article_arr["paging"] = $paging;

    http_response_code(200);

    echo json_encode($article_arr);
} else {
    http_response_code(404);

    echo json_encode(array("message" => "Страницы статей не найдены"), JSON_UNESCAPED_UNICODE);
}