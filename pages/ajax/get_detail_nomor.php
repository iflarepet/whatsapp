<?php
include_once("../../helper/koneksi.php");
include_once("../../helper/function.php");


$id = $_POST['id'];

// $query = mysqli_query($koneksi,"SELECT * FROM group_nomor");
// $t = $_POST['target'][0];

// 	if ($result = $koneksi -> query("SELECT * FROM detail_group join nomor on detail_group.id_nomor = nomor.id where id_group = '$id'")) {
//     $result = $koneksi -> query("SELECT * FROM detail_group join nomor on detail_group.id_nomor = nomor.id where id_group = 64 ");
// 	$res = $result->fetch_all(MYSQLI_ASSOC);

$result = mysqli_query($koneksi, "SELECT * FROM detail_group join nomor on detail_group.id_nomor = nomor.id where detail_group.id_group = '$id'");
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);
   
// }else{
    
//     echo "gagal";
// }
 //        $y = mysqli_query($koneksi, "SELECT * FROM detail_group WHERE id_group = '$id'");

 //        $t = mysqli_fetch_assoc($y);
 //        $n = [$t];
	// echo json_encode($t);
