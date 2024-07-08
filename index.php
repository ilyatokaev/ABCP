<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
//header('Content-Type: text/html; charset=utf-8');


// Фейковые функции для имитации вашей среды
include_once __DIR__ . '/Fake_entities/fakes_functions.php';

require_once 'autoload.php';

$controller = new \Controllers\TsController();
$result = $controller->doOperation();

echo json_encode($result, JSON_UNESCAPED_UNICODE);
//var_dump($result);