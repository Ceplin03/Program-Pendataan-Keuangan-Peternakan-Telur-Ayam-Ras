<?php
session_start(); // Mulai sesi untuk penggunaan $_SESSION

$host = 'localhost'; // Ganti dengan host database Anda
$dbname = 'db_telur'; // Ganti dengan nama database Anda
$username = 'root'; // Ganti dengan username database Anda
$password = ''; // Ganti dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

$id_user = $_GET['id'];

$sql = "DELETE FROM tbl_user WHERE id_user = :id_user";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_user' => $id_user]);

header('Location: user.php');
exit;
?>