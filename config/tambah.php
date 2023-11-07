<?php
date_default_timezone_set("Asia/Jakarta");
session_start();

include "database.php";



$idfinger   = $_POST['idfinger'];
$nama       = $_POST['nama'];
$alamat     = $_POST['alamat'];
$ttl        = $_POST['ttl'];
$jk         = $_POST['jk'];
$idtelegram = $_POST['idtelegram'];

if (isset($_POST['tambah'])) {


    $tambah = "INSERT INTO tbsiswa  VALUES ('', '$idfinger', '$nama', '$alamat', '$ttl', '$jk', '$idtelegram')";

    if (mysqli_query($koneksi, $tambah)) {
        header("Location: ../dashboard.php");
    } else {
        echo "Gagal ditambah";
    }
}
// $koneksi->close();
