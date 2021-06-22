<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-Width');

include_once '../Database/Database.php';
include_once '../Modele/RDV.php';

$database = new Database();
$db = $database->connect();
$RDV = new RDV($db);
$data = json_decode(file_get_contents('php://input'));
$RDV->login_number = $data->login_number;
$result = $RDV->read();
$count = $result->rowCount();

    if ($count > 0) {
        $rdv_arr = [];
        $rdv_arr['data'] = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $rdva = [
            'id' => $id,
            'subject' => $subject,
            'times' => $times,
        ];
            array_push($rdv_arr['data'], $rdva);
        }
        echo json_encode($rdv_arr['data']);
    } else {
        echo json_encode(
        ['message' => 'No rdv Found']
    );
    }
