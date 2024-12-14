<?php
$servername = "localhost"; // Ubah ini jika server MySQL Anda berjalan di lokasi lain
$username = "root"; // Ganti dengan nama pengguna MySQL Anda
$password = ""; // Ganti dengan kata sandi MySQL Anda
$dbname = "ecommerce"; // Ganti dengan nama database yang telah Anda buat di PhpMyAdmin

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
