<?php
session_start(); // Pastikan session sudah dimulai

include '../koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_cus = $_SESSION['kode_cus']; // Tidak perlu di-escape karena ini dari session
    $kode_produk = mysqli_real_escape_string($conn, $_POST['kode_produk']);
    $kode_p = mysqli_real_escape_string($conn, $_POST['kode_p']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

    date_default_timezone_set("Asia/Jakarta");
    $tgl_input = date("Y-m-d H:i:s");

    $status_rating = "Sudah Dinilai";

    // Buat kode_rating unik dengan menggabungkan beberapa kode
    $kode_rating = "L" . "-" . $kode_produk . "-" . $kode_p . "-" . $kode_cus;

    // Gunakan prepared statement untuk menghindari SQL Injection
    $query_insert_rating = "INSERT INTO rating (kode_rating, kode_produk, kode_p, kode_cus, rating, komentar, tgl_input, status_rating) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query_insert_rating);

    mysqli_stmt_bind_param($stmt, "ssssssss", $kode_rating, $kode_produk, $kode_p, $kode_cus, $rating, $komentar, $tgl_input, $status_rating);

    if (mysqli_stmt_execute($stmt)) {
        // Update status pesanan menjadi 'pesanan selesai'
        $query_update_pesanan = "UPDATE t_pesanan SET status = 'Pesanan Selesai', tgl_selesai = ? WHERE kode_p = ?";
        $tgl_selesai = $tgl_input; // Gunakan tgl_input sebagai tgl_selesai
        $stmt_update_pesanan = mysqli_prepare($conn, $query_update_pesanan);
        mysqli_stmt_bind_param($stmt_update_pesanan, "ss", $tgl_selesai, $kode_p);
        mysqli_stmt_execute($stmt_update_pesanan);
        
        echo '<script>alert("Rating dan Ulasan Anda berhasil disimpan, Terimakasih Telah Melakukan Pemesanan.");</script>';
        echo '<script>window.location.replace("../riwayat_belanja.php");</script>';
    } else {
        echo '<script>alert("Rating dan Ulasan Anda gagal disimpan, Silahkan Coba Lagi");</script>';
        echo '<script>window.location.replace("../riwayat_belanja.php");</script>';
    }

    mysqli_stmt_close($stmt);
} else {
    header('Location: ../riwayat_belanja.php');
    exit();
}
?>
