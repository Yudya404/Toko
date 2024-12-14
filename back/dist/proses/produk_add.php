<?php
session_start();

include '../koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
    $nama 		= mysqli_real_escape_string($conn, $_POST['produk_nama']);
    $harga 		= mysqli_real_escape_string($conn, $_POST['produk_harga']);
    $stok 		= mysqli_real_escape_string($conn, $_POST['produk_stok']);
    $satuan 	= mysqli_real_escape_string($conn, $_POST['produk_satuan']);
	$deskripsi 	= mysqli_real_escape_string($conn, $_POST['produk_deskripsi']);
    $tgl_exp 	= mysqli_real_escape_string($conn, $_POST['produk_exp']);

    date_default_timezone_set("Asia/Jakarta");
    $tgl_input = date("Y-m-d");

    $kode_produk = generateKodeProduk($conn);

    if ($_FILES['avatar']['name'] != '') {
        $uploadDir = "../upload/fotoProduk/";
        $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        $allowedExtensions = array("png", "jpg", "jpeg");
        if (!in_array($imageFileType, $allowedExtensions)) {
            echo "
                <script>
                alert('Gambar yang anda upload tidak sesuai ketentuan Format');
                window.location = '../tambah_produk.php';
                </script>
                ";
            exit();
        }

        if ($_FILES['avatar']['size'] > 10 * 1024 * 1024) {
            echo "
                <script>
                alert('Gambar yang anda upload tidak sesuai dengan ukuran yang telah ditentukan');
                window.location = '../tambah_produk.php';
                </script>
                ";
            exit();
        }

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
            $sql = "INSERT INTO produk (kode_produk, nama, harga, stok, satuan, deskripsi, tgl_exp, foto_produk) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssssss", $kode_produk, $nama, $harga, $stok, $satuan, $deskripsi, $tgl_exp, $uploadFile);

            if (mysqli_stmt_execute($stmt)) {
                echo "
                <script>
                alert('Data Anda dengan Kode $kode_produk berhasil disimpan pada tanggal $tgl_input');
                window.location = '../produk.php';
                </script>
                ";
            } else {
                echo "
                <script>
                alert('Mohon Cek Kembali Data Yang Anda Masukkan!');
                window.location = '../tambah_produk.php';
                </script>
                ";
            }

            mysqli_stmt_close($stmt);
        }
    } else {
        $sql = "INSERT INTO produk (kode_produk, nama, harga, stok, satuan, deskripsi, tgl_exp) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $kode_produk, $nama, $harga, $stok, $satuan, $deskripsi, $tgl_exp);

        if (mysqli_stmt_execute($stmt)) {
            echo "
                <script>
                alert('Data Anda dengan Kode $kode_produk berhasil disimpan pada tanggal $tgl_input');
                window.location = '../produk.php';
                </script>
            ";
        } else {
            echo "
                <script>
                alert('Mohon Cek Kembali Data Yang Anda Masukkan!');
                window.location = '../tambah_produk.php';
                </script>
            ";
        }

        mysqli_stmt_close($stmt);
    }

    $conn->close();
}

// Fungsi untuk menghasilkan kode user yang unik
function generateKodeProduk($conn) {
    $query = mysqli_query($conn, "SELECT kode_produk FROM produk ORDER BY kode_produk DESC LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $num = (int) substr($data['kode_produk'], 1) + 1;
    } else {
        $num = 1;
    }

    return "P" . str_pad($num, 3, '0', STR_PAD_LEFT);
}
?>
