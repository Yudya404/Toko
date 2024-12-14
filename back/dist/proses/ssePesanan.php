<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// Sertakan file koneksi ke database Anda di sini
include '../koneksi/koneksi.php';

while (true) {
    // Query database untuk memeriksa pembaruan pesanan
    $query = "SELECT t.*, c.nama AS nama, 'Pesanan Menunggu Diproses' AS status
			  FROM t_pesanan t
			  JOIN customer c ON t.kode_cus = c.kode_cus
			  WHERE t.status = 'Pesanan Menunggu Diproses'
			  ORDER BY t.kode_p DESC";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $detailPesanan = json_decode($row['detail_pesanan'], true);
            // Gantilah data dengan informasi yang Anda ambil dari database
            $data = array( // Nomor pesanan
                'kode_p' => $row['kode_p'],
                'customer' => $row['nama'],
                't_item' => $row['t_item'],
                't_harga' => 'Rp. ' . number_format($row['t_harga'], 0, ',', '.'),
                'detail_pesanan' => $detailPesanan,
                'status' => $row['status'],
                'tgl_pesan' => $row['tgl_pesan']
            );

            // Kirim data sebagai pesan SSE ke klien
            echo 'data: ' . json_encode($data) . "\n\n";
            ob_flush();
            flush();

        }
    } else {
        // Jika tidak ada pembaruan, kirim pesan SSE kosong
        echo "data: {}\n\n";
        ob_flush();
        flush();
    }

    // Tangani pemutusan koneksi
    if (connection_aborted()) {
        // Tutup koneksi database dan keluar dari loop
        mysqli_close($conn);
        exit();
    }

    // Hentikan proses selama beberapa detik sebelum mengirim pembaruan berikutnya
    sleep(5); // Anda bisa mengatur interval sesuai kebutuhan
}

// Tutup koneksi database (jika diperlukan)
mysqli_close($conn);
?>
