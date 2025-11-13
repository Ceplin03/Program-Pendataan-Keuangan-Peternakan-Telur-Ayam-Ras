<?php
require_once 'koneksi.php';
session_start(); // Mulai sesi untuk penggunaan $_SESSION

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Query untuk mengambil data dari tabel tbl_pengeluaran
$sql = "SELECT id_pengeluaran, tgl_pengeluaran, total_pengeluaran,  harga_lain, jml_baki, harga_baki, total_pakanayam FROM tbl_pengeluaran";
$result = $conn->query($sql);

// Inisialisasi variabel untuk menampung baris data
$rows = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}



// Tutup koneksi database
$conn->close();
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
            <h1 class="m-0">Pengeluaran</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Pengeluaran</li>
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
                  <h3 class="card-title">Data pengeluaran Telur Ayam Ras</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <!-- <a href="tambah_pengeluaran.php" class="btn btn-primary"><i class="fas fa-inbox"></i>Tambah Data pengeluaran</a> -->
                <p></p>
                  <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4"><div class="row"><div class="col-sm-12 col-md-6"></div></div><div class="row"><div class="col-sm-12"><table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                    <thead>
                    <tr>
                    <th>ID pengeluaran</th>
                    <th>Tanggal</th>
                    <th>Total Harga Makanan Ayam</th>
                    <th>Jumlah Kertas Telur</th>
                    <th>Harga Kertas Telur</th>
                    <th>Pengeluaran Lain-Lain</th>
                    <th>Total pengeluaran</th>
                    <!-- <th>Aksi</th> -->
                  </tr>
                    
                    </thead>
                    <tbody>
                    <?php foreach ($rows as $row) : ?>
                                  <tr>
                                  <td><?php echo $row['id_pengeluaran']; ?></td>
                                      <td><?php echo $row['tgl_pengeluaran']; ?></td>
                                      
                                      <td>Rp. <?php echo number_format($row['total_pakanayam'], 2); ?> <b><b><a href="lihat_pakan_admin.php?id=<?php echo $row['id_pengeluaran']; ?>"><i class="fas fa-folder"></i> Lihat Selengkapnya </a></b></b> </td>
                                      
                                      
                                      <td><?php echo $row['jml_baki']; ?></td>
                                      <td>Rp. <?php echo number_format($row['harga_baki'], 2); ?></td>
                                      <td>Rp. <?php echo number_format($row['harga_lain'], 2); ?></td>
                                      <td>Rp. <?php echo number_format($row['total_pengeluaran'], 2); ?></td>
                                      <!-- <td><a href="edit_pengeluaran.php?id=<?php echo $row['id_pengeluaran']; ?>" class="btn btn-secondary"><i class="fas fa-edit"></i> Edit </a>
                                      <a href="hapus_pengeluaran.php?id=<?php echo $row['id_pengeluaran']; ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini?');"><i class="fas fa-times"></i> Hapus </a></td> -->
                                  </tr>
                              <?php endforeach; ?>
                            
                    </tbody>
                    <tfoot>
                    
                    </tfoot>
                  </table></div></div></div>
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
