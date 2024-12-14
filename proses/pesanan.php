<?php
session_start();

include'../koneksi/koneksi.php';

if (isset($_POST['submit1'])) {
    $kode_cart	= mysqli_real_escape_string($conn, $_POST['kode']);
    $jumlah		= mysqli_real_escape_string($conn, $_POST['jumlah']);

    $edit_query = "UPDATE cart SET jumlah = ? WHERE kode_cart = ?";
    $edit_statement = mysqli_prepare($conn, $edit_query);
    mysqli_stmt_bind_param($edit_statement, "is", $jumlah, $kode_cart);

    if (mysqli_stmt_execute($edit_statement)) {
        echo "
        <script>
        alert('Keranjang Belanja Anda Berhasil Diupdate');
        window.location = '../cart.php';
        </script>
        ";
    }
} else if (isset($_GET['del'])) {
    $kode_cart = $_GET['kode'];
    $del_query = "DELETE FROM cart WHERE kode_cart = ?";
    $del_statement = mysqli_prepare($conn, $del_query);
    mysqli_stmt_bind_param($del_statement, "s", $kode_cart);

    if (mysqli_stmt_execute($del_statement)) {
        echo "
        <script>
        alert('Produk Pada Keranjang Anda Berhasil Dihapus');
        window.location = '../cart.php';
        </script>
        ";
    }
}

if (isset($_POST['submit'])) {
    if (isset($_POST['setuju'])) {
        $kode_cus = $_SESSION['kode_cus'];
        $result = mysqli_query($conn, "SELECT * FROM cart WHERE kode_cus = '$kode_cus'");
        $total_quantity = 0;
        $total_price = 0;

        date_default_timezone_set("Asia/Jakarta");
        $tgl_pesanan = date("Y-m-d H:i:s");

        $kode = mysqli_query($conn, "SELECT kode_p FROM t_pesanan ORDER BY kode_p DESC");
        $data = mysqli_fetch_assoc($kode);

        if ($data) {
            $num = substr($data['kode_p'], 4);
            $add = (int) $num + 1;
        } else {
            $add = 1;
        }

        $kode_p = "KPC-" . str_pad($add, 4, '0', STR_PAD_LEFT);

        $cek_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM t_pesanan WHERE kode_p = ?");
        $result = mysqli_fetch_assoc($cek_query);
        $count = $result['count'];

        while ($count > 0) {
            $add++;
            $kode_p = "KPC-" . str_pad($add, 4, '0', STR_PAD_LEFT);
            $cek_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM t_pesanan WHERE kode_p = ?");
            $result = mysqli_fetch_assoc($cek_query);
            $count = $result['count'];
        }

        $result = mysqli_query($conn, "SELECT * FROM cart WHERE kode_cus = '$kode_cus'");
        $t_item = 0;
        $t_harga = 0;
        $product_info_array = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $sub_total = $row['harga'] * $row['jumlah'];
            $t_item += $row['jumlah'];
            $t_harga += $sub_total;

            $product_info = array(
                "kode_produk" => $row['kode_produk'],
                "nama_produk" => $row['nama'],
                "harga_per_item" => $row['harga'],
                "jumlah" => $row['jumlah'],
                "subtotal" => $sub_total
            );

            $product_info_array[] = $product_info;
        }

        $product_info_json = json_encode($product_info_array);

        $status = "Pesanan Menunggu Diproses";
        $checkbox = isset($_POST['setuju']) ? "Setuju" : "Tidak Setuju";

        $insert_query = "INSERT INTO t_pesanan (kode_p, kode_cus, detail_pesanan, t_item, t_harga, status, tgl_pesan, checkbox)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $insert_statement = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param(
            $insert_statement,
            "sssissss",
            $kode_p,
            $kode_cus,
            $product_info_json,
            $t_item,
            $t_harga,
            $status,
            $tgl_pesanan,
            $checkbox
        );

        if (mysqli_stmt_execute($insert_statement)) {
            echo '<script>alert("Pesanan Anda Berhasil Dibuat.");</script>';

            foreach ($product_info_array as $product_info) {
                $kode_produk = $product_info['kode_produk'];
                $jumlah_dipesan = $product_info['jumlah'];

                $query = "SELECT stok FROM produk WHERE kode_produk = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "s", $kode_produk);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
                $current_stock = $row['stok'];

                $new_stock = $current_stock - $jumlah_dipesan;

                $update_stock_query = "UPDATE produk SET stok = ? WHERE kode_produk = ?";
                $stmt_update_stock = mysqli_prepare($conn, $update_stock_query);
                mysqli_stmt_bind_param($stmt_update_stock, "is", $new_stock, $kode_produk);
                mysqli_stmt_execute($stmt_update_stock);
            }

            mysqli_query($conn, "DELETE FROM cart WHERE kode_cus = '$kode_cus'");

            header("Location: ../riwayat_belanja.php");
            exit();
        } else {
            echo "
               <script>
                    alert('Terjadi kesalahan saat membuat pesanan. Silakan coba lagi.');
                    window.location = '../checkout.php';
               </script>
             ";
        }
    } else {
        echo "
           <script>
                alert('Anda harus menyetujui persyaratan pembelian');
                window.location = '../checkout.php';
           </script>
         ";
    }
} else {
    echo "
      <script>
        alert('Tidak ada permintaan pembelian yang dikirim.');
        window.location = '../cart.php';
      </script>
    ";
}
?>
