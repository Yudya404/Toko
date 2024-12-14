<?php
session_start();

include '../koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Data dari form edit user
    $kode_a = mysqli_real_escape_string($conn, $_POST['about_id']);
    $nama	= mysqli_real_escape_string($conn, $_POST['about_nama']);

    // Tentukan zona waktu Anda
    date_default_timezone_set("Asia/Jakarta"); // Ganti "Asia/Jakarta" sesuai dengan zona waktu Anda

    // Ambil tanggal sekarang dengan format yang diinginkan (misalnya, Y-m-d)
    $tgl_input = date("Y-m-d");

    // Data upload gambar
    $targetDir = "../upload/gambarAbout/";
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
                  window.location = '../edit_about.php?kode=" . $kode_a . "';
                </script>
              ";
        } else {
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFile)) {
                // File berhasil diunggah, lakukan proses update data
                $sql = "UPDATE about SET nama=?, gambar_a=? WHERE kode_a=?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sss", $nama, $targetFile, $kode_a);

                if (mysqli_stmt_execute($stmt)) {
                    echo "
                        <script>
                        alert('Data Anda dengan $kode_a berhasil diubah pada tanggal $tgl_input');
                        window.location = '../about.php';
                        </script>
                    ";
                } else {
                    $errorMessage = mysqli_error($conn);
                    echo "
                        <script>
                        alert('Mohon Cek Kembali Data Yang Anda Masukkan! Pesan Kesalahan: $errorMessage');
                        window.location = '../edit_about.php?kode=" . $kode_a . "';
                        </script>
                    ";
                }

                mysqli_stmt_close($stmt);
            } else {
                $errorMessage = mysqli_error($conn);
                echo "
                   <script>
                    alert('Maaf, terjadi kesalahan saat mengunggah file Pesan Kesalahan: $errorMessage');
                    window.location = '../edit_about.php?kode=" . $kode_a . "';
                   </script>
                  ";
            }
        }
    } else {
        // Jika gambar tidak diupload, lakukan proses update data tanpa mengubah foto
        $sql = "UPDATE about SET nama=? WHERE kode_a=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $nama, $kode_a);

        if (mysqli_stmt_execute($stmt)) {
            echo "
               <script>
                 alert('Data Anda dengan $kode_a berhasil diubah pada tanggal $tgl_input');
                 window.location = '../about.php';
               </script>
             ";
        } else {
            $errorMessage = mysqli_error($conn);
            echo "
               <script>
                 alert('Mohon Cek Kembali Data Yang Anda Masukkan! Pesan Kesalahan: $errorMessage');
                 window.location = '../edit_about.php?kode=" . $kode_a . "';
               </script>
            ";
        }

        mysqli_stmt_close($stmt);
    }

    $conn->close();
}
?>
