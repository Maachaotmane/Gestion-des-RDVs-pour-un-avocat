<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-Width');

include_once '../Database/Database.php';
include_once '../Modele/RDV.php';

$database = new Database();
$db = $database->connect();

$appoi = new RDV($db);
$data = json_decode(file_get_contents('php://input'));
$res = false;
$appoi->login_number = $data->login_number;
$appoi->subject = $data->subject;
$appoi->times = $data->times;

    if ($appoi->insertrdv()) {
        echo json_encode(
                ['message' => 'Creation du RDV passe avec succes !!!', 'login_number' => $appoi->login_number, 'res' => true]
            );
    } else {
        echo json_encode(
                ['message' => 'Try Again !!', 'res' => false]
            );
    }
