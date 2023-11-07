<?php
date_default_timezone_set("Asia/Jakarta");
include "database.php";
error_reporting(0);
$id = $_GET['id'];

$datenow = date("Y-m-d H:i:s");
$query = mysqli_query($koneksi, "SELECT * FROM tbsiswa WHERE id = '$id'");
$cek = mysqli_fetch_array($query);
$finger = $cek['id_finger'];

if ($id > 0) {
    $add = mysqli_query($koneksi, "INSERT INTO hapus VALUES ('', '$finger', '$datenow')");
}

$date10ago = date('Y-m-d H:i:s', strtotime('-3 seconds', strtotime($datenow))); //kurang 10 detik lalu
$query = mysqli_query($koneksi, "SELECT * FROM hapus WHERE date BETWEEN '$date10ago' AND '$datenow' ORDER BY id DESC LIMIT 1");
$cek = mysqli_fetch_array($query);
$sensor = $cek['idfinger'];


$delete = mysqli_query($koneksi, "DELETE FROM tbsiswa WHERE id = '$id'");

if ($delete === TRUE) {
    header("Location: ../dashboard.php");
    echo $sensor;
} else {
    header("Location: ../dashboard.php?delete=gagal");
}


