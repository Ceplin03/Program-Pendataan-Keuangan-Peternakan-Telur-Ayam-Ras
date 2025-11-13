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

// Inisialisasi variabel untuk menampung baris data
$rows = array();
$total_pendapatan_tahunan = 0;
$data_found = false; // Tambahkan variabel untuk mengecek data
$tahun = ''; // Inisialisasi variabel tahun

// Periksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tahun'])) {
    $tahun = $_POST['tahun'];

    // Loop untuk setiap bulan dalam tahun yang dipilih
    for ($bulan = 1; $bulan <= 12; $bulan++) {
        $bulan_str = str_pad($bulan, 2, '0', STR_PAD_LEFT); // Format bulan menjadi 'MM'
        $start_date = $tahun . '-' . $bulan_str . '-01'; // Tanggal awal bulan
        $end_date = date('Y-m-t', strtotime($start_date)); // Tanggal akhir bulan

        // Query untuk mengambil data dari tabel tbl_pendapatan sesuai bulan yang dipilih
        $sql = "SELECT id_pendapatan, id_penjualan, id_pengeluaran, tgl_awal, tgl_akhir, tgl_pengeluaran, total_penjualan, total_pengeluaran, total_pendapatan 
                FROM tbl_pendapatan 
                WHERE tgl_awal >= ? AND tgl_akhir <= ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();

        $total_penjualan_bulanan = 0;
        $total_pengeluaran_bulanan = 0;
        $total_pendapatan_bulanan = 0;

        if ($result->num_rows > 0) {
            $data_found = true; // Set variabel ke true jika data ditemukan
            while ($row = $result->fetch_assoc()) {
                // Masukkan data ke dalam array $rows
                $rows[] = $row;
                // Hitung total pendapatan bulan ini
                $total_penjualan_bulanan += $row['total_penjualan'];
                $total_pengeluaran_bulanan += $row['total_pengeluaran'];
                $total_pendapatan_bulanan += $row['total_pendapatan'];
            }
            // Tambah total pendapatan tahunan
            $total_pendapatan_tahunan += $total_pendapatan_bulanan;
        }
        $stmt->close();
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
  <style>
    @media print {
      .no-print {
        display: none;
      }
    }
  </style>
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
            <h1 class="m-0">Laporan Tahunan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Laporan Tahunan</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
        <div class="col-12">
          <div class="card no-print">
            <div class="card-body">
              <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label for="tahun">Pilih tahun:</label>
                <input type="text" id="tahun" name="tahun" placeholder="Masukkan Tahun" pattern="\d{4}" title="Masukkan tahun dalam format YYYY" required>
                <br><br>
                <input type="submit" value="Cari" class="btn btn-primary">
              </form>
            </div>
          </div>

          <div class="card">
            <div class="card-body">
                <center>
            <h1>PETERNAKAN TELUR AYAM RAS MUNTI</h1>

            <div class="report-info">
                <p class="p1">Jl. Padang-Bukittinggi Km 48, Nagari Kapalo Hilalang, Kec 2 x 11 Kayutanam (25584)</p>
            </div>
            <hr><h5>Laporan Data Keuangan Tahunan</h5><hr></center>
              <table class="table">
                <thead>
                  <tr>
                    <th>Bulan</th>
                    <th>Total Penjualan</th>
                    <th>Total Pengeluaran</th>
                    <th>Total Pendapatan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $months = array(
                    "01" => "Januari", "02" => "Februari", "03" => "Maret",
                    "04" => "April", "05" => "Mei", "06" => "Juni",
                    "07" => "Juli", "08" => "Agustus", "09" => "September",
                    "10" => "Oktober", "11" => "November", "12" => "Desember"
                  );

                  $has_data = false; // Flag untuk mengecek apakah ada data

                  foreach ($months as $month_num => $month_name) {
                      $total_penjualan_bulanan = 0;
                      $total_pengeluaran_bulanan = 0;
                      $total_pendapatan_bulanan = 0;

                      foreach ($rows as $row) {
                          $row_month = date('m', strtotime($row['tgl_awal']));
                          if ($row_month == $month_num) {
                              $has_data = true; // Data ditemukan
                              $total_penjualan_bulanan += $row['total_penjualan'];
                              $total_pengeluaran_bulanan += $row['total_pengeluaran'];
                              $total_pendapatan_bulanan += $row['total_pendapatan'];
                          }
                      }

                      if ($total_penjualan_bulanan > 0 || $total_pengeluaran_bulanan > 0 || $total_pendapatan_bulanan > 0) {
                          echo "<tr>";
                          echo "<td>$month_name</td>";
                          echo "<td>Rp. " . number_format($total_penjualan_bulanan, 2) . "</td>";
                          echo "<td>Rp. " . number_format($total_pengeluaran_bulanan, 2) . "</td>";
                          echo "<td>Rp. " . number_format($total_pendapatan_bulanan, 2) . "</td>";
                          echo "</tr>";
                      }
                  }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                  <td colspan="3" class="text-right">Total Pendapatan Tahun <?php echo htmlspecialchars($tahun); ?>:</td>
                    <td>Rp. <?php echo number_format($total_pendapatan_tahunan, 2); ?></td>
                  </tr>
                  
                </tfoot>
              </table><br><br>
              
              <p class="cad">Kapalo Hilalang</p>
              <br><br>
              <p class="cad1">(Irlentuti)</p>
              <style>
                .cad {
                  text-align: right;
                  padding-right: 80px;
                  margin-top: 20px;
                }
                .cad1 {
                  text-align: right;
                  padding-right: 100px;
                  margin-top: 20px;
                }
              </style>
              
              
              

              
              <a href="javascript:void(0);" class="btn btn-info no-print" onclick="window.print();">Print</a>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>

</div>

<!-- REQUIRED SCRIPTS -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
<script src="dist/js/adminlte.min.js"></script>

<script>
  $(function () {
    $("#example1").DataTable().buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
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

  // JavaScript untuk menampilkan alert jika tidak ada data
  <?php if (!$data_found && $_SERVER["REQUEST_METHOD"] == "POST"): ?>
    alert("Tidak ada data dalam rentang tahun tersebut.");
  <?php endif; ?>
</script>
</body>
</html>
