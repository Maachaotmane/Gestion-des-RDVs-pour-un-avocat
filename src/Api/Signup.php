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

$res = false;
$Client->login_number = $Client->generateRandomString();
$Client->name = $data->name;
$Client->prenom = $data->prenom;
$Client->email = $data->email;
$Client->job = $data->job;
// $Client->cin = $data->cin;
// $count = $Client->CinExists();
if ($count > 0) {
    echo json_encode(
        ['message' => 'Existe deja', 'res' => false]
    );
} else {
    if ($Client->Signup()) {
        echo json_encode(
                ['message' => 'Creation du compte passe avec succes !!!', 'login_number' => $Client->login_number, 'res' => true]
            );
    } else {
        echo json_encode(
                ['message' => 'Try Again !!', 'res' => false]
            );
    }
}
