<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: applecation/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-Width');

include_once '../../database/Database.php';
include_once '../../Modele/Client.php';

$database   =   new Database();
$db         =   $database->connect();

$client = new Client($db);
$client->Reference = isset($_GET['Reference']) ? $_GET['Reference'] : die();

