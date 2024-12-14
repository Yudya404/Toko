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
												<li class="breadcrumb-item text-gray-700 fw-bold lh-1">Informasi</li>
												<!--end::Item-->
												<!--begin::Item-->
												<li class="breadcrumb-item">
													<i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
												</li>
												<!--end::Item-->
												<!--begin::Item-->
												<li class="breadcrumb-item text-gray-700">Customer</li>
												<!--end::Item-->
											</ul>
											<!--end::Breadcrumb-->
											<!--begin::Title-->
											<h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0">Customer</h1>
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
													<input type="text" id="searchInput" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Cari Customer" />
												</div>
												<!--end::Search-->
											</div>
											<!--begin::Card title-->
											<!--begin::Card toolbar-->
											<div class="card-toolbar">
												<!--begin::Toolbar-->
												<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
													<!--begin::Export-->
													<button type="button" data-bs-toggle="modal" data-bs-target="#modalCetakCus" class="btn btn-light-primary me-3"><i class="fa fa-print"></i>Cetak</button>
													<!--end::Export-->
													<!--begin::Modal - Cetak-->
													<div class="modal fade" id="modalCetakCus" tabindex="-1" aria-hidden="true">
													<!--begin::Modal dialog-->
													<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
														<!--begin::Modal content-->
														<div class="modal-content">
															<!--begin::Modal header-->
															<div class="modal-header" id="kt_modal_add_user_header">
																<!--begin::Modal title-->
																<h2 class="fw-bold">Cetak Data Customer</h2>
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
																				<th class="min-w-250px">Nama</th>
																				<th class="min-w-60px">ID</th>
																				<th class="min-w-70px">Email</th>
																				<th class="min-w-300px">Alamat</th>
																				<th class="text-center min-w-150px">Tanggal Daftar</th>
																			</tr>
																		</thead>
																		<tbody class="text-gray-600 fw-semibold">
																		<?php
																			$no = 1;
																			$result = mysqli_query($conn, "SELECT * FROM customer ORDER BY kode_cus DESC");
																			while ($row = mysqli_fetch_assoc($result)) {
																		?>
																			<tr>
																				<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
																				<td class="d-flex align-items-center">
																					<!--begin:: Avatar -->
																					<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																						<a href="#">
																							<div class="symbol-label">
																								<img src="proses/<?= $row['foto_cus']; ?>" alt="Foto Customer" class="w-100" />
																							</div>
																						</a>
																					</div>
																					<!--end::Avatar-->
																					<!--begin::User details-->
																					<div class="d-flex flex-column">
																						<a href="#" class="text-gray-800 text-hover-primary mb-1"><?= $row['nama'];  ?></a>
																						<span><span>0</span><?= $row['no_telp'];  ?></span>
																					</div>
																					<!--begin::User details-->
																				</td>
																				<td><?= $row['kode_cus'];  ?></td>
																				<td><?= $row['email'];  ?></td>
																				<td><div class="text-gray-800 text-hover-primary"><?= $row['alamat'];  ?></div></td>
																				<td class="text-center"><?= formatTanggalIndonesia($row['tgl_join']); ?></td>
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
																	$queryTotalPelanggan = "SELECT COUNT(*) AS total_pelanggan FROM customer";
																	$resultTotalPelanggan = mysqli_query($conn, $queryTotalPelanggan);
																	$rowTotalPelanggan = mysqli_fetch_assoc($resultTotalPelanggan);
																	$totalPelanggan = $rowTotalPelanggan['total_pelanggan'];
																	?>
																	<div class="text-start">
																		<div class="d-flex flex-column">
																			<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Customer: <?= $totalPelanggan; ?> Orang</h5></span>
																		</div>
																	</div>
																	<div class="text-end">
																		<button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
																		<button type="button" onclick="cetakCus('modalBody')" class="btn btn-primary"><i class="fa fa-print"></i>Cetak</button>
																	</div>
																</div>
															</div>
															<!--end::Modal content-->
														</div>
														<!--end::Modal dialog-->
													</div>
													<!--end::Modal - Cetak-->
													<!--begin::Add user-->
													<a href="tambah_cus.php" class="btn btn-primary"><i class="ki-duotone ki-plus fs-2"></i>Tambah Customer</a>
													<!--end::Add user-->
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
														<th class="min-w-250px">Nama</th>
														<th class="min-w-60px">ID</th>
														<th class="min-w-70px">Email</th>
														<th class="min-w-300px">Alamat</th>
														<th class="min-w-150px">Tanggal Daftar</th>
														<th class="text-center min-w-60px">Aksi</th>
													</tr>
												</thead>
												<tbody class="text-gray-600 fw-semibold">
													<?php
														$no = 1;
														$result = mysqli_query($conn, "SELECT * FROM customer ORDER BY kode_cus DESC");
														while ($row = mysqli_fetch_assoc($result)) {
													?>
													<tr>
														<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
														<td class="d-flex align-items-center">
															<!--begin:: Avatar -->
															<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="#">
																	<div class="symbol-label">
																		<img src="proses/<?= $row['foto_cus']; ?>" alt="Foto Customer" class="w-100" />
																	</div>
																</a>
															</div>
															<!--end::Avatar-->
															<!--begin::User details-->
															<div class="d-flex flex-column">
																<a href="#" class="text-gray-800 text-hover-primary mb-1"><?= $row['nama'];  ?></a>
																<span><span>0</span><?= $row['no_telp'];  ?></span>
															</div>
															<!--begin::User details-->
														</td>
														<td><?= $row['kode_cus'];  ?></td>
														<td><?= $row['email'];  ?></td>
														<td><div class="text-gray-800 text-hover-primary"><?= $row['alamat'];  ?></div></td>
														<td><?= formatTanggalIndonesia($row['tgl_join']); ?></td>
														<td class="text-center">
															<!--begin::Menu item-->
															<div class="menu-item px-2">
																<div class="btn-group" role="group">
																	<a href="edit_profile_cus.php?kode=<?= $row['kode_cus']; ?>" class="btn btn-primary" ><i class="fa fa-edit"></i></a>
																	<button type="button" class="btn btn-danger" data-tabel="customer" data-kode-cus="<?= $row['kode_cus']; ?>"><i class="fa fa-trash"></i></button>
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
											$queryTotalPelanggan = "SELECT COUNT(*) AS total_pelanggan FROM customer";
											$resultTotalPelanggan = mysqli_query($conn, $queryTotalPelanggan);
											$rowTotalPelanggan = mysqli_fetch_assoc($resultTotalPelanggan);
											$totalPelanggan = $rowTotalPelanggan['total_pelanggan'];
											?>
											<div class="text-start">
												<div class="d-flex flex-column">
													<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Customer: <?= $totalPelanggan; ?> Orang</h5></span>
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
		<!--end::Modals-->
		
<?php include 'footer.php'; ?>