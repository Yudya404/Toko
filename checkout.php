<?php 
// Matikan pelaporan error berbasis notice
error_reporting(E_ALL & ~E_NOTICE);
include 'base/header.php';

$kode_cus = mysqli_real_escape_string($conn,$_GET['kode_cus']);
$cus = mysqli_query($conn, "SELECT * FROM customer WHERE kode_cus = '$kode_cus'");
$rows = mysqli_fetch_assoc($cus);
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
        <div class="checkout__form">
            <h4>Detail Pembayaran</h4>
            <form action="proses/pesanan.php" method="post">
				<div class="row">
					<?php
					if (isset($_SESSION['kode_cus'])) {
						$kode_cus = $_SESSION['kode_cus'];

						$result = mysqli_query($conn, "SELECT * FROM cart WHERE kode_cus = '$kode_cus'");
						$total_quantity = 0; // Inisialisasi total jumlah
						$total_price = 0;    // Inisialisasi total harga

						if (mysqli_num_rows($result) > 0) {
							?>
							<!-- Tampilkan judul Pesanan Kamu di luar loop while -->
							<div class="col-lg-12 col-md-6">
								<div class="checkout__order">
									<h4>Pesanan Kamu</h4>
								</div>
							</div>
							<?php

							while ($row = mysqli_fetch_assoc($result)) {
								$sub_total = $row['harga'] * $row['jumlah'];

								// Menambahkan jumlah dan harga subtotal ke total
								$total_quantity += $row['jumlah'];
								$total_price += $sub_total;
								?>
								<!-- Tampilkan item dalam form checkout -->
								<div class="col-lg-12 col-md-6">
									<div class="checkout__order">
										<div class="checkout__order__products">Produk <span><?= $row['nama']; ?></span></div>
										<div class="checkout__order__price">Harga per Item <span>Rp.<?= number_format($row['harga']); ?></span></div>
										<div class="checkout__order__quantity">Jumlah per Item <span><?= $row['jumlah']; ?> pcs</span></div>
										<div class="checkout__order__subtotal">Subtotal per Item <span>Rp.<?= number_format($sub_total); ?></span></div>
									</div>
								</div>
								<?php
							}

							// Tampilkan total jumlah dan total harga di luar loop while
							?>
							<div class="col-lg-12 col-md-6">
								<div class="checkout__order">
									<div class="checkout__order__products">Total Barang <span><?= $total_quantity; ?> pcs</span></div>
									<div class="checkout__order__total">Total Harga <span>Rp.<?= number_format($total_price); ?></span></div>
									<p>Produk/barang yang telah dibeli tidak dapat dikembalikan/ditukarkan kecuali ada perjanjian terlebih dahulu.</p>
									<div class="checkout__input__checkbox">
										<input type="checkbox" id="payment" name="setuju">
										<label for="payment">Setuju</label>
									</div>
										<input type="hidden" name="kode_cus" value="<?= $row['kode_cus']; ?>">
										<input type="hidden" name="kode_produk" value="<?= $row['kode_produk']; ?>">
										<input type="hidden" name="nama" value="<?= $row['nama']; ?>">
										<input type="hidden" name="jumlah" value="<?= $row['jumlah']; ?>">
										<input type="hidden" name="sub_total" value="<?= $sub_total; ?>">
									<button type="submit" name="submit" class="site-btn" onclick="return confirm('Apakah Jumlah Item Barang & Total Harga sudah sesuai? Lanjutkan')">Beli</button>
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
						} else {
							// Tampilkan pesan jika belum login
							?>
							<div class="row">
							<div class="col-lg-12">
								<table>
								<div class="checkout__order">
									<h4>Pesanan Kamu</h4>
									<p>Silakan login terlebih dahulu sebelum melakukan pembelian.</p>
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
    </div>
</section>
<!-- Checkout Section End -->

<?php include 'base/footer.php'; ?>