<?php
session_start();

include '../koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Data dari form edit user
    $kode_user		= mysqli_real_escape_string($conn, $_POST['user_id']);
    $nama			= mysqli_real_escape_string($conn, $_POST['user_nama']);
    $no_telp 		= mysqli_real_escape_string($conn, $_POST['user_telp']);
    $alamat			= mysqli_real_escape_string($conn, $_POST['user_alamat']);
    $kategori_user	= mysqli_real_escape_string($conn, $_POST['user_role']);

    // Tentukan zona waktu Anda
    date_default_timezone_set("Asia/Jakarta"); // Ganti "Asia/Jakarta" sesuai dengan zona waktu Anda

    // Ambil tanggal sekarang dengan format yang diinginkan (misalnya, Y-m-d)
    $tgl_input = date("Y-m-d");

    // Data upload gambar
    $targetDir = "../upload/fotoUser/";
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
                  window.location = '../edit_profile_user.php?kode=" . $kode_user . "';
                </script>
              ";
        } else {
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFile)) {
                // File berhasil diunggah, lakukan proses update data
                $sql = "UPDATE user SET nama=?, no_telp=?, alamat=?, kategori_user=?, foto_user=? WHERE kode_user=?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ssssss", $nama, $no_telp, $alamat, $kategori_user, $targetFile, $kode_user);

                if (mysqli_stmt_execute($stmt)) {
                    echo "
                        <script>
                        alert('Data Anda dengan $kode_user berhasil diubah pada tanggal $tgl_input');
                        window.location = '../user.php';
                        </script>
                    ";
                } else {
                    $errorMessage = mysqli_error($conn);
                    echo "
                        <script>
                        alert('Mohon Cek Kembali Data Yang Anda Masukkan! Pesan Kesalahan: $errorMessage');
                        window.location = '../edit_profile_user.php?kode=" . $kode_user . "';
                        </script>
                    ";
                }

                mysqli_stmt_close($stmt);
            } else {
                $errorMessage = mysqli_error($conn);
                echo "
                   <script>
                    alert('Maaf, terjadi kesalahan saat mengunggah file Pesan Kesalahan: $errorMessage');
                    window.location = '../edit_profile_user.php?kode=" . $kode_user . "';
                   </script>
                  ";
            }
        }
    } else {
        // Jika gambar tidak diupload, lakukan proses update data tanpa mengubah foto
        $sql = "UPDATE user SET nama=?, no_telp=?, alamat=?, kategori_user=? WHERE kode_user=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $nama, $no_telp, $alamat, $kategori_user, $kode_user);

        if (mysqli_stmt_execute($stmt)) {
            echo "
               <script>
                 alert('Data Anda dengan $kode_user berhasil diubah pada tanggal $tgl_input');
                 window.location = '../user.php';
               </script>
             ";
        } else {
            $errorMessage = mysqli_error($conn);
            echo "
               <script>
                 alert('Mohon Cek Kembali Data Yang Anda Masukkan! Pesan Kesalahan: $errorMessage');
                 window.location = '../edit_profile_user.php?kode=" . $kode_user . "';
               </script>
            ";
        }

        mysqli_stmt_close($stmt);
    }

    $conn->close();
}
?>
