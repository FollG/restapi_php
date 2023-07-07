<?php

// показывать сообщения об ошибках
ini_set("display_errors", 1);
error_reporting(E_ALL);

// URL домашней страницы
$home_url = "http://blog/src";

// страница указана в параметре URL, страница по умолчанию одна
$page = isset($_GET["page"]) ? $_GET["page"] : 1;

// TODO установка количества записей на странице
$records_per_page = 5; // установка количества записей на странице
// установка количества записей на странице

// расчёт для запроса предела записей
$from_record_num = ($records_per_page * $page) - $records_per_page;