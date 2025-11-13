<?php
require_once 'koneksi.php';
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $sql = "DELETE FROM tbl_produksi WHERE id_produksi = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo "Data berhasil dihapus.";
        } else {
            echo "Gagal menghapus data.";
        }

        $stmt->close();
    }
}

$conn->close();
?>
