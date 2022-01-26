<?php

// $host = "localhost";
// $username = "root";
// $password = "";
// $db = "wav3";
$host = "localhost";
$username = "flareuser";
$password = "Di3sCtB9Br!@";
$db = "whatsappdb";

error_reporting(0);
$koneksi = mysqli_connect($host, $username, $password, $db) or die("GAGAL");

$base_url = "https://whatsapp.flare.pet/";
date_default_timezone_set('Asia/Jakarta');
