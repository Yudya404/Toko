<?php
session_start(); // Pastikan session sudah dimulai

require_once('../koneksi/koneksi.php'); // Sertakan file koneksi ke database

if (isset($_SESSION['kode_cus']) && isset($_POST['new_email']) && isset($_POST['password'])) {
    $kode_cus	= $_SESSION['kode_cus']; // Tidak perlu di-escape karena ini dari session
    $new_email	= mysqli_real_escape_string($conn, $_POST['new_email']);
    $password	= mysqli_real_escape_string($conn, $_POST['password']); // Menggunakan $_POST['password'] untuk password lama

    // Lakukan pengecekan password lama
    $password_query = "SELECT password FROM customer WHERE kode_cus = ?";
    $stmt_password = mysqli_prepare($conn, $password_query);
    mysqli_stmt_bind_param($stmt_password, "s", $kode_cus);
    mysqli_stmt_execute($stmt_password);
    $result = mysqli_stmt_get_result($stmt_password);
    $row = mysqli_fetch_assoc($result);
    $hashed_password = $row['password'];

    if (password_verify($password, $hashed_password)) {
        // Lakukan update email dalam database
        $update_query = "UPDATE customer SET email = ? WHERE kode_cus = ?";
        $stmt_update = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt_update, "ss", $new_email, $kode_cus);
        $result = mysqli_stmt_execute($stmt_update);

        if ($result) {
            // Email berhasil diperbarui
            $successMessage = "Email Anda Berhasil Diperbarui.";
            echo "
                <script>
                alert('$successMessage');
                window.location = '../edit_profilku.php';
                </script>
            ";
        } else {
            // Gagal memperbarui email
            $errorMessage = "Email Anda Gagal diperbarui.";
            echo "
                <script>
                alert('$errorMessage');
                window.location = '../edit_profilku.php';
                </script>
            ";
        }
    } else {
        // Password lama tidak sesuai
        $errorMessage = "Password lama tidak sesuai.";
        echo "
            <script>
            alert('$errorMessage');
            window.location = '../edit_profilku.php';
            </script>
        ";
    }

    // Tutup prepared statements
    mysqli_stmt_close($stmt_password);
    mysqli_stmt_close($stmt_update);
} else {
    // Akses tidak sah
    $errorMessage = "Akses tidak sah.";
    echo "
        <script>
        alert('$errorMessage');
        window.location = '../index.php';
        </script>
    ";
}

// Tutup koneksi database
mysqli_close($conn);
?>
