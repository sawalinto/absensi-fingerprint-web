<?php
date_default_timezone_set("Asia/Jakarta");
include "database.php";

error_reporting(0);


$datenow = date("Y-m-d H:i:s");
$date10ago = date('Y-m-d H:i:s', strtotime('-10 seconds', strtotime($datenow))); //kurang 10 detik lalu
$query = mysqli_query($koneksi, "SELECT * FROM sensor WHERE date BETWEEN '$date10ago' AND '$datenow' ORDER BY id DESC LIMIT 1");

// $query = mysqli_query($conn, "SELECT * FROM sensor ORDER BY id DESC");
$sql = mysqli_fetch_array($query);
$sensor = $sql['sensor'];
echo $sensor;

?>