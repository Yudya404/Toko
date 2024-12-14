<?php include 'base/header.php'; ?>

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
                        <h2>Keranjang Belanja</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Beranda</a>
                            <span>Keranjang Belanja</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
	<section class="shoping-cart spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="shoping__cart__table">
						<table>
							<?php 
							if(isset($_SESSION['kode_cus'])){
								$kode_cus = $_SESSION['kode_cus'];
								// CEK JUMLAH KERANJANG
								$cek = mysqli_query($conn, "SELECT * FROM cart WHERE kode_cus = '$kode_cus'");
								$jml = mysqli_num_rows($cek);

								if($jml > 0){
							?>	
							<thead>
								<tr>
									<th class="shoping__product">Produk</th>
									<th>Harga</th>
									<th>Quantity</th>
									<th>Total</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								if(isset($_SESSION['kode_cus'])){
									$kode_cus = $_SESSION['kode_cus'];

									$result = mysqli_query($conn, "SELECT c.kode_cart as cart, c.kode_produk as kode_produk, c.nama as nama, c.jumlah as jumlah, p.foto_produk as foto_produk, p.harga as harga FROM cart c JOIN produk p ON c.kode_produk=p.kode_produk WHERE kode_cus = '$kode_cus'");
									$no = 1;
									$hasil = 0;
									while($row = mysqli_fetch_assoc($result)){
										?>
										<form action="proses/pesanan.php" method="POST">
											<input type="hidden" name="kode" value="<?php echo $row['cart']; ?>">
											<tr>
												<td class="shoping__cart__item">
													<img src="back/dist/proses/<?= $row['foto_produk']; ?>" alt="Gambar Produk" style="width: 100px;">
													<h5><?= $row['nama']; ?></h5>
												</td>
												<td class="shoping__cart__price">
													Rp.<?= number_format($row['harga']);  ?>
												</td>
												<td class="shoping__cart__quantity">
													<div class="quantity">
														<div class="pro-qty">
															<input type="number" name="jumlah" value="<?= $row['jumlah']; ?>">
														</div>
													</div>
												</td>
												<td class="shoping__cart__total">
													Rp.<?= number_format($row['harga'] * $row['jumlah']);  ?>
												</td>
												<td class="shoping__cart__item__close">
													<a href="proses/pesanan.php?del=1&kode=<?= $row['cart']; ?>"><span class="icon_close" onclick="return confirm('Yakin ingin dihapus ?')"></span></a>
												</td>
												<td class="shoping__cart__item__close">
													<button type="submit" name="submit1"><span class="fa fa-refresh" style="color:green"></span></button>
												</td>
											</tr>
										</form>
										<?php 
										$sub = $row['harga'] * $row['jumlah'];
										$hasil += $sub;
										$no++;
									}
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="shoping__cart__btns">
						<a href="produk.php" class="primary-btn cart-btn-primary">Lanjut Belanja</a>
					</div>
				</div>
				<div class="col-lg-6">
				</div>
				<div class="col-lg-6">
					<div class="shoping__checkout">
						<h5>Total Belanjaan</h5>
						<ul>
							<li>Total <span>Rp.<?= number_format($hasil); ?></span></li>
						</ul>
						<a href="./checkout.php?kode_cus=<?= $kode_cus; ?>" class="primary-btn" onclick="return confirm('Apakah tidak ada tambahan lagi? Lanjut Ke Checkout')">Checkout</a>
					</div>
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
	</section>
	<!-- Shoping Cart Section End -->


<?php include 'base/footer.php'; ?>