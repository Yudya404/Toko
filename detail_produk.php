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
                        <h2>Detail Produk</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Beranda</a>
                            <span>Detail Produk</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
	
    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
				<?php
					$kode_produk = $_GET['kode'];
					$result = mysqli_query($conn, "SELECT * FROM produk WHERE kode_produk = '$kode_produk'");
					while ($row = mysqli_fetch_assoc($result)) {
				?>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large" src="back/dist/proses/<?= $row['foto_produk']; ?>" alt="">
                        </div>
                    </div>
                </div>
				
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3><?= $row['nama']; ?></h3>
						<div class="product__details__rating">
							<?php
							// Ambil kode produk dari parameter URL
							$kode_produk = $row['kode_produk'];

							// Query untuk mengambil rating dan menghitung total customer yang memberi rating pada produk
							$rating_query = "SELECT r.rating, COUNT(r.kode_cus) AS total_customers
											 FROM rating r
											 JOIN produk p ON r.kode_produk = p.kode_produk
											 WHERE p.kode_produk = '$kode_produk'";
							$rating_result = mysqli_query($conn, $rating_query);

							// Ambil nilai rating dan total customers dari hasil query
							$rating = 0;
							$total_customers = 0;
							if ($rating_row = mysqli_fetch_assoc($rating_result)) {
								$rating = $rating_row['rating'];
								$total_customers = $rating_row['total_customers'];
							}

							// Menampilkan ikon hati berdasarkan nilai rating
							for ($i = 1; $i <= 5; $i++) {
								if ($i <= $rating) {
									echo '<i class="fa fa-heart" style="color:red"></i>'; // Tampilkan hati merah jika rating mencukupi
								} else {
									echo '<i class="fa fa-heart-o"></i>'; // Tampilkan hati kosong jika rating tidak mencukupi
								}
							}

							// Tampilkan total customers yang memberi rating
							echo '<span>(' . $total_customers . ' Ulasan)</span>';
							?>
						</div>
                        <div class="product__details__price">Rp.<?= number_format($row['harga']); ?></div>
                        <p><?= $row['deskripsi']; ?></p>
                        <div class="product__details__quantity">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="number" name="jumlah" value="1">
                                </div>
								<span><?= $row['satuan']; ?></span>
                            </div>
                        </div>
                        <?php
						// Periksa apakah customer sudah login
						if (isset($_SESSION['kode_cus'])) {
							// Customer sudah login, berikan link untuk menambah ke keranjang
							echo '<a href="proses/add_cart.php?produk=' . $row['kode_produk'] . '&customer=' . $kode_cus . '" class="primary-btn">Tambah Ke Keranjang</a>';
						} else {
							// Customer belum login, berikan link untuk membawa mereka ke halaman login
							echo '<a href="#" data-toggle="modal" data-target="#loginModal" class="primary-btn header__login-link">Tambah Ke Keranjang</a>';
						}
						?>
                        <ul>
                            <li><b>Stock</b> <span><?= $row['stok']; ?></span> <span><?= $row['satuan']; ?></span></li>
                            <li><b>Share on</b>
                                <div class="share">
                                    <a href="https://www.facebook.com/"><i class="fa fa-facebook" style="color:blue"></i></a>
									<a href="https://www.instagram.com/"><i class="fa fa-instagram" style="color:pink"></i></a>
									<a href="https://www.whatsapp.com/"><i class="fa fa-whatsapp" style="color:green"></i></a>
									<a href="https://www.google.com/intl/id/gmail/about/"><i class="fa fa-envelope" style="color:red"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
				<?php 
				}
				?>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

<?php include 'base/footer.php'; ?>