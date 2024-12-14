<?php
session_start();

include '../koneksi/koneksi.php';

// Tentukan zona waktu Anda
date_default_timezone_set("Asia/Jakarta"); // Ganti "Asia/Jakarta" sesuai dengan zona waktu Anda

// Ambil tanggal sekarang dengan format yang diinginkan (misalnya, Y-m-d H:i:s)
$tgl_input = date("Y-m-d H:i:s");

// Kode PHP untuk menyimpan respon dan mengubah status ulasan
if (isset($_POST['submit'])) {
    // Ambil data dari form respon
    $kode_ulasan = mysqli_real_escape_string($conn, $_POST['kode_ulasan']);
    $isi_respon = mysqli_real_escape_string($conn, $_POST['isi_respon']);

    // Persiapkan pernyataan SQL untuk menyimpan data respon
    $query_respon = "INSERT INTO respons (kode_respons, kode_ulasan, isi_respon, status) VALUES (NULL, ?, ?, 'sudah')";
    $stmt_respon = $conn->prepare($query_respon);
    $stmt_respon->bind_param("ss", $kode_ulasan, $isi_respon);

    // Persiapkan pernyataan SQL untuk mengubah status ulasan
    $query_ubah_status = "UPDATE ulasan SET status = 'sudah' WHERE kode_ulasan = ?";
    $stmt_ubah_status = $conn->prepare($query_ubah_status);
    $stmt_ubah_status->bind_param("s", $kode_ulasan);

    // Eksekusi pernyataan SQL untuk menyimpan respon
    if ($stmt_respon->execute()) {
        // Eksekusi pernyataan SQL untuk mengubah status ulasan
        if ($stmt_ubah_status->execute()) {
            // Jika penyimpanan dan pembaruan berhasil, lakukan sesuatu (misalnya tampilkan pesan sukses)
            echo "Respon berhasil disimpan, dan status ulasan berhasil diubah menjadi 'Sudah'.";
        } else {
            // Jika ada kesalahan saat mengubah status ulasan
            echo "Terjadi kesalahan saat mengubah status ulasan.";
        }
    } else {
        // Jika ada kesalahan saat menyimpan respon
        echo "Terjadi kesalahan saat menyimpan respon.";
    }

    // Tutup pernyataan
    $stmt_respon->close();
    $stmt_ubah_status->close();
}

?>