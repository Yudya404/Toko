<?php
include '../koneksi/koneksi.php';

$nama		= mysqli_real_escape_string($conn, $_POST["nama"]);
$email		= mysqli_real_escape_string($conn, $_POST["email"]);
$no_telp	= mysqli_real_escape_string($conn, $_POST["no_telp"]);
$alamat		= mysqli_real_escape_string($conn, $_POST["alamat"]);
$isi_pesan	= mysqli_real_escape_string($conn, $_POST["isi_pesan"]);

// Tentukan zona waktu Anda
date_default_timezone_set("Asia/Jakarta"); // Ganti "Asia/Jakarta" sesuai dengan zona waktu Anda

// Ambil tanggal sekarang dengan format yang diinginkan (misalnya, Y-m-d H:i:s)
$tgl_input = date("Y-m-d H:i:s");

// Query untuk mendapatkan kode_ulasan terakhir dari tabel ulasan
$kode = mysqli_query($conn, "SELECT kode_ulasan FROM ulasan ORDER BY kode_ulasan DESC");
$data = mysqli_fetch_assoc($kode);

// Mendapatkan kode_ulasan berikutnya berdasarkan data terakhir atau membuat "KS001" jika belum ada data
if ($data) {
    $num = substr($data['kode_ulasan'], 1);
    $add = (int) $num + 1;
} else {
    $add = 1;
}

$num = 1;
$kode_ulasan = "KS" . str_pad($num, 3, '0', STR_PAD_LEFT);

// Periksa apakah kode ulasan sudah ada di tabel
$cek_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM ulasan WHERE kode_ulasan = '$kode_ulasan'");
$result = mysqli_fetch_assoc($cek_query);
$count = $result['count'];

while ($count > 0) {
    // Jika kode ulasan sudah ada, tambahkan nomor urutan dan cek lagi
    $num++;
    $kode_ulasan = "KS" . str_pad($num, 3, '0', STR_PAD_LEFT);
    $cek_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM ulasan WHERE kode_ulasan = '$kode_ulasan'");
    $result = mysqli_fetch_assoc($cek_query);
    $count = $result['count'];
}

// Menghindari serangan SQL Injection menggunakan prepared statement
$stmt = $conn->prepare("INSERT INTO ulasan (kode_ulasan, nama, email, no_telp, alamat, isi_pesan, tgl_ulasan, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$status = "Belum Direspon"; // Tambahkan variabel status dengan nilai "Belum Direspon"
$stmt->bind_param("ssssssss", $kode_ulasan, $nama, $email, $no_telp, $alamat, $isi_pesan, $tgl_input, $status);

// Mengeksekusi pernyataan SQL
if ($stmt->execute()) {
    // Jika berhasil disimpan
    echo "
		<script>
		alert('Pesan Anda berhasil dikirim dengan Kode $kode_ulasan pada tanggal $tgl_input');
		window.location = '../contact.php';
		</script>
		";
} else {
    // Jika terjadi error
    echo "Error: " . $conn->error;
}

// Menutup statement
$stmt->close();
?>
