<?php
// Panggil file koneksi.php
require_once 'koneksi.php';

// Inisialisasi variabel untuk pesan status
$status = '';

// Ambil id produksi dari parameter GET
if (!isset($_GET['id'])) {
    die("ID Produksi tidak ditemukan.");
}

$id_produksi = $_GET['id'];

// Query untuk mengambil data produksi berdasarkan id
$sql = "SELECT * FROM tbl_produksi WHERE id_produksi = '$id_produksi'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Ambil nilai dari database untuk diisi ke form
    $tgl_produksi = $row['tgl_produksi'];
    $jml_telur = $row['jml_telur'];
    $tbakso = $row['tbakso'];
    $tmk = $row['tmk'];
    $ts = $row['ts'];
} else {
    die("Data produksi tidak ditemukan.");
}

// Proses form jika ada data yang disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil nilai dari form
    $tgl_produksi = $_POST['tgl_produksi'];
    $jml_telur = $_POST['jml_telur'];
    $tbakso = $_POST['tbakso'];
    $tmk = $_POST['tmk'];
    $ts = $_POST['ts'];

    // Update data ke dalam database
    $sql_update = "UPDATE tbl_produksi SET tgl_produksi = '$tgl_produksi', jml_telur = '$jml_telur', tbakso = '$tbakso', tmk = '$tmk', ts = '$ts' WHERE id_produksi = '$id_produksi'";

    if ($conn->query($sql_update) === TRUE) {
        $status = 'Data berhasil diupdate';
    } else {
        $status = 'Error: ' . $sql_update . '<br>' . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Produksi Telur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Produksi Telur</h2>
        <?php if (!empty($status)): ?>
            <div class="alert alert-success"><?php echo $status; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="tgl_produksi">Tanggal Produksi:</label>
                <input type="date" class="form-control" id="tgl_produksi" name="tgl_produksi" value="<?php echo $tgl_produksi; ?>" required>
            </div>
            <div class="form-group">
                <label for="jml_telur">Jumlah Telur:</label>
                <input type="number" class="form-control" id="jml_telur" name="jml_telur" value="<?php echo $jml_telur; ?>" required>
            </div>
            <div class="form-group">
                <label for="tbakso">Telur Bakso:</label>
                <input type="number" class="form-control" id="tbakso" name="tbakso" value="<?php echo $tbakso; ?>" required>
            </div>
            <div class="form-group">
                <label for="tmk">Telur Menengah Kecil:</label>
                <input type="number" class="form-control" id="tmk" name="tmk" value="<?php echo $tmk; ?>" required>
            </div>
            <div class="form-group">
                <label for="ts">Telur Standar:</label>
                <input type="number" class="form-control" id="ts" name="ts" value="<?php echo $ts; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="produksi.php" class="btn btn-danger">Kembali</a>
        </form>
    </div>
</body>
</html>
