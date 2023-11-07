<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
session_start();
include "database.php"; 
error_reporting(0);
$sha=sha1(time());

$id = $_POST["id"];
$token = $_POST["token"];
$masuk = $_POST["masuk"];


$query = "
			UPDATE setting SET  
                token = '$token',
                jam_masuk = '$masuk'
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
