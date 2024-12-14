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
									<a class="nav-link text-active-primary ms-0 me-10 py-1 active" href="profilku.php">Detail Profil</a>
								</li>
								<!--end::Nav item-->
								<!--begin::Nav item-->
								<li class="nav-item mt-2">
									<a class="nav-link text-active-primary ms-0 me-10 py-1" href="edit_profilku.php">Edit Profil</a>
								</li>
								<!--end::Nav item-->
							</ul>
							<!--begin::Navs-->
						</div>
					</div>
					<!--end::Navbar-->
					<!--begin::details View-->
					<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
						<!--begin::Card header-->
						<div class="card-header cursor-pointer">
							<!--begin::Card title-->
							<div class="card-title m-0">
								<h3 class="fw-bold m-0">Detail Profil</h3>
							</div>
							<!--end::Card title-->
						</div>
						<!--begin::Card header-->
						<!--begin::Card body-->
						<div class="card-body p-9">
						<div class="row g-5">
							<div class="col-lg-8">
							<!--begin::Row-->
							<div class="row mb-7">
								<!--begin::Label-->
								<label class="col-lg-4 fw-semibold text-muted">Nama</label>
								<!--end::Label-->
								<!--begin::Col-->
								<div class="col-lg-8">
									<span class="fw-bold fs-6 text-gray-800"><?= $_SESSION['nama'];  ?></span>
								</div>
								<!--end::Col-->
							</div>
							<!--end::Row-->
							<!--begin::Input group-->
							<div class="row mb-7">
								<!--begin::Label-->
								<label class="col-lg-4 fw-semibold text-muted">No. Telp</label>
								<!--end::Label-->
								<!--begin::Col-->
								<div class="col-lg-8 fv-row">
									<span class="fw-semibold text-gray-800 fs-6"><span>0</span><?= $_SESSION['no_telp'];  ?></span>
								</div>
								<!--end::Col-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="row mb-7">
								<!--begin::Label-->
								<label class="col-lg-4 fw-semibold text-muted">Email</label>
								<!--end::Label-->
								<!--begin::Col-->
								<div class="col-lg-8 fv-row">
									<span class="fw-semibold text-gray-800 fs-6"><?= $_SESSION['email'];  ?></span>
								</div>
								<!--end::Col-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="row mb-7">
								<!--begin::Label-->
								<label class="col-lg-4 fw-semibold text-muted">Alamat</label>
								<!--end::Label-->
								<!--begin::Col-->
								<div class="col-lg-8 fv-row">
									<span class="fw-semibold text-gray-800 fs-6"><?= $_SESSION['alamat'];  ?></span>
								</div>
								<!--end::Col-->
							</div>
							<!--end::Input group-->
							</div>
							<div class="col-lg-4">
							<!--begin::Input group-->
							<div class="row mb-6">
								<!--begin::Label-->
								<label class="col-lg-4 col-form-label fw-semibold fs-6">Fotomu</label>
								<!--end::Label-->
								<!--begin::Col-->
								<div class="col-lg-4">
									<!--begin::Image input-->
									<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
										<!--begin::Preview existing avatar-->
										<img src="back/dist/proses/<?= $_SESSION['foto_cus']; ?>" alt="Gambar" style="width: 100px;">
										<!--end::Preview existing avatar-->
									</div>
									<!--end::Image input-->
								</div>
								<!--end::Col-->
							</div>
							<!--end::Input group-->	
							</div>
						</div>
						</div>
						<!--end::Card body-->
					</div>
					<!--end::details View-->
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