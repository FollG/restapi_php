<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";

include_once "../objects/user.php";

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->username) &&
    !empty($data->password) 
) {
    $user->username = $data->username;
    $user->password= $data->password;

    if ($user->create()) {

        http_response_code(201);

        echo json_encode(array("message" => "Пользователь был создан."), JSON_UNESCAPED_UNICODE);
    } else {

        http_response_code(503);

        echo json_encode(array("message" => "Невозможно создать пользователя."), JSON_UNESCAPED_UNICODE);
    }
} else {

    http_response_code(400);

    echo json_encode(array("message" => "Невозможно создать пользовтеля. Данные неполные."), JSON_UNESCAPED_UNICODE);
}