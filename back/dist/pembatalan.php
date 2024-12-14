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
												<li class="breadcrumb-item text-gray-700">Laporan</li>
												<!--end::Item-->
											</ul>
											<!--end::Breadcrumb-->
											<!--begin::Title-->
											<h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0">Laporan Pesanan Dibatalkan</h1>
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
													<input type="text" id="searchInput" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Cari Orderan" />
												</div>
												<!--end::Search-->
											</div>
											<!--begin::Card title-->
											<!--begin::Card toolbar-->
											<div class="card-toolbar">
												<!--begin::Toolbar-->
												<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
													<!--begin::Export-->
													<button type="button" data-bs-toggle="modal" data-bs-target="#modalCetakPesananDibatalkan" class="btn btn-light-primary me-3"><i class="fa fa-print"></i>Cetak</button>
													<!--end::Export-->
													<!--begin::Modal - Cetak-->
													<div class="modal fade" id="modalCetakPesananDibatalkan" tabindex="-1" aria-hidden="true">
													<!--begin::Modal dialog-->
													<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
														<!--begin::Modal content-->
														<div class="modal-content">
															<!--begin::Modal header-->
															<div class="modal-header" id="kt_modal_add_user_header">
																<!--begin::Modal title-->
																<h2 class="fw-bold">Cetak Pesanan Dibatalkan</h2>
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
																			$totalHargaSemuaPesanan = 0; // Inisialisasi total harga semua pesanan
																			$totalQtySemuaPesanan = 0; // Inisialisasi total jumlah semua pesanan
																			$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, 'Pesanan Dibatalkan' AS status
																										   FROM t_pesanan t
																										   JOIN customer c ON t.kode_cus = c.kode_cus
																										   WHERE t.status = 'Pesanan Dibatalkan'
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
																	$queryTotalBatal = "SELECT COUNT(*) AS total_batal FROM t_pesanan WHERE status = 'Pesanan Dibatalkan'";
																	$resultTotalBatal = mysqli_query($conn, $queryTotalBatal);
																	$rowTotalBatal = mysqli_fetch_assoc($resultTotalBatal);
																	$totalPesananBatal = $rowTotalBatal['total_batal'];
																	?>
																	<div class="text-start">
																		<div class="d-flex flex-column">
																			<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Harga              : Rp. <?= number_format($totalHargaSemuaPesanan, 2); ?></h5></span>
																			<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Pesanan Dibatalkan : <?= $totalPesananBatal; ?> Pesanan</h5></span>
																		</div>
																	</div>
																	<div class="text-end">
																		<button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
																		<button type="button" onclick="cetakPesananDibatalkan('modalBody')" class="btn btn-primary"><i class="fa fa-print"></i>Cetak</button>
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
													$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, 'Pesanan Dibatalkan' AS status
																				   FROM t_pesanan t
																				   JOIN customer c ON t.kode_cus = c.kode_cus
																				   WHERE t.status = 'Pesanan Dibatalkan'
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
														<td class="text-center">
															<!--begin::Menu item-->
															<div class="menu-item px-2">
																<div class="btn-group" role="group">
																	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalViewPesanan_<?= $row['kode_p'];  ?>"><i class="fa fa-eye"></i></a>
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
											$queryTotalBatal = "SELECT COUNT(*) AS total_batal FROM t_pesanan WHERE status = 'Pesanan Dibatalkan'";
											$resultTotalBatal = mysqli_query($conn, $queryTotalBatal);
											$rowTotalBatal = mysqli_fetch_assoc($resultTotalBatal);
											$totalPesananBatal = $rowTotalBatal['total_batal'];
											?>
											<div class="text-start">
												<div class="d-flex flex-column">
													<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Harga              : Rp. <?= number_format($totalHargaSemuaPesanan, 2); ?></h5></span>
													<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Pesanan Dibatalkan : <?= $totalPesananBatal; ?> Pesanan</h5></span>
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
<!--begin::Modals-->
<!--begin::Modal - View Pesanan-->
<?php
	$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, p.kode_b, p.alasan
								   FROM t_pesanan t
								   JOIN customer c ON t.kode_cus = c.kode_cus
								   LEFT JOIN t_pembatalan p ON t.kode_p = p.kode_p");

while ($row = mysqli_fetch_assoc($result)) {
	// Ubah JSON menjadi bentuk array menggunakan json_decode
	$detailPesanan = json_decode($row['detail_pesanan'], true);
	
	$isDisable = false;
    $isSelesaiDisabled = false; // Tambah variabel untuk tombol "Selesai"
    
    if ($row['status'] == 'Pesanan Selesai' || $row['status'] == 'Pesanan Dibatalkan' || $row['status'] == 'Pesanan Diproses' || $row['status'] == 'Pesanan Dalam Pengiriman') {
        $isDisable = true;
        if ($row['status'] == 'Pesanan Dalam Pengiriman') {
            $isSelesaiDisabled = false; // Tombol "Selesai" diaktifkan jika status "Pesanan Dalam Pengiriman"
        } else {
            $isSelesaiDisabled = true; // Tombol "Selesai" dinonaktifkan untuk status lainnya
        }
    }
?>
<div class="modal fade" id="ModalViewPesanan_<?= $row['kode_p'];  ?>" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header" id="kt_modal_edit_user_header">
				<!--begin::Modal title-->
				<h2 class="fw-bold">View Pesanan</h2>
				<!--end::Modal title-->
				<!--begin::Close-->
				<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
					<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
				</div>
				<!--end::Close-->
			</div>
			<!--end::Modal header-->
			<!--begin::Modal body-->
			<div class="modal-body scroll-y mx-5 mx-xl-15 my-7_<?= $row['kode_p'];  ?>">
				<!--begin::Form-->
				<form id="kt_modal_edit_user_form" class="form" action="proses/proses_pesanan.php" method="POST">
					<!--begin::Scroll-->
					<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_edit_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="200px">
						<div class="row g-5">
							<div class="col-lg-6">
								<table cellpadding="6">
									<div class="card shadow-sm mb-5">
										<div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse" data-bs-target="#kt_docs_card_collapsible">
											<h3 class="card-title">Detail Pesanan</h3>
											<div class="card-toolbar rotate-180">
												<!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2023-03-24-172858/core/html/src/media/icons/duotune/arrows/arr072.svg-->
												<span class="svg-icon svg-icon-muted svg-icon-2hx">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
													</svg>
												</span>
												<!--end::Svg Icon-->
											</div>
										</div>
										<div id="kt_docs_card_collapsible" class="collapse">
											<div class="card-body">
												<div class="row g-5">
													<div class="col-lg-6">
														<div class="mb-5">
															<label for="exampleFormControlInput1" class="form-label fs-5">Kode Pesanan</label>
														</div>
													</div>
													<div class="col-lg-6">
														<div>:
															<label for="exampleFormControlInput1" class="form-label fs-5"><?= $row['kode_p'];  ?></label>
														</div>
													</div>
												</div>
												<div class="row g-5">
													<div class="col-lg-6">
														<div class="mb-5">
															<label for="exampleFormControlInput1" class="form-label fs-5">Nama Customer</label>
														</div>
													</div>
													<div class="col-lg-6">
														<div>:
															<label for="exampleFormControlInput1" class="form-label fs-5"><?= $row['nama'];  ?></label>
														</div>
													</div>
												</div>
												<div class="row g-5">
													<div class="col-lg-6">
														<div class="mb-5">
															<label for="exampleFormControlInput1" class=form-label fs-5">Detail Pesanan</label>
														</div>
													</div>
													<div class="col-lg-6">
														<?php foreach ($detailPesanan as $item) { ?>
															Nama Barang :<?php echo $item['nama_produk']; ?>
																<li class="list-unstyled">Jumlah Per Item : <?php echo $item['jumlah']; ?></li>
																<li class="list-unstyled">Harga Per Item : Rp <?php echo number_format($item['harga_per_item'], 0, ',', '.'); ?></li>
															<br>
														<?php } ?>
													</div>
												</div>
												<div class="row g-5">
													<div class="col-lg-6">
														<div class="mb-5">
															<label for="exampleFormControlInput1" class="form-label fs-5">Total Item</label>
														</div>
													</div>
													<div class="col-lg-6">
														<div>:
															<label for="exampleFormControlInput1" class="form-label fs-5"><?= $row['t_item'];  ?> <span>Item</span></label>
														</div>
													</div>
												</div>
												<div class="row g-5">
													<div class="col-lg-6">
														<div class="mb-5">
															<label for="exampleFormControlInput1" class="form-label fs-5">Total Bayar</label>
														</div>
													</div>
													<div class="col-lg-6">
														<div>:
															<label for="exampleFormControlInput1" class="form-label fs-5">Rp.<?= number_format($row['t_harga']); ?></label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="card shadow-sm mb-5">
										<div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse" data-bs-target="#kt_docs_card_collapsible2">
											<h3 class="card-title">Alasan Pembatalan</h3>
											<div class="card-toolbar rotate-180">
												<!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2023-03-24-172858/core/html/src/media/icons/duotune/arrows/arr072.svg-->
												<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
												</svg>
											</span>
											<!--end::Svg Icon-->
										</div>
									</div>
									<div id="kt_docs_card_collapsible2" class="collapse show">
										<div class="card-body">
											<div class="row g-5">
												<div class="col-lg-6">
													<div class="mb-5">
														<label for="exampleFormControlInput1" class="form-label fs-5">Alasan</label>
													</div>
												</div>
												<div class="col-lg-6">
													<div>:
														<label for="exampleFormControlInput1" class="form-label fs-5">
															<?php
																$alasan = $row['alasan'];
																echo isset($alasan) && !empty($alasan) ? $alasan : '---';
															?>
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</table>
						</div>
						<div class="col-lg-6">
							<div class="card shadow-sm">
								<div class="card-header">
									<div class="row">
										<label for="basic-url" class="form-label fs-4 mt-3">Aktivitas</label>
										<label for="basic-url" class="form-label fs-8">Daftar aktivitas Pesanan Customer </label>
									</div>
								</div>
								<div class="card-body card-scroll">
									<!--begin::Timeline-->
									<div class="timeline-label ms-10" id="timeline-label">
										<!--begin::Item-->
										<?php if ($row['tgl_pesan'] != 0) { ?>
										<div class="timeline-item">
											<!--begin::Label-->
											<div class="timeline-label fw-bold text-gray-800 fs-8 w-100px"><?= formatTanggalIndonesia($row['tgl_pesan']); ?></div>
											<!--end::Label-->
											<!--begin::Badge-->
											<div class="timeline-badge">
												<i class="fa fa-genderless text-secondary fs-1"></i>
											</div>
											<!--end::Badge-->
											<!--begin::Text-->
											<div class="row ms-3">
												<div class="fw-bold text-gray-800 ps-3 w-100">Pesanan Dibuat</div>
											</div>
											<!--end::Text-->
										</div>
										<?php } ?>
										
										<?php if ($row['tgl_pesan'] != 0) { ?>
										<div class="timeline-item">
											<!--begin::Label-->
											<div class="timeline-label fw-bold text-gray-800 fs-8 w-100px"><?= formatTanggalIndonesia($row['tgl_pesan']); ?></div>
											<!--end::Label-->
											<!--begin::Badge-->
											<div class="timeline-badge">
												<i class="fa fa-genderless text-warning fs-1"></i>
											</div>
											<!--end::Badge-->
											<!--begin::Text-->
											<div class="row ms-3">
												<div class="fw-bold text-gray-800 ps-3 w-100">Pesanan Menunggu Diproses</div>
											</div>
											<!--end::Text-->
										</div>
										<?php } ?>
										
										<?php if ($row['tgl_proses'] != 0) { ?>
										<div class="timeline-item">
											<!--begin::Label-->
											<div class="timeline-label fw-bold text-gray-800 fs-8 w-100px"><?= formatTanggalIndonesia($row['tgl_proses']); ?></div>
											<!--end::Label-->
											<!--begin::Badge-->
											<div class="timeline-badge">
												<i class="fa fa-genderless text-warning fs-1"></i>
											</div>
											<!--end::Badge-->
											<!--begin::Text-->
											<div class="row ms-3">
												<div class="fw-bold text-gray-800 ps-3 w-100">Pesanan Diproses</div>
											</div>
											<!--end::Text-->
										</div>
										<?php } ?>
										
										<?php if ($row['tgl_kirim'] != 0) { ?>
										<div class="timeline-item">
											<!--begin::Label-->
											<div class="timeline-label fw-bold text-gray-800 fs-8 w-100px"><?= formatTanggalIndonesia($row['tgl_kirim']); ?></div>
											<!--end::Label-->
											<!--begin::Badge-->
											<div class="timeline-badge">
												<i class="fa fa-genderless text-warning fs-1"></i>
											</div>
											<!--end::Badge-->
											<!--begin::Text-->
											<div class="row ms-3">
												<div class="fw-bold text-gray-800 ps-3 w-100">Pesanan Dalam Pengiriman</div>
											</div>
											<!--end::Text-->
										</div>
										<?php } ?>
										
										<?php if ($row['tgl_sampai'] != 0) { ?>
										<div class="timeline-item">
											<!--begin::Label-->
											<div class="timeline-label fw-bold text-gray-800 fs-8 w-100px"><?= formatTanggalIndonesia($row['tgl_sampai']); ?></div>
											<!--end::Label-->
											<!--begin::Badge-->
											<div class="timeline-badge">
												<i class="fa fa-genderless text-success fs-1"></i>
											</div>
											<!--end::Badge-->
											<!--begin::Text-->
											<div class="row ms-3">
												<div class="fw-bold text-gray-800 ps-3 w-100">Pesanan Sampai Tujuan</div>
											</div>
											<!--end::Text-->
										</div>
										<?php } ?>
										
										<?php if ($row['tgl_selesai'] != 0) { ?>
										<div class="timeline-item">
											<!--begin::Label-->
											<div class="timeline-label fw-bold text-gray-800 fs-8 w-100px"><?= formatTanggalIndonesia($row['tgl_selesai']); ?></div>
											<!--end::Label-->
											<!--begin::Badge-->
											<div class="timeline-badge">
												<i class="fa fa-genderless text-primary fs-1"></i>
											</div>
											<!--end::Badge-->
											<!--begin::Text-->
											<div class="row ms-3">
												<div class="fw-bold text-gray-800 ps-3 w-100">Pesanan Selesai</div>
											</div>
											<!--end::Text-->
										</div>
										<?php } ?>
										
										<?php if ($row['tgl_batal'] != 0) { ?>
										<div class="timeline-item">
											<!--begin::Label-->
											<div class="timeline-label fw-bold text-gray-800 fs-8 w-100px"><?= formatTanggalIndonesia($row['tgl_batal']); ?></div>
											<!--end::Label-->
											<!--begin::Badge-->
											<div class="timeline-badge">
												<i class="fa fa-genderless text-danger fs-1"></i>
											</div>
											<!--end::Badge-->
											<!--begin::Text-->
											<div class="row ms-3">
												<div class="fw-bold text-gray-800 ps-3 w-100">Pesanan Dibatalkan</div>
											</div>
											<!--end::Text-->
										</div>
										<?php } ?>
									</div>
									<!--end::Timeline-->
								</div>
							</div>
						</div>
						</div>
					</div>
					<!--end::Scroll-->
					<br>
					<!--begin::Actions-->
					<div class="text-end">
						<button type="button" class="btn btn-secondary" data-toggle="modal" data-bs-dismiss="modal">Tutup</button>
					</div>
					<!--end::Actions-->
				</form>
				<!--end::Form-->
			</div>
			<!--end::Modal body-->
		</div>
		<!--end::Modal content-->
	</div>
	<!--end::Modal dialog-->
</div>
<?php
}
?>
<!--end::Modal - View Pesanan-->
						
<?php include 'footer.php'; ?>