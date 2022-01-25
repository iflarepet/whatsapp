<?php
include_once("../../helper/koneksi.php");
include_once("../../helper/function.php");


$id = $_POST['id'];

$q = mysqli_query($koneksi, "DELETE FROM detail_group WHERE id_detail_group='$id'");
redirect("group_nomor.php");
?>



?>