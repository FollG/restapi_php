<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";

include_once "../objects/author.php";
$database = new Database();
$db = $database->getConnection();
$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->FirstName) &&
    !empty($data->LastName) 
) {
    $author->FirstName = $data->FirstName;
    $author->LastName = $data->LastName;


    if ($author->create()) {
        http_response_code(201);

        echo json_encode(array("message" => "Товар был создан."), JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(503);

        echo json_encode(array("message" => "Невозможно создать товар."), JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(400);

    // сообщим пользователю
    echo json_encode(array("message" => "Невозможно создать товар. Данные неполные."), JSON_UNESCAPED_UNICODE);
}