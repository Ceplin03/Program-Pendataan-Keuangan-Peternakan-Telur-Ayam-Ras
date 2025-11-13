<?php
// Panggil file koneksi.php
require_once 'koneksi.php';

// Periksa apakah parameter id ada dalam URL
if (isset($_GET['id'])) {
    // Ambil id pengeluaran dari parameter GET
    $id_pengeluaran = $_GET['id'];

    // Query hapus data dari tabel tbl_pengeluaran
    $sql = "DELETE FROM tbl_pengeluaran WHERE id_pengeluaran = $id_pengeluaran";

    if ($conn->query($sql) === TRUE) {
        // Redirect kembali ke halaman pengeluaran setelah berhasil menghapus
        header('Location: pengeluaran.php');
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
