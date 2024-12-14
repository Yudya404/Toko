<?php include 'header.php'; ?>

				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					
					<?php include 'sidebar.php'; ?>
					
					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">
							<!--begin::Toolbar-->
							<div id="kt_app_toolbar" class="app-toolbar pt-5">
								<!--begin::Toolbar container-->
								<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
									<!--begin::Toolbar wrapper-->
									<div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
										<!--begin::Page title-->
										<div class="page-title d-flex flex-column gap-1 me-3 mb-2">
											<!--begin::Breadcrumb-->
											<ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-6">
												<!--begin::Item-->
												<li class="breadcrumb-item text-gray-700 fw-bold lh-1">
													<a href="../dist/index.html" class="text-gray-500">
														<i class="ki-duotone ki-home fs-3 text-gray-400 me-n1"></i>
													</a>
												</li>
												<!--end::Item-->
												<!--begin::Item-->
												<li class="breadcrumb-item">
													<i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
												</li>
												<!--end::Item-->
												<!--begin::Item-->
												<li class="breadcrumb-item text-gray-700 fw-bold lh-1">Beranda</li>
												<!--end::Item-->
											</ul>
											<!--end::Breadcrumb-->
											<!--begin::Title-->
											<h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0">Beranda</h1>
											<!--end::Title-->
										</div>
										<!--end::Page title-->
										<!--begin::Actions-->
										<!--end::Actions-->
									</div>
									<!--end::Toolbar wrapper-->
								</div>
								<!--end::Toolbar container-->
							</div>
							<!--end::Toolbar-->
							<!--begin::Content-->
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-fluid">
									<!--begin::Row-->
									<div class="row gx-5 gx-xl-10">
										<!--begin::Col-->
										<div class="col-xxl-6 mb-5 mb-xl-10">
											<!--begin::Chart widget 8-->
											<div class="card card-flush h-xl-100">
												<!--begin::Header-->
												<div class="card-header pt-5">
													<!--begin::Title-->
													<h3 class="card-title align-items-start flex-column">
														<span class="card-label fw-bold text-dark">Performance Overview</span>
													</h3>
													<!--end::Title-->
												</div>
												<!--end::Header-->
												<!--begin::Body-->
												<div class="card-body pt-6">
													<!--begin::Tab content-->
													<div class="tab-content">
														<!--begin::Tabs-->
																<?php
																if ($_SESSION['kategori_user'] == 'Admin') {
																// Tampilkan menu User hanya jika kategori_user adalah 'admin'
																?>
																<ul class="nav row row-cols-xl-4 row-cols-1 mb-5 ">
																	<li class="nav-item col mb-5 mb-lg-5">
																		<a class="nav-link btn btn-flex btn-secondary active  btn-active-dark d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-130px btn-hover-scale" href="produk.php">
																			<?php
																			$result = mysqli_query($conn, "SELECT COUNT(*) AS total_produk FROM produk");
																			if ($result) {
																				$row = mysqli_fetch_assoc($result);
																				$total_produk = $row['total_produk'];
																				?>
																				<div class="symbol symbol-40px mb-1">
																					<img src="assets/media/svg/illustrations/easy/1.svg" class="w-50px" alt="" />
																				</div>
																				<span class="fs-8 fw-bold">Total Produk</span>
																				<span class="fs-1 fw-bold"><?= $total_produk; ?></span>
																				<?php
																			} else {
																				echo "Gagal mengambil data: " . mysqli_error($conn);
																			}
																			?>
																		</a>
																	</li>
																	<li class="nav-item col mb-5 mb-lg-5">
																		<a class="nav-link btn btn-flex btn-light-info  btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-130px btn-hover-scale " href="customer.php">
																		<?php
																			$result = mysqli_query($conn, "SELECT COUNT(*) AS total_customer FROM customer");
																			if ($result) {
																				$row = mysqli_fetch_assoc($result);
																				$total_customer = $row['total_customer'];
																				?>
																				<div class="symbol symbol-40px mb-1">
																					<img src="assets/media/svg/illustrations/easy/2.svg" class="w-50px" alt="" />
																				</div>
																				<span class="fs-8 fw-bold">Total Customer</span>
																				<span class="fs-1 fw-bold"><?= $total_customer; ?></span>
																				<?php
																			} else {
																				echo "Gagal mengambil data: " . mysqli_error($conn);
																			}
																			?>
																		</a>
																	</li>
																	<li class="nav-item col mb-5 mb-lg-5">
																		<a class="nav-link btn btn-flex btn-light-warning  btn-active-primary d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-130px btn-hover-scale " href="pesanan.php">
																		<?php
																			$result = mysqli_query($conn, "SELECT COUNT(*) AS total_pesanan FROM t_pesanan");
																			if ($result) {
																				$row = mysqli_fetch_assoc($result);
																				$total_pesanan = $row['total_pesanan'];
																				?>
																				<div class="symbol symbol-40px mb-1">
																					<img src="assets/media/svg/illustrations/easy/1.svg" class="w-50px" alt="" />
																				</div>
																				<span class="fs-8 fw-bold">Total Pesanan</span>
																				<span class="fs-1 fw-bold"><?= $total_pesanan; ?></span>
																				<?php
																			} else {
																				echo "Gagal mengambil data: " . mysqli_error($conn);
																			}
																			?>
																		</a>
																	</li>
																	<li class="nav-item col mb-5 mb-lg-5">
																		<a class="nav-link btn btn-flex btn-light-success  btn-active-success d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-130px btn-hover-scale " href="rating.php">
																		<?php
																			$result = mysqli_query($conn, "SELECT COUNT(*) AS total_ulasan FROM rating");
																			if ($result) {
																				$row = mysqli_fetch_assoc($result);
																				$total_ulasan = $row['total_ulasan'];
																				?>
																			<div class="symbol symbol-40px mb-1">
																				<img src="assets/media/svg/illustrations/easy/2.svg" class="w-50px" alt="" />
																			</div>
																			<span class="fs-8 fw-bold">Total Ulasan</span>
																			<span class="fs-1 fw-bold"><?= $total_ulasan; ?></span>
																			<?php
																		} else {
																			echo "Gagal mengambil data: " . mysqli_error($conn);
																		}
																		?>
																		</a>
																	</li>
																	<li class="nav-item col mb-5 mb-lg-5">
																		<a class="nav-link btn btn-flex btn-light-danger  btn-active-danger d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-130px btn-hover-scale" href="pembatalan.php">
																			<?php
																			$result = mysqli_query($conn, "SELECT COUNT(*) AS total_pembatalan FROM t_pembatalan");
																			if ($result) {
																				$row = mysqli_fetch_assoc($result);
																				$total_pembatalan = $row['total_pembatalan'];
																				?>
																				<div class="symbol symbol-40px mb-1">
																					<img src="assets/media/svg/illustrations/easy/1.svg" class="w-50px" alt="" />
																				</div>
																				<span class="fs-8 fw-bold">Total Pesanan Batal</span>
																				<span class="fs-1 fw-bold"><?= $total_pembatalan; ?></span>
																				<?php
																			} else {
																				echo "Gagal mengambil data: " . mysqli_error($conn);
																			}
																			?>
																		</a>
																	</li>
																	<li class="nav-item col mb-5 mb-lg-5">
																		<a class="nav-link btn btn-flex btn-primary  btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-130px btn-hover-scale " href="penjualan.php">
																		<?php
																			$result = mysqli_query($conn, "SELECT COUNT(*) AS total_pesanan_selesai FROM t_pesanan WHERE status = 'Pesanan Selesai'");
																			if ($result) {
																				$row = mysqli_fetch_assoc($result);
																				$total_pesanan_selesai = $row['total_pesanan_selesai'];
																				?>
																				<div class="symbol symbol-40px mb-1">
																					<img src="assets/media/svg/illustrations/easy/2.svg" class="w-50px" alt="" />
																				</div>
																				<span class="fs-8 fw-bold">Total Pesanan Selesai</span>
																				<span class="fs-1 fw-bold"><?= $total_pesanan_selesai; ?></span>
																				<?php
																			} else {
																				echo "Gagal mengambil data: " . mysqli_error($conn);
																			}
																			?>
																		</a>
																	</li>
																	<li class="nav-item col mb-5 mb-lg-5">
																		<?php
																		$result = mysqli_query($conn, "SELECT COUNT(*) AS total_user FROM user");
																		if ($result) {
																		$row = mysqli_fetch_assoc($result);
																		$total_user = $row['total_user'];
																		?>
																		<a class="nav-link btn btn-flex btn-light-primary  btn-active-primary d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-130px btn-hover-scale " href="user.php">
																				<div class="symbol symbol-40px mb-1">
																					<img src="assets/media/svg/illustrations/easy/1.svg" class="w-50px" alt="" />
																				</div>
																				<span class="fs-8 fw-bold">Total User</span>
																				<span class="fs-1 fw-bold"><?= $total_user; ?></span>
																				<?php
																			} else {
																				echo "Gagal mengambil data: " . mysqli_error($conn);
																			}
																			?>
																		</a>
																	</li>
																	<li class="nav-item col mb-5 mb-lg-5">
																		<a class="nav-link btn btn-flex btn-success  btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-130px btn-hover-scale " href="user.php">
																		<?php
																			$result = mysqli_query($conn, "SELECT COUNT(*) AS total_driver FROM user WHERE kategori_user = 'Driver'");
																			if ($result) {
																				$row = mysqli_fetch_assoc($result);
																				$total_driver = $row['total_driver'];
																				?>
																			<div class="symbol symbol-40px mb-1">
																				<img src="assets/media/svg/illustrations/easy/2.svg" class="w-50px" alt="" />
																			</div>
																			<span class="fs-8 fw-bold">Total Driver</span>
																			<span class="fs-1 fw-bold"><?= $total_driver; ?></span>
																			<?php
																		} else {
																			echo "Gagal mengambil data: " . mysqli_error($conn);
																		}
																		?>
																		</a>
																	</li>
																</ul>
																<?php
																}
																?>
																
																<?php
																if ($_SESSION['kategori_user'] == 'User') {
																// Tampilkan menu User hanya jika kategori_user adalah 'admin'
																?>
																<ul class="nav row row-cols-xl-3 row-cols-1 mb-5 ">
																	<li class="nav-item col mb-5 mb-lg-5">
																		<a class="nav-link btn btn-flex btn-secondary active  btn-active-dark d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-130px btn-hover-scale" href="produk.php">
																			<?php
																			$result = mysqli_query($conn, "SELECT COUNT(*) AS total_produk FROM produk");
																			if ($result) {
																				$row = mysqli_fetch_assoc($result);
																				$total_produk = $row['total_produk'];
																				?>
																				<div class="symbol symbol-40px mb-1">
																					<img src="assets/media/svg/illustrations/easy/1.svg" class="w-50px" alt="" />
																				</div>
																				<span class="fs-8 fw-bold">Total Produk</span>
																				<span class="fs-1 fw-bold"><?= $total_produk; ?></span>
																				<?php
																			} else {
																				echo "Gagal mengambil data: " . mysqli_error($conn);
																			}
																			?>
																		</a>
																	</li>
																	<li class="nav-item col mb-5 mb-lg-5">
																		<a class="nav-link btn btn-flex btn-light-info  btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-130px btn-hover-scale " href="customer.php">
																		<?php
																			$result = mysqli_query($conn, "SELECT COUNT(*) AS total_customer FROM customer");
																			if ($result) {
																				$row = mysqli_fetch_assoc($result);
																				$total_customer = $row['total_customer'];
																				?>
																				<div class="symbol symbol-40px mb-1">
																					<img src="assets/media/svg/illustrations/easy/2.svg" class="w-50px" alt="" />
																				</div>
																				<span class="fs-8 fw-bold">Total Customer</span>
																				<span class="fs-1 fw-bold"><?= $total_customer; ?></span>
																				<?php
																			} else {
																				echo "Gagal mengambil data: " . mysqli_error($conn);
																			}
																			?>
																		</a>
																	</li>
																	<li class="nav-item col mb-5 mb-lg-5">
																		<a class="nav-link btn btn-flex btn-light-warning  btn-active-primary d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-130px btn-hover-scale " href="pesanan.php">
																		<?php
																			$result = mysqli_query($conn, "SELECT COUNT(*) AS total_pesanan FROM t_pesanan");
																			if ($result) {
																				$row = mysqli_fetch_assoc($result);
																				$total_pesanan = $row['total_pesanan'];
																				?>
																				<div class="symbol symbol-40px mb-1">
																					<img src="assets/media/svg/illustrations/easy/1.svg" class="w-50px" alt="" />
																				</div>
																				<span class="fs-8 fw-bold">Total Pesanan</span>
																				<span class="fs-1 fw-bold"><?= $total_pesanan; ?></span>
																				<?php
																			} else {
																				echo "Gagal mengambil data: " . mysqli_error($conn);
																			}
																			?>
																		</a>
																	</li>
																	<li class="nav-item col mb-5 mb-lg-5">
																		<a class="nav-link btn btn-flex btn-light-success  btn-active-success d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-130px btn-hover-scale " href="rating.php">
																		<?php
																			$result = mysqli_query($conn, "SELECT COUNT(*) AS total_ulasan FROM rating");
																			if ($result) {
																				$row = mysqli_fetch_assoc($result);
																				$total_ulasan = $row['total_ulasan'];
																				?>
																			<div class="symbol symbol-40px mb-1">
																				<img src="assets/media/svg/illustrations/easy/2.svg" class="w-50px" alt="" />
																			</div>
																			<span class="fs-8 fw-bold">Total Ulasan</span>
																			<span class="fs-1 fw-bold"><?= $total_ulasan; ?></span>
																			<?php
																		} else {
																			echo "Gagal mengambil data: " . mysqli_error($conn);
																		}
																		?>
																		</a>
																	</li>
																	<li class="nav-item col mb-5 mb-lg-5">
																		<a class="nav-link btn btn-flex btn-light-danger  btn-active-danger d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-130px btn-hover-scale" href="pembatalan.php">
																			<?php
																			$result = mysqli_query($conn, "SELECT COUNT(*) AS total_pembatalan FROM t_pembatalan");
																			if ($result) {
																				$row = mysqli_fetch_assoc($result);
																				$total_pembatalan = $row['total_pembatalan'];
																				?>
																				<div class="symbol symbol-40px mb-1">
																					<img src="assets/media/svg/illustrations/easy/1.svg" class="w-50px" alt="" />
																				</div>
																				<span class="fs-8 fw-bold">Total Pesanan Batal</span>
																				<span class="fs-1 fw-bold"><?= $total_pembatalan; ?></span>
																				<?php
																			} else {
																				echo "Gagal mengambil data: " . mysqli_error($conn);
																			}
																			?>
																		</a>
																	</li>
																	<li class="nav-item col mb-5 mb-lg-5">
																		<a class="nav-link btn btn-flex btn-primary  btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-130px btn-hover-scale " href="penjualan.php">
																		<?php
																			$result = mysqli_query($conn, "SELECT COUNT(*) AS total_pesanan_selesai FROM t_pesanan WHERE status = 'Pesanan Selesai'");
																			if ($result) {
																				$row = mysqli_fetch_assoc($result);
																				$total_pesanan_selesai = $row['total_pesanan_selesai'];
																				?>
																				<div class="symbol symbol-40px mb-1">
																					<img src="assets/media/svg/illustrations/easy/2.svg" class="w-50px" alt="" />
																				</div>
																				<span class="fs-8 fw-bold">Total Pesanan Selesai</span>
																				<span class="fs-1 fw-bold"><?= $total_pesanan_selesai; ?></span>
																				<?php
																			} else {
																				echo "Gagal mengambil data: " . mysqli_error($conn);
																			}
																			?>
																		</a>
																	</li>
																</ul>
																<?php
																}
																?>
																
																<?php
																if ($_SESSION['kategori_user'] == 'Driver') {
																// Tampilkan menu User hanya jika kategori_user adalah 'admin'
																?>
																<ul class="nav row row-cols-xl-2 row-cols-1 mb-5 ">
																	<li class="nav-item col mb-5 mb-lg-5">
																		<a class="nav-link btn btn-flex btn-light-warning  btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-130px btn-hover-scale " href="#" data-bs-toggle="modal" data-bs-target="#modalPesananDikirim">
																		<?php
																			$result = mysqli_query($conn, "SELECT COUNT(*) AS total_diproses FROM t_pesanan WHERE status = 'Pesanan Diproses' ORDER BY kode_p DESC LIMIT 5");
																			if ($result) {
																				$row = mysqli_fetch_assoc($result);
																				$total_diproses = $row['total_diproses'];
																				?>
																				<div class="symbol symbol-40px mb-1">
																					<img src="assets/media/svg/illustrations/easy/2.svg" class="w-50px" alt="" />
																				</div>
																				<span class="fs-8 fw-bold">Total Dalam Pengiriman</span>
																				<span class="fs-1 fw-bold"><?= $total_diproses; ?></span>
																				<?php
																			} else {
																				echo "Gagal mengambil data: " . mysqli_error($conn);
																			}
																			?>
																		</a>
																	</li>
																	<li class="nav-item col mb-5 mb-lg-5">
																		<a class="nav-link btn btn-flex btn-light-success  btn-active-success d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-130px btn-hover-scale " href="#" data-bs-toggle="modal" data-bs-target="#modalPesananSampai">
																		<?php
																			$result = mysqli_query($conn, "SELECT COUNT(*) AS total_pesanan_sampai FROM t_pesanan WHERE status = 'Pesanan Sampai Tujuan'");
																			if ($result) {
																				$row = mysqli_fetch_assoc($result);
																				$total_pesanan_sampai = $row['total_pesanan_sampai'];
																				?>
																				<div class="symbol symbol-40px mb-1">
																					<img src="assets/media/svg/illustrations/easy/2.svg" class="w-50px" alt="" />
																				</div>
																				<span class="fs-8 fw-bold">Total Pesanan Sampai Tujuan</span>
																				<span class="fs-1 fw-bold"><?= $total_pesanan_sampai; ?></span>
																				<?php
																			} else {
																				echo "Gagal mengambil data: " . mysqli_error($conn);
																			}
																			?>
																		</a>
																	</li>
																</ul>
																<?php
																}
																?>
															</div>
														</div>
														<!--end::Nav-->
													</div>
													<!--end::Tab content-->
												</div>
												<!--end::Body-->
											</div>
											<!--begin::Chart widget 8-->
											<?php
											if ($_SESSION['kategori_user'] == 'Admin' || $_SESSION['kategori_user'] == 'User') {
												// Tampilkan menu User jika kategori_user adalah 'Admin' atau 'User'
											?>
											<div class="card card-flush h-xl-100">
												<!--begin::Header-->
												<div class="card-header pt-5">
													<!--begin::Title-->
													<h3 class="card-title align-items-start flex-column">
														<span class="card-label fw-bold text-dark">Pesanan Customer</span>
													</h3>
													<!--end::Title-->
												</div>
												<!--end::Header-->
												<!--begin::Body-->
												<div class="card-body pt-6">
													<!--begin::Table-->
													<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
														<thead>
															<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
																<th class="min-w-100px">No Pesanan</th>
																<th class="min-w-200px">Customer</th>
																<th class="min-w-70px">Total QTY</th>
																<th class="min-w-90px">Total Harga</th>
																<th class="min-w-250px">Detail Pesanan</th>
																<th class="min-w-60px">Aksi</th>
															</tr>
														</thead>
														<tbody class="text-gray-600 fw-semibold">
															
														</tbody>
													</table>
													<!--end::Table-->
												</div>
												<!--end::Body-->
											</div>
											<?php
											}
											?>
											<!--end::Chart widget 8-->
											<!--begin::Chart widget 8
											<div class="card card-flush h-xl-100">
												<!--begin::Header
												<div class="card-header pt-5">
													<!--begin::Title
													<h3 class="card-title align-items-start flex-column">
														<span class="card-label fw-bold text-dark">Grafik Kunjungan Pelanggan Di Toko Bu Heru</span>
													</h3>
													<!--end::Title
												</div>
												<!--end::Header
												<!--begin::Body
												<div class="card-body pt-6">
													<div id="chartContainer">
														<canvas id="visitorChart"></canvas>
													</div>
												</div>
												<!--end::Body
											</div>
											<!--end::Chart widget 8-->
										</div>
										<!--end::Col-->
									</div>
								<!--end::Content wrapper-->
								
<?php include 'footer.php'; ?>