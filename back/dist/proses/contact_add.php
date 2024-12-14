<?php
session_start();

include '../koneksi/koneksi.php';

$nama	= mysqli_real_escape_string($conn, $_POST["contact_nama"]);
$isi	= mysqli_real_escape_string($conn, $_POST["contact_isi"]);

// Tentukan zona waktu Anda
date_default_timezone_set("Asia/Jakarta"); // Ganti "Asia/Jakarta" sesuai dengan zona waktu Anda

// Ambil tanggal sekarang dengan format yang diinginkan (misalnya, Y-m-d H:i:s)
$tgl_input = date("Y-m-d H:i:s");

// Query untuk mendapatkan kode_c terakhir dari tabel kontak
$queryGetLastCode = "SELECT kode_c FROM kontak ORDER BY kode_c DESC LIMIT 1";
$result = $conn->query($queryGetLastCode);

if ($result) {
    $data = $result->fetch_assoc();

    // Mendapatkan kode_c berikutnya berdasarkan data terakhir atau membuat "K001" jika belum ada data
    if ($data) {
        $lastCode = $data['kode_c'];
        $num = (int)substr($lastCode, 1) + 1;
    } else {
        $num = 1;
    }

    $kode_c = "K" . str_pad($num, 3, '0', STR_PAD_LEFT);

    // Persiapkan pernyataan SQL untuk insert
    $queryInsert = "INSERT INTO kontak (kode_c, nama, isi, tgl_input) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($queryInsert);
    $stmt->bind_param("ssss", $kode_c, $nama, $isi, $tgl_input);

    // Mengeksekusi pernyataan SQL
    if ($stmt->execute()) {
        // Jika berhasil disimpan
        echo "
            <script>
            alert('Data anda dengan Kode $kode_c berhasil disimpan pada tanggal $tgl_input');
            window.location = '../contact.php';
            </script>
            ";
    } else {
        // Jika terjadi error
        echo "Error: " . $stmt->error;
    }

    // Menutup statement
    $stmt->close();
} else {
    // Jika terjadi error saat mengambil kode_c terakhir
    echo "Error: " . $conn->error;
}

// Menutup koneksi
$conn->close();
?>
