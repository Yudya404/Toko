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
												<li class="breadcrumb-item text-gray-700">Pesanan</li>
												<!--end::Item-->
											</ul>
											<!--end::Breadcrumb-->
											<!--begin::Title-->
											<h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0">Pesanan</h1>
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
													<input type="text" id="searchInput" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Cari Pesanan" />
												</div>
												<!--end::Search-->
											</div>
											<!--begin::Card title-->
											<!--begin::Card toolbar-->
											<div class="card-toolbar">
												<!--begin::Toolbar-->
												<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
													<!--begin::Export
													<button type="button" data-bs-toggle="modal" data-bs-target="#modalCetakPesanan" class="btn btn-light-primary me-3"><i class="fa fa-print"></i>Cetak Pesanan</button>
													<!--end::Export-->
													<!--begin::Modal - Cetak-->
													<div class="modal fade" id="modalCetakPesanan" tabindex="-1" aria-hidden="true">
													<!--begin::Modal dialog-->
													<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
														<!--begin::Modal content-->
														<div class="modal-content">
															<!--begin::Modal header-->
															<div class="modal-header" id="kt_modal_add_user_header">
																<!--begin::Modal title-->
																<h2 class="fw-bold">Cetak Pesanan</h2>
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
																				<th class="min-w-200px">Pesanan</th>
																				<th class="text-center min-w-70px">Total QTY</th>
																				<th class="text-center min-w-70px">Total Harga</th>
																				<th class="text-start min-w-150px">Detail Pesanan</th>
																				<th class="text-center min-w-50px">Status</th>
																				<th class="text-center min-w-150px">Tanggal Pesanan</th>
																			</tr>
																		</thead>
																		<tbody class="text-gray-600 fw-semibold">
																		
																		<?php
																			$no = 1;
																			$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, 
																										   CASE 
																											 WHEN t.status = 'Pesanan Menunggu Diproses' THEN 'Pesanan Menunggu Diproses' 
																											 WHEN t.status = 'Pesanan Diproses' THEN 'Pesanan Diproses' 
																										   END AS status
																										   FROM t_pesanan t
																										   JOIN customer c ON t.kode_cus = c.kode_cus
																										   WHERE t.status = 'Pesanan Menunggu Diproses' OR t.status = 'Pesanan Diproses'
																										   ORDER BY t.kode_p DESC");

																			while ($row = mysqli_fetch_assoc($result)) {
																				// Ubah JSON menjadi bentuk array menggunakan json_decode
																				$detailPesanan = json_decode($row['detail_pesanan'], true);
																				
																		?>
																		
																			<tr>
																				<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
																				<td class="text-gray-800 text-hover-primary">
																					<!--begin::User details-->
																					<div class="d-flex flex-column">
																						<a href="#" class="text-gray-800 text-hover-primary mb-1 text-center"><h5><?= $row['nama'];  ?></h5></a>
																						<span class="text-center"><?= $row['kode_p'];  ?></span>
																						<span class="text-center"> Syarat&Ketentuan </span>
																						<span class="text-center"><?= $row['checkbox'];  ?></span>
																					</div>
																					<!--begin::User details-->
																				</td>
																				<td class="text-center"><?= $row['t_item'];  ?></td>
																				<td class="text-center"><?= $row['t_harga'];  ?></td>
																				<td class="text-start">
																					<?php
																					foreach ($detailPesanan as $item) {
																						echo "Nama Barang : " . $item['nama_produk'] . "<br>";
																						echo "Jumlah Item : " . $item['jumlah'] . "<br>";
																						echo "Harga Per Item : " . $item['harga_per_item'] . "<br><br>";
																					}
																					?>
																				</td>
																				<td class="text-center">
																					<?php
																					// Cek status untuk menentukan kelas CSS
																					$status = $row['status'];
																					$statusClass = '';

																					if ($status == 'Pesanan Selesai') {
																						$statusClass = 'badge-light-primary';
																					} elseif ($status == 'Pesanan Sampai Tujuan') {
																						$statusClass = 'badge-light-success';
																					} elseif ($status == 'Pesanan Dalam Pengiriman') {
																						$statusClass = 'badge-light-warning';
																					} elseif ($status == 'Pesanan Diproses') {
																						$statusClass = 'badge-light-warning';
																					} elseif ($status == 'Pesanan Menunggu Diproses') {
																						$statusClass = 'badge-light-warning';
																					} elseif ($status == 'Pesanan Dibuat') {
																						$statusClass = 'badge-light-secondary';
																					} elseif ($status == 'Pesanan Dibatalkan') {
																						$statusClass = 'badge-light-danger';
																					}

																					// Tampilkan status dengan kelas CSS yang sesuai
																					echo '<span class="badge form-label fs-5 ' . $statusClass . '">' . $status . '</span>';
																					?>
																				</td>
																				<td class="text-center"><?= formatTanggalIndonesia($row['tgl_pesan']); ?></td>
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
																	// Query untuk menghitung total pesanan dengan status "Pesanan Batal"
																	$queryTotalMenungguDiproses = "SELECT COUNT(*) AS total_menunggu_diproses FROM t_pesanan WHERE status = 'Pesanan Menunggu Diproses'";
																	$resultTotalMenungguDiproses = mysqli_query($conn, $queryTotalMenungguDiproses);
																	$rowTotalMenungguDiproses = mysqli_fetch_assoc($resultTotalMenungguDiproses);
																	$totalPesananMenungguDiproses = $rowTotalMenungguDiproses['total_menunggu_diproses'];
																	
																	// Query untuk menghitung total pesanan dengan status "Pesanan Batal"
																	$queryTotalDiproses = "SELECT COUNT(*) AS total_diproses FROM t_pesanan WHERE status = 'Pesanan Diproses'";
																	$resultTotalDiproses = mysqli_query($conn, $queryTotalDiproses);
																	$rowTotalDiproses = mysqli_fetch_assoc($resultTotalDiproses);
																	$totalPesananDiproses = $rowTotalDiproses['total_diproses'];
																	?>
																	<div class="text-start">
																		<div class="d-flex flex-column">
																			<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Pesanan Menunggu Diproses : <?= $totalPesananMenungguDiproses; ?> Pesanan</h5></span>
																			<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Pesanan Diproses : <?= $totalPesananDiproses; ?> Pesanan</h5></span>
																		</div>
																	</div>
																	<div class="text-end">
																		<button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
																		<button type="button" onclick="cetakPesanan('modalBody')" class="btn btn-primary"><i class="fa fa-print"></i>Cetak</button>
																	</div>
																</div>
															</div>
															<!--end::Modal content-->
														</div>
														<!--end::Modal dialog-->
													</div>
													<!--end::Modal - Cetak-->
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
														<th class="min-w-200px">Customer</th>
														<th class="text-center min-w-70px">Total QTY</th>
														<th class="text-center min-w-125px">Total Harga</th>
														<th class="text-start min-w-250px">Detail Pesanan</th>
														<th class="text-center min-w-50px">Status</th>
														<th class="text-center min-w-150px">Tanggal Pesanan</th>
														<th class="text-center min-w-60px">Aksi</th>
													</tr>
												</thead>
												<tbody class="text-gray-600 fw-semibold">
												
												<?php
													$no = 1;
													$totalHargaSemuaPesanan = 0; // Inisialisasi total harga semua pesanan
													$totalQtySemuaPesanan = 0; // Inisialisasi total jumlah semua pesanan
													$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, 
																				   CASE 
																					 WHEN t.status = 'Pesanan Menunggu Diproses' THEN 'Pesanan Menunggu Diproses' 
																					 WHEN t.status = 'Pesanan Diproses' THEN 'Pesanan Diproses' 
																				   END AS status
																				   FROM t_pesanan t
																				   JOIN customer c ON t.kode_cus = c.kode_cus
																				   WHERE t.status = 'Pesanan Menunggu Diproses' OR t.status = 'Pesanan Diproses'
																				   ORDER BY t.kode_p DESC");

													while ($row = mysqli_fetch_assoc($result)) {
														// Ubah JSON menjadi bentuk array menggunakan json_decode
														$detailPesanan = json_decode($row['detail_pesanan'], true);
														
														// Hitung total harga pesanan saat ini dan tambahkan ke total keseluruhan
														$totalHargaSemuaPesanan += floatval($row['t_harga']);
																				
														// Hitung total jumlah pesanan saat ini dan tambahkan ke total keseluruhan
														$totalQtySemuaPesanan += intval($row['t_item']);
												?>
												
													<tr>
														<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
														<td class="text-gray-800 text-hover-primary">
															<!--begin::User details-->
															<div class="d-flex flex-column">
																<a href="#" class="text-gray-800 text-hover-primary mb-1 text-center" data-bs-toggle="modal" data-bs-target="#ModalViewPesananDiproses_<?= $row['kode_p'];  ?>"><h5><?= $row['nama'];  ?></h5></a>
																<span class="text-center"><?= $row['kode_p'];  ?></span>
															</div>
															<!--begin::User details-->
														</td>
														<td class="text-center"><?= $row['t_item'];  ?></td>
														<td class="text-center"><?= $row['t_harga'];  ?></td>
														<td class="text-start">
															<?php
															foreach ($detailPesanan as $item) {
																echo "Nama Barang : " . $item['nama_produk'] . "<br>";
																echo "Jumlah Item : " . $item['jumlah'] . "<br>";
																echo "Harga Per Item : " . $item['harga_per_item'] . "<br><br>";
															}
															?>
														</td>
														<td class="text-center">
															<?php
															// Cek status untuk menentukan kelas CSS
															$status = $row['status'];
															$statusClass = '';

															if ($status == 'Pesanan Selesai') {
																$statusClass = 'badge-light-primary';
															} elseif ($status == 'Pesanan Sampai Tujuan') {
																$statusClass = 'badge-light-success';
															} elseif ($status == 'Pesanan Dalam Pengiriman') {
																$statusClass = 'badge-light-warning';
															} elseif ($status == 'Pesanan Diproses') {
																$statusClass = 'badge-light-warning';
															} elseif ($status == 'Pesanan Menunggu Diproses') {
																$statusClass = 'badge-light-warning';
															} elseif ($status == 'Pesanan Dibuat') {
																$statusClass = 'badge-light-secondary';
															} elseif ($status == 'Pesanan Dibatalkan') {
																$statusClass = 'badge-light-danger';
															}

															// Tampilkan status dengan kelas CSS yang sesuai
															echo '<span class="badge form-label fs-5 ' . $statusClass . '">' . $status . '</span>';
															?>
														</td>
														<td class="text-center"><?= formatTanggalIndonesia($row['tgl_pesan']); ?></td>
														<td class="text-center">
															<!--begin::Menu item-->
															<div class="menu-item px-2">
																<div class="btn-group" role="group">
																	<form id="kt_modal_edit_user_form" class="form" action="proses/prosesPesanan.php" method="POST">
																		<div class="mb-3">
																			<input type="hidden" name="kode_p" id="kode_p" value="<?= $row['kode_p']; ?>">
																		</div>
																		<?php
																		// Tentukan status pesanan
																		$status = $row['status'];

																		// Tambahkan kondisi untuk men-disable tombol berdasarkan status
																		if ($status == 'Pesanan Dibuat' || $status == 'Pesanan Menunggu Diproses') {
																			// Tombol "Proses" hanya aktif jika status "Pesanan Menunggu Diproses" atau "Pesanan Dibuat"
																		?>
																		<button type="submit" name="submit" class="btn btn-warning mb-2">Proses</button>
																		<?php
																		} else {
																			// Tombol "Proses" dinonaktifkan untuk status lainnya
																		?>
																		<button type="submit" name="submit" class="btn btn-warning mb-2" disabled>Proses</button>
																		<?php
																		}

																		// Tombol "Tolak" hanya aktif jika status "Pesanan Dibuat"
																		if ($status == 'Pesanan Dibuat' || $status == 'Pesanan Menunggu Diproses') {
																		?>
																		<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalTolak_<?= $row['kode_p']; ?>">Tolak</button>
																		<?php
																		} else {
																			// Tombol "Tolak" dinonaktifkan untuk status lainnya
																		?>
																		<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalTolak_<?= $row['kode_p']; ?>" disabled>Tolak</button>
																		<?php
																		}
																		?>
																	</form>
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
											// Query untuk menghitung total pesanan dengan status "Pesanan Batal"
											$queryTotalMenungguDiproses = "SELECT COUNT(*) AS total_menunggu_diproses FROM t_pesanan WHERE status = 'Pesanan Menunggu Diproses'";
											$resultTotalMenungguDiproses = mysqli_query($conn, $queryTotalMenungguDiproses);
											$rowTotalMenungguDiproses = mysqli_fetch_assoc($resultTotalMenungguDiproses);
											$totalPesananMenungguDiproses = $rowTotalMenungguDiproses['total_menunggu_diproses'];
											
											// Query untuk menghitung total pesanan dengan status "Pesanan Batal"
											$queryTotalDiproses = "SELECT COUNT(*) AS total_diproses FROM t_pesanan WHERE status = 'Pesanan Diproses'";
											$resultTotalDiproses = mysqli_query($conn, $queryTotalDiproses);
											$rowTotalDiproses = mysqli_fetch_assoc($resultTotalDiproses);
											$totalPesananDiproses = $rowTotalDiproses['total_diproses'];
											?>
											<div class="text-start">
												<div class="d-flex flex-column">
													<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Pesanan Menunggu Diproses : <?= $totalPesananMenungguDiproses; ?> Pesanan</h5></span>
													<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Pesanan Diproses : <?= $totalPesananDiproses; ?> Pesanan</h5></span>
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