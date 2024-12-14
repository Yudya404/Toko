<?php
session_start();

// Hapus semua data sesi
session_unset();
// Hapus cookie sesi jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
// Akhiri sesi
session_destroy();

// Redirect ke halaman beranda atau halaman lain yang sesuai
header('Location: ../index.php'); // Ganti dengan halaman beranda atau halaman logout
exit();
?>
