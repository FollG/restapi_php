<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once "../config/database.php";
include_once "../objects/tag.php";

$database = new Database();
$db = $database->getConnection();

$tag = new Tag($db);

$tag->ID = isset($_GET["id"]) ? $_GET["id"] : die();

$tag->readOne();

if ($tag->TagName != null) {

    $tag_arr = array(
        "ID" =>  $tag->ID,
        "TagName" => $tag->TagName,
    );

    http_response_code(200);

    echo json_encode($tag_arr);
} else {
    http_response_code(404);

    echo json_encode(array("message" => "Тэг не существует"), JSON_UNESCAPED_UNICODE);
}