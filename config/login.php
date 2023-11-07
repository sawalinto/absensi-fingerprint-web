<?php
session_start();
require "database.php";
if (isset($_SESSION['username'])) {
    header("location: ../dashboard.php");
}

if(isset($_POST['login'])){
    $username= $_POST['username'];
    $password= $_POST['password'];

    $cek = mysqli_query($koneksi, "SELECT * FROM admin WHERE username= '$username'");
    if($cek -> num_rows > 0)
    {
        $query = mysqli_fetch_assoc($cek);
        if(password_verify($password, $query['password']))
        {
            $_SESSION['username'] = $query['username'];
            header("Location: ../dashboard.php");
        }
        else{
            
             header("Location: ../index.php?password=" . sha1(time()));
        }
    }
    else{
        mt_srand(7);
        header("Location: ../index.php?user=" . sha1(time()));
    }
}
