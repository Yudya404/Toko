<?php
session_start();

include '../koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Data dari form edit kontak
    $kode_c = mysqli_real_escape_string($conn, $_POST['contact_id']);
    $nama 	= mysqli_real_escape_string($conn, $_POST['contact_nama']);
    $isi 	= mysqli_real_escape_string($conn, $_POST['contact_isi']);

    // Tentukan zona waktu Anda
    date_default_timezone_set("Asia/Jakarta"); // Ganti "Asia/Jakarta" sesuai dengan zona waktu Anda

    // Ambil tanggal sekarang dengan format yang diinginkan (misalnya, Y-m-d)
    $tgl_input = date("Y-m-d");

    // Jika gambar tidak diupload, lakukan proses update data tanpa mengubah gambar
    $sql = "UPDATE kontak SET nama=?, isi=? WHERE kode_c=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $nama, $isi, $kode_c);

    if (mysqli_stmt_execute($stmt)) {
        echo "
            <script>
            alert('Data dengan Kode $kode_c berhasil diubah pada tanggal $tgl_input');
            window.location = '../contact.php';
            </script>
        ";
    } else {
        $errorMessage = mysqli_error($conn);
        echo "
           <script>
             alert('Mohon Cek Kembali Data Yang Anda Masukkan! Pesan Kesalahan: $errorMessage');
             window.location = '../edit_contact.php?kode=" . $kode_c . "';
           </script>
        ";
    }

    mysqli_stmt_close($stmt);
    $conn->close();
}
?>
