<?php
// Sertakan file koneksi ke database Anda di sini
include '../koneksi/koneksi.php';

// Query untuk mengambil notifikasi terbaru (misalnya, jumlah pesanan yang belum diproses)
$query = "SELECT COUNT(*) AS total_unproses FROM t_pesanan WHERE status = 'Pesanan Menunggu Diproses'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

// Ambil data notifikasi dari hasil query
$row = mysqli_fetch_assoc($result);

// Buat respons dalam format JSON
$response = array(
    'totalUnproses' => $row['total_unproses']
);

// Kembalikan respons dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);

// Tutup koneksi database
mysqli_close($conn);
?>