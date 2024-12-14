<?php include 'base/header.php'; ?>

    <?php include 'base/nav.php'; ?>

    <!-- Breadcrumb Section Begin -->
    <?php
		$nama = "Gambar Breadcrumb"; // Ganti dengan nama yang ingin dicari
		$result = mysqli_query($conn, "SELECT * FROM about");
		while ($row = mysqli_fetch_assoc($result)) {
		if ($row['nama'] == $nama) {
	?>
    <section class="breadcrumb-section set-bg" data-setbg="back/dist/proses/<?= $row['gambar_a']; ?>">
	<?php
		}
	}
	?>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Detail Profilku</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Beranda</a>
                            <span>Profilku</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Form Begin -->
	<div class="container mt-5">
		<div class="justify-content-center">
			<!--begin::Content-->
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
									<a class="nav-link text-active-primary ms-0 me-10 py-1" href="profilku.php">Detail Profil</a>
								</li>
								<!--end::Nav item-->
								<!--begin::Nav item-->
								<li class="nav-item mt-2">
									<a class="nav-link text-active-primary ms-0 me-10 py-1 active" href="edit_profilku.php">Edit Profil</a>
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
							<form class="form" action="proses/edit_cus.php" method="POST" enctype="multipart/form-data">
								<!--begin::Card body-->
								<div class="card-body border-top p-9">
									<!--begin::Input group-->
									<div class="row mb-6">
										<!--begin::Label-->
										<label class="col-lg-4 col-form-label fw-semibold fs-6">Unggah Foto</label>
										<!--end::Label-->
										<!--begin::Col-->
										<div class="col-lg-8">
											<!--begin::Image input-->
											<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
												<!--begin::Preview existing avatar-->
												<img src="back/dist/proses/<?= $_SESSION['foto_cus']; ?>" alt="Gambar" style="width: 100px;">
												<!--end::Preview existing avatar-->
												<!--begin::Label-->
												<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
													<i class="ki-duotone ki-pencil fs-7">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
													<!--begin::Inputs-->
													<input type="file" name="avatar" class="form-control-file" accept=".png, .jpg, .jpeg" />
													<input type="hidden" name="avatar_remove" />
													<!--end::Inputs-->
												</label>
												<!--end::Label-->
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
											<input type="text" id="user_id" class="form-control form-control-lg form-control-solid" disabled value="<?= $_SESSION['kode_cus'];  ?>" />
											<input type="hidden" name="cus_id" class="form-control form-control-solid mb-3 mb-lg-0" id="user_id"  value="<?= $_SESSION['kode_cus']; ?>">
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
											<input type="text" name="cus_nama" class="form-control form-control-lg form-control-solid" value="<?= $_SESSION['nama'];  ?>" />
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
											<input type="tel" name="cus_telp" class="form-control form-control-lg form-control-solid" value="<?= $_SESSION['no_telp'];  ?>" />
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
											<textarea name="cus_alamat" class="form-control form-control-lg form-control-solid"><?= $_SESSION['alamat'];  ?></textarea>
										</div>
										<!--end::Input-->
									</div>
									<!--end::Input group-->
								</div>
								<!--end::Card body-->
								<!--begin::Actions-->
								<div class="card-footer d-flex justify-content-end py-6 px-9">
									<a href="profilku.php" class="btn btn-light btn-active-light-primary me-2">Batal</a>
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
					<button class="collapsible">Ubah Email</button>
					<div class="content">
					<div class="card mb-5 mb-xl-10">
						<!--begin::Card header-->
						<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
							<div class="card-title m-0">
								<h5 class="fw-bold m-0">Ubah Email</h5>
							</div>
						</div>
						<!--end::Card header-->
						<!--begin::Content-->
						<div id="kt_account_settings_profile_details" class="collapse show">
							<!--begin::Form-->
							<form class="form" action="proses/update_email.php" method="POST" enctype="multipart/form-data">
								<!--begin::Card body-->
								<div class="card-body border-top p-9">
									<!--begin::Input group-->
									<div class="row mb-6">
										<!--begin::Label-->
										<label class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
										<!--end::Label-->
										<!--begin::Col-->
										<div class="col-lg-8 fv-row">
											<input type="email" name="new_email" class="form-control form-control-lg form-control-solid" value="<?= $_SESSION['email'];  ?>" />
										</div>
										<!--end::Col-->
									</div>
									<!--end::Input group-->
									<!--begin::Input group-->
									<div class="row mb-6">
										<!--begin::Label-->
										<label class="col-lg-4 col-form-label required fw-semibold fs-6">Password</label>
										<!--end::Label-->
										<!--begin::Col-->
										<div class="col-lg-8 fv-row">
											<input type="password" name="password" class="form-control form-control-lg form-control-solid" />
										</div>
										<!--end::Col-->
									</div>
									<!--end::Input group-->
								</div>
								<!--end::Card body-->
								<!--begin::Actions-->
								<div class="card-footer d-flex justify-content-end py-6 px-9">
									<a href="profilku.php" class="btn btn-light btn-active-light-primary me-2">Batal</a>
									<button type="submit" class="btn btn-primary">Simpan</button>
								</div>
								<!--end::Actions-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Content-->
					</div>
					</div>
					<!--end::Sign-in Method-->
					<br>
					<!--begin::Sign-in Method-->
					<button class="collapsible">Ubah Password</button>
					<div class="content">
					<div class="card mb-5 mb-xl-10">
						<!--begin::Card header-->
						<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
							<div class="card-title m-0">
								<h5 class="fw-bold m-0">Ubah Sandi</h5>
							</div>
						</div>
						<!--end::Card header-->
						<!--begin::Content-->
						<div id="kt_account_settings_profile_details" class="collapse show">
							<!--begin::Form-->
							<form class="form" action="proses/update_password.php" method="POST" enctype="multipart/form-data">
								<!--begin::Card body-->
								<div class="card-body border-top p-9">
									<!--begin::Input group-->
									<div class="row mb-6">
										<!--begin::Label-->
										<label class="col-lg-4 col-form-label required fw-semibold fs-6">Sandi Baru</label>
										<!--end::Label-->
										<!--begin::Col-->
										<div class="col-lg-8 fv-row">
											<input type="password" name="new_password" class="form-control form-control-lg form-control-solid" />
										</div>
										<!--end::Col-->
									</div>
									<!--end::Input group-->
									<!--begin::Input group-->
									<div class="row mb-6">
										<!--begin::Label-->
										<label class="col-lg-4 col-form-label required fw-semibold fs-6">Ulangi Sandi Baru</label>
										<!--end::Label-->
										<!--begin::Col-->
										<div class="col-lg-8 fv-row">
											<input type="password" name="confirm_password" class="form-control form-control-lg form-control-solid" />
										</div>
										<!--end::Col-->
									</div>
									<!--end::Input group-->
									<!--begin::Input group-->
									<div class="row mb-6">
										<!--begin::Label-->
										<label class="col-lg-4 col-form-label required fw-semibold fs-6">Password Lama Anda</label>
										<!--end::Label-->
										<!--begin::Col-->
										<div class="col-lg-8 fv-row">
											<input type="password" name="password" class="form-control form-control-lg form-control-solid" />
										</div>
										<!--end::Col-->
									</div>
									<!--end::Input group-->
								</div>
								<!--end::Card body-->
								<!--begin::Actions-->
								<div class="card-footer d-flex justify-content-end py-6 px-9">
									<a href="profilku.php" class="btn btn-light btn-active-light-primary me-2">Batal</a>
									<button type="submit" class="btn btn-primary">Simpan</button>
								</div>
								<!--end::Actions-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Content-->
					</div>
					</div>
					<!--end::Sign-in Method-->
				</div>
				<!--end::Content container-->
			</div>
			<!--end::Content-->
		</div>
	</div>
	<!-- Contact Form End -->
			<br>
			<br>

<?php include 'base/footer.php'; ?>