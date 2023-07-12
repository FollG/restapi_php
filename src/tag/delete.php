<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";
include_once "../objects/tag.php";

$database = new Database();
$db = $database->getConnection();

$tag = new Tag($db);

$data = json_decode(file_get_contents("php://input"));

$tag->ID = $data->ID;

if ($tag->delete()) {
    http_response_code(200);

    echo json_encode(array("message" => "Тэг был удален"), JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(503);

    echo json_encode(array("message" => "Не удалось удалить тэг"));
}