<?php
// session_start();
// if(isset($_SESSION['username']))
// {
//   header("Location: dashboard.php");
// }
 $server = "localhost";
 $username = "root";
 $password = "";
 $db       = "finger";

 $koneksi = new mysqli($server, $username, $password, $db);
 if($koneksi -> connect_error)
 {
    die("Koneksi Gagal !" . $koneksi->connect_error);
 }
//  die("Koneksi Berhasil");
?>