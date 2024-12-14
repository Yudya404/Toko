<?php
session_start();

include '../koneksi/koneksi.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Ambil nilai rowId dari permintaan POST
    $kode_p = mysqli_real_escape_string($conn, $_POST['kode_p']);
    $status = "Pesanan Diproses";

    // Tentukan zona waktu Anda
    date_default_timezone_set("Asia/Jakarta"); // Ganti "Asia/Jakarta" sesuai dengan zona waktu Anda

    // Ambil tanggal sekarang dengan format yang diinginkan (misalnya, Y-m-d)
    $tgl_input = date("Y-m-d H:i:s");

    // Siapkan statement SQL dengan prepared statement
    $queryUpdateStatus = "UPDATE t_pesanan SET status = 'Pesanan Diproses', tgl_proses = ? WHERE kode_p = ?";

    // Siapkan statement
    $stmt = $conn->prepare($queryUpdateStatus);

    // Bind parameter ke statement
    $stmt->bind_param('ss', $tgl_input, $kode_p);

    // Eksekusi statement
    if ($stmt->execute()) {
        // Beri respons sukses jika update berhasil
        echo json_encode(array('message' => 'Data Pesanan berhasil diproses', 'status' => 'success'));
    } else {
        // Beri respons error jika terjadi kesalahan pada query
        echo json_encode(array('message' => 'Gagal memproses pesanan', 'status' => 'error'));
    }

    // Tutup statement dan koneksi
    $stmt->close();
} else {
    // Beri respons error jika tidak ada data yang diberikan
    echo json_encode(array('message' => 'Gagal memproses pesanan', 'status' => 'error'));
}
?>
