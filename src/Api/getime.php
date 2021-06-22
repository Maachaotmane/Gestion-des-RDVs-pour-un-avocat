<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-Width');

include_once '../Database/Database.php';
include_once '../Modele/RDV.php';

$database = new Database();
$db = $database->connect();

$RD = new RDV($db);
$data = json_decode(file_get_contents('php://input'));
$rlt = $RD->gettime($data->times);
$count = $rlt->rowCount();

    $data = [];
    while ($row = $rlt->fetch(PDO::FETCH_ASSOC)) {
        $hour = date_create($row['times'])->format('H:i');
        array_push($data, $hour);
    }
    $time = ['10:00', '11:00', '14:00', '15:00', '16:00'];
    $arr_1 = array_diff($data, $time);
    $arr_2 = array_diff($time, $data);
    $time = array_merge($arr_1, $arr_2);
    echo json_encode($time);
