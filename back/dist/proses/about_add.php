<?php
session_start();

include '../koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['about_nama']);

    date_default_timezone_set("Asia/Jakarta");
    $tgl_input = date("Y-m-d");

    $kode_a = generateKodeAbout($conn);

    if ($_FILES['avatar']['name'] != '') {
        $uploadDir = "../upload/gambarAbout/";
        $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        $allowedExtensions = array("png", "jpg", "jpeg");
        if (!in_array($imageFileType, $allowedExtensions)) {
            echo "
                <script>
                alert('Gambar yang anda upload tidak sesuai ketentuan Format');
                window.location = '../tambah_about.php';
                </script>
                ";
            exit();
        }

        if ($_FILES['avatar']['size'] > 10 * 1024 * 1024) {
            echo "
                <script>
                alert('Gambar yang anda upload tidak sesuai dengan ukuran yang telah ditentukan');
                window.location = '../tambah_about.php';
                </script>
                ";
            exit();
        }

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
            $sql = "INSERT INTO about (kode_a, nama, tgl_input, gambar_a) 
                    VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $kode_a, $nama, $tgl_input, $uploadFile);

            if (mysqli_stmt_execute($stmt)) {
                echo "
                <script>
                alert('Data Anda dengan Kode $kode_a berhasil disimpan pada tanggal $tgl_input');
                window.location = '../about.php';
                </script>
                ";
            } else {
                echo "
                <script>
                alert('Mohon Cek Kembali Data Yang Anda Masukkan!');
                window.location = '../tambah_about.php';
                </script>
                ";
            }

            mysqli_stmt_close($stmt);
        }
    } else {
        $sql = "INSERT INTO about (kode_a, nama, tgl_input) 
                VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $kode_a, $nama, $tgl_input);

        if (mysqli_stmt_execute($stmt)) {
            echo "
                <script>
                alert('Data Anda dengan Kode $kode_a berhasil disimpan pada tanggal $tgl_input');
                window.location = '../about.php';
                </script>
            ";
        } else {
            echo "
                <script>
                alert('Mohon Cek Kembali Data Yang Anda Masukkan!');
                window.location = '../tambah_about.php';
                </script>
            ";
        }

        mysqli_stmt_close($stmt);
    }

    $conn->close();
}

// Fungsi untuk menghasilkan kode user yang unik
function generateKodeAbout($conn) {
    $query = mysqli_query($conn, "SELECT kode_a FROM about ORDER BY kode_a DESC LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $num = (int) substr($data['kode_a'], 1) + 1;
    } else {
        $num = 1;
    }

    return "G" . str_pad($num, 3, '0', STR_PAD_LEFT);
}
?>
