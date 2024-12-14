<?php
session_start();

include '../koneksi/koneksi.php'; // Pastikan Anda telah memasukkan koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email		= mysqli_real_escape_string($conn, $_POST['email']);
    $password	= mysqli_real_escape_string($conn, $_POST['pass']);

    // Lakukan query ke database untuk verifikasi
    $query = "SELECT * FROM user WHERE email = ?";
    $statement = mysqli_prepare($conn, $query);

    if ($statement) {
        mysqli_stmt_bind_param($statement, "s", $email);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);

        if ($result) {
            $user = mysqli_fetch_assoc($result);

            if ($user && password_verify($password, $user['password'])) {
                // Verifikasi sukses
                $_SESSION['kode_user'] = $user['kode_user'];
				$_SESSION['nama'] = $user['nama'];
				$_SESSION['no_telp'] = $user['no_telp'];// Atur sesi nama pengguna
				$_SESSION['email'] = $user['email'];
				$_SESSION['alamat'] = $user['alamat'];
				$_SESSION['tgl_join'] = $user['tgl_join'];
				$_SESSION['kategori_user'] = $user['kategori_user'];
				$_SESSION['foto_user'] = $user['foto_user'];

                // Redirect ke halaman sesuai peran pengguna (misalnya admin atau user)
                header('Location: ../beranda.php'); // Ganti dengan halaman beranda
                exit();
            } else {
                // Verifikasi gagal
				$_SESSION['error_message'] = 'Login gagal.<br>Silakan periksa kembali email dan password Anda.';
				header('Location: ../index.php');
                exit();
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($statement);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Jika metode tidak sesuai, kembali ke halaman login
    header('Location: ../index.php');
    exit();
}
?>
