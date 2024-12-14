<?php
session_start();

include '../koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
    $nama			 = mysqli_real_escape_string($conn, $_POST['user_nama']);
    $no_telp 		 = mysqli_real_escape_string($conn, $_POST['user_telp']);
    $email			 = mysqli_real_escape_string($conn, $_POST['user_email']);
    $alamat			 = mysqli_real_escape_string($conn, $_POST['user_alamat']);
	$kategori_user	 = mysqli_real_escape_string($conn, $_POST['user_role']);
    $user_password 	 = mysqli_real_escape_string($conn, $_POST['user_pass']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPass']);

    // Validasi password
    if ($user_password !== $confirmPassword) {
        echo "
           <script>
              alert('Sandi yang anda masukkan tidak sama harap ulangi lagi');
              window.location = '../tambah_user.php';
           </script>
           ";
        exit();
    }

    // Enkripsi password sebelum disimpan ke database
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    date_default_timezone_set("Asia/Jakarta");
    $tgl_input = date("Y-m-d");

    $kode_user = generateKodeUser($conn);

    if ($_FILES['avatar']['name'] != '') {
        $uploadDir = "../upload/fotoUser/";
        $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        $allowedExtensions = array("png", "jpg", "jpeg");
        if (!in_array($imageFileType, $allowedExtensions)) {
            echo "
                <script>
                alert('Gambar yang anda upload tidak sesuai ketentuan Format');
                window.location = '../tambah_user.php';
                </script>
                ";
            exit();
        }

        if ($_FILES['avatar']['size'] > 10 * 1024 * 1024) {
            echo "
                <script>
                alert('Gambar yang anda upload tidak sesuai dengan ukuran yang telah ditentukan');
                window.location = '../tambah_user.php';
                </script>
                ";
            exit();
        }

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
            $sql = "INSERT INTO user (kode_user, nama, no_telp, email, alamat, kategori_user, password, tgl_join, foto_user) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssssssss", $kode_user, $nama, $no_telp, $email, $alamat, $kategori_user, $hashed_password, $tgl_input, $uploadFile);

            if (mysqli_stmt_execute($stmt)) {
                echo "
                <script>
                alert('Data Anda dengan Kode $kode_user berhasil disimpan pada tanggal $tgl_input');
                window.location = '../user.php';
                </script>
                ";
            } else {
                echo "
                <script>
                alert('Mohon Cek Kembali Data Yang Anda Masukkan!');
                window.location = '../tambah_user.php';
                </script>
                ";
            }

            mysqli_stmt_close($stmt);
        }
    } else {
        $sql = "INSERT INTO user (kode_user, nama, no_telp, email, alamat, kategori_user, password, tgl_join) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssss", $kode_user, $nama, $no_telp, $email, $alamat, $kategori_user, $hashed_password, $tgl_input);

        if (mysqli_stmt_execute($stmt)) {
            echo "
                <script>
                alert('Data Anda berhasil disimpan dengan Kode $kode_cus pada tanggal $tgl_input');
                window.location = '../user.php';
                </script>
            ";
        } else {
            echo "
                <script>
                alert('Mohon Cek Kembali Data Yang Anda Masukkan!');
                window.location = '../tambah_user.php';
                </script>
            ";
        }

        mysqli_stmt_close($stmt);
    }

    $conn->close();
}

// Fungsi untuk menghasilkan kode user yang unik
function generateKodeUser($conn) {
    $query = mysqli_query($conn, "SELECT kode_user FROM user ORDER BY kode_user DESC LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $num = (int) substr($data['kode_user'], 1) + 1;
    } else {
        $num = 1;
    }

    return "U" . str_pad($num, 3, '0', STR_PAD_LEFT);
}
?>
