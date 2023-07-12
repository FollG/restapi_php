<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once "../config/database.php";
include_once "../objects/user.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
 
$stmt = $user->read(); 
$num = $stmt->rowCount();

if ($num > 0) {
    $user_arr = array();
    $user_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $user_item = array(
            "ID" => $ID,
            "username" => $username,
            "password" => $password,
        );
        array_push($user_arr["records"], $user_item);
    }

    http_response_code(200);

    echo json_encode($user_arr);
} else {
    http_response_code(404);

    echo json_encode(array("message" => "Пользователи не найдены."), JSON_UNESCAPED_UNICODE);
}