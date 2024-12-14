<?php
session_start();
 
include '../koneksi/koneksi.php';

$kode_cus = $_GET['customer'];
$kode_produk = $_GET['produk'];

if (isset($_GET['jml'])) {
    $qty = $_GET['jml'];
}

$stmt = mysqli_prepare($conn, "SELECT * FROM produk WHERE kode_produk = ?");
mysqli_stmt_bind_param($stmt, "s", $kode_produk);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$nama = $row['nama'];
$kode_produk = $row['kode_produk'];
$harga = $row['harga'];

$cek_stmt = mysqli_prepare($conn, "SELECT * FROM cart WHERE kode_produk = ? AND kode_cus = ?");
mysqli_stmt_bind_param($cek_stmt, "ss", $kode_produk, $kode_cus);
mysqli_stmt_execute($cek_stmt);
$cek_result = mysqli_stmt_get_result($cek_stmt);
$jml = mysqli_num_rows($cek_result);
$row1 = mysqli_fetch_assoc($cek_result);

if ($jml > 0) {
    $set = $row1['jumlah'] + (isset($qty) ? $qty : 1);
    $action = "UPDATE cart SET jumlah = ? WHERE kode_produk = ? AND kode_cus = ?";
    $update_stmt = mysqli_prepare($conn, $action);
    mysqli_stmt_bind_param($update_stmt, "iss", $set, $kode_produk, $kode_cus);
    $insert = mysqli_stmt_execute($update_stmt);
} else {
    $qtyToAdd = isset($qty) ? $qty : 1;

    // Mendapatkan kode_cart berikutnya
    $kode = mysqli_query($conn, "SELECT kode_cart FROM cart ORDER BY kode_cart DESC");
    $data = mysqli_fetch_assoc($kode);

    if ($data) {
        $num = substr($data['kode_cart'], 1);
        $add = (int) $num + 1;
    } else {
        $add = 1;
    }

    $kode_cart = "KBC-" . str_pad($add, 3, '0', STR_PAD_LEFT);

    $cek_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM cart WHERE kode_cart = '$kode_cart'");
    $result = mysqli_fetch_assoc($cek_query);
    $count = $result['count'];

    while ($count > 0) {
        $add++;
        $kode_cart = "KBC-" . str_pad($add, 3, '0', STR_PAD_LEFT);
        $cek_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM cart WHERE kode_cart = '$kode_cart'");
        $result = mysqli_fetch_assoc($cek_query);
        $count = $result['count'];
    }

    $action = "INSERT INTO cart (kode_cart, kode_cus, kode_produk, nama, jumlah, harga, tgl_input) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $insert_stmt = mysqli_prepare($conn, $action);
    mysqli_stmt_bind_param($insert_stmt, "ssssii", $kode_cart, $kode_cus, $kode_produk, $nama, $qtyToAdd, $harga);
    $insert = mysqli_stmt_execute($insert_stmt);
}

if ($insert) {
    echo "
        <script>
        alert('Produk Berhasil Ditambahkan Ke Keranjang Anda');
        window.location = '../cart.php';
        </script>
    ";
    die;
} else {
    echo "
        <script>
        alert('Terjadi kesalahan saat menambahkan & mengupdate produk ke keranjang. Silakan coba lagi.');
        window.location = '../produk.php';
        </script>
    ";
    die;
}

// Tutup prepared statements
mysqli_stmt_close($stmt);
mysqli_stmt_close($cek_stmt);
if (isset($update_stmt)) {
    mysqli_stmt_close($update_stmt);
}
mysqli_stmt_close($insert_stmt);

// Tutup koneksi database
mysqli_close($conn);
?>
