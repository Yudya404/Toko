<?php include 'base/header.php'; ?>

   <?php include 'base/nav.php'; ?>

    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
					<?php
						$nama = "Gambar Banner 1 Halaman Utama"; // Ganti dengan nama yang ingin dicari
						$result = mysqli_query($conn, "SELECT * FROM about");
						while ($row = mysqli_fetch_assoc($result)) {
							if ($row['nama'] == $nama) {
					?>
                    <div class="hero__item set-bg" data-setbg="back/dist/proses/<?= $row['gambar_a']; ?>">
                        <div class="hero__text">
                            <span>Buah Segar, Daging Segar, Sayur Segar, Jajanan, Dan Berbagai kebutuhan dapur lainnya</span>
                            <h2>Jaminan <br />100% Fresh</h2>
                            <p>Bisa Dikirim Dan Gratis Ongkir</p>
                            <a href="./produk.php" class="primary-btn">Belanja Sekarang</a>
                        </div>
                    </div>
					<?php
							}
						}
					?>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Categories Section Begin -->
    <section class="categories">
		<!-- Hero Section Begin -->
		<section class="hero hero-normal">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="hero__search">
							<div class="hero__search__form">
								<form action="index.php">
									<input type="text" name="keyword" placeholder="Pencarian">
									<button type="submit" class="site-btn">Cari</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Hero Section End -->
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/buahBuahan.jpg">
                            <h5><a href="./produk.php">Buah Segar</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/sayurSayuran.jpg">
                            <h5><a href="./produk.php">Sayuran Segar</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/daging.jpg">
                            <h5><a href="./produk.php">Daging Segar</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/bumbuDapur.jpg">
                            <h5><a href="./produk.php">Bumbu Dapur</a></h5>
                        </div>
                    </div><div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/bumbuDapur.jpg">
                            <h5><a href="./produk.php">Beras</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/makananRingan.jpg">
                            <h5><a href="./produk.php">Snack</a></h5>
                        </div>
                    </div>
					<div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/minuman.jpg">
                            <h5><a href="./produk.php">Minuman Botol</a></h5>
                        </div>
                    </div>
					<div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/minuman.jpg">
                            <h5><a href="./produk.php">Minuman Sachet</a></h5>
                        </div>
                    </div>
					<div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/sabun.jpg">
                            <h5><a href="./produk.php">Sabun</a></h5>
                        </div>
                    </div>
					<div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/produkLainnya.jpg">
                            <h5><a href="./produk.php">Produk Lainnya</a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
	<section class="featured spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="section-title">
						<h2>Produk</h2>
					</div>
					<div class="featured__controls">
						<ul>
                            <li class="active" data-filter="*">Semua</li>
                            <li data-filter=".oranges">Buah</li>
                            <li data-filter=".fresh-meat">Daging</li>
                            <li data-filter=".vegetables">Sayur</li>
                            <li data-filter=".fastfood">Jajanan</li>
                        </ul>
					</div>
				</div>
			</div>
			<div class="row">
				<?php
				// Menentukan jumlah item per halaman
				$items_per_page = 8;

				// Mengambil halaman saat ini dari parameter URL
				$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

				// Menghitung offset (mulai dari baris ke berapa)
				$offset = ($current_page - 1) * $items_per_page;

				// Query untuk mendapatkan jumlah total data
				$total_items_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM produk");
				$total_items = mysqli_fetch_assoc($total_items_query)['total'];

				// Menghitung jumlah halaman total
				$total_pages = ceil($total_items / $items_per_page);

				// Query umum untuk mendapatkan data produk dengan batasan dan offset
				$query = "SELECT * FROM produk LIMIT $offset, $items_per_page";

				// Inisialisasi variabel hasil pencarian
				$search_result = false;

				// Jika ada parameter 'keyword' dalam URL, gunakan query pencarian
				if (isset($_GET['keyword'])) {
					$keyword = $_GET['keyword'];
					$query = "SELECT * FROM produk WHERE nama LIKE '%$keyword%' LIMIT $offset, $items_per_page";
					$search_result = true;
				}

				$result = mysqli_query($conn, $query);

				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						// Tampilkan data produk
					?>
						<div class="col-lg-3 col-md-4 col-sm-6">
							<div class="featured__item">
								<div class="featured__item__pic set-bg" data-setbg="back/dist/proses/<?= $row['foto_produk']; ?>">
									<ul class="featured__item__pic__hover">
										<li><a href="detail_produk.php?kode=<?= $row['kode_produk']; ?>"><i class="fa fa-eye" style="color:blue"></i></a></li>
										<?php if(isset($_SESSION['kode_cus'])) { ?>
											<li><a href="proses/add_cart.php?produk=<?= $row['kode_produk']; ?>&customer=<?= $_SESSION['kode_cus']; ?>"><i class="fa fa-shopping-cart" style="color:orange"></i></a></li>
										<?php } else { ?>
											<li><a href="#" data-toggle="modal" data-target="#loginModal" class="header__login-link"><i class="fa fa-shopping-cart" style="color:orange"></i></a></li>
										<?php } ?>
									</ul>
								</div>
								<div class="featured__item__text">
									<h6><a href="#"><?= $row['nama']; ?></a></h6>
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
										echo '<br>';
										echo '<span>(' . $total_customers . ' Ulasan)</span>';
										?>
									</div>
									<h5><b>Stock</b> <span><?= $row['stok']; ?></span></h5>
									<h5>Rp.<?= number_format($row['harga']); ?></h5>
								</div>
							</div>
						</div>
					<?php
					}
				} else {
					// Tampilkan pesan jika produk yang dicari tidak ditemukan
					if ($search_result) {
						echo '<div class="col-lg-12 text-center"><p><b><h5>Produk yang Anda cari tidak ditemukan.</h5></b></p></div>';
					}
				}
				?>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<nav aria-label="Page navigation">
						<ul class="pagination justify-content-center">
							<?php if ($current_page > 1) { ?>
								<li class="page-item">
									<a class="page-link" href="?page=<?= $current_page - 1; ?>" aria-label="Previous">
										<span aria-hidden="true">&laquo;</span>
									</a>
								</li>
							<?php } ?>

							<?php for ($i = 1; $i <= $total_pages; $i++) { ?>
								<li class="page-item <?php if ($i == $current_page) echo 'active'; ?>">
									<a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
								</li>
							<?php } ?>

							<?php if ($current_page < $total_pages) { ?>
								<li class="page-item">
									<a class="page-link" href="?page=<?= $current_page + 1; ?>" aria-label="Next">
										<span aria-hidden="true">&raquo;</span>
									</a>
								</li>
							<?php } ?>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
				<?php
					$nama = "Gambar Banner 2 Halaman Utama"; // Ganti dengan nama yang ingin dicari
					$result = mysqli_query($conn, "SELECT * FROM about");
					while ($row = mysqli_fetch_assoc($result)) {
						if ($row['nama'] == $nama) {
				?>
                    <div class="banner__pic">
                        <img src="back/dist/proses/<?= $row['gambar_a']; ?>" alt="Gambar Banner 2">
                    </div>
				<?php
						}
					}
				?>
                </div>
				<?php
					$nama = "Gambar Banner 3 Halaman Utama"; // Ganti dengan nama yang ingin dicari
					$result = mysqli_query($conn, "SELECT * FROM about");
					while ($row = mysqli_fetch_assoc($result)) {
						if ($row['nama'] == $nama) {
				?>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="back/dist/proses/<?= $row['gambar_a']; ?>" alt="Gambar Banner 3">
                    </div>
                </div>
				<?php
						}
					}
				?>
            </div>
        </div>
    </div>
    <!-- Banner End -->
	
	<br>
	<br>

<?php include 'base/footer.php'; ?>	
    