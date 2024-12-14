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
                        <h2>Semua Produk</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Beranda</a>
                            <span>Produk</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
		<!-- Hero Section Begin -->
		<section class="hero hero-normal">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="hero__search">
							<div class="hero__search__form">
								<form action="produk.php">
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
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            <h4>Pilihan Produk</h4>
                            <ul>
                                <li><a href="produk.php?kategori=Daging">Daging Segar</a></li>
                                <li><a href="produk.php?kategori=Buah">Buah Segar</a></li>
                                <li><a href="produk.php?kategori=Sayuran">Sayuran Segar</a></li>
                                <li><a href="produk.php?kategori=Bumbu Dapur">Bumbu-bumbu Dapur</a></li>
								<li><a href="produk.php?kategori=Beras">Beras</a></li>
                                <li><a href="produk.php?kategori=Snack">Snack</a></li>
                                <li><a href="produk.php?kategori=Minuman Botol">Minuman Botol</a></li>
								<li><a href="produk.php?kategori=Minuman Sachet">Minuman Sachet</a></li>
                                <li><a href="produk.php?kategori=Sabun">Sabun</a></li>
								<li><a href="produk.php?kategori=Lainnya">Produk Lain-lainnya</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <div class="product__discount">
                        <div class="section-title product__discount__title">
                            <h2>Top Produk</h2>
                        </div>
                        <div class="row">
							<?php
							// Query untuk mengambil data produk dari database
							$query = "SELECT * FROM produk";
							$result = mysqli_query($conn, $query);
							?>
                            <div class="product__discount__slider owl-carousel">
							<?php while ($row = mysqli_fetch_assoc($result)) { ?>
								<div class="col-lg-4">
									<div class="product__discount__item">
										<div class="product__discount__item__pic set-bg" data-setbg="back/dist/proses/<?= $row['foto_produk']; ?>">
											<div class="product__discount__percent">-20%</div>
											<ul class="product__item__pic__hover">
												<li><a href="detail_produk.php?kode=<?= $row['kode_produk']; ?>"><i class="fa fa-eye"></i></a></li>
												<?php if(isset($_SESSION['kode_cus'])) { ?>
												<li><a href="proses/add_cart.php?produk=<?= $row['kode_produk']; ?>&customer=<?= $kode_cus; ?>"><i class="fa fa-shopping-cart"></i></a></li>
												<?php } else { ?>
													<li><a href="#" data-toggle="modal" data-target="#loginModal" class="header__login-link"><i class="fa fa-shopping-cart"></i></a></li>
												<?php } ?>
											</ul>
										</div>
										<div class="product__discount__item__text">
											<span><?php echo $row['kategori']; ?></span>
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
											<h5><b><?php echo $row['nama']; ?></b></h5>
											<h5><b>Stock <span><?= $row['stok']; ?></span></b></h5>
											<div class="product__item__price">Rp. <?php echo $row['harga']; ?> <!--<span>Rp. <?php echo $row['harga']; ?></span>--></div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
                      </div>
                    </div>
                    <!-- Filter Section -->
					<?php
					// Query untuk menghitung total produk
					$query = "SELECT COUNT(*) as total_produk FROM produk";
					$result = mysqli_query($conn, $query);
					if ($result) {
						$row = mysqli_fetch_assoc($result);
						$total_produk = $row['total_produk'];
					} else {
						$total_produk = 0;
					}

					// Rest of your code

					?>
					<!-- Filter Section -->
					<div class="filter__item">
						<div class="row">
							<div class="col-lg-4 col-md-5">
								<div class="filter__sort">
									<span>Sort By</span>
									<select id="sortby">
										<option value="default">Default</option>
										<option value="default">Kategori</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4 col-md-4">
								<div class="filter__found">
									<h6><span><?php echo $total_produk; ?></span> Produk</h6>
								</div>
							</div>
							<div class="col-lg-4 col-md-3">
								<div class="filter__option">
									<span class="icon_grid-2x2"></span>
									<span class="icon_ul"></span>
								</div>
							</div>
						</div>
					</div>
					<!-- Rest of your code -->
                     <div class="col-lg-12 col-md-8">
						<!-- Tampilkan hasil pencarian dan produk berdasarkan kategori -->
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

							// Jika ada parameter 'kategori' dalam URL, gunakan query berdasarkan kategori
							if (isset($_GET['kategori'])) {
								$kategori = $_GET['kategori'];
								$query = "SELECT * FROM produk WHERE kategori = '$kategori' LIMIT $offset, $items_per_page";
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
													<li><a href="detail_produk.php?kode=<?= $row['kode_produk']; ?>"><i class="fa fa-eye"></i></a></li>
													<?php if(isset($_SESSION['kode_cus'])) { ?>
														<li><a href="proses/add_cart.php?produk=<?= $row['kode_produk']; ?>&customer=<?= $_SESSION['kode_cus']; ?>"><i class="fa fa-shopping-cart"></i></a></li>
													<?php } else { ?>
														<li><a href="#" data-toggle="modal" data-target="#loginModal" class="header__login-link"><i class="fa fa-shopping-cart"></i></a></li>
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
								// Tampilkan pesan jika produk yang dicari atau produk berdasarkan kategori tidak ditemukan
								if ($search_result) {
									echo '<div class="col-lg-12 text-center"><p><b><h5>Produk yang Anda cari tidak ditemukan.</h5></b></p></div>';
								}
							}
							?>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<nav aria-label="Page navigation">
									<!-- Tampilkan navigasi halaman -->
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
                </div>
            </div>
        </div>
    </section>

<?php include 'base/footer.php'; ?>