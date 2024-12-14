<?php
session_start();
include 'koneksi/koneksi.php'; // Pastikan Anda telah memasukkan koneksi ke database
?>
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href=""/>
		<title>Toko Bu Heru</title>
		<meta charset="utf-8" />
		<meta name="description" content="Saul HTML Free - Bootstrap 5 HTML Multipurpose Admin Dashboard Theme" />
		<meta name="keywords" content="Saul, bootstrap, bootstrap 5, dmin themes, free admin themes, bootstrap admin, bootstrap dashboard" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Saul HTML Free - Bootstrap 5 HTML Multipurpose Admin Dashboard Theme" />
		<meta property="og:url" content="https://keenthemes.com/products/saul-html-pro" />
		<meta property="og:site_name" content="Keenthemes | Saul HTML Free" />
		<link rel="canonical" href="https://preview.keenthemes.com/saul-html-free" />
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
		<style>
		.error {
			color: red;
			font-weight: bold;
		}
		</style>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
		  <!--begin::Page bg image-->
		  <style>
			 body {
				background-image: url('dist/assets/media/auth/bg10.jpeg');
			 }

			 [data-theme="dark"] body {
				background-image: url('dist/assets/media/auth/bg10-dark.jpeg');
			 }
		  </style>
		  <!--end::Page bg image-->
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Aside-->
				<div class="d-flex flex-column flex-lg-row-auto bg-primary w-xl-600px positon-xl-relative">
					<!--begin::Wrapper-->
					<div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
						<!--begin::Header-->
						<div class="d-flex flex-row-fluid flex-column text-center p-5 p-lg-10 pt-lg-20">
							<!--begin::Logo-->
							<a href="../dist/index.html" class="py-2 py-lg-20">
								<?php
									$nama = "Gambar Login Customer"; // Ganti dengan nama yang ingin dicari
									$result = mysqli_query($conn, "SELECT * FROM about");
									while ($row = mysqli_fetch_assoc($result)) {
										if ($row['nama'] == $nama) {
								?>
								<img alt="Logo" src="proses/<?= $row['gambar_a']; ?>" class="h-40px h-lg-150px" />
								<?php
									}		
								}
								?>
							</a>
							<!--end::Logo-->
							<!--begin::Title-->
							<h1 class="d-none d-lg-block fw-bold text-white fs-2qx pb-5 pb-md-10">Selamat Datang di Toko Bu Heru</h1>
							<!--end::Title-->
							<!--begin::Description-->
							<p class="d-none d-lg-block fw-semibold fs-2 text-white">Minimarket yang menjual berbagai kebutuhan rumah & dapur anda dengan harga yang variatif dan murah.</p>
							<!--end::Description-->
						</div>
						<!--end::Header-->
						<!--begin::Illustration
						<div class="d-none d-lg-block d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url(assets/media/illustrations/sketchy-1/17.png)"></div>
						end::Illustration-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--begin::Aside-->
				<!--begin::Body-->
				<div class="d-flex flex-column flex-lg-row-fluid py-10">
					<!--begin::Content-->
					<div class="d-flex flex-center flex-column flex-column-fluid">
						<!--begin::Wrapper-->
						<div class="w-lg-500px p-10 p-lg-15 mx-auto">
							<!--begin::Form-->
							<form class="form w-100" action="proses/verifikasi.php" method="POST">
								<!--begin::Heading-->
								<div class="px-10 text-center mb-10">
									<?php
										$nama = "Gambar Login Customer"; // Ganti dengan nama yang ingin dicari
										$result = mysqli_query($conn, "SELECT * FROM about");
										while ($row = mysqli_fetch_assoc($result)) {
											if ($row['nama'] == $nama) {
									?>
									<img src="proses/<?= $row['gambar_a']; ?>" height="100px" alt="Logo Toko Bu Heru">
									<?php
										}		
									}
									?>
								</div>
								<!--begin::Input group-->
								<div class="fv-row mb-10">
									<!--begin::Label-->
									<label class="form-label fs-6 fw-bold text-dark">Email</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="email" placeholder="joni@gmail.com" name="email" id="email" autocomplete="off" class="form-control bg-transparent" />
									<!--end::Input-->
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
								<div class="fv-row mb-3">
									<!--begin::Wrapper-->
									<div class="d-flex flex-stack">
										<!--begin::Label-->
										<label class="form-label fw-bold text-dark fs-6 mb-0">Sandi</label>
										<!--end::Label-->
									</div>
									<!--end::Wrapper-->
									<!--begin::Input-->
									<input type="password" placeholder="Sandi" name="pass" id="pass" autocomplete="off" class="form-control bg-transparent" />
									<!--end::Input-->
								</div>
								<!--end::Input group-->
								<!--begin::Wrapper-->
									<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
										<div></div>
										<!--begin::Link-->
										<div class="flex-container">
										<a href="#" class="ps-0 btn-danger" data-bs-toggle="modal" data-bs-target="#bantuan">Bantuan Lainnya?</a>
										</div>
										<!--end::Link-->
									</div>
									<!--end::Wrapper-->
								<!--begin::Actions-->
								<div class="text-center">
									<!--begin::Submit button-->
									<button type="submit" class="btn btn-lg btn-primary w-100 mb-5">Masuk</button>
									<!--end::Submit button-->
								</div>
								<!--end::Actions-->
							</form>
							<!--end::Form-->
							<!-- Menampilkan pesan kesalahan -->
							 <?php
								if (isset($_SESSION['error_message'])) {
									echo '<div class="error" style="text-align: center;">' . $_SESSION['error_message'] . '</div>';
									unset($_SESSION['error_message']); // Hapus pesan kesalahan setelah ditampilkan
								}
							?>
						</div>
						<!--end::Wrapper-->
						<!--begin::Footer-->
						<div id="kt_app_footer" class="app-footer align-items-center justify-content-center justify-content-md-between flex-column flex-md-row py-3">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<?php
									$nama = "Footer"; // Ganti dengan nama yang ingin dicari
									$result = mysqli_query($conn, "SELECT * FROM kontak");
									while ($row = mysqli_fetch_assoc($result)) {
									if ($row['nama'] == $nama) {
								?>
								Copyright &copy;<script>document.write(new Date().getFullYear());</script> <?= $row['isi']; ?>
								<?php
									}
								}
								?>
							</div>
							<!--end::Copyright-->
						</div>
						<!--end::Footer-->
					</div>
					<!--end::Content-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->
		<!--Begin::Modal Bantuan-->
		<div class="modal fade" tabindex="-1" id="bantuan">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-primary fw-bold">Helpdesk Toko Bu Heru</h5>
						<!--begin::Close-->
						<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
							<i class="ki-duotone ki-cross fs-1">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</div>
						<!--end::Close-->
					</div>
					<div class="modal-body center-align">
						<?php
							$nama = "Gambar Bantuan"; // Ganti dengan nama yang ingin dicari
							$result = mysqli_query($conn, "SELECT * FROM about");
							while ($row = mysqli_fetch_assoc($result)) {
							if ($row['nama'] == $nama) {
						?>
						<img src="proses/<?= $row['gambar_a']; ?>" style="width:100%; height:80%; display:block; margin:auto;" alt="Helpdesk BHS" />
						<?php
							}
						}
						?>
					</div>
				</div>
			</div>
		</div> 
		<!--End::Modal Bantuan-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="assets/js/custom/authentication/sign-in/general.js"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>