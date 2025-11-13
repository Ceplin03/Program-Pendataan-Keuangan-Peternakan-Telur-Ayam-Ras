<?php
// Panggil file koneksi.php
require_once 'koneksi.php';
session_start(); // Mulai sesi untuk penggunaan $_SESSION


// Inisialisasi variabel untuk pesan status
$status = '';

// Pastikan ada parameter id_pengeluaran yang dikirimkan melalui URL untuk edit
if (isset($_GET['id'])) {
    $id_pengeluaran = $_GET['id'];

    // Ambil data pengeluaran berdasarkan id_pengeluaran
    $sql = "SELECT * FROM tbl_pengeluaran WHERE id_pengeluaran = '$id_pengeluaran'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Ambil data hasil query
        $row = $result->fetch_assoc();
    } else {
        $status = 'Data pengeluaran tidak ditemukan';
    }
}

// Proses form jika ada data yang disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil nilai dari form
    $id_pengeluaran = $_POST['id_penjualan']; // Perbaikan disini, sesuai dengan name pada input hidden
    $b_kons = $_POST['b_kons'];
    $b_jagung = $_POST['b_jagung'];
    $b_dadak = $_POST['b_dadak'];
    $b_tb = $_POST['b_tb'];
    $harga_kons = $_POST['harga_kons'];
    $harga_jagung = $_POST['harga_jagung'];
    $harga_dadak = $_POST['harga_dadak'];
    $harga_tb = $_POST['harga_tb'];
    $total_kons = $b_kons * $harga_kons;
    $total_jagung = $b_jagung * $harga_jagung;
    $total_dadak = $b_dadak * $harga_dadak;
    $total_tb = $b_tb * $harga_tb;
    $total_pakanayam = $total_kons + $_total_jagung + $total_dadak + $total_dadak + $total_tb;

    // Update data ke dalam database
    $sql = "UPDATE tbl_pengeluaran SET b_kons = '$b_kons', b_jagung = '$b_jagung', b_dadak = '$b_dadak', b_tb = '$b_tb', harga_kons = '$harga_kons', harga_jagung = '$harga_jagung', harga_dadak = '$harga_dadak', 
            harga_tb = '$harga_tb', total_kons = '$total_kons', total_jagung = '$total_jagung', total_dadak = '$total_dadak', total_tb = '$total_tb' , total_pakanayam = '$total_pakanayam' WHERE id_pengeluaran = '$id_pengeluaran'";

    if ($conn->query($sql) === TRUE) {
        $status = 'Data berhasil diupdate';
    } else {
        $status = 'Error: ' . $sql . '<br>' . $conn->error;
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
          
        <div class="col-12">
          
          <!-- <h5>Cari Harga Berdasarkan Tanggal</h5>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
              <label for="tanggal">Pilih Tanggal:</label>
              <input type="date" id="tanggal" name="tanggal" required>
              <br><br>
              <input type="submit" value="Cari" class="btn btn-primary">
          </form>
          <div class="mt-4">
              <?php echo $search_result; ?>
          </div> -->
          <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Data pengeluaran Pakan Ayam</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                
                <p></p>
                <form action="" method="POST">
                <table class="table">
                <td><label for="id_pengeluaran">ID pengeluaran</label></td>
                <td><input type="number" class="form-control" id="id_penjualan" name="id_penjualan" value="<?php echo $id_pengeluaran; ?>" readonly></td>

                <tr><td><label for="b_kons">Banyak Konsentrat</label></td>
                <td><input type="number" class="form-control" id="b_kons" name="b_kons" value="<?php echo $row['b_kons']; ?>" readonly></td>

                <td><label for="harga_kons">Harga Konsentrat</label></td>
                <td><input type="number" class="form-control" id="harga_kons" name="harga_kons" value="<?php echo $row['harga_kons']; ?>"  readonly></td>

                <td><label for="total_kons">Jumlah Harga</label></td>
                <td><input type="number" class="form-control" id="total_kons" name="total_kons" value="<?php echo $row['total_kons']; ?>" readonly></td></tr>
                
                <tr><td><label for="b_jagung">Banyak Jagung </label></td>
                <td><input type="number" class="form-control" id="b_jagung" name="b_jagung" value="<?php echo $row['b_jagung']; ?>" readonly></td>

                <td><label for="harga_jagung">Harga Jagung</label></td>
                <td><input type="number" class="form-control" id="harga_jagung" name="harga_jagung"  value="<?php echo $row['harga_jagung']; ?>" readonly></td>

                <td><label for="total_jagung">Jumlah Harga</label></td>
                <td><input type="number" class="form-control" id="total_jagung" name="total_jagung" value="<?php echo $row['total_jagung']; ?>"  readonly></td></tr>

                <tr><td><label for="b_dadak">Banyak Dadak </label></td>
                <td><input type="number" class="form-control" id="b_dadak" name="b_dadak" value="<?php echo $row['b_dadak']; ?>"  readonly></td>

                <td><label for="harga_dadak">Harga Dadak</label></td>
                <td><input type="number" class="form-control" id="harga_dadak" name="harga_dadak" value="<?php echo $row['harga_dadak']; ?>"   readonly></td>

                <td><label for="total_dadak">Jumlah Harga</label></td>
                <td><input type="number" class="form-control" id="total_dadak" name="total_dadak" value="<?php echo $row['total_dadak']; ?>"  readonly></td></tr>

                <tr><td><label for="b_tb">Banyak Tepung Batu </label></td>
                <td><input type="number" class="form-control" id="b_tb" name="b_tb" value="<?php echo $row['b_tb']; ?>" readonly></td>

                <td><label for="harga_tb">Harga Tepung Batu</label></td>
                <td><input type="number" class="form-control" id="harga_tb" name="harga_tb" value="<?php echo $row['harga_tb']; ?>" readonly></td>

                <td><label for="total_tb">Jumlah Harga</label></td>
                <td><input type="number" class="form-control" id="total_tb" name="total_tb" value="<?php echo $row['total_tb']; ?>"  readonly></td></tr>

                <tr><td colspan="5" align="center"><label for="total_pakanayam">Total Harga Pakan Ayam</label></td><td><input type="number" class="form-control" id="total_pakanayam" name="total_pakanayam"  value="<?php echo $row['total_pakanayam']; ?>" readonly></td></tr>
               
                
                </table>
                </form>
                <p></p>
                <a href="l_pengeluaran.php" class="btn btn-danger">Kembali</a>
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
        
    }

    
</script>


                </div>
                <!-- /.card-body -->
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
