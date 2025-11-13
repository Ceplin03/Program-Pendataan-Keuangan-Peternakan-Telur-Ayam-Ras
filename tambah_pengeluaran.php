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
    $id_pengeluaran = $_POST['id_pengeluaran'];
    $tgl_pengeluaran = $_POST['tgl_pengeluaran'];
    $b_kons = $_POST['b_kons'];
    $b_jagung = $_POST['b_jagung'];
    $b_dadak = $_POST['b_dadak'];
    $b_tb = $_POST['b_tb'];
    
    $harga_lain = $_POST['harga_lain'];
    $jml_baki = $_POST['jml_baki'];
    $harga_baki = $_POST['harga_baki'];
    $harga_kons = $_POST['harga_kons'];
    $harga_jagung = $_POST['harga_jagung'];
    $harga_dadak = $_POST['harga_dadak'];
    $harga_tb = $_POST['harga_tb'];
    $total_kons = $_POST['total_kons'];
    $total_jagung = $_POST['total_jagung'];
    $total_dadak = $_POST['total_dadak'];
    $total_tb = $_POST['total_tb'];
    $total_pengeluaran = $_POST['total_pengeluaran'];
    $total_pakanayam = $_POST['total_pakanayam'];

    // Hitung total harga untuk setiap jenis pakan
    $total_kons = $b_kons * $harga_kons;
    $total_jagung = $b_jagung * $harga_jagung;
    $total_dadak = $b_dadak * $harga_dadak;
    $total_tb = $b_tb * $harga_tb;
    $total_pakanayam = $total_kons + $total_jagung + $total_dadak + $total_tb;

    // Hitung total pengeluaran
    $total_pengeluaran = $total_pakanayam + $harga_lain + $harga_baki;

    // Query untuk memasukkan data ke database (sesuaikan dengan tabel dan kolom yang sesuai)
    $sql = "INSERT INTO tbl_pengeluaran (id_pengeluaran, tgl_pengeluaran, b_kons, b_jagung, b_dadak, b_tb,
            harga_lain, jml_baki, harga_baki, harga_kons, harga_jagung, 
            harga_dadak, harga_tb, total_kons, total_jagung, total_dadak, total_tb, total_pengeluaran, total_pakanayam) 
            VALUES ('$id_pengeluaran','$tgl_pengeluaran', '$b_kons', '$b_jagung', '$b_dadak', '$b_tb', 
            '$harga_lain', '$jml_baki', '$harga_baki', '$harga_kons', 
            '$harga_jagung', '$harga_dadak', '$harga_tb', '$total_kons', '$total_jagung', '$total_dadak', 
            '$total_tb', '$total_pengeluaran', '$total_pakanayam')";

if ($conn->query($sql) === TRUE) {
  // Jika berhasil ditambahkan, set flag untuk menampilkan pemberitahuan
  $success_message = "Data pengeluaran berhasil ditambahkan!";
  echo "<script>
          alert('$success_message');
          window.location.href = 'pengeluaran.php';
        </script>";
} else {
  $error_message = "Error: " . $sql . "<br>" . $conn->error;
  echo "<script>
          alert('$error_message');
          window.location.href = 'pengeluaran.php';
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
            <h1 class="m-0">pengeluaran</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">pengeluaran</li>
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
          
        <div class="container mt-0">
        <h2>Tambah pengeluaran </h2>
        <?php if (!empty($status)): ?>
            <div class="alert alert-success"><?php echo $status; ?></div>
        <?php endif; ?>
        <form method="POST">
        <div class="form-group">
                <label for="id_pengeluaran">ID pengeluaran:</label>
                <input type="number" class="form-control" id="id_pengeluaran" name="id_pengeluaran" required>
            </div>
            <div class="form-group">
                <label for="tgl_pengeluaran">Tanggal pengeluaran:</label>
                <input type="date" class="form-control" id="tgl_pengeluaran" name="tgl_pengeluaran" required>
            </div>
            <h5><label>Form pengeluaran Pakan Ayam</label></h5>
            <div class="card">
            <div class="card-body">
            <table class="table ">
                <tr><td><label for="b_kons">Banyak Konsentrat</label></td>
                <td><input type="number" class="form-control" id="b_kons" name="b_kons" oninput="hitungTotal('kons')" placeholder="Karung"  required></td>

                <td><label for="harga_kons">Harga Konsentrat</label></td>
                <td><input type="number" class="form-control" id="harga_kons" name="harga_kons" oninput="hitungTotal('kons')"  required></td>

                <td><label for="total_kons">Jumlah Harga</label></td>
                <td><input type="number" class="form-control" id="total_kons" name="total_kons" readonly></td></tr>
                
                <tr><td><label for="b_jagung">Banyak Jagung </label></td>
                <td><input type="number" class="form-control" id="b_jagung" name="b_jagung" oninput="hitungTotal('jagung')" placeholder="Kilo" required></td>

                <td><label for="harga_jagung">Harga Jagung</label></td>
                <td><input type="number" class="form-control" id="harga_jagung" name="harga_jagung"  oninput="hitungTotal('jagung')"  required></td>

                <td><label for="total_jagung">Jumlah Harga</label></td>
                <td><input type="number" class="form-control" id="total_jagung" name="total_jagung"  readonly></td></tr>

                <tr><td><label for="b_dadak">Banyak Dadak </label></td>
                <td><input type="number" class="form-control" id="b_dadak" name="b_dadak" oninput="hitungTotal('dadak')" placeholder="Kilo"  required></td>

                <td><label for="harga_dadak">Harga Dadak</label></td>
                <td><input type="number" class="form-control" id="harga_dadak" name="harga_dadak" oninput="hitungTotal('dadak')"   required></td>

                <td><label for="total_dadak">Jumlah Harga</label></td>
                <td><input type="number" class="form-control" id="total_dadak" name="total_dadak"  readonly></td></tr>

                <tr><td><label for="b_tb">Banyak Tepung Batu </label></td>
                <td><input type="number" class="form-control" id="b_tb" name="b_tb" oninput="hitungTotal('tb')"  placeholder="Karung" required></td>

                <td><label for="harga_tb">Harga Tepung Batu</label></td>
                <td><input type="number" class="form-control" id="harga_tb" name="harga_tb" oninput="hitungTotal('tb')"  required></td>

                <td><label for="total_tb">Jumlah Harga</label></td>
                <td><input type="number" class="form-control" id="total_tb" name="total_tb"  readonly></td></tr>

                <tr><td colspan="5" align="center"><label for="total_pakanayam">Total Harga Pakan Ayam</label></td><td><input type="number" class="form-control" id="total_pakanayam" name="total_pakanayam"  readonly></td></tr>

                </table>
            </div></div>
            <p></p>
            <h5><label for="">Form pengeluaran Lain-Lain</label></h5>
            <div class="card">
            <div class="card-body">
            <table class="table">
                
            
                

                <td colspan="2"></td><td><label for="jml_baki">Jumlah Kertas Telur:</label></td>
                <td><input type="number" class="form-control" id="jml_baki" name="jml_baki" required></td>
            
                <td><label for="harga_baki">Harga Kertas Telur:</label></td>
                <td><input type="number" class="form-control" id="harga_baki" name="harga_baki"  oninput="hitungTotalpengeluaran()"  required></td>
                <td><label for="harga_lain">Pengeluaran Lain-Lain:</label></td>
                <td><input type="number" class="form-control" id="harga_lain" name="harga_lain" oninput="hitungTotalpengeluaran()"  required></td>
                </table>
            </div></div>

            <div class="card">
            <div class="card-body">
          
            <div class="form-group">
                <label for="total_pengeluaran">Total pengeluaran</label>
                <input type="number" class="form-control" id="total_pengeluaran" name="total_pengeluaran" readonly>
                

            </div>
            </div></div>


            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <a href="pengeluaran.php" class="btn btn-danger">Kembali</a>
        </form>

        <script>
    // Fungsi untuk menghitung total harga untuk setiap jenis pakan
    function hitungTotal(jenis) {
        var banyak = parseInt(document.getElementById('b_' + jenis).value);
        var harga = parseFloat(document.getElementById('harga_' + jenis).value);
        var total = banyak * harga;
        document.getElementById('total_' + jenis).value = total;
        hitungTotalPakanAyam();
    }

    // Fungsi untuk menghitung total harga pakan ayam
    function hitungTotalPakanAyam() {
        var total_kons = parseFloat(document.getElementById('total_kons').value);
        var total_jagung = parseFloat(document.getElementById('total_jagung').value);
        var total_dadak = parseFloat(document.getElementById('total_dadak').value);
        var total_tb = parseFloat(document.getElementById('total_tb').value);
        var total_pakanayam = total_kons + total_jagung + total_dadak + total_tb;
        document.getElementById('total_pakanayam').value = total_pakanayam;
        hitungTotalpengeluaran();
    }

    // Fungsi untuk menghitung total pengeluaran keseluruhan
    function hitungTotalpengeluaran() {
        var total_pakanayam = parseFloat(document.getElementById('total_pakanayam').value);
        var harga_lain = parseFloat(document.getElementById('harga_lain').value);
        var harga_baki = parseFloat(document.getElementById('harga_baki').value);
        var total_pengeluaran = total_pakanayam + harga_lain + harga_baki;
        document.getElementById('total_pengeluaran').value = total_pengeluaran;
    }
</script>


        

        <p><p></p></p>
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