<?php
// Panggil file koneksi.php
require_once 'koneksi.php';

// Periksa apakah parameter id ada dalam URL
if (isset($_GET['id'])) {
    // Ambil id penjualan dari parameter GET
    $id_penjualan = $_GET['id'];

    // Query hapus data dari tabel tbl_penjualan
    $sql = "DELETE FROM tbl_penjualan WHERE id_penjualan = $id_penjualan";

    if ($conn->query($sql) === TRUE) {
        // Redirect kembali ke halaman penjualan setelah berhasil menghapus
        header('Location: penjualan.php');
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
