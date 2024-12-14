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
											<ul class="breadcrumb breadcrumb-separatorless fw-semibold">
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
												<li class="breadcrumb-item text-gray-700">Edit Produk</li>
												<!--end::Item-->
											</ul>
											<!--end::Breadcrumb-->
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
										<div class="card-header border-0 pt-6 mb-7">
											<!--begin::Card title-->
											<div class="card-title">
											<h2>Edit Produk</h2>
											</div>
											<!--begin::Card title-->
										</div>
										<!--end::Card header--><!--begin::Card body-->
										<?php
											$kode_produk = $_GET['kode'];
											$result = mysqli_query($conn, "SELECT * FROM produk where kode_produk = '$kode_produk'");
											while ($row = mysqli_fetch_assoc($result)) {
										?>
										<div class="card-body py-4">
											<!--begin::Form-->
											<form class="form" action="proses/produk_edit.php" method="POST" enctype="multipart/form-data">
												<!--begin::Scroll-->
												<div class="d-flex flex-column scroll-y me-n7 pe-7">
													<!--begin::Input group-->
													<div class="fv-row mb-3">
														<!--begin::Label-->
														<label class="required fw-semibold fs-6 mb-2">Kode Produk</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input type="text" id="user_id" class="form-control form-control-solid mb-3 mb-lg-0"  disabled value="<?= $row['kode_produk'];  ?>" />
														<input type="hidden" name="produk_id" class="form-control form-control-solid mb-3 mb-lg-0" id="user_id"  value="<?= $row['kode_produk']; ?>">
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row g-5 mb-3">
														<div class="col-lg-6">
															<!--begin::Label-->
															<label class="required fw-semibold fs-6 mb-2">Nama Produk</label>
															<!--end::Label-->
															<!--begin::Input-->
															<input type="text" name="produk_nama" class="form-control form-control-solid mb-3 mb-lg-0" value="<?= $row['nama'];  ?>" />
															<!--end::Input-->
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="col-lg-6">
															<!--begin::Label-->
															<label class="required fw-semibold fs-6 mb-2">Harga</label>
															<!--end::Label-->
															<!--begin::Input-->
															<input type="text" name="produk_harga" class="form-control form-control-solid mb-3 mb-lg-0" value="<?= $row['harga'];  ?>" />
															<!--end::Input-->
														</div>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row g-5 mb-3">
														<div class="col-lg-6">
															<!--begin::Label-->
															<label class="required fw-semibold fs-6 mb-2">stok</label>
															<!--end::Label-->
															<!--begin::Input-->
															<input type="text" name="produk_stok" class="form-control form-control-solid mb-3 mb-lg-0" value="<?= $row['stok'];  ?>" />
															<!--end::Input-->
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="col-lg-6">
															<!--begin::Label-->
															<label class="required fw-semibold fs-6 mb-2">Deskripsi</label>
															<!--end::Label-->
															<!--begin::Input-->
															<textarea type="text" name="produk_deskripsi" class="form-control form-control-solid mb-3 mb-lg-0" /><?= $row['deskripsi'];  ?></textarea>
															<!--end::Input-->
														</div>
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row g-5">
														<div class="col-lg-6">
															<label class="fs-6 fw-semibold form-label mb-2">Satuan Produk</label>
															<!--end::Label-->
															<?php
															$selectedKg = $row['satuan'] == 'Kg' ? 'selected' : '';
															$selectedLiter = $row['satuan'] == 'Liter' ? 'selected' : '';
															$selectedPack = $row['satuan'] == 'Pack' ? 'selected' : '';
															$selectedPcs = $row['satuan'] == 'Pcs' ? 'selected' : '';
															?>
															<!--begin::Input-->
															<select name="produk_satuan" data-control="select2" class="form-select form-select-solid fw-bold">
																<option value="Kg" <?= $selectedKg; ?>>Kg</option>
																<option value="Liter" <?= $selectedLiter; ?>>Liter</option>
																<option value="Pack" <?= $selectedPack; ?>>Pack</option>
																<option value="Pcs" <?= $selectedPcs; ?>>Pcs</option>
															</select>
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="col-lg-6">
															<!--begin::Label-->
															<label class="required d-block fw-semibold fs-6 mb-5">Unggah Gambar Produk</label>
															<!--end::Label-->
															<!--begin::Image placeholder-->
															<style>.image-input-placeholder { background-image: url('assets/media/svg/files/blank-image.svg'); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }</style>
															<!--end::Image placeholder-->
															<!--begin::Image input-->
															<div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
																<!--begin::Preview existing avatar-->
																<div class="image-input-wrapper w-125px h-125px" style="background-image: url('proses/<?= $row['foto_produk']; ?>');"></div>
																<!--end::Preview existing avatar-->
																<!--begin::Label-->
																<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
																	<i class="ki-duotone ki-pencil fs-7">
																		<span class="path1"></span>
																		<span class="path2"></span>
																	</i>
																	<!--begin::Inputs-->
																	<input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
																	<input type="hidden" name="avatar_remove" />
																	<!--end::Inputs-->
																</label>
																<!--end::Label-->
																<!--begin::Cancel-->
																<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
																	<i class="ki-duotone ki-cross fs-2">
																		<span class="path1"></span>
																		<span class="path2"></span>
																	</i>
																</span>
																<!--end::Cancel-->
																<!--begin::Remove-->
																<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
																	<i class="ki-duotone ki-cross fs-2">
																		<span class="path1"></span>
																		<span class="path2"></span>
																	</i>
																</span>
																<!--end::Remove-->
															</div>
															<!--end::Image input-->
															<!--begin::Hint-->
															<div class="form-text">File tipe yang dapat di unggah: png, jpg, jpeg. <br> Minimal 1 Mb Maksimal 10 Mb.</div>
															<!--end::Hint-->
														</div>
													</div>
													<!--end::Input group-->
													<div class="row g-5">
														<div class="col-lg-6">
															<!--begin::Label-->
															<label class="required fw-semibold fs-6 mb-2">Tanggal Exp Produk</label>
															<!--end::Label-->
															<!--begin::Input-->
															<input type="date" name="produk_exp" class="form-control form-control-solid mb-3 mb-lg-0" value="<?= $row['tgl_exp'];  ?>" />
															<!--end::Input-->
														</div>
													</div>
												</div>
												<!--end::Scroll-->
												<!--begin::Actions-->
												<div class="text-end pt-15">
													<a href="produk.php" class="btn btn-light me-3">Batal</a>
													<button type="submit" class="btn btn-primary">Simpan</button>
												</div>
												<!--end::Actions-->
											</form>
											<!--end::Form-->
										</div>
										<!--end::Card body-->
										<?php
										}
										?>
									</div>
									<!--end::Card-->
								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>
						<!--end::Content wrapper-->
			
<?php include 'footer.php'; ?>