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
    <title>Setting</title>
    <!-- base:css -->
    <link rel="stylesheet" href="assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">

    <link rel="stylesheet" href="assets/css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body>

    <div class="container-scroller">

        <?php
        include "layout/nav.php";
        ?>
        <div class="container-fluid page-body-wrapper">
            <?php
            include "layout/sidebar.php";

            include "layout/theme.php";
            ?>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <?php
                    $query = mysqli_query($koneksi, "SELECT * FROM setting");
                    $query1 = mysqli_fetch_array($query);
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" style="padding: 50px;">
                                <form action="config/edit-setting.php" method="POST">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="alert alert-primary" role="alert">
                                                Setting Data
                                            </div>
                                            <div class="form-group">
                                            <input type="hidden" name="id" class="form-control" id="id" value="<?= $query1['id'];?>" >
                                                <label for="token1">Token Telegram</label><br>
                                                <!-- <p style="display: inline-block;"><?= $query1['token']; ?></p> -->
                                                <input type="text" name="token" class="form-control" id="token1" value="<?= $query1['token']; ?>" placeholder="Update Token" >
                                            </div>
                                            <div class="form-group">
                                                <label for="token2">Jam Masuk</label>
                                                <input type="time" name="masuk" class="form-control" id="token2" value="<?= $query1['jam_masuk']; ?>" >
                                            </div>
                                            <button type="submit" name="update" class="btn btn-primary">Update</button>
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