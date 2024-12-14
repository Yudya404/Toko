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
												<li class="breadcrumb-item text-gray-700 fw-bold lh-1">Transaksi</li>
												<!--end::Item-->
												<!--begin::Item-->
												<li class="breadcrumb-item">
													<i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
												</li>
												<!--end::Item-->
												<!--begin::Item-->
												<li class="breadcrumb-item text-gray-700">Produk</li>
												<!--end::Item-->
											</ul>
											<!--end::Breadcrumb-->
											<!--begin::Title-->
											<h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0">Produk</h1>
											<!--end::Title-->
										</div>
										<!--end::Page title-->
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
									<!--begin::Card-->
									<div class="card">
										<!--begin::Card header-->
										<div class="card-header border-0 pt-6">
											<!--begin::Card title-->
											<div class="card-title">
												<!--begin::Search-->
												<div class="d-flex align-items-center position-relative my-1">
													<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
													<input type="text" id="searchInput" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Cari Produk" />
												</div>
												<!--end::Search-->
											</div>
											<!--begin::Card title-->
											<!--begin::Card toolbar-->
											<div class="card-toolbar">
												<!--begin::Toolbar-->
												<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
													<!--begin::Export-->
													<button type="button" data-bs-toggle="modal" data-bs-target="#modalCetakProduk" class="btn btn-light-primary me-3"><i class="fa fa-print"></i>Cetak</button>
													<!--end::Export-->
													<!--begin::Modal - Cetak-->
													<div class="modal fade" id="modalCetakProduk" tabindex="-1" aria-hidden="true">
													<!--begin::Modal dialog-->
													<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
														<!--begin::Modal content-->
														<div class="modal-content">
															<!--begin::Modal header-->
															<div class="modal-header" id="kt_modal_add_user_header">
																<!--begin::Modal title-->
																<h2 class="fw-bold">Cetak Produk</h2>
																<!--end::Modal title-->
																<!--begin::Close-->
																<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
																	<i class="ki-duotone ki-cross fs-1">
																		<span class="path1"></span>
																		<span class="path2"></span>
																	</i>
																</div>
																<!--end::Close-->
															</div>
															<!--end::Modal header-->
															<!--begin::Modal body-->
															<div class="modal-body" id="modalBody">
																<!--begin::Table-->
																	<table class="table align-middle table-row-dashed fs-6 gy-5">
																		<thead>
																			<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
																				<th class="min-w-5px">No</th>
																				<th class="min-w-200px">Produk</th>
																				<th class="text-center min-w-50px">Stok</th>
																				<th class="text-center min-w-70px">Harga</th>
																				<th class="text-center min-w-300px">Deskripsi</th>
																				<th class="text-center min-w-50px">Satuan</th>
																				<th class="text-center min-w-150px">Tgl EXP</th>
																			</tr>
																		</thead>
																		<tbody class="text-gray-600 fw-semibold">
																		
																		<?php
																			$no = 1;
																			$totalHargaSemuaProduk = 0; // Inisialisasi total harga semua pesanan
																			$totalQtySemuaProduk = 0; // Inisialisasi total jumlah semua pesanan
																			$result = mysqli_query($conn, "SELECT * FROM produk ORDER BY kode_produk DESC");
																			while ($row = mysqli_fetch_assoc($result)) {
																				
																				// Hitung total harga pesanan saat ini dan tambahkan ke total keseluruhan
																				$totalHargaSemuaProduk += floatval($row['harga']);
																				
																				// Hitung total jumlah pesanan saat ini dan tambahkan ke total keseluruhan
																				$totalQtySemuaProduk += intval($row['stok']);
																		?>
																		
																			<tr>
																				<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
																				<td class="d-flex align-items-center">
																					<!--begin:: Avatar -->
																					<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																						<a href="#">
																							<div class="symbol-label">
																								<img src="proses/<?= $row['foto_produk']; ?>" alt="Gambar Produk" class="w-100" />
																							</div>
																						</a>
																					</div>
																					<!--end::Avatar-->
																					<!--begin::User details-->
																					<div class="d-flex flex-column">
																						<a href="#" class="text-gray-800 text-hover-primary mb-1"><?= $row['nama'];  ?></a>
																						<span><?= $row['kode_produk'];  ?></span>
																					</div>
																					<!--begin::User details-->
																				</td>
																				<td class="text-center">
																					<?php
																					$stok = $row['stok'];

																					if ($stok < 10 && $stok > 0) {
																						echo '<span class="badge badge-light-warning">Re-stock</span>';
																						echo '<span class="fw-bold text-warning ms-3">' . $stok . '</span>';
																					} elseif ($stok == 0) {
																						echo '<span class="badge badge-light-danger">Stok Habis</span>';
																						echo '<span class="fw-bold text-danger ms-3">' . $stok . '</span>';
																					} else {
																						echo '<span class="fw-bold text-success ms-3">' . $stok . '</span>';
																					}
																					?>
																				</td>
																				<td class="text-center"><?= $row['harga'];  ?></td>
																				<td class="text-center"><?= $row['deskripsi'];  ?></td>
																				<td class="text-center"><div class="text-gray-800 text-hover-primary"><?= $row['satuan'];  ?></div></td>
																				<td class="text-center"><?= formatTanggalIndonesia($row['tgl_exp']); ?></td>
																			</tr>
																			<?php
																			}
																			?>
																			
																		</tbody>
																	</table>
																	<!--end::Table-->
																</div>
																<!--end::Modal body-->
																<div class="modal-footer">
																	<?php
																	// Query untuk menghitung total pesanan dengan status "Pesanan Selesai"
																	$queryTotalProduk = "SELECT COUNT(*) AS total_produk FROM produk";
																	$resultTotalProduk = mysqli_query($conn, $queryTotalProduk);
																	$rowTotalProduk = mysqli_fetch_assoc($resultTotalProduk);
																	$totalProduk= $rowTotalProduk['total_produk'];
																	?>
																	<div class="text-start">
																		<div class="d-flex flex-column">
																			<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Semua Produk: <?= $totalProduk; ?> Produk</h5></span>
																			<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Semua Stok Produk	: <?= $totalQtySemuaProduk; ?> Item</h5></span>
																			<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Harga Produk	: Rp. <?= number_format($totalHargaSemuaProduk, 2); ?></h5></span>
																		</div>
																	</div>
																	<div class="text-end">
																		<button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
																		<button type="button" onclick="cetakProduk('modalBody')" class="btn btn-primary"><i class="fa fa-print"></i>Cetak</button>
																	</div>
																</div>
															</div>
															<!--end::Modal content-->
														</div>
														<!--end::Modal dialog-->
													</div>
													<!--end::Modal - Cetak-->
													<!--begin::Add Produk-->
													<a href="tambah_produk.php" class="btn btn-primary"><i class="ki-duotone ki-plus fs-2"></i>Tambah Produk</a>
													<!--end::Add Produk-->
												</div>
												<!--end::Toolbar-->
											</div>
											<!--end::Card toolbar-->
										</div>
										<!--end::Card header--><!--begin::Card body-->
										<div class="card-body py-4">
											<!--begin::Table-->
											<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
												<thead>
													<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
														<th class="min-w-5px">No</th>
														<th class="min-w-200px">Produk</th>
														<th class="min-w-60px">Stok</th>
														<th class="text-center min-w-70px">Harga</th>
														<th class="text-center min-w-300px">Deskripsi</th>
														<th class="text-center min-w-50px">Satuan</th>
														<th class="text-center min-w-150px">Tgl EXP</th>
														<th class="text-center min-w-60px">Aksi</th>
													</tr>
												</thead>
												<tbody class="text-gray-600 fw-semibold">
													<?php
														$no = 1;
														$totalHargaSemuaProduk = 0; // Inisialisasi total harga semua pesanan
														$totalQtySemuaProduk = 0; // Inisialisasi total jumlah semua pesanan
														$result = mysqli_query($conn, "SELECT * FROM produk ORDER BY kode_produk DESC");
														while ($row = mysqli_fetch_assoc($result)) {
															
															// Hitung total harga pesanan saat ini dan tambahkan ke total keseluruhan
															$totalHargaSemuaProduk += floatval($row['harga']);
															
															// Hitung total jumlah pesanan saat ini dan tambahkan ke total keseluruhan
															$totalQtySemuaProduk += intval($row['stok']);
													?>
													<tr>
														<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
														<td class="d-flex align-items-center">
															<!--begin:: Avatar -->
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="#">
																	<div class="symbol-label">
																		<img src="proses/<?= $row['foto_produk']; ?>" alt="Gambar Produk" class="w-100" />
																	</div>
																</a>
															</div>
															<!--end::Avatar-->
															<!--begin::User details-->
															<div class="d-flex flex-column">
																<a href="#" class="text-gray-800 text-hover-primary mb-1"><?= $row['nama'];  ?></a>
																<span><?= $row['kode_produk'];  ?></span>
															</div>
															<!--begin::User details-->
														</td>
														<td class="text-end">
															<?php
															$stok = $row['stok'];

															if ($stok < 10 && $stok > 0) {
																echo '<span class="badge badge-light-warning">Re-stock</span>';
																echo '<span class="fw-bold text-warning ms-3">' . $stok . '</span>';
															} elseif ($stok == 0) {
																echo '<span class="badge badge-light-danger">Stok Habis</span>';
																echo '<span class="fw-bold text-danger ms-3">' . $stok . '</span>';
															} else {
																echo '<span class="fw-bold text-success ms-3">' . $stok . '</span>';
															}
															?>
														</td>
														<td class="text-center"><?= $row['harga'];  ?></td>
														<td class="text-center"><?= $row['deskripsi'];  ?></td>
														<td class="text-center"><div class="text-gray-800 text-hover-primary"><?= $row['satuan'];  ?></div></td>
							 							<td class="text-center"><?= formatTanggalIndonesia($row['tgl_exp']); ?></td>
														<td class="text-center">
															<!--begin::Menu item-->
															<div class="menu-item px-2">
																<div class="btn-group" role="group">
																	<a href="edit_produk.php?kode=<?= $row['kode_produk']; ?>" class="btn btn-primary" ><i class="fa fa-edit"></i></a>
																	<button type="button" class="btn btn-danger" data-tabel="produk" data-kode-pro="<?= $row['kode_produk']; ?>"><i class="fa fa-trash"></i></button>
																</div>
															</div>
															<!--end::Menu item-->
														</td>
													</tr>
													<?php
													}
													?>
													
												</tbody>
											</table>
											<!--end::Table-->
											<?php
											// Query untuk menghitung total pesanan dengan status "Pesanan Selesai"
											$queryTotalProduk = "SELECT COUNT(*) AS total_produk FROM produk";
											$resultTotalProduk = mysqli_query($conn, $queryTotalProduk);
											$rowTotalProduk = mysqli_fetch_assoc($resultTotalProduk);
											$totalProduk= $rowTotalProduk['total_produk'];
											?>
											<div class="text-start">
												<div class="d-flex flex-column">
													<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Semua Produk: <?= $totalProduk; ?> Produk</h5></span>
													<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Semua Stok Produk	: <?= $totalQtySemuaProduk; ?> Item</h5></span>
													<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Harga Produk	: Rp. <?= number_format($totalHargaSemuaProduk, 2); ?></h5></span>
												</div>
											</div>
										</div>
										<!--end::Card body-->
									</div>
									<!--end::Card-->
								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>
						<!--end::Content wrapper-->
						
<?php include 'footer.php'; ?>