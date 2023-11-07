<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
session_start();
include "database.php"; 
error_reporting(0);
$sha=sha1(time());

$id = $_POST["id"];
$finger = $_POST["id_finger"];
$nama = $_POST["nama"];
$alamat = $_POST["alamat"];
$ttl = $_POST["ttl"];
$kelamin = $_POST["kelamin"];
$telegram = $_POST["id_telegram"];

$query = "
			UPDATE tbsiswa SET  
                id_finger = '$finger',
                nama = '$nama',
				alamat = '$alamat',
				ttl = '$ttl',
				kelamin= '$kelamin',
                id_telegram = '$telegram'
				WHERE id= $id
			";

$result = mysqli_query($koneksi, $query);
// header("Location:data-guru.php");
if (mysqli_affected_rows($koneksi) > 0) { 

    
    echo "<script> 
			alert('Data berhasil diubah!');
			document.location.href = '../dashboard.php';
		</script>
	";   
}
		else {
            echo "<script> 
			alert('Data Tidak Di Ubah');
			document.location.href = '../dashboard.php?Xys=$sha';
		</script>
	"; 
}
