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
								<li class="breadcrumb-item text-gray-700">Respon</li>
								<!--end::Item-->
							</ul>
							<!--end::Breadcrumb-->
							<!--begin::Title-->
							<h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0">Respon Ulasan</h1>
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
									<input type="text" id="searchInput" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Cari " />
								</div>
								<!--end::Search-->
							</div>
							<!--begin::Card title-->
							<!--begin::Card toolbar-->
							<div class="card-toolbar">
								<!--begin::Toolbar-->
								<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
									<!--begin::Export-->
									<button type="button" data-bs-toggle="modal" data-bs-target="#modalCetakRespon" class="btn btn-light-primary me-3"><i class="fa fa-print"></i>Cetak</button>
									<!--end::Export-->
									<!--begin::Modal - Cetak-->
									<div class="modal fade" id="modalCetakRespon" tabindex="-1" aria-hidden="true">
										<!--begin::Modal dialog-->
										<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
											<!--begin::Modal content-->
											<div class="modal-content">
												<!--begin::Modal header-->
												<div class="modal-header" id="kt_modal_add_user_header">
													<!--begin::Modal title-->
													<h2 class="fw-bold">Cetak Respon</h2>
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
													<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
														<thead>
															<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
																<th class="min-w-5px">No</th>
																<th class="min-w-125px">Kode Respon</th>
																<th class="min-w-125px">Kode Ulasan</th>
																<th class="min-w-100px">Status</th>
																<th class="min-w-250px">Isi Respon </th>
																<th class="min-w-150px">Tanggal Respon</th>
															</tr>
														</thead>
														<tbody class="text-gray-600 fw-semibold" id="tableBody">
															<?php
															$no = 1;
															$result = mysqli_query($conn, "SELECT * FROM respon");
															while ($row = mysqli_fetch_assoc($result)) {
															?>
															
															<tr>
																<td>
																	<div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div>
																</td>
																<td><?= $row['kode_respon'];  ?></td>
																<td><?= $row['kode_ulasan'];  ?></td>
																<td><?= $row['status'];  ?></td>																
																<td>
																	<div class="text-gray-800 text-hover-primary"><?= $row['isi_respon'];  ?></div>
																</td>
																<td>
																	<div class="text-gray-800 text-hover-primary"><?= formatTanggalIndonesia($row['tgl_input']); ?></div>
																</td>
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
												<ul class="pagination" id="pagination">
												</ul>
												<div class="text-end">
													<button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
													<button type="button" onclick="cetakRespon('modalBody')" class="btn btn-primary"><i class="fa fa-print"></i> Cetak</button>
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
					<!--end::Card header-->
					<!--begin::Card body-->
					<div class="card-body py-4">
						<!--begin::Table-->
						<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
							<thead>
								<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
									<th class="min-w-5px">No</th>
									<th class="min-w-125px">Kode Respon</th>
									<th class="min-w-125px">Kode Ulasan</th>
									<th class="min-w-70px">Status</th>
									<th class="min-w-250px">Isi Respon</th>
									<th class="min-w-150px">Tanggal Respon</th>
									<th class="text-center min-w-50px">Aksi</th>
								</tr>
							</thead>
							<tbody class="text-gray-600 fw-semibold">
								<?php
									$no = 1;
									$result = mysqli_query($conn, "SELECT * FROM respon");
									while ($row = mysqli_fetch_assoc($result)) {
								?>
									<tr>
										<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
										<td><?= $row['kode_respon'];  ?></td>
										<td><?= $row['kode_ulasan'];  ?></td>
										<td class="text-center">
											<?php
											// Cek status jika sudah direspon
												if ($row['status'] == 'Sudah Direspon') {
													echo '<span class="badge badge-light-success form-label fs-5">' . $row['status'] . '</span>';
												} else {
													echo '<span class="badge badge-light-danger form-label fs-5">' . $row['status'] . '</span>';
												}
											?>
										</td>
										<td><?= $row['isi_respon'];  ?></td>
										<td><?= formatTanggalIndonesia($row['tgl_input']); ?></td>
										<td class="text-center">
											<!--begin::Menu item-->
											<div class="menu-item px-2">
												<div class="btn-group" role="group">
													<button type="button" class="btn btn-danger" data-tabel="respon" data-kode-res="<?= $row['kode_respon']; ?>"><i class="fa fa-trash"></i></button>
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