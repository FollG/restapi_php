<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";

include_once "../objects/article.php";
$database = new Database();
$db = $database->getConnection();
$article = new Article($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->Author) &&
    !empty($data->Tag) &&
    !empty($data->Title) &&
    !empty($data->Text) &&
    !empty($data->CreateDate)
) {

    $article->Author = $data->Author;
    $article->Tag= $data->Tag;
    $article->Title = $data->Title;
    $article->Text = $data->Text;
    $article->CreateDate= $data->CreateDate;


    if ($article->create()) {
        http_response_code(201);

        echo json_encode(array("message" => "Статья была создана."), JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(503);

        echo json_encode(array("message" => "Невозможно создать статью."), JSON_UNESCAPED_UNICODE);
    }
}

else {
    http_response_code(400);

    echo json_encode(array("message" => "Невозможно создать статью. Данные неполные."), JSON_UNESCAPED_UNICODE);
}