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
												<li class="breadcrumb-item text-gray-700 fw-bold lh-1">User</li>
												<!--end::Item-->
												<!--begin::Item-->
												<li class="breadcrumb-item">
													<i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
												</li>
												<!--end::Item-->
												<!--begin::Item-->
												<li class="breadcrumb-item text-gray-700">Edit Profile</li>
												<!--end::Item-->
											</ul>
											<!--end::Breadcrumb-->
											<!--begin::Title-->
											<h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0">Edit Profil</h1>
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
							<?php
								$kode_user = $_GET['kode'];
								$result = mysqli_query($conn, "SELECT * FROM user where kode_user = '$kode_user'");
								while ($row = mysqli_fetch_assoc($result)) {
							?>
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-fluid">
									<!--begin::Navbar-->
									<div class="card mb-3 mb-xl-10">
										<div class="card-body pt-9 pb-0">
										<!--begin::Navs-->
											<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
												<!--begin::Nav item-->
												<li class="nav-item mt-2">
													<a class="nav-link text-active-primary ms-0 me-10 py-1" href="../dist/overview_user.php?kode=<?= $row['kode_user']; ?>">Detail Profil</a>
												</li>
												<!--end::Nav item-->
												<!--begin::Nav item-->
												<li class="nav-item mt-2">
													<a class="nav-link text-active-primary ms-0 me-10 py-1 active" href="../dist/edit_profile_user.php?kode=<?= $row['kode_user']; ?>">Edit Profile</a>
												</li>
												<!--end::Nav item-->
											</ul>
											<!--begin::Navs-->
										</div>
									</div>
									<!--end::Navbar-->
									<!--begin::Basic info-->
									<div class="card mb-5 mb-xl-10">
										<!--begin::Card header-->
										<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
											<!--begin::Card title-->
											<div class="card-title m-0">
												<h3 class="fw-bold m-0">Profil Detail</h3>
											</div>
											<!--end::Card title-->
										</div>
										<!--begin::Card header-->
										<!--begin::Content-->
										<div id="kt_account_settings_profile_details" class="collapse show">
											<!--begin::Form-->
											<form class="form" action="proses/user_edit.php" method="POST" enctype="multipart/form-data">
												<!--begin::Card body-->
												<div class="card-body border-top p-9">
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label fw-semibold fs-6">Unggah Foto User</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8">
															<!--begin::Image input-->
															<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
																<!--begin::Preview existing avatar-->
																<div class="image-input-wrapper w-125px h-125px" style="background-image: url('proses/<?= $row['foto_user']; ?>')"></div>
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
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label id="user_id" class="col-lg-4 col-form-label required fw-semibold fs-6">ID User</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<input type="text" id="user_id" class="form-control form-control-lg form-control-solid" disabled value="<?= $row['kode_user'];  ?>" />
															<input type="hidden" name="user_id" class="form-control form-control-solid mb-3 mb-lg-0" id="user_id"  value="<?= $row['kode_user']; ?>">
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<input type="text" name="user_nama" class="form-control form-control-lg form-control-solid" value="<?= $row['nama'];  ?>" />
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label required fw-semibold fs-6">No. Telp</label>
														<!--end::Label-->
														<!--begin::Col-->
														<div class="col-lg-8 fv-row">
															<input type="tel" name="user_telp" class="form-control form-control-lg form-control-solid" value="<?= $row['no_telp'];  ?>" />
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label required fw-semibold fs-6">Alamat</label>
														<!--end::Label-->
														<!--begin::Input-->
														<div class="col-lg-8 fv-row">
															<textarea name="user_alamat" class="form-control form-control-lg form-control-solid"><?= $row['alamat'];  ?></textarea>
														</div>
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<?php
													if ($_SESSION['kategori_user'] == 'Admin') {
													// Tampilkan menu User hanya jika kategori_user adalah 'admin'
													?>
													<div class="row mb-6">
														<!--begin::Label-->
														<label class="col-lg-4 col-form-label required fw-semibold fs-6">Pilih Tipe User</label>
														<!--end::Label-->
														<!--begin::Input-->
														<div class="col-lg-8 fv-row">
															<?php
															$selectedAdmin = $row['kategori_user'] == 'Admin' ? 'selected' : '';
															$selectedUser = $row['kategori_user'] == 'User' ? 'selected' : '';
															?>
															<!--begin::Input-->
															<select name="user_role" data-control="select2" class="form-select form-select-solid fw-bold">
																<option value="Admin" <?= $selectedAdmin; ?>>Admin</option>
																<option value="User" <?= $selectedUser; ?>>User</option>
															</select>
														</div>
														<!--end::Input-->
													</div>
													<?php
													}
													?>
													<!--end::Input group-->
												</div>
												<!--end::Card body-->
												<!--begin::Actions-->
												<div class="card-footer d-flex justify-content-end py-6 px-9">
													<a href="user.php" class="btn btn-light btn-active-light-primary me-2">Batal</a>
													<button type="submit" class="btn btn-primary">Simpan</button>
												</div>
												<!--end::Actions-->
											</form>
											<!--end::Form-->
										</div>
										<!--end::Content-->
									</div>
									<!--end::Basic info-->
									<!--begin::Sign-in Method-->
									<div class="card mb-5 mb-xl-10">
										<!--begin::Card header-->
										<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
											<div class="card-title m-0">
												<h3 class="fw-bold m-0">Ubah Email & Sandi</h3>
											</div>
										</div>
										<!--end::Card header-->
										<!--begin::Content-->
									<div id="kt_account_settings_signin_method" class="collapse show">
										<!--begin::Card body-->
										<div class="card-body border-top p-9">
											<!--begin::Email Address-->
											<div class="d-flex flex-wrap align-items-center">
												<!--begin::Label-->
												<div id="kt_signin_email">
													<div class="fs-6 fw-bold mb-1">Email</div>
													<div class="fw-semibold text-gray-600"><?= $row['email'];  ?></div>
												</div>
												<!--end::Label-->
												<!--begin::Edit-->
												<div id="kt_signin_email_edit" class="flex-row-fluid d-none">
													<!--begin::Form-->
													<form action="proses/cus_edit_passemail.php" method="POST" id="kt_signin_change_email" class="form" novalidate="novalidate">
														<input type="hidden" name="user_id" value="<?= $row['kode_user']; ?>">
														<div class="row mb-6">
															<div class="col-lg-6 mb-4 mb-lg-0">
																<div class="fv-row mb-0">
																	<label for="emailaddress" class="form-label fs-6 fw-bold mb-3">Masukan Email Baru Anda</label>
																	<input type="email" class="form-control form-control-lg form-control-solid" id="user_email" name="user_email" value="<?= $_SESSION['email']; ?>" />
																</div>
															</div>
															<div class="col-lg-6">
																<div class="fv-row mb-0">
																	<label for="confirmemailpassword" class="form-label fs-6 fw-bold mb-3">Masukkan Sandi</label>
																	<input type="password" class="form-control form-control-lg form-control-solid" name="user_pass" id="user_pass" />
																</div>
															</div>
														</div>
														<div class="d-flex">
															<button type="submit" class="btn btn-primary me-2 px-6">Update Email</button>
															<button id="kt_signin_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Batal</button>
														</div>
													</form>
													<!--end::Form-->
												</div>
												<!--end::Edit-->
												<!--begin::Action-->
												<div id="kt_signin_email_button" class="ms-auto">
													<button class="btn btn-light btn-active-light-primary">Ubah Email</button>
												</div>
												<!--end::Action-->
											</div>
											<!--end::Email Address-->
											<!--begin::Separator-->
											<div class="separator separator-dashed my-6"></div>
											<!--end::Separator-->
											<!--begin::Password-->
											<div class="d-flex flex-wrap align-items-center mb-10">
												<div id="kt_signin_password">
													<div class="fs-6 fw-bold mb-1">Sandi</div>
													<div class="fw-semibold text-gray-600">************</div>
												</div>
												<!--begin::Edit-->
												<div id="kt_signin_password_edit" class="flex-row-fluid d-none">
													<!--begin::Form-->
													<form action="proses/cus_edit_passemail.php" method="POST" id="kt_signin_change_password" class="form" novalidate="novalidate">
														<input type="hidden" name="user_id" value="<?= $row['kode_user']; ?>">
														<div class="row mb-1">
															<div class="col-lg-4">
																<div class="fv-row mb-0">
																	<label for="currentpassword" class="form-label fs-6 fw-bold mb-3">Sandi Saat Ini</label>
																	<input type="password" class="form-control form-control-lg form-control-solid" name="user_pass" id="user_pass" />
																</div>
															</div>
															<div class="col-lg-4" data-kt-password-meter="true">
																<div class="fv-row mb-0">
																	<label for="newpassword" class="form-label fs-6 fw-bold mb-3">Sandi Baru</label>
																	<div class="position-relative mb-3">
																		<input type="password" class="form-control form-control-lg form-control-solid" name="user_passnew" id="user_passnew" />
																		<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
																			<i class="ki-duotone ki-eye-slash fs-2"></i>
																			<i class="ki-duotone ki-eye fs-2 d-none"></i>
																		</span>
																	</div>
																</div>
																<!--begin::Meter-->
																<div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
																	<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
																	<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
																	<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
																	<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
																</div>
																<!--end::Meter-->
																<div class="form-text mb-5">Gunakan 8 karakter atau lebih dengan campuran huruf, angka & simbol.</div>
															</div>
															<div class="col-lg-4">
																<div class="fv-row mb-0">
																	<label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">Ulangi Sandi Baru</label>
																	<input type="password" class="form-control form-control-lg form-control-solid" name="confirmpassnew" id="confirmpassnew" />
																</div>
															</div>
														</div>
														<div class="d-flex">
															<button type="submit" class="btn btn-primary me-2 px-6">Update Password</button>
															<button id="kt_password_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Batal</button>
														</div>
													</form>
													<!--end::Form-->
												</div>
												<!--end::Edit-->
												<!--begin::Action-->
												<div id="kt_signin_password_button" class="ms-auto">
													<button class="btn btn-light btn-active-light-primary">Ubah Password</button>
												</div>
												<!--end::Action-->
											</div>
											<!--end::Password-->
										</div>
										<!--end::Card body-->
									</div>
									<!--end::Content-->
									</div>
									<!--end::Sign-in Method-->
									<!--begin::Deactivate Account-->
									<?php
									if ($_SESSION['kategori_user'] == 'Admin') {
									// Tampilkan menu User hanya jika kategori_user adalah 'admin'
									?>
									<div class="card">
										<!--begin::Card header-->
										<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
											<div class="card-title m-0">
												<h3 class="fw-bold m-0">Nonaktifkan Akun</h3>
											</div>
										</div>
										<!--end::Card header-->
										<!--begin::Content-->
										<div id="kt_account_settings_deactivate" class="collapse show">
											<!--begin::Form-->
											<form id="kt_account_deactivate_form" class="form">
												<!--begin::Card body-->
												<div class="card-body border-top p-9">
													<!--begin::Notice-->
													<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
														<!--begin::Icon-->
														<i class="ki-duotone ki-information fs-2tx text-warning me-4">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
														</i>
														<!--end::Icon-->
														<!--begin::Wrapper-->
														<div class="d-flex flex-stack flex-grow-1">
															<!--begin::Content-->
															<div class="fw-semibold">
																<h4 class="text-gray-900 fw-bold">Anda Menonaktifkan Akun Anda</h4>
																<div class="fs-6 text-gray-700">Untuk keamanan ekstra, Anda harus mengonfirmasi email atau nomor telepon saat menyetel ulang sandi yang ditandatangani.
																<br />
																<a class="fw-bold" href="#">Informasi Lebih Lanjut</a></div>
															</div>
															<!--end::Content-->
														</div>
														<!--end::Wrapper-->
													</div>
													<!--end::Notice-->
													<!--begin::Form input row-->
													<div class="form-check form-check-solid fv-row">
														<input name="deactivate" class="form-check-input" type="checkbox" value="" id="deactivate" />
														<label class="form-check-label fw-semibold ps-2 fs-6" for="deactivate">Saya mengkonfirmasi penonaktifan akun saya</label>
													</div>
													<!--end::Form input row-->
												</div>
												<!--end::Card body-->
												<!--begin::Card footer-->
												<div class="card-footer d-flex justify-content-end py-6 px-9">
													<button id="kt_account_deactivate_account_submit" type="submit" class="btn btn-danger fw-semibold">Nonaktifkan Akun</button>
												</div>
												<!--end::Card footer-->
											</form>
											<!--end::Form-->
										</div>
										<!--end::Content-->
									</div>
									<?php
									}
									?>
									<!--end::Deactivate Account-->
								</div>
								<!--end::Content container-->
							</div>
							<?php
							}
							?>
							<!--end::Content-->
						</div>
						<!--end::Content wrapper-->
						
<?php include 'footer.php'; ?>