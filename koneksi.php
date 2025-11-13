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

// Jika ingin menggunakan karakter set UTF-8 (opsional)
// $conn->set_charset("utf8");

// Untuk keamanan, disarankan menggunakan prepared statement
// Contoh penggunaan:
// $stmt = $conn->prepare("SELECT * FROM table_name WHERE id = ?");
// $stmt->bind_param("i", $id);
// $stmt->execute();
// $result = $stmt->get_result();
// while ($row = $result->fetch_assoc()) {
//     // Lakukan sesuatu dengan data
// }

?>
