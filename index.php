<?php
session_start(); // Mulai sesi untuk penggunaan $_SESSION

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}


?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Program Sepri</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>

    <!-- Right navbar links -->
    
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include "sidebar.php";?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">

        <div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-info">
    <div class="inner">
      <?php 
      // Koneksi ke database
      $koneksi = mysqli_connect("localhost", "root", "", "db_telur");
      
      // Cek koneksi
      if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
      }

      // Query untuk menjumlahkan total penjualan
      $query = mysqli_query($koneksi, "SELECT SUM(total_penjualan) as total_penjualan FROM tbl_penjualan");
      
      // Ambil hasil query
      $result = mysqli_fetch_assoc($query);
      
      // Ambil total penjualan
      $totalPenjualan = $result['total_penjualan'];
      
      // Jika total penjualan adalah NULL, set menjadi 0
      if ($totalPenjualan === NULL) {
        $totalPenjualan = 0;
      }
      ?>

      <h3>Rp. <?php echo number_format($totalPenjualan, 0, ',', '.'); ?></h3>

      <p>Penjualan</p>
    </div>
    <div class="icon">
      <i class="ion ion-stats-bars"></i>
    </div>
    <!-- <a href="penjualan.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
  </div>
</div>

<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-success">
    <div class="inner">
      <?php 
      // Koneksi ke database
      $koneksi = mysqli_connect("localhost", "root", "", "db_telur");
      
      // Cek koneksi
      if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
      }

      // Query untuk menjumlahkan total penjualan
      $query = mysqli_query($koneksi, "SELECT SUM(total_pengeluaran) as total_pengeluaran FROM tbl_pengeluaran");
      
      // Ambil hasil query
      $result = mysqli_fetch_assoc($query);
      
      // Ambil total penjualan
      $totalPengeluaran = $result['total_pengeluaran'];
      
      // Jika total penjualan adalah NULL, set menjadi 0
      if ($totalPengeluaran === NULL) {
        $totalPengeluaran = 0;
      }
      ?>

      <h3>Rp. <?php echo number_format($totalPengeluaran, 0, ',', '.'); ?></h3>

      <p>Pengeluaran</p>
      
    </div>
    <div class="icon">
      <i class="ion ion-stats-bars"></i>
    </div>
    <!-- <a href="pengeluaran.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
  </div>
</div>

<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-warning">
    <div class="inner">
      
      <?php 
      // Koneksi ke database
      $koneksi = mysqli_connect("localhost", "root", "", "db_telur");
      
      // Cek koneksi
      if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
      }

      // Query untuk menjumlahkan total penjualan
      $query = mysqli_query($koneksi, "SELECT SUM(total_pendapatan) as total_pendapatan FROM tbl_pendapatan");
      
      // Ambil hasil query
      $result = mysqli_fetch_assoc($query);
      
      // Ambil total pendapatan
      $totalpendapatan = $result['total_pendapatan'];
      
      // Jika total pendapatan adalah NULL, set menjadi 0
      if ($totalpendapatan === NULL) {
        $totalpendapatan = 0;
      }
      ?>

      <h3>Rp. <?php echo number_format($totalpendapatan, 0, ',', '.'); ?></h3>

      <p>Pendapatan</p>
    </div>
    <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
    <!-- <a href="pendapatan.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
  </div>
</div>

          
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
