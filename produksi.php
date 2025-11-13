<?php
require_once 'koneksi.php';
session_start(); // Mulai sesi untuk penggunaan $_SESSION

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Query untuk mengambil data dari tabel tbl_produksi
$sql = "SELECT id_produksi, tgl_produksi, jml_telur, tbakso, tmk, ts FROM tbl_produksi";
$result = $conn->query($sql);

// Inisialisasi variabel untuk menampung baris data
$rows = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}

// Tutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
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
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
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
            <h1 class="m-0">Produksi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Produksi</li>
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Produksi Telur Ayam Ras</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="tambah_produksi.php" class="btn btn-primary"><i class="fas fa-inbox"></i>Tambah Data Produksi</a>
                <p></p>
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                  <div class="row">
                    <div class="col-sm-12">
                      <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                        <thead>
                          <tr>
                            <th>ID Produksi</th>
                            <th>Tanggal</th>
                            <th>Jumlah Telur</th>
                            <th>Telur Bakso</th>
                            <th>Telur Menengah Kecil</th>
                            <th>Telur Standar</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($rows as $row) : ?>
                            <tr>
                              <td><?php echo htmlspecialchars($row['id_produksi']); ?></td>
                              <td><?php echo htmlspecialchars($row['tgl_produksi']); ?></td>
                              <td><?php echo htmlspecialchars($row['jml_telur']); ?></td>
                              <td><?php echo htmlspecialchars($row['tbakso']); ?></td>
                              <td><?php echo htmlspecialchars($row['tmk']); ?></td>
                              <td><?php echo htmlspecialchars($row['ts']); ?></td>
                              <td>
                                <a href="edit_produksi.php?id=<?php echo htmlspecialchars($row['id_produksi']); ?>" class="btn btn-secondary"><i class="fas fa-edit"></i> Edit</a>
                                <a href="#" data-id="<?php echo htmlspecialchars($row['id_produksi']); ?>" class="btn btn-danger btn-hapus"><i class="fas fa-times"></i> Hapus</a>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
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
  <script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <!-- Page specific script -->
  <script>
    $(function () {
      $("#example1").DataTable().buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    $(document).ready(function() {
      $('.btn-hapus').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        
        Swal.fire({
          title: 'Apa Anda Ingin Menghapus Data ini?',
          text: "Data ini akan dihapus secara permanen!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: 'hapus_produksi.php',
              type: 'POST',
              data: { id: id },
              success: function(response) {
                Swal.fire(
                  'Terhapus!',
                  'Data Telah Berhasil Di Hapus.',
                  'success'
                ).then(() => {
                  location.reload(); // Reload halaman setelah data dihapus
                });
              },
              error: function() {
                Swal.fire(
                  'Gagal!',
                  'Terjadi kesalahan saat menghapus data.',
                  'error'
                );
              }
            });
          }
        });
      });
    });
  </script>
</body>
</html>
