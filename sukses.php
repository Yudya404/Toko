<?php 
// Matikan pelaporan error berbasis notice
error_reporting(E_ALL & ~E_NOTICE);
include 'base/header.php';

?>

   <?php include 'base/nav.php'; ?>

    <!-- Breadcrumb Section Begin -->
    <?php
		$nama = "Gambar Breadcrumb"; // Ganti dengan nama yang ingin dicari
		$result = mysqli_query($conn, "SELECT * FROM about");
		while ($row = mysqli_fetch_assoc($result)) {
		if ($row['nama'] == $nama) {
	?>
    <section class="breadcrumb-section set-bg" data-setbg="back/dist/proses/<?= $row['gambar_a']; ?>">
	<?php
		}
	}
	?>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Checkout</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Beranda</a>
                            <span>Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <form action="#" method="post">
            <div class="row">
                <?php
                if (isset($_SESSION['kode_cus'])) {
                    $kode_cus = $_SESSION['kode_cus'];
                    ?>
                    <div class="col-lg-12 col-md-6">
                        <div class="checkout__order text-center">
                            <h4>Pesanan Atas Nama <?= $_SESSION['nama']; ?></h4>
                            <p><h5><b> Berhasil Di Checkout.<br> Terimakasih. </b></h5></p>
                            <div class="shoping__cart__btns">
                                <a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#invoiceModal">Cetak Bukti</a>
                                <a href="checkout.php" class="btn btn-lg btn-primary">Kembali</a>
                            </div>
                        </div>
                    </div>
                  <?php
					} else {
						echo '<tr>
								<td colspan="4">
									<div class="checkout__order">
										<p>Anda telah logout silahkan login kembali.</p>
									 </div>
								</td>
							</tr>';
						header("Location: index.php");
						exit();
						}
					?>
            </div>
        </form>
    </div>
</section>
<!-- Checkout Section End -->

<!-- Modal for Invoice -->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceModalLabel">Invoice Pesanan <?= $_SESSION['nama']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Isi konten invoice di sini -->
                <form action="#" method="post">
                    <div class="row">
                        <?php
                        // Ambil data pesanan dari tabel berdasarkan kriteria yang sesuai
                        $query = "SELECT * FROM t_pesanan WHERE kode_cus = '$kode_cus'";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            $total_barang = 0; // Inisialisasi total barang
                            $total_harga = 0; // Inisialisasi total harga

                            while ($row = mysqli_fetch_assoc($result)) {
                                // Ambil data detail pesanan (item) dari kolom 'detail_pesanan'
                                $detail_pesanan = json_decode($row['detail_pesanan'], true);
								
								?>
									<div class="col-lg-12">
										<div class="order-info">
											<h6>Tanggal Order : <?= formatTanggalIndonesia($row['tgl_pesan']); ?></h6>
											<h6>Kode Order : <?= $row['kode_p']; ?></h6>
										</div>
									</div>
									
								<?php
                                foreach ($detail_pesanan as $item) {
                                    // Tampilkan rincian item
                                    ?>
                                    <div class="col-lg-12 col-md-6">
                                        <div class="checkout__order">
                                            <div class="checkout__order__products">Produk <span><?= $item['nama_produk']; ?></span></div>
                                            <div class="checkout__order__price">Harga per Item <span>Rp.<?= number_format($item['harga_per_item']); ?></span></div>
                                            <div class="checkout__order__quantity">Jumlah per Item <span><?= $item['jumlah']; ?> pcs</span></div>
                                            <div class="checkout__order__subtotal">Subtotal per Item <span>Rp.<?= number_format($item['subtotal']); ?></span></div>
                                        </div>
                                    </div>
                                    <?php

                                    // Akumulasi total barang dan total harga
                                    $total_barang += $item['jumlah'];
                                    $total_harga += $item['subtotal'];
                                }
                            }

                            // Tampilkan total jumlah barang dan total harga di luar loop while
                            ?>
                            <div class="col-lg-12 col-md-6">
                                <div class="checkout__order">
                                    <div class="checkout__order__products">Total Barang <span><?= $total_barang; ?> pcs</span></div>
                                    <div class="checkout__order__total">Total Harga <span>Rp.<?= number_format($total_harga); ?></span></div>
                                </div>
                            </div>
                        <!-- Notifikasi atau Peringatan -->
						<?php
						} else {
							// Tampilkan pesan jika keranjang kosong
							?>
							<div class="row">
								<div class="col-lg-12">
									<table>
										<div class="col-lg-12">
											<div class="checkout__order">
												<h4>Pesanan Kamu</h4>
												<p>Kamu belum memiliki produk dalam keranjang.</p>
											</div>
										</div>
									</table>
								</div>
							</div>
						<?php
						}
						?>
						<!-- Notifikasi atau Peringatan -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="printInvoice()">Cetak</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Invoice -->

<script>
    function printContent(content) {
        const printWindow = window.open('', '_blank');
        printWindow.document.write(content);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }

    function printInvoice() {
    const modalBody = document.getElementById('invoiceModal').innerHTML;
    const content = `
        <!DOCTYPE html>
		<html>
		<head>
			<title>Invoice Cetak</title>
			<!-- Include your CSS styles here -->
			<link rel="stylesheet" href="css/style.css" type="text/css">
			<style>
				/* ... Other styles ... */

				/* Style for the order date and order code container */
				.order-info {
					display: flex;
					justify-content: space-between;
					align-items: center;
					margin-bottom: 20px;
				}
			</style>
		</head>
		<body>
			<div class="row">
				<!-- Isi konten invoice di sini -->
					<form action="#" method="post">
						<div class="row">
							<?php
							// Ambil data pesanan dari tabel berdasarkan kriteria yang sesuai
							$query = "SELECT * FROM t_pesanan WHERE kode_cus = '$kode_cus'";
							$result = mysqli_query($conn, $query);

							if (mysqli_num_rows($result) > 0) {
								$total_barang = 0; // Inisialisasi total barang
								$total_harga = 0; // Inisialisasi total harga

								while ($row = mysqli_fetch_assoc($result)) {
									// Ambil data detail pesanan (item) dari kolom 'detail_pesanan'
									$detail_pesanan = json_decode($row['detail_pesanan'], true);
									
									// Tampilkan informasi pesanan di atas detail item
									?>
									<div class="col-lg-12">
										<div class="order-info">
											<h6>Tanggal Order : <?= formatTanggalIndonesia($row['tgl_pesanan']); ?></h6>
											<h6>Pesanan Atas Nama : <?= $_SESSION['nama']; ?></h6>
											<h6>Kode Order : <?= $row['kode_p']; ?></h6>
										</div>
									</div>
									<?php

									foreach ($detail_pesanan as $item) {
										// Tampilkan rincian item
										?>
										<div class="col-lg-12 col-md-6">
											<div class="checkout__order">
												<div class="checkout__order__products">Produk <span><?= $item['nama_produk']; ?></span></div>
												<div class="checkout__order__price">Harga per Item <span>Rp.<?= number_format($item['harga_per_item']); ?></span></div>
												<div class="checkout__order__quantity">Jumlah per Item <span><?= $item['jumlah']; ?> pcs</span></div>
												<div class="checkout__order__subtotal">Subtotal per Item <span>Rp.<?= number_format($item['subtotal']); ?></span></div>
											</div>
										</div>
										<?php

										// Akumulasi total barang dan total harga
										$total_barang += $item['jumlah'];
										$total_harga += $item['subtotal'];
									}
								}

								// Tampilkan total jumlah barang dan total harga di luar loop while
								?>
								<div class="col-lg-12 col-md-6">
									<div class="checkout__order">
										<div class="checkout__order__products">Total Barang <span><?= $total_barang; ?> pcs</span></div>
										<div class="checkout__order__total">Total Harga <span>Rp.<?= number_format($total_harga); ?></span></div>
									</div>
								</div>
								<?php
									} else {
										echo '<tr>
												<td colspan="4">
													<div class="checkout__order">
														<p>Anda telah logout silahkan login kembali.</p>
													</div>
												</td>
											</tr>';
										header("Location: index.php");
										exit();
									}
								?>
						</div>
						<br>
						<!-- Content to be added below "Terima Kasih" message -->
						<div class="col-lg-12">
							<center><p>Terima Kasih telah melakukan pembelian. <br> Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan.</p></center>
						</div>
					</form>
				</div>
			</body>
			</html>
    `;
    printContent(content);
}
</script>


<?php include 'base/footer.php'; ?>