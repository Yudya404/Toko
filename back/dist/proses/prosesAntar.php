<?php
session_start();

include '../koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Ambil nilai rowId dari permintaan POST
    $kode_p = mysqli_real_escape_string($conn, $_POST['kode_p']);
    $status = "Pesanan Dalam Pengiriman";

    // Tentukan zona waktu Anda
    date_default_timezone_set("Asia/Jakarta"); // Ganti "Asia/Jakarta" sesuai dengan zona waktu Anda

    // Ambil tanggal sekarang dengan format yang diinginkan (misalnya, Y-m-d)
    $tgl_input = date("Y-m-d H:i:s");

    // Siapkan statement SQL dengan prepared statement
    $queryUpdateStatus = "UPDATE t_pesanan SET status = 'Pesanan Dalam Pengiriman', tgl_kirim = ? WHERE kode_p = ?";

    // Siapkan statement
    $stmt = $conn->prepare($queryUpdateStatus);

    // Bind parameter ke statement
    $stmt->bind_param('ss', $tgl_input, $kode_p);

    // Eksekusi statement
    if ($stmt->execute()) {
        // Beri respons sukses jika update berhasil
        echo "
            <script>
               alert('Data Pesanan dengan Kode $kode_p berhasil diproses pada tanggal $tgl_input');
               window.location = '../beranda.php';
            </script>
        ";
    } else {
        // Beri respons error jika terjadi kesalahan pada query
        echo "
            <script>
               alert('Data Pesanan dengan Kode $kode_p gagal diproses');
               window.location = '../beranda.php';
            </script>
        ";
    }

    // Tutup statement dan koneksi
    $stmt->close();
} else {
    // Beri respons error jika tidak ada data yang diberikan
    echo "
       <script>
          alert('Data Pesanan dengan Kode $kode_p gagal diproses');
          window.location = '../beranda.php';
       </script>
    ";
}
?>
