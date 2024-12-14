<?php
session_start();

include '../koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama			 = mysqli_real_escape_string($conn, $_POST['cus_nama']);
    $no_telp		 = mysqli_real_escape_string($conn, $_POST['cus_telp']);
    $email			 = mysqli_real_escape_string($conn, $_POST['cus_email']);
    $alamat			 = mysqli_real_escape_string($conn, $_POST['cus_alamat']);
    $user_password	 = mysqli_real_escape_string($conn, $_POST['cus_pass']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPass']);

    // Validasi password
    if ($user_password !== $confirmPassword) {
        echo "
           <script>
              alert('Sandi yang anda masukkan tidak sama harap ulangi lagi');
              window.location = '../register.php';
           </script>
           ";
        exit();
    }

    // Enkripsi password sebelum disimpan ke database
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    date_default_timezone_set("Asia/Jakarta");
    $tgl_input = date("Y-m-d");

    $kode_cus = generateKodeCus($conn);

    if ($_FILES['avatar']['name'] != '') {
        $uploadDir = "../back/dist/upload/fotoCus/";
        $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        $allowedExtensions = array("png", "jpg", "jpeg");
        if (!in_array($imageFileType, $allowedExtensions)) {
            echo "
                <script>
                alert('Gambar yang anda upload tidak sesuai ketentuan Format');
                window.location = '../register.php';
                </script>
                ";
            exit();
        }

        if ($_FILES['avatar']['size'] > 10 * 1024 * 1024) {
            echo "
                <script>
                alert('Gambar yang anda upload tidak sesuai dengan ukuran yang telah ditentukan');
                window.location = '../register.php';
                </script>
                ";
            exit();
        }

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
            $sql = "INSERT INTO customer (kode_cus, nama, no_telp, email, alamat, password, tgl_join, foto_cus) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssssss", $kode_cus, $nama, $no_telp, $email, $alamat, $hashed_password, $tgl_input, $uploadFile);

            if (mysqli_stmt_execute($stmt)) {
                echo "
                <script>
                alert('Data Anda berhasil disimpan dengan Nama $nama pada tanggal $tgl_input');
                window.location = '../index.php';
                </script>
                ";
            } else {
                echo "
                <script>
                alert('Mohon Cek Kembali Data Yang Anda Masukkan!');
                window.location = '../register.php';
                </script>
                ";
            }

            mysqli_stmt_close($stmt);
        }
    } else {
        $sql = "INSERT INTO customer (kode_cus, nama, no_telp, email, alamat, password, tgl_join) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $kode_cus, $nama, $no_telp, $email, $alamat, $hashed_password, $tgl_input);

        if (mysqli_stmt_execute($stmt)) {
            echo "
                <script>
                alert('Data Anda berhasil disimpan dengan Nama $nama pada tanggal $tgl_input');
                window.location = '../index.php';
                </script>
            ";
        } else {
            echo "
                <script>
                alert('Mohon Cek Kembali Data Yang Anda Masukkan!');
                window.location = '../register.php';
                </script>
            ";
        }

        mysqli_stmt_close($stmt);
    }

    $conn->close();
}

// Fungsi untuk menghasilkan kode user yang unik
function generateKodeCus($conn) {
    $query = mysqli_query($conn, "SELECT kode_cus FROM customer ORDER BY kode_cus DESC LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $num = (int) substr($data['kode_cus'], 1) + 1;
    } else {
        $num = 1;
    }

    return "C" . str_pad($num, 3, '0', STR_PAD_LEFT);
}
?>