<?php
session_start(); // Pastikan session sudah dimulai

include '../koneksi/koneksi.php';

if (isset($_POST['submit'])) {
    // Ambil data dari formulir dan bersihkan input
	$kode_cus 			= mysqli_real_escape_string($conn, $_POST['kode_cus']); // Tidak perlu di-escape karena ini dari session
    $nama_cus 			= mysqli_real_escape_string($conn, $_POST['nama_cus']);
    $kode_p 			= mysqli_real_escape_string($conn, $_POST['kode_p']);
    $alasan_pembatalan 	= mysqli_real_escape_string($conn, $_POST['alasan']);

    // Tentukan zona waktu Anda
    date_default_timezone_set("Asia/Jakarta");

    // Ambil tanggal sekarang
    $tgl_pembatalan = date("Y-m-d H:i:s");

    // Buat kode_b yang unik
    $kode_b = generateUniqueKodeBatal($conn);

    // Query Prepare untuk melakukan INSERT ke tabel pembatalan
    $sql = "INSERT INTO t_pembatalan (kode_b, kode_cus, nama_cus, kode_p, alasan, tgl_pembatalan)
            VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare statement
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $kode_b, $kode_cus, $nama_cus, $kode_p, $alasan_pembatalan, $tgl_pembatalan);

    // Eksekusi prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Update status dan tanggal pembatalan pada tabel t_pesanan
        $update_sql = "UPDATE t_pesanan SET status = 'Pesanan Ditolak', tgl_batal = '$tgl_pembatalan' WHERE kode_p = '$kode_p'";
        if (mysqli_query($conn, $update_sql)) {
            // Mendapatkan data dari detail pemesanan dalam format JSON
            $get_detail_data = mysqli_query($conn, "SELECT detail_pesanan FROM t_pesanan WHERE kode_p = '$kode_p'");
            if ($get_detail_data) {
                $row = mysqli_fetch_assoc($get_detail_data);
                $detail_pesanan = json_decode($row['detail_pesanan'], true);
                
                // Mengembalikan stok produk
                foreach ($detail_pesanan as $item) {
                    $kode_produk = $item['kode_produk'];
                    $jumlah_dipesan = $item['jumlah'];
                    
                    // Mengembalikan stok produk
                    $update_stok = "UPDATE produk SET stok = stok + $jumlah_dipesan WHERE kode_produk = '$kode_produk'";
                    if (mysqli_query($conn, $update_stok)) {
                        continue;
                    } else {
                        echo "Error updating stok produk: " . mysqli_error($conn);
                        break;
                    }
                }

                echo "
                    <script>
                        alert('Pesanan Anda dengan Kode $kode_p berhasil dibatalkan pada tanggal $tgl_pembatalan');
                        window.location = '../pembatalan.php';
                    </script>
                ";
            } else {
                echo "Error fetching detail data: " . mysqli_error($conn);
            }
        } else {
            echo "Error updating status and tanggal: " . mysqli_error($conn);
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Tutup prepared statement
    mysqli_stmt_close($stmt);

    // Tutup koneksi
    mysqli_close($conn);
}

function generateUniqueKodeBatal($conn) {
    $num = 1;
    $kode_b = "B" . str_pad($num, 3, '0', STR_PAD_LEFT);

    $cek_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM t_pembatalan WHERE kode_b = '$kode_b'");
    $result = mysqli_fetch_assoc($cek_query);
    $count = $result['count'];

    while ($count > 0) {
        // Jika kode_b sudah ada, tambahkan nomor urutan dan cek lagi
        $num++;
        $kode_b = "B" . str_pad($num, 3, '0', STR_PAD_LEFT);
        $cek_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM t_pembatalan WHERE kode_b = '$kode_b'");
        $result = mysqli_fetch_assoc($cek_query);
        $count = $result['count'];
    }

    return $kode_b;
}
?>
