<?php
date_default_timezone_set("Asia/Jakarta");
session_start();
include "config/database.php";


if (!isset($_SESSION['username'])) {
  header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Data</title>
    <!-- base:css -->
    <link rel="stylesheet" href="assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">

    <link rel="stylesheet" href="assets/css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body>

    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <!-- partial -->
        <?php
        include "layout/nav.php";
        ?>
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->


            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            <?php
            include "layout/sidebar.php";

            include "layout/theme.php";
            ?>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" style="padding: 50px;">
                                <form action="config/tambah.php" method="POST">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="alert alert-primary" role="alert">
                                                Isi Data Terlebih Dahulu!
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Nama</label>
                                                <input type="text" name="nama" class="form-control" id="exampleFormControlInput1" placeholder="Nama siswa" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput2">Alamat</label>
                                                <input type="text" name="alamat" class="form-control" id="exampleFormControlInput2" placeholder="Alamat siswa" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput3">Alamat</label>
                                                <input type="date" name="ttl" class="form-control" id="exampleFormControlInput3" placeholder="Tanggal Lahir" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Jenis Kelamin</label>
                                                <select name="jk" class="form-control" id="exampleFormControlSelect1" required>
                                                    <option value="" disabled selected>Pilih jenis kelamin</option>
                                                    <option value="L">L</option>
                                                    <option value="P">P</option>

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput4">Id Telegram</label>
                                                <input type="number" name="idtelegram" class="form-control" id="exampleFormControlInput4" placeholder="2012XXX" required>
                                            </div>

                                        </div>
                                        <script>
                                            function cekID() {
                                                $.ajax({
                                                    type: 'GET',
                                                    url: 'config/realid.php',
                                                    cache: false,
                                                    success: function(response) {
                                                        $("#sensor").val(response);
                                                    }
                                                });
                                            }
                                            setInterval(cekID, 1000);
                                        </script>
                                        <div class="col-md-4 ml-auto mr-auto pl-5">
                                            <div class="alert alert-primary" role="alert">
                                                Finger Print Sebelum Simpan Data!
                                            </div>
                                            <div class="form-group">
                                                <img src="assets/gif/Finger.gif" class="text-center" alt="" style="display: block;">
                                                <label class="text-center" for="exampleFormControlInput4">Silahkan Finger Print!</label>
                                                <input type="text" name="idfinger" id="sensor" class="form-control" id="exampleFormControlInput4" placeholder="id finger print" readonly>
                                            </div>
                                            <button type="reset" class="btn btn-danger">Reset</button>
                                            <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                <footer class="footer">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2022 Rahmayani</a>. All rights reserved.</span>
                                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center text-muted">SMP DARUR ISTIQLAL MARINDAL 1</span>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->


            <!-- partial -->
        </div>


        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>

    <!-- container-scroller -->

    <?php
    include "scrip.php";
    ?>
</body>

</html>