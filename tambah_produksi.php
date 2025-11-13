<?php
// Panggil file koneksi.php
require_once 'koneksi.php';

// Inisialisasi variabel untuk pesan status
$status = '';

// Proses form jika ada data yang disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil nilai dari form
    $id_produksi = $_POST['id_produksi'];
    $tgl_produksi = $_POST['tgl_produksi'];
    $jml_telur = $_POST['jml_telur'];
    $tbakso = $_POST['tbakso'];
    $tmk = $_POST['tmk'];
    $ts = $_POST['ts'];

    // Simpan data ke dalam array (contoh simulasi tambah ke database)
    $new_data = array(
        'id_produksi' => $id_produksi,
        'tgl_produksi' => $tgl_produksi,
        'jml_telur' => $jml_telur,
        'tbakso' => $tbakso,
        'tmk' => $tmk,
        'ts' => $ts
    );

    // Contoh penggunaan: Insert data ke database (jika Anda ingin mengirim langsung ke database)
    $sql = "INSERT INTO tbl_produksi (id_produksi, tgl_produksi, jml_telur, tbakso, tmk, ts) VALUES ('$id_produksi','$tgl_produksi', '$jml_telur', '$tbakso', '$tmk', '$ts')";
    if ($conn->query($sql) === TRUE) {
        $status = 'Data berhasil ditambahkan';
        echo '<a href="produksi.php" class="btn btn-info">Lanjut</a>';
    } else {
        $status = 'Error: ' . $sql . '<br>' . $conn->error;
    }
}
    // Simulasi berhasil tambah data (tanpa koneksi ke database)
    // $status = 'Data berhasil ditambahkan: <br>';
    // $status .= 'Tanggal Produksi: ' . $tgl_produksi . '<br>';
    // $status .= 'Jumlah Telur: ' . $jml_telur . '<br>';
    // $status .= 'Telur Bakso: ' . $tbakso . '<br>';
    // $status .= 'Telur Menengah Kecil: ' . $tmk . '<br>';
    // $status .= 'Telur Standar: ' . $ts . '<br>';

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
          
        <div class="container mt-5">
        <h2>Tambah Produksi Telur</h2>
        <?php if (!empty($status)): ?>
            <div class="alert alert-success"><?php echo $status; ?></div>
        <?php endif; ?>
        <form method="POST">
        <div class="form-group">
                <label for="id_produksi">ID Produksi:</label>
                <input type="number" class="form-control" id="id_produksi" name="id_produksi" required>
            </div>
            <div class="form-group">
                <label for="tgl_produksi">Tanggal Produksi:</label>
                <input type="date" class="form-control" id="tgl_produksi" name="tgl_produksi" required>
            </div>
            <div class="form-group">
                <label for="jml_telur">Jumlah Telur:</label>
                <input type="number" class="form-control" id="jml_telur" name="jml_telur" required>
            </div>
            <div class="form-group">
                <label for="tbakso">Telur Bakso:</label>
                <input type="number" class="form-control" id="tbakso" name="tbakso" required>
            </div>
            <div class="form-group">
                <label for="tmk">Telur Menengah Kecil:</label>
                <input type="number" class="form-control" id="tmk" name="tmk" required>
            </div>
            <div class="form-group">
                <label for="ts">Telur Standar:</label>
                <input type="number" class="form-control" id="ts" name="ts" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <a href="produksi.php" class="btn btn-danger">Kembali</a>
        </form>
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