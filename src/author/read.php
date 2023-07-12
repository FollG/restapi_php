<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once "../config/database.php";
include_once "../objects/author.php";

$database = new Database();
$db = $database->getConnection();

$author = new Author($db);
 
$stmt = $author->read(); 
$num = $stmt->rowCount();

if ($num > 0) {
    $authors_arr = array();
    $authors_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $authors_item = array(
            "ID" => $ID,
            "FirstName" => $FirstName,
            "LastName" => $LastName,
        );
        array_push($authors_arr["records"], $authors_item);
    }

    http_response_code(200);

   echo json_encode($authors_arr);
} else {
    http_response_code(404);

    echo json_encode(array("message" => "Авторы не найдены."), JSON_UNESCAPED_UNICODE);
}