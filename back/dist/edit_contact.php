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
												<li class="breadcrumb-item text-gray-700 fw-bold lh-1">Informasi</li>
												<!--end::Item-->
												<!--begin::Item-->
												<li class="breadcrumb-item">
													<i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
												</li>
												<!--end::Item-->
												<!--begin::Item-->
												<li class="breadcrumb-item text-gray-700">Edit Contact</li>
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
											<h2>Edit Contact</h2>
											</div>
											<!--begin::Card title-->
										</div>
										<!--end::Card header--><!--begin::Card body-->
										<?php
											$kode_c = $_GET['kode'];
											$result = mysqli_query($conn, "SELECT * FROM kontak WHERE kode_c = '$kode_c'");
											while ($row = mysqli_fetch_assoc($result)) {
										?>
										<div class="card-body py-4">
											<!--begin::Form-->
											<form class="form" action="proses/contact_edit.php" method="POST" enctype="multipart/form-data">
												<!--begin::Scroll-->
												<div class="d-flex flex-column scroll-y me-n7 pe-7">
													<!--begin::Input group-->
													<div class="fv-row mb-3">
														<!--begin::Label-->
														<label id="user_id" class="required fw-semibold fs-6 mb-2">Kode Contact</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input type="text" id="user_id" class="form-control form-control-solid mb-3 mb-lg-0"  disabled value="<?= $row['kode_c'];  ?>" />
														<input type="hidden" name="contact_id" class="form-control form-control-solid mb-3 mb-lg-0" id="user_id"  value="<?= $row['kode_c']; ?>">
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row g-5 mb-3">
														<div class="col-lg-6">
															<!--begin::Label-->
															<label class="required fw-semibold fs-6 mb-2">Nama</label>
															<!--end::Label-->
															<!--begin::Input-->
															<input type="text" name="contact_nama" class="form-control form-control-solid mb-3 mb-lg-0" value="<?= $row['nama'];  ?>" />
															<!--end::Input-->
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="col-lg-6">
															<!--begin::Label-->
															<label class="required fw-semibold fs-6 mb-2">Isi</label>
															<!--end::Label-->
															<!--begin::Input-->
															<input type="text" name="contact_isi" class="form-control form-control-solid mb-3 mb-lg-0" value="<?= $row['isi'];  ?>" />
															<!--end::Input-->
														</div>
													</div>
												</div>
												<!--end::Scroll-->
												<!--begin::Actions-->
												<div class="text-end pt-15">
													<a href="contact.php" class="btn btn-light me-3">Batal</a>
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