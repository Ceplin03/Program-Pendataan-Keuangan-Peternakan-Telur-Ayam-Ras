<?php
// Panggil file koneksi.php
require_once 'koneksi.php';

// Periksa apakah parameter id ada dalam URL
if (isset($_GET['id'])) {
    // Ambil id penjualan dari parameter GET
    $id_pendapatan = $_GET['id'];

    // Query hapus data dari tabel tbl_pendapatan
    $sql = "DELETE FROM tbl_pendapatan WHERE id_pendapatan = $id_pendapatan";

    if ($conn->query($sql) === TRUE) {
        // Redirect kembali ke halaman penjualan setelah berhasil menghapus
        header('Location: pendapatan.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ID tidak ditemukan.";
}

// Tutup koneksi database
$conn->close();
?>
