<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once "../config/database.php";
include_once "../objects/user.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->ID = isset($_GET["id"]) ? $_GET["id"] : die();

$user->readOne();

if ($user->username != null) {

    $user_arr = array(
        "ID" =>  $tag->ID,
        "username" => $user->username,
        "password" => $user->password,
    );

    http_response_code(200);

    echo json_encode($user_arr);
} else {

    http_response_code(404);

    echo json_encode(array("message" => "user не существует"), JSON_UNESCAPED_UNICODE);
}