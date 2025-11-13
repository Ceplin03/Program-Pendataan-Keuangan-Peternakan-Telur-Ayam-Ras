 <?php
// Konfigurasi koneksi ke database
$servername = "localhost"; // Ganti dengan nama server database Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "db_telur"; // Ganti dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
session_start(); // Mulai sesi untuk penggunaan $_SESSION

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

// Fungsi untuk membersihkan input
function cleanInput($data) {
    global $conn; // Gunakan koneksi global
    return htmlspecialchars(strip_tags(trim($conn->real_escape_string($data))));
}

// Variabel untuk menampung hasil
$hasil_pencarian = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ambil dan bersihkan nilai dari form
  $tgl_awal = isset($_POST['tgl_awal']) ? cleanInput($_POST['tgl_awal']) : '';
  $tgl_akhir = isset($_POST['tgl_akhir']) ? cleanInput($_POST['tgl_akhir']) : '';
  $tgl_pengeluaran = isset($_POST['tgl_pengeluaran']) ? cleanInput($_POST['tgl_pengeluaran']) : '';

  
  
  // Query untuk menghitung total penjualan dalam rentang tanggal
  $query_penjualan = "SELECT SUM(total_penjualan) AS total_penjualan, id_penjualan 
                      FROM tbl_penjualan 
                      WHERE tgl_penjualan BETWEEN '$tgl_awal' AND '$tgl_akhir'";
  $result_penjualan = $conn->query($query_penjualan);

  if ($result_penjualan) {
      $row_penjualan = $result_penjualan->fetch_assoc();
      $total_penjualan = $row_penjualan['total_penjualan'];
      $id_penjualan = $row_penjualan['id_penjualan'];
  } else {
      $total_penjualan = 0; // Atau sesuaikan dengan penanganan error yang sesuai
      $id_penjualan = 0; // Atau nilai default jika tidak ada hasil
  }

  // Query untuk menghitung total pengeluaran pada tanggal tertentu
  $query_pengeluaran = "SELECT SUM(total_pengeluaran) AS total_pengeluaran, id_pengeluaran 
                      FROM tbl_pengeluaran 
                      WHERE tgl_pengeluaran = '$tgl_pengeluaran'";
  $result_pengeluaran = $conn->query($query_pengeluaran);

  if ($result_pengeluaran) {
      $row_pengeluaran = $result_pengeluaran->fetch_assoc();
      $total_pengeluaran = $row_pengeluaran['total_pengeluaran'];
      $id_pengeluaran = $row_pengeluaran['id_pengeluaran'];
  } else {
      $total_pengeluaran = 0; // Atau sesuaikan dengan penanganan error yang sesuai
      $id_pengeluaran = 0; // Atau nilai default jika tidak ada hasil
  }

  // Hitung total pendapatan
  $total_pendapatan = $total_penjualan - $total_pengeluaran;

  // Tampilkan hasil
  $hasil_pencarian .= "<div class='card'>";
  $hasil_pencarian .= "<div class='card-body'>";
  $hasil_pencarian .= "<h2>Hasil Pencarian</h2>";
  $hasil_pencarian .= "<p>Total Penjualan dari $tgl_awal sampai $tgl_akhir = Rp. $total_penjualan</p>";
  $hasil_pencarian .= "<p>Total pengeluaran pada tanggal $tgl_pengeluaran = Rp. $total_pengeluaran</p>";
  $hasil_pencarian .= "<p>Total Pendapatan = Rp. $total_pendapatan</p>";
  $hasil_pencarian .= "<form method='post'>";
  $hasil_pencarian .= "<input type='hidden' name='id_penjualan' value='$id_penjualan'>";
  $hasil_pencarian .= "<input type='hidden' name='id_pengeluaran' value='$id_pengeluaran'>";
  $hasil_pencarian .= "<input type='hidden' name='tgl_awal' value='$tgl_awal'>";
  $hasil_pencarian .= "<input type='hidden' name='tgl_akhir' value='$tgl_akhir'>";
  $hasil_pencarian .= "<input type='hidden' name='tgl_pengeluaran' value='$tgl_pengeluaran'>";
  $hasil_pencarian .= "<input type='hidden' name='total_penjualan' value='$total_penjualan'>";
  $hasil_pencarian .= "<input type='hidden' name='total_pengeluaran' value='$total_pengeluaran'>";
  $hasil_pencarian .= "<input type='hidden' name='total_pendapatan' value='$total_pendapatan'>";
  $hasil_pencarian .= "<button type='submit' name='simpan' class='btn btn-primary'>Simpan Ke Database</button>";
  $hasil_pencarian .= "</form>";
  $hasil_pencarian .= "</div>";
  $hasil_pencarian .= "</div>";

  // Handle simpan ke database jika tombol Simpan diklik
  if (isset($_POST['simpan'])) {
      // Ambil nilai dari $_POST
      $id_penjualan = cleanInput($_POST['id_penjualan']);
      $id_pengeluaran = cleanInput($_POST['id_pengeluaran']);
      $tgl_awal = cleanInput($_POST['tgl_awal']);
      $tgl_akhir = cleanInput($_POST['tgl_akhir']);
      $tgl_pengeluaran = cleanInput($_POST['tgl_pengeluaran']);
      $total_penjualan = cleanInput($_POST['total_penjualan']);
      $total_pengeluaran = cleanInput($_POST['total_pengeluaran']);
      $total_pendapatan = cleanInput($_POST['total_pendapatan']);

      // Pemeriksaan apakah rentang tanggal sudah ada
$check_query = "SELECT COUNT(*) AS count_data FROM tbl_pendapatan 
WHERE tgl_awal = '$tgl_awal' AND tgl_akhir = '$tgl_akhir' AND tgl_pengeluaran = '$tgl_pengeluaran'";
$result_check = $conn->query($check_query);

if ($result_check) {
$row_check = $result_check->fetch_assoc();
$count_data = $row_check['count_data'];

if ($count_data > 0) {
$hasil_pencarian .= "<div class='alert alert-warning' role='alert'>Data untuk rentang tanggal ini sudah ada di database.</div>";
} else {
// Masukkan data ke dalam tabel tbl_pendapatan
$insert_query = "INSERT INTO tbl_pendapatan (id_pendapatan, id_penjualan, id_pengeluaran, tgl_awal, tgl_akhir, tgl_pengeluaran, total_penjualan, total_pengeluaran, total_pendapatan)
         VALUES (NULL, '$id_penjualan', '$id_pengeluaran', '$tgl_awal', '$tgl_akhir', '$tgl_pengeluaran', '$total_penjualan', '$total_pengeluaran', '$total_pendapatan')";

if ($conn->query($insert_query) === TRUE) {
// Pesan jika berhasil disimpan
$hasil_pencarian .= "<div class='alert alert-success' role='alert'>Data berhasil disimpan ke database.</div>";
} else {
// Pesan jika terjadi kesalahan
$hasil_pencarian .= "<div class='alert alert-danger' role='alert'>Error: " . $conn->error . "</div>";
}
}
} else {
$hasil_pencarian .= "<div class='alert alert-danger' role='alert'>Error: " . $conn->error . "</div>";
}

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
  <!-- CSS -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav>
  <?php include "sidebar.php";?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pendapatan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Pendapatan</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <form action="" method="POST">
                <h3>Cari Data Penjualan </h3>
                <label for="tgl_awal">Tanggal Awal:</label>
                <input type="date" id="tgl_awal" name="tgl_awal" class="form-control" required>
                <label for="tgl_akhir">Tanggal Akhir:</label>
                <input type="date" id="tgl_akhir" name="tgl_akhir" class="form-control" required>
                <br><br>
                <h3>Cari Data pengeluaran </h3>
                <label for="tgl_pengeluaran">Tanggal pengeluaran:</label>
                <input type="date" id="tgl_pengeluaran" name="tgl_pengeluaran" class="form-control" required>
                <br><br>
                <input type="submit" class="btn btn-info" value="Cari">
                
              </form><br>
              
            </div>
          </div>
          <!-- Tempat untuk menampilkan hasil pencarian -->
          <div class="col-md-6">
            <?php echo $hasil_pencarian; ?>
          </div>

          <?php
// Panggil file koneksi.php
require_once 'koneksi.php';


$sql = "SELECT id_pendapatan, id_penjualan, id_pengeluaran, tgl_awal, tgl_akhir, tgl_pengeluaran, total_penjualan
, total_pengeluaran, total_pendapatan FROM tbl_pendapatan";
$result = $conn->query($sql);

// Inisialisasi variabel untuk menampung baris data
$rows = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Masukkan data ke dalam array $rows
        $rows[] = $row;
    }
}

// Tutup koneksi database
$conn->close();
?>
<div class="col-12">
<div class="card">
  <div class="card-body">
  <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4"><div class="row"><div class="col-sm-12 col-md-6"></div></div><div class="row"><div class="col-sm-12"><table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                        <thead>
                            <tr>
                              <th>ID Pendapatan</th>
                                <th>Tanggal Awal</th>
                                <th>Tanggal Akhir</th>
                                <th>Tanggal pengeluaran</th>
                                <th>Total Penjualan</th>
                                <th>Total pengeluaran</th>
                                <th>Total Pendapatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row) : ?>
                                <tr>
                                <td><?php echo $row['id_pendapatan']; ?></td>
                                    <td><?php echo $row['tgl_awal']; ?></td>
                                    <td><?php echo $row['tgl_akhir']; ?></td>
                                    <td><?php echo $row['tgl_pengeluaran']; ?></td>
                                    <td>Rp. <?php echo number_format($row['total_penjualan'], 2); ?></td>
                                    <td>Rp. <?php echo number_format($row['total_pengeluaran'], 2); ?></td>
                                    <td>Rp. <?php echo number_format($row['total_pendapatan'], 2); ?></td>
                                    <td>
                                    <a href="hapus_pendapatan.php?id=<?php echo $row['id_pendapatan']; ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini?');"><i class="fas fa-times"></i> Hapus </a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        </tfoot>
                        </table></div></div></div>
  </div>
</div>



</div>
        </div>
      </div>
    </div>
  </div>
  <aside class="control-sidebar control-sidebar-dark">
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
</div>
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
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

<script src="plugins/chart.js/Chart.min.js"></script>
<script src="dist/js/pages/dashboard3.js"></script>

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
