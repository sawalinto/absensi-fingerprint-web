<?php
date_default_timezone_set("Asia/Jakarta");
include "database.php";
error_reporting(0);
$id = $_GET['idfinger'];
$date = date('Y-m-d H:i:s');
$jam = date('H:i:s');
// echo $id;  

$add = mysqli_query($koneksi, "INSERT INTO sensor VALUES ('', '$id', '$date')");


$query = mysqli_query($koneksi, "SELECT * FROM tbsiswa WHERE id_finger = '$id'");
$cek= mysqli_fetch_array($query);
$nama = $cek['nama'];
$idtele = $cek['id_telegram'] ;
// echo $idtele;

$msg= mysqli_query($koneksi, "SELECT * FROM setting");
$msg1 = mysqli_fetch_array($msg);
$batas_absen = date('H:i:s', strtotime($msg1['jam_masuk']));
$jam = date('H:i:s');
$mulai_absen = "00:00:00";
if($jam >= $batas_absen)
{
    $pesan = "Terlambat";
    // echo 'T';  
}
else{
    $pesan="Hadir";
    // echo 'H';  
}

// 5450564272:AAFm4dkyXSq8n9tdG6FGxAC60Rlg2cdvD0E
$token = $msg1['token']; // token bot
// echo $token;  
$telegram_id =  $idtele;
$message_text = $nama . "||" . $pesan;


function sendMessage($telegram_id, $message_text, $token) {
    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?parse_mode=markdown&chat_id=" . $telegram_id;
    $url = $url . "&text=" . urlencode($message_text);
    $ch = curl_init();
    $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
}

if(mysqli_num_rows($query) == 1)
{
    sendMessage($telegram_id, $message_text, $token);
    echo $nama;
    // header("Location: ../dashboard.php");
}
else
{
    echo 'COBA LAGI';   
}

