<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once "../config/database.php";
include_once "../objects/tag.php";

$database = new Database();
$db = $database->getConnection();

$tag = new Tag($db);
 
$stmt = $tag->read(); 
$num = $stmt->rowCount();

if ($num > 0) {
    $tag_arr = array();
    $tag_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $tag_item = array(
            "ID" => $ID,
            "TagName" => $TagName,
        );
        array_push($tag_arr["records"], $tag_item);
    }

    http_response_code(200);

    echo json_encode($tag_arr);
} else {
    http_response_code(404);

    echo json_encode(array("message" => "Тэги не найдены."), JSON_UNESCAPED_UNICODE);
}