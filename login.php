<?php
include 'koneksi.php';

// Inisialisasi pesan error
$error = '';

// Periksa apakah pengguna sudah login, jika iya arahkan ke halaman index
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $query = "SELECT * FROM tbl_user WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Mulai sesi dan simpan data pengguna
        session_start();
        $_SESSION['username'] = $username;

        // Redirect ke halaman indeks setelah login berhasil
        // header("Location: index.php");
        echo "<script>
                alert('Login berhasil!');
                window.location.href = 'index.php'; // Kembali ke halaman login.php
              </script>";
        
    } else {
      echo "<script>
      alert('Login Gagal, Periksa Kembali Username dan Passwordnya!');
      window.location.href = 'login.php'; // Kembali ke halaman login.php
    </script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Program Pendataan Keuangan | Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  
  <style>
    /* CSS untuk membuat gambar transparan dan menempatkannya di belakang */
    .login-page {
      position: relative; /* Untuk posisi relatif pada body */
      z-index: 1; /* Indeks z agar konten form login tetap di atas */
    }
    .login-logo img {
      opacity: 0.5; /* Mengatur tingkat kejernihan gambar */
      position: absolute; /* Posisi absolut untuk gambar */
      top: 50%; /* Posisi vertikal tepat di tengah */
      left: 50%; /* Posisi horizontal tepat di tengah */
      transform: translate(-50%, -50%); /* Membuat gambar tepat berada di tengah */
      z-index: 0; /* Indeks z agar berada di belakang */
    }
    .login-box {
      z-index: 1; /* Indeks z agar kotak login tetap di atas gambar */
    }
  </style>
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a class="h5"><b>TELUR AYAM RAS </b>MUNTI</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Silahkan Masuk Untuk Melanjutkan Sesi!</p>

        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Masukkan Username" name="username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Masukkan Password" name="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>

          <div class="form-check-container">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="radio1" id="admin">
        <label class="form-check-label" for="admin">Admin</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="radio1" id="karyawan">
        <label class="form-check-label" for="karyawan">Karyawan</label>
      </div>
    </div>
    <style>
    .form-check-container {
      display: flex;
      align-items: center;
    }
    .form-check {
      margin-right: 15px; /* Atur jarak antar elemen */
    }
  </style>
  <br>

          <div class="row">
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block" value="login">Masuk</button>
            </div>
          </div>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- Logo -->
  <div class="login-logo">
    <img src="logo1.jpg" alt="">
  </div>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
</body>
</html>
