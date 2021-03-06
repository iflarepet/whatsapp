<?php

include_once("../helper/koneksi.php");
include_once("../helper/function.php");


// Takes raw data from the request
$data = json_decode(file_get_contents('php://input'), true);

header('Content-Type: application/json');
$nomor = $data['number'];
$pesan = $data['message'];
$api_key = $data['api_key'];


if (!isset($nomor) && !isset($pesan) && !isset($api_key)) {
    $ret['status'] = false;
    $ret['msg'] = "Nomor / pesan tidak boleh kosong";
    echo json_encode($ret, true);
    exit;
}
if ($api_key != api_key()) {
    $ret['status'] = false;
    $ret['msg'] = "Api key salah";
    echo json_encode($ret, true);
    exit;
}

$res = sendMSG($nomor, $pesan);
if ($res['status'] == "true") {
    $ret['status'] = true;
    $ret['msg'] = "Pesan berhasil dikirim";
    echo json_encode($ret, true);
    exit;
} else {
    $ret['status'] = false;
    $ret['msg'] = $res['msg'];
    echo json_encode($ret, true);
    exit;
}
