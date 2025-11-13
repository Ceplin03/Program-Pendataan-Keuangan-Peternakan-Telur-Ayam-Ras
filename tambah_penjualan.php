<?php
// Panggil file koneksi.php
require_once 'koneksi.php';
session_start(); // Mulai sesi untuk penggunaan $_SESSION

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Inisialisasi variabel untuk pesan status
$status = '';

// Proses form jika ada data yang disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil nilai dari form
    $id_penjualan = $_POST['id_penjualan'];
    $tgl_penjualan = $_POST['tgl_penjualan'];
    $harga_tbakso = $_POST['harga_tbakso'];
    $harga_tmk = $_POST['harga_tmk'];
    $harga_ts = $_POST['harga_ts'];
    $tbakso = $_POST['tbakso'];
    $tmk = $_POST['tmk'];
    $ts = $_POST['ts'];

    // Hitung total harga untuk masing-masing jenis telur
    $total_tbakso = $tbakso * $harga_tbakso;
    $total_tmk = $tmk * $harga_tmk;
    $total_ts = $ts * $harga_ts;

    // Hitung total harga keseluruhan
    $total_penjualan = $total_tbakso + $total_tmk + $total_ts;

    

    // Contoh penggunaan: Insert data ke database (jika Anda ingin mengirim langsung ke database)
    $sql = "INSERT INTO tbl_penjualan (id_penjualan, tgl_penjualan, total_penjualan, harga_tbakso, harga_tmk, harga_ts, tbakso, tmk, ts, total_tbakso, total_tmk, total_ts) VALUES ('$id_penjualan','$tgl_penjualan', '$total_penjualan', '$harga_tbakso', '$harga_tmk', '$harga_ts', '$tbakso', '$tmk', '$ts', '$total_tbakso', '$total_tmk', '$total_ts')";
    if ($conn->query($sql) === TRUE) {
      // Jika berhasil ditambahkan, set flag untuk menampilkan pemberitahuan
      $success_message = "Data Penjualan berhasil ditambahkan!";
      echo "<script>
              alert('$success_message');
              window.location.href = 'penjualan.php';
            </script>";
    } else {
      $error_message = "Error: " . $sql . "<br>" . $conn->error;
      echo "<script>
              alert('$error_message');
              window.location.href = 'penjualan.php';
            </script>";
    }
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
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
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
            <h1 class="m-0">Penjualan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Penjualan</li>
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
        <div class="container mt-5">
        <h2>Tambah Penjualan Telur</h2>
        <?php if (!empty($status)): ?>
            <div class="alert alert-success"><?php echo $status; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="id_penjualan">ID Penjualan:</label>
                <input type="number" class="form-control" id="id_penjualan" name="id_penjualan" required>
            </div>
            <div class="form-group">
                <label for="tgl_penjualan">Tanggal Penjualan:</label>
                <input type="date" class="form-control" id="tgl_penjualan" name="tgl_penjualan" required>
            </div>
            
            <div class="form-group">
                <label for="tbakso">Jumlah Telur Bakso:</label>
                <input type="number" class="form-control" id="tbakso" name="tbakso" oninput="hitungTotal('tbakso')" required>
            </div>
            <div class="form-group">
                <label for="harga_tbakso">Harga Telur Bakso:</label>
                <input type="number" class="form-control" id="harga_tbakso" name="harga_tbakso" oninput="hitungTotal('tbakso')" required>
            </div>
            <div class="form-group">
                <label for="total_tbakso">Total Harga Telur Bakso:</label>
                <input type="number" class="form-control" id="total_tbakso" name="total_tbakso" readonly>
            </div>

            <div class="form-group">
                <label for="tmk">Jumlah Telur Menengah Kecil:</label>
                <input type="number" class="form-control" id="tmk" name="tmk" oninput="hitungTotal('tmk')" required>
            </div>
            <div class="form-group">
                <label for="harga_tmk">Harga Telur Menengah Kecil:</label>
                <input type="number" class="form-control" id="harga_tmk" name="harga_tmk" oninput="hitungTotal('tmk')" required>
            </div>
            <div class="form-group">
                <label for="total_tmk">Total Harga Telur Menengah Kecil:</label>
                <input type="number" class="form-control" id="total_tmk" name="total_tmk" readonly>
            </div>

            <div class="form-group">
                <label for="ts">Jumlah Telur Standar:</label>
                <input type="number" class="form-control" id="ts" name="ts" oninput="hitungTotal('ts')" required>
            </div>
            <div class="form-group">
                <label for="harga_ts">Harga Telur Standar:</label>
                <input type="number" class="form-control" id="harga_ts" name="harga_ts" oninput="hitungTotal('ts')" required>
            </div>
            <div class="form-group">
                <label for="total_ts">Total Harga Telur Standar:</label>
                <input type="number" class="form-control" id="total_ts" name="total_ts" readonly>
            </div>

            <div class="form-group">
                <label for="total_penjualan">Total Harga Keseluruhan:</label>
                <input type="number" class="form-control" id="total_penjualan" name="total_penjualan" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <a href="penjualan.php" class="btn btn-danger">Kembali</a>
        </form>
    </div>

    <script>
    // Fungsi untuk menghitung total harga untuk setiap jenis telur
    function hitungTotal(jenisTelur) {
        var jumlah = parseInt(document.getElementById(jenisTelur).value);
        var harga = parseFloat(document.getElementById('harga_' + jenisTelur).value);
        var total = jumlah * harga;
        document.getElementById('total_' + jenisTelur).value = total;

        // Hitung total harga keseluruhan
        var total_tbakso = parseFloat(document.getElementById('total_tbakso').value);
        var total_tmk = parseFloat(document.getElementById('total_tmk').value);
        var total_ts = parseFloat(document.getElementById('total_ts').value);
        var total_penjualan = total_tbakso + total_tmk + total_ts;
        document.getElementById('total_penjualan').value = total_penjualan;
    }
    </script>
          
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
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

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