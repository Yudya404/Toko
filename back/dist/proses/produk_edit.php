<?php
session_start();

include '../koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Data dari form edit user
    $kode_produk	= mysqli_real_escape_string($conn, $_POST['produk_id']);
    $nama 			= mysqli_real_escape_string($conn, $_POST['produk_nama']);
    $harga 			= mysqli_real_escape_string($conn, $_POST['produk_harga']);
    $stok 			= mysqli_real_escape_string($conn, $_POST['produk_stok']);
    $satuan 		= mysqli_real_escape_string($conn, $_POST['produk_satuan']);
	$deskripsi 		= mysqli_real_escape_string($conn, $_POST['produk_deskripsi']);
    $tgl_exp 		= mysqli_real_escape_string($conn, $_POST['produk_exp']);

    // Tentukan zona waktu Anda
    date_default_timezone_set("Asia/Jakarta"); // Ganti "Asia/Jakarta" sesuai dengan zona waktu Anda

    // Ambil tanggal sekarang dengan format yang diinginkan (misalnya, Y-m-d)
    $tgl_input = date("Y-m-d");

    // Data upload gambar
    $targetDir = "../upload/fotoProduk/";
    $targetFile = $targetDir . basename($_FILES["avatar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // ... (validasi gambar seperti yang sudah Anda berikan)

    // Jika gambar diupload, lakukan proses upload dan update data
    if (!empty($_FILES["avatar"]["name"])) {
        if ($uploadOk == 0) {
            $errorMessage = mysqli_error($conn);
			echo "
                <script>
                  alert('Maaf, file tidak berhasil diunggah.! Pesan Kesalahan: $errorMessage');
                  window.location = '../edit_produk.php?kode=" . $kode_produk . "';
                </script>
              ";
        } else {
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFile)) {
                // File berhasil diunggah, lakukan proses update data
                $sql = "UPDATE produk SET nama=?, harga=?, stok=?, satuan=?, deskripsi=?, tgl_exp=?, foto_produk=? WHERE kode_produk=?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ssssssss", $nama, $harga, $stok, $satuan, $deskripsi, $tgl_exp, $targetFile, $kode_produk);

                if (mysqli_stmt_execute($stmt)) {
                    echo "
                        <script>
                        alert('Data Anda dengan $kode_produk berhasil diubah pada tanggal $tgl_input');
                        window.location = '../produk.php';
                        </script>
                    ";
                } else {
                    $errorMessage = mysqli_error($conn);
                    echo "
                        <script>
                        alert('Mohon Cek Kembali Data Yang Anda Masukkan! Pesan Kesalahan: $errorMessage');
                        window.location = '../edit_produk.php?kode=" . $kode_produk . "';
                        </script>
                    ";
                }

                mysqli_stmt_close($stmt);
            } else {
                $errorMessage = mysqli_error($conn);
                echo "
                   <script>
                    alert('Maaf, terjadi kesalahan saat mengunggah file Pesan Kesalahan: $errorMessage');
                    window.location = '../edit_produk.php?kode=" . $kode_produk . "';
                   </script>
                  ";
            }
        }
    } else {
        // Jika gambar tidak diupload, lakukan proses update data tanpa mengubah foto
        $sql = "UPDATE produk SET nama=?, harga=?, stok=?, satuan=?, deskripsi=?, tgl_exp=? WHERE kode_produk=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $nama, $harga, $stok, $satuan, $deskripsi, $tgl_exp, $kode_produk);

        if (mysqli_stmt_execute($stmt)) {
            echo "
               <script>
                 alert('Data Anda dengan $kode_produk berhasil diubah pada tanggal $tgl_input');
                 window.location = '../produk.php';
               </script>
             ";
        } else {
            $errorMessage = mysqli_error($conn);
            echo "
               <script>
                 alert('Mohon Cek Kembali Data Yang Anda Masukkan! Pesan Kesalahan: $errorMessage');
                 window.location = '../edit_produk.php?kode=" . $kode_produk . "';
               </script>
            ";
        }

        mysqli_stmt_close($stmt);
    }

    $conn->close();
}
?>