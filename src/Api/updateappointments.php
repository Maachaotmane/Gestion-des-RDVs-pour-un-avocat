<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-Width');

include_once '../Database/Database.php';
include_once '../Modele/RDV.php';

$database = new Database();
$db = $database->connect();

$upd = new RDV($db);
$data = json_decode(file_get_contents('php://input'));
$res = false;
print_r($data);
die('sdks');
