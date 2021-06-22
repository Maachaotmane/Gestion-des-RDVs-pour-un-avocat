<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-Width');

include_once '../Database/Database.php';
include_once '../Modele/Client.php';

$database = new Database();
$db = $database->connect();
$Client = new Client($db);
$data = json_decode(file_get_contents('php://input'));
$Client->login_number = $data->login_number;

if ($Client->Signin()) {
    echo json_encode(
        ['message' => 'Login est passe avec succes !!!', 'login_number' => $Client->login_number]
    );
} else {
    echo json_encode(
        ['message' => 'Try Again Ref incorrect!!']
    );
}
