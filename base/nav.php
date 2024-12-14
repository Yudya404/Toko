 <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
								<?php
									$nama = "No Telp & WA"; // Ganti dengan nama yang ingin dicari
									$result = mysqli_query($conn, "SELECT * FROM kontak");
									while ($row = mysqli_fetch_assoc($result)) {
									if ($row['nama'] == $nama) {
								?>
								<li><i class="fa fa-whatsapp" style="color:green"></i> <?= $row['isi']; ?></li>
								<?php
									}
								}
								?>
								<?php
									$nama = "Email"; // Ganti dengan nama yang ingin dicari
									$result = mysqli_query($conn, "SELECT * FROM kontak");
									while ($row = mysqli_fetch_assoc($result)) {
									if ($row['nama'] == $nama) {
								?>
								<li><i class="fa fa-envelope" style="color:red"></i> <?= $row['isi']; ?></li>
								<?php
									}
								}
								?>
							</ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
								<a href="https://www.instagram.com/"><i class="fa fa-instagram" style="color:pink"></i></a>
								<a href="https://www.whatsapp.com/"><i class="fa fa-whatsapp" style="color:green"></i></a>
								<a href="https://www.google.com/intl/id/gmail/about/"><i class="fa fa-envelope" style="color:red"></i></a>
							</div>
                            <div class="header__top__right__auth">
							   <?php if (isset($_SESSION["kode_cus"])) { ?>
									<div class="header__user-dropdown">
										<a href="#" class="header__user-dropdown-toggle">
											<i class="fa fa-user"></i> <?= $_SESSION['nama']; ?>
										</a>
										<ul class="header__user-dropdown-menu text-left">
											<li><a href="profilku.php"><i class="fa fa-user"></i>&nbsp;&nbsp; Profilku</a></li>
											<li><a href="riwayat_belanja.php"><i class="fa fa-shopping-bag"></i>&nbsp;&nbsp;Riwayat Belanja</a></li>
											<li><a href="#" onclick="confirmLogout()"><i class="fa fa-sign-out"></i>&nbsp;&nbsp; Logout</a></li>
										</ul>
									</div>
								<?php } else { ?>
									<a href="#" data-toggle="modal" data-target="#loginModal" class="header__login-link">
										<i class="fa fa-user"></i> Login
									</a>
								<?php } ?>
								<!-- Modal -->
								<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="false" aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content" style="background-image: url('img/blog/blog-2.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center;">
											<div class="modal-header">
												<h5 class="modal-title" style="color:green" id="exampleModalLabel">Halaman Login Customer</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<!--begin::Heading-->
												<div class="px-10 text-center mb-10">
													<?php
														$nama = "Gambar Login Customer"; // Ganti dengan nama yang ingin dicari
														$result = mysqli_query($conn, "SELECT * FROM about");
														while ($row = mysqli_fetch_assoc($result)) {
															if ($row['nama'] == $nama) {
													?>
														<img src="back/dist/proses/<?= $row['gambar_a']; ?>" height="100px" alt="Gambar Logo">
													<?php
														}		
													}
													?>
												</div>
												<!-- Form Login -->
												<form action="proses/verifikasi_login.php" method="POST">
													<div class="form-group text-left">
														<label for="email">Email:</label>
														<input type="email" class="form-control" id="email" name="email" required>
													</div>
													<div class="form-group text-left">
														<label for="password">Password:</label>
														<input type="password" class="form-control" id="pass" name="pass" required>
													</div>
													<button type="submit" class="site-btn w-100 mb-5">Login</button>
													<div class="text-center">Belum punya akun? <a href="register.php" class="text-primary" id="signup-link">Buat akun baru</a></div>
												</form>
											</div>
											<div class="modal-footer">
												<div class="text-center">
													<a href="#" data-toggle="modal" data-target="#bantuan" class="text-primary" id="help-link">Butuh bantuan? </a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- Modal -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
						<?php
							$nama = "Gambar Logo Header"; // Ganti dengan nama yang ingin dicari
							$result = mysqli_query($conn, "SELECT * FROM about");
							while ($row = mysqli_fetch_assoc($result)) {
							if ($row['nama'] == $nama) {
						?>
                        <a href="./index.php"><img src="back/dist/proses/<?= $row['gambar_a']; ?>" alt="Gambar Logo"></a>
						<?php
							}		
						}
						?>
                    </div> 
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="./index.php">Beranda</a></li>
							<li><a href="./produk.php">Produk</a></li>
                            <li><a href="#">Halaman</a>
                                <ul class="header__menu__dropdown">
									<li><a href="./about.php">Tentang Kami</a></li>
									<?php
										if (isset($_SESSION['kode_cus'])) {
										// User sudah login, tampilkan elemen
										echo '<li><a href="./mohonMaaf.php">Ulasan</a></li>';
									}
									?>
                                    <li><a href="./mohonMaaf.php">Blog</a></li>
                                </ul>
                            </li>
							<li><a href="./contact.php">Kontak</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
					<div class="header__cart">
						<ul>
							<?php
							// Periksa apakah customer sudah login
							if (isset($_SESSION['kode_cus'])) {
								// Ambil kode customer dari sesi
								$kode_cus = $_SESSION['kode_cus'];

								// Query untuk menghitung jumlah barang di keranjang customer
								$query_barang = "SELECT COUNT(*) AS total_barang FROM cart WHERE kode_cus = '$kode_cus'";
								$result_barang = mysqli_query($conn, $query_barang);
								$row_barang = mysqli_fetch_assoc($result_barang);
								$total_barang = $row_barang['total_barang'];

								// Query untuk menghitung total harga dari barang di keranjang customer
								$query_total_harga = "SELECT SUM(harga * jumlah) AS total_harga FROM cart WHERE kode_cus = '$kode_cus'";
								$result_total_harga = mysqli_query($conn, $query_total_harga);
								$row_total_harga = mysqli_fetch_assoc($result_total_harga);
								$total_harga = $row_total_harga['total_harga'];

								// Tampilkan jumlah barang di keranjang dan total harga
								echo '<li><a href="./cart.php"><i class="fa fa-shopping-cart" style="color:orange"></i> <span>' . $total_barang . '</span></a></li>';
							}
							?>
							<?php
							// Periksa apakah customer sudah login
							if (isset($_SESSION['kode_cus'])) {
								// Ambil kode customer dari sesi
								$kode_cus = $_SESSION['kode_cus'];

								// Query untuk menghitung jumlah pesanan yang sedang dalam status "Pesanan Menunggu Diproses" dan "Pesanan Diproses"
								$query_pesanan = "SELECT COUNT(*) AS total_pesanan FROM t_pesanan WHERE kode_cus = '$kode_cus' AND (status = 'Pesanan Menunggu Diproses' OR status = 'Pesanan Diproses')";
								$result_pesanan = mysqli_query($conn, $query_pesanan);
								$row_pesanan = mysqli_fetch_assoc($result_pesanan);
								$total_pesanan = $row_pesanan['total_pesanan'];

								// Tampilkan jumlah pesanan di keranjang
								echo '<li><a href="./riwayat_belanja.php"><i class="fa fa-shopping-bag" style="color:green"></i> <span>' . $total_pesanan . '</span></a></li>';
							}
							?>
							<?php
							if (isset($_SESSION['kode_cus'])) {
								// Ambil kode customer dari sesi
								$kode_cus = $_SESSION['kode_cus'];

								// Query untuk menghitung jumlah rating dengan status "Belum Dinilai" atau "Periksa"
								$query_rating = "SELECT COUNT(*) AS total_rating FROM rating WHERE kode_cus = '$kode_cus' AND (status_rating = 'Belum Dinilai')";
								$result_rating = mysqli_query($conn, $query_rating);
								$row_rating = mysqli_fetch_assoc($result_rating);
								$total_rating = $row_rating['total_rating'];

								// Tampilkan jumlah rating belum dinilai
								echo '<li><a href="./riwayat_rating.php"><i class="fa fa-heart" style="color:red"></i> <span>' . $total_rating . '</span></a></li>';
							}
							?>
						</ul>
					</div>
				</div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->
