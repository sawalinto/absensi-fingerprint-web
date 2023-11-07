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
  <title>dashboard</title>
  <!-- base:css -->
  <link rel="stylesheet" href="assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">

  <link rel="stylesheet" href="assets/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="assets/images/favicon.png" />
  <link rel="stylesheet" type="text/css" href="assets/vendors/datatables/media/css/dataTables.bootstrap4.min.css">
  <script src="assets/vendors/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="assets/vendors/datatables/media/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/vendors/datatables-fixedcolumns/js/dataTables.fixedColumns.js"></script>
  <script src="assets/vendors/datatables-responsive/js/dataTables.responsive.js"></script>


  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css"> -->
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script> -->


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
          <?php
          include "layout/card.php";
          ?>
          <nav class="navbar navbar-light bg-light">
            <form class="form-inline">
              <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
          </nav>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="table-responsive pt-3">
                  <!-- <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%"> -->
                  <table class="table table-striped project-orders-table dt-responsive  nowrap" id="datatable-responsive" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th class="ml-5">No</th>
                        <th>Id</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>TTL</th>
                        <th>Jenis Kelamin</th>
                        <th>Id Telegram</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $query =  mysqli_query($koneksi, 'SELECT * FROM tbsiswa');
                      // $data = mysqli_fetch_array($query);
                      $i = 1;
                      while ($datas = mysqli_fetch_array($query)) {
                      ?>
                        <tr>
                          <td><?= $i++; ?></td>
                          <td><?= $datas['id_finger']; ?></td>
                          <td><?= $datas['nama']; ?></td>
                          <td><?= $datas['alamat']; ?></td>
                          <td><?= $datas['ttl']; ?></td>
                          <td><?= $datas['kelamin']; ?></td>
                          <td><?= $datas['id_telegram']; ?></td>
                          <td>
                            <div class="d-flex align-items-center">
                              <a  href="#edit<?= $datas['id']; ?>" class="btn btn-success btn-sm btn-icon-text mr-3" data-toggle="modal" data-target="#edit<?= $datas['id']; ?>">
                                Edit
                                <i class="typcn typcn-edit btn-icon-append"></i>
                              </a>
                              <a href="config/delete.php?id=<?= $datas['id']; ?>" onclick="return confirm('Yakin Hapus Data?');" class="btn btn-danger btn-sm btn-icon-text">
                                Delete
                                <i class="typcn typcn-delete-outline btn-icon-append"></i>
                              </a>
                            </div>
                          </td>
                        </tr>
                        <script>
                          function myFunction() {
                            let text = "Press a button!\nEither OK or Cancel.";
                            if (confirm(text) == true) {
                              text = "You pressed OK!";
                            } else {
                              text = "You canceled!";
                            }
                            document.getElementById("demo").innerHTML = text;
                        </script>
                        <!-- Modal -->
                        <div class="modal fade" id="edit<?= $datas['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Update Data Siswa</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="config/edit.php" method="post" enctype="multipart/form-data">
                                <div class="modal-body">

                                  <div class="form-group">
                                    <input type="hidden" name="id" class="form-control" id="exampleFormControlInput1" value="<?= $datas['id']; ?>">
                                    <label for="exampleFormControlInput1">Id Finger</label>
                                    <input type="text" name="id_finger" class="form-control" id="exampleFormControlInput1" value="<?= $datas['id_finger']; ?>" placeholder="Nama siswa" disabled>
                                  </div>

                                  <div class="form-group">
                                    <!-- <input type="hidden" class="form-control" id="exampleFormControlInput1" value="<?= $datas['id']; ?>"> -->
                                    <label for="exampleFormControlInput1">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="exampleFormControlInput1" value="<?= $datas['nama']; ?>" placeholder="Nama siswa">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleFormControlInput2">Alamat</label>
                                    <input type="text" name="alamat" class="form-control" id="exampleFormControlInput2" value="<?= $datas['alamat']; ?>" placeholder="Alamat siswa">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleFormControlInput3">Tanggal Lahir</label>
                                    <input type="date" name="ttl" class="form-control" id="exampleFormControlInput3" value="<?= $datas['ttl']; ?>" placeholder="Tanggal Lahir">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleFormControlSelect1">Jenis Kelamin</label>
                                    <select class="form-control" name="kelamin" id="exampleFormControlSelect1">
                                      <option value='L' <?php if ($datas['kelamin'] == "L") {
                                                          echo " selected";
                                                        }  ?>>L</option>
                                      <option value='P' <?php if ($datas['kelamin'] == "P") {
                                                          echo " selected";
                                                        }  ?>>P</option>

                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleFormControlInput4">Id Telegram</label>
                                    <input type="number" name="id_telegram" class="form-control" id="exampleFormControlInput4" value="<?= $datas['id_telegram']; ?>" placeholder="2012XXX">
                                  </div>



                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" name="submit" onclick="submit()" class="btn btn-primary">Update</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
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


  <script type="text/javascript">
    $(document).ready(function() {
      $('.table').dataTable();
    });
  </script>

</body>

</html>