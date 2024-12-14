<?php
// Mulai sesi
session_start();

include 'koneksi/koneksi.php'; // Pastikan Anda telah memasukkan koneksi ke database

// Tentukan waktu timeout (dalam detik)
$sessionTimeout = 1800; // 30 menit

// Set waktu timeout pada sesi
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $sessionTimeout)) {
    // Sesuatu yang ingin Anda lakukan saat sesi kedaluwarsa
    session_unset();
    session_destroy();
    header("Location: index.php"); // Redirect ke halaman login
}
$_SESSION['last_activity'] = time();

if (!isset($_SESSION['kode_user'])) {
    header('Location: index.php'); // Arahkan kembali ke halaman login
    exit();
}
// Ambil data pengguna dari database berdasarkan kode_user yang sedang login
$kode_user = $_SESSION['kode_user'];
$nama = $_SESSION['nama'];
$email = $_SESSION['email'];
$alamat = $_SESSION['alamat'];
$no_telp = $_SESSION['no_telp'];
$tgl_join = $_SESSION['tgl_join'];
$kategori_user = $_SESSION['kategori_user'];
$foto_user = $_SESSION['foto_user'];
$query = "SELECT * FROM user WHERE kode_user = '$kode_user'";
$result = mysqli_query($conn, $query);
$userData = mysqli_fetch_assoc($result);

function formatTanggalIndonesia($tanggal) {
    $bulan = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    );

    // Ubah format tanggal ke format timestamp
    $timestamp = strtotime($tanggal);

    $tahun = date('Y', $timestamp);
    $bulanIndex = (int)date('m', $timestamp);
    $hari = date('d', $timestamp);
    $waktu = date('H:i:s', $timestamp); // Format waktu

    return $hari . ' ' . $bulan[$bulanIndex] . ' ' . $tahun . ' ' . $waktu;
}

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
		<!--begin::Vendor Stylesheets(used for this page only)-->
		<link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<style>
        /* Stil untuk kontainer grafik */
        #chartContainer {
            position: relative;
            width: 100%;
            height: 400px;
        }
		</style>
		<style>
			.modal-footer {
				display: flex;
				justify-content: space-between;
				align-items: center;
			}

			.modal-footer .text-center {
				flex-grow: 2;
				display: flex;
				justify-content: center;
			}

			.modal-footer .btn {
				margin: 0;
			}
		</style>
		<style>
			/* Menyembunyikan elemen dengan ID user_id */
			#user_id {
				display: none;
			}
		</style>
		<style>
			/* Animasi masuk untuk notifikasi */
			
			.animated-badge {
				animation: fadeInUp 0.3s ease-in-out;
			}
			
			#notificationDiproses {
			  transition: background-color 0.3s, color 0.3s;
			}

			#notificationDiproses.new-order {
			  background-color: #ffc107; /* Ganti warna latar belakang yang sesuai */
			  color: #000; /* Ganti warna teks yang sesuai */
			}
			
			@keyframes fadeInUp {
				0% {
					opacity: 0;
					transform: translateY(10px);
				}
				100% {
					opacity: 1;
					transform: translateY(0);
				}
			}
			
			#notificationDiproses.new-order {
			  animation: fadeIn 1s ease-in-out; /* Ganti durasi dan timing function sesuai kebutuhan */
			}
		</style>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-toolbar="true" data-kt-app-aside-push-footer="true" class="app-default">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				<!--begin::Header-->
				<div id="kt_app_header" class="app-header d-flex flex-column flex-stack">
					<!--begin::Header main-->
					<div class="d-flex align-items-center flex-stack flex-grow-1">
						<div class="app-header-logo d-flex align-items-center flex-stack px-lg-11 mb-2" id="kt_app_header_logo">
							<!--begin::Sidebar mobile toggle-->
							<div class="btn btn-icon btn-active-color-primary w-35px h-35px ms-3 me-2 d-flex d-lg-none" id="kt_app_sidebar_mobile_toggle">
								<i class="ki-duotone ki-abstract-14 fs-2">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</div>
							<!--end::Sidebar mobile toggle-->
							<!--begin::Logo-->
							<a href="beranda.php" class="app-sidebar-logo">
								<img alt="Logo" src="assets/media/logos/default-dark1.svg" class="h-65px theme-light-show" />
								<img alt="Logo" src="assets/media/logos/default1.svg" class="h-65px theme-dark-show" />
							</a>
							<!--end::Logo-->
							<!--begin::Sidebar toggle-->
							<div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-sm btn-icon btn-color-warning me-n2 d-none d-lg-flex" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
								<i class="ki-duotone ki-exit-left fs-2x rotate-180">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</div>
							<!--end::Sidebar toggle-->
						</div>
						<!--begin::Navbar-->
						<div class="app-navbar flex-grow-1 justify-content-end" id="kt_app_header_navbar">
							<!--begin::Notifications-->
							<div class="app-navbar-item me-lg-1">
								<?php
								if ($_SESSION['kategori_user'] == 'Admin') {
									// Query untuk mengambil notifikasi
									$query = "SELECT COUNT(*) AS total_unproses FROM t_pesanan WHERE status = 'Pesanan Menunggu Diproses'";
									$result = mysqli_query($conn, $query);
									$row = mysqli_fetch_assoc($result);
									$totalUnproses = $row['total_unproses'];

									// Tentukan apakah ada notifikasi yang belum dibaca
									$hasUnreadNotifications = ($totalUnproses > 0);
									?>
									<div id="notificationContainer" class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-35px h-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
										<span class="svg-icon svg-icon-muted svg-icon-2hx text-primary">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<?php if ($hasUnreadNotifications) : ?>
													<!-- Jika ada notifikasi yang belum dibaca, tampilkan badge dan notifikasi -->
													<path opacity="0.3" d="M14 3V20H2V3C2 2.4 2.4 2 3 2H13C13.6 2 14 2.4 14 3ZM11 13V11C11 9.7 10.2 8.59995 9 8.19995V7C9 6.4 8.6 6 8 6C7.4 6 7 6.4 7 7V8.19995C5.8 8.59995 5 9.7 5 11V13C5 13.6 4.6 14 4 14V15C4 15.6 4.4 16 5 16H11C11.6 16 12 15.6 12 15V14C11.4 14 11 13.6 11 13Z" fill="currentColor"></path>
													<path d="M2 20H14V21C14 21.6 13.6 22 13 22H3C2.4 22 2 21.6 2 21V20ZM9 3V2H7V3C7 3.6 7.4 4 8 4C8.6 4 9 3.6 9 3ZM6.5 16C6.5 16.8 7.2 17.5 8 17.5C8.8 17.5 9.5 16.8 9.5 16H6.5ZM21.7 12C21.7 11.4 21.3 11 20.7 11H17.6C17 11 16.6 11.4 16.6 12C16.6 12.6 17 13 17.6 13H20.7C21.2 13 21.7 12.6 21.7 12ZM17 8C16.6 8 16.2 7.80002 16.1 7.40002C15.9 6.90002 16.1 6.29998 16.6 6.09998L19.1 5C19.6 4.8 20.2 5 20.4 5.5C20.6 6 20.4 6.60005 19.9 6.80005L17.4 7.90002C17.3 8.00002 17.1 8 17 8ZM19.5 19.1C19.4 19.1 19.2 19.1 19.1 19L16.6 17.9C16.1 17.7 15.9 17.1 16.1 16.6C16.3 16.1 16.9 15.9 17.4 16.1L19.9 17.2C20.4 17.4 20.6 18 20.4 18.5C20.2 18.9 19.9 19.1 19.5 19.1Z" fill="currentColor"></path>
													<span id="notificationBadge" class="badge badge-danger badge-icon">
														<?php echo $totalUnproses; ?>
													</span>
												<?php else : ?>
													<!-- Jika tidak ada notifikasi yang belum dibaca, tampilkan hanya ikon tanpa badge -->
													<path opacity="0.3" d="M14 3V20H2V3C2 2.4 2.4 2 3 2H13C13.6 2 14 2.4 14 3ZM11 13V11C11 9.7 10.2 8.59995 9 8.19995V7C9 6.4 8.6 6 8 6C7.4 6 7 6.4 7 7V8.19995C5.8 8.59995 5 9.7 5 11V13C5 13.6 4.6 14 4 14V15C4 15.6 4.4 16 5 16H11C11.6 16 12 15.6 12 15V14C11.4 14 11 13.6 11 13Z" fill="currentColor"/>
												<path d="M2 20H14V21C14 21.6 13.6 22 13 22H3C2.4 22 2 21.6 2 21V20ZM9 3V2H7V3C7 3.6 7.4 4 8 4C8.6 4 9 3.6 9 3ZM6.5 16C6.5 16.8 7.2 17.5 8 17.5C8.8 17.5 9.5 16.8 9.5 16H6.5ZM21.7 12C21.7 11.4 21.3 11 20.7 11H17.6C17 11 16.6 11.4 16.6 12C16.6 12.6 17 13 17.6 13H20.7C21.2 13 21.7 12.6 21.7 12ZM17 8C16.6 8 16.2 7.80002 16.1 7.40002C15.9 6.90002 16.1 6.29998 16.6 6.09998L19.1 5C19.6 4.8 20.2 5 20.4 5.5C20.6 6 20.4 6.60005 19.9 6.80005L17.4 7.90002C17.3 8.00002 17.1 8 17 8ZM19.5 19.1C19.4 19.1 19.2 19.1 19.1 19L16.6 17.9C16.1 17.7 15.9 17.1 16.1 16.6C16.3 16.1 16.9 15.9 17.4 16.1L19.9 17.2C20.4 17.4 20.6 18 20.4 18.5C20.2 18.9 19.9 19.1 19.5 19.1Z" fill="currentColor"/>
												<?php endif; ?>
											</svg>
										</span>
									</div>
								<?php
								}
								?>
							
								<?php
								if ($_SESSION['kategori_user'] == 'User') {
									// Query untuk mengambil notifikasi
									$query = "SELECT COUNT(*) AS total_unproses FROM t_pesanan WHERE status = 'Pesanan Menunggu Diproses'";
									$result = mysqli_query($conn, $query);
									$row = mysqli_fetch_assoc($result);
									$totalUnproses = $row['total_unproses'];

									// Tentukan apakah ada notifikasi yang belum dibaca
									$hasUnreadNotifications = ($totalUnproses > 0);
									?>
									<div id="notificationContainer" class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-35px h-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
										<span class="svg-icon svg-icon-muted svg-icon-2hx text-primary">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<!-- Jika ada notifikasi yang belum dibaca, tampilkan badge dan notifikasi -->
												<path opacity="0.3" d="M14 3V20H2V3C2 2.4 2.4 2 3 2H13C13.6 2 14 2.4 14 3ZM11 13V11C11 9.7 10.2 8.59995 9 8.19995V7C9 6.4 8.6 6 8 6C7.4 6 7 6.4 7 7V8.19995C5.8 8.59995 5 9.7 5 11V13C5 13.6 4.6 14 4 14V15C4 15.6 4.4 16 5 16H11C11.6 16 12 15.6 12 15V14C11.4 14 11 13.6 11 13Z" fill="currentColor"></path>
												<path d="M2 20H14V21C14 21.6 13.6 22 13 22H3C2.4 22 2 21.6 2 21V20ZM9 3V2H7V3C7 3.6 7.4 4 8 4C8.6 4 9 3.6 9 3ZM6.5 16C6.5 16.8 7.2 17.5 8 17.5C8.8 17.5 9.5 16.8 9.5 16H6.5ZM21.7 12C21.7 11.4 21.3 11 20.7 11H17.6C17 11 16.6 11.4 16.6 12C16.6 12.6 17 13 17.6 13H20.7C21.2 13 21.7 12.6 21.7 12ZM17 8C16.6 8 16.2 7.80002 16.1 7.40002C15.9 6.90002 16.1 6.29998 16.6 6.09998L19.1 5C19.6 4.8 20.2 5 20.4 5.5C20.6 6 20.4 6.60005 19.9 6.80005L17.4 7.90002C17.3 8.00002 17.1 8 17 8ZM19.5 19.1C19.4 19.1 19.2 19.1 19.1 19L16.6 17.9C16.1 17.7 15.9 17.1 16.1 16.6C16.3 16.1 16.9 15.9 17.4 16.1L19.9 17.2C20.4 17.4 20.6 18 20.4 18.5C20.2 18.9 19.9 19.1 19.5 19.1Z" fill="currentColor"></path>
												<span id="notificationDiproses" class="badge badge-danger badge-icon">
													<?php echo $totalUnproses; ?>
												</span>
											</svg>
										</span>
									</div>
									<?php if ($hasUnreadNotifications) : ?>
										<script>
											// Tambahkan animasi ke notifikasi jika ada notifikasi yang belum dibaca
											$("#notificationDiproses").addClass("animated-badge");
										</script>
									<?php endif; ?>
								<?php
								}
								?>

								<?php
								if ($_SESSION['kategori_user'] == 'Driver') {
									// Query untuk mengambil notifikasi
									$query = "SELECT COUNT(*) AS total_dikirim FROM t_pesanan WHERE status = 'Pesanan Diproses'";
									$result = mysqli_query($conn, $query);
									$row = mysqli_fetch_assoc($result);
									$totalDikirim = $row['total_dikirim'];

									// Tentukan apakah ada notifikasi yang belum dibaca
									$hasUnreadNotifications = ($totalDikirim > 0);
									?>
									<div id="notificationContainerDikirim" class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-35px h-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
										<span class="svg-icon svg-icon-muted svg-icon-2hx text-primary">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<?php if ($hasUnreadNotifications) : ?>
													<!-- Jika ada notifikasi yang belum dibaca, tampilkan badge dan notifikasi -->
													<path opacity="0.3" d="M14 3V20H2V3C2 2.4 2.4 2 3 2H13C13.6 2 14 2.4 14 3ZM11 13V11C11 9.7 10.2 8.59995 9 8.19995V7C9 6.4 8.6 6 8 6C7.4 6 7 6.4 7 7V8.19995C5.8 8.59995 5 9.7 5 11V13C5 13.6 4.6 14 4 14V15C4 15.6 4.4 16 5 16H11C11.6 16 12 15.6 12 15V14C11.4 14 11 13.6 11 13Z" fill="currentColor"></path>
													<path d="M2 20H14V21C14 21.6 13.6 22 13 22H3C2.4 22 2 21.6 2 21V20ZM9 3V2H7V3C7 3.6 7.4 4 8 4C8.6 4 9 3.6 9 3ZM6.5 16C6.5 16.8 7.2 17.5 8 17.5C8.8 17.5 9.5 16.8 9.5 16H6.5ZM21.7 12C21.7 11.4 21.3 11 20.7 11H17.6C17 11 16.6 11.4 16.6 12C16.6 12.6 17 13 17.6 13H20.7C21.2 13 21.7 12.6 21.7 12ZM17 8C16.6 8 16.2 7.80002 16.1 7.40002C15.9 6.90002 16.1 6.29998 16.6 6.09998L19.1 5C19.6 4.8 20.2 5 20.4 5.5C20.6 6 20.4 6.60005 19.9 6.80005L17.4 7.90002C17.3 8.00002 17.1 8 17 8ZM19.5 19.1C19.4 19.1 19.2 19.1 19.1 19L16.6 17.9C16.1 17.7 15.9 17.1 16.1 16.6C16.3 16.1 16.9 15.9 17.4 16.1L19.9 17.2C20.4 17.4 20.6 18 20.4 18.5C20.2 18.9 19.9 19.1 19.5 19.1Z" fill="currentColor"></path>
													<span id="notificationDikirim" class="badge badge-danger badge-icon">
														<?php echo $totalDikirim; ?>
													</span>
												<?php else : ?>
													<!-- Jika tidak ada notifikasi yang belum dibaca, tampilkan hanya ikon tanpa badge -->
													<path opacity="0.3" d="M14 3V20H2V3C2 2.4 2.4 2 3 2H13C13.6 2 14 2.4 14 3ZM11 13V11C11 9.7 10.2 8.59995 9 8.19995V7C9 6.4 8.6 6 8 6C7.4 6 7 6.4 7 7V8.19995C5.8 8.59995 5 9.7 5 11V13C5 13.6 4.6 14 4 14V15C4 15.6 4.4 16 5 16H11C11.6 16 12 15.6 12 15V14C11.4 14 11 13.6 11 13Z" fill="currentColor"/>
													<path d="M2 20H14V21C14 21.6 13.6 22 13 22H3C2.4 22 2 21.6 2 21V20ZM9 3V2H7V3C7 3.6 7.4 4 8 4C8.6 4 9 3.6 9 3ZM6.5 16C6.5 16.8 7.2 17.5 8 17.5C8.8 17.5 9.5 16.8 9.5 16H6.5ZM21.7 12C21.7 11.4 21.3 11 20.7 11H17.6C17 11 16.6 11.4 16.6 12C16.6 12.6 17 13 17.6 13H20.7C21.2 13 21.7 12.6 21.7 12ZM17 8C16.6 8 16.2 7.80002 16.1 7.40002C15.9 6.90002 16.1 6.29998 16.6 6.09998L19.1 5C19.6 4.8 20.2 5 20.4 5.5C20.6 6 20.4 6.60005 19.9 6.80005L17.4 7.90002C17.3 8.00002 17.1 8 17 8ZM19.5 19.1C19.4 19.1 19.2 19.1 19.1 19L16.6 17.9C16.1 17.7 15.9 17.1 16.1 16.6C16.3 16.1 16.9 15.9 17.4 16.1L19.9 17.2C20.4 17.4 20.6 18 20.4 18.5C20.2 18.9 19.9 19.1 19.5 19.1Z" fill="currentColor"/>
												<?php endif; ?>
											</svg>
										</span>
									</div>
								<?php
								}
								?>
								
								<div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
									<!--begin::Heading-->
									<div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
										<!--begin::Title-->
										<h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifikasi</h3>
										<!--end::Title-->
										<!--begin::Tabs-->
										<?php
										if ($_SESSION['kategori_user'] == 'Admin') {
										// Tampilkan menu User jika kategori_user adalah 'Admin' atau 'User'
										?>
										<ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
											<li class="nav-item">
												<?php
												$query = "SELECT COUNT(*) AS total_unproses FROM t_pesanan WHERE status = 'Pesanan Menunggu Diproses'";
												$result = mysqli_query($conn, $query);
												$row = mysqli_fetch_assoc($result);
												$totalUnproses = $row['total_unproses'];
												?>
												<a class="nav-link text-white opacity-75 opacity-state-100 pb-6 active" data-bs-toggle="tab" href="#kt_topbar_notifications_1">
													<?php echo $totalUnproses?>
													Pesanan Masuk
												</a>
											</li>
										</ul>
										<?php
										}
										?>
										<?php
										if ($_SESSION['kategori_user'] == 'User') {
										// Tampilkan menu User jika kategori_user adalah 'Admin' atau 'User'
										?>
										<ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
											<li class="nav-item">
												<?php
												$query = "SELECT COUNT(*) AS total_unproses FROM t_pesanan WHERE status = 'Pesanan Menunggu Diproses'";
												$result = mysqli_query($conn, $query);
												$row = mysqli_fetch_assoc($result);
												$totalUnproses = $row['total_unproses'];

												// Tentukan apakah ada notifikasi yang belum dibaca
												$hasUnreadNotifications = ($totalUnproses > 0);
												?>
												<a id="notificationDiproses" class="nav-link text-white opacity-75 opacity-state-100 pb-6 active" data-bs-toggle="tab" href="#kt_topbar_notifications_1">
												  <span id="notificationCount"><?php echo $totalUnproses; ?> Pesanan Masuk</span>
												</a>
											</li>
											<li class="nav-item">
												<?php
												$query = "SELECT COUNT(*) AS total_rating FROM rating WHERE status_rating = 'Sudah Dinilai'";
												$result = mysqli_query($conn, $query);
												$row = mysqli_fetch_assoc($result);
												$totalRating = $row['total_rating'];
												
												// Tentukan apakah ada notifikasi yang belum dibaca
												$hasUnreadNotifications = ($totalRating > 0);
												?>
												<a class="nav-link text-white opacity-75 opacity-state-100 pb-6" data-bs-toggle="tab" href="#kt_topbar_notifications">
													<?php echo $totalRating?> Ulasan Pesanan
												</a>
											</li>
										</ul>
										<?php
										}
										?>
										<?php
											if ($_SESSION['kategori_user'] == 'Driver') {
											// Tampilkan menu User jika kategori_user adalah 'Admin' atau 'User'
											?>
										<ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
											<li class="nav-item">
												<?php
												$query = "SELECT COUNT(*) AS total_dikirim FROM t_pesanan WHERE status = 'Pesanan Diproses'";
												$result = mysqli_query($conn, $query);
												$row = mysqli_fetch_assoc($result);
												$totalDikirim = $row['total_dikirim'];
												?>
												<a class="nav-link text-white opacity-75 opacity-state-100 pb-6 active" data-bs-toggle="tab" href="#kt_topbar_notifications_2"><?php echo $totalDikirim?> Pesanan Masuk</a>
											</li>
										</ul>
										<?php
										}
										?>
										<!--end::Tabs-->
									</div>
									<!--end::Heading-->
									<!--begin::Tab content-->
									<div class="tab-content">
										<!--begin::Tab panel Ulasan-->
										<?php
										if ($_SESSION['kategori_user'] == 'Admin') {
										// Tampilkan menu User jika kategori_user adalah 'Admin' atau 'User'
										?>
										<div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
											<!--begin::Items-->
											<div class="scroll-y mh-325px my-5 px-8">
												<!--begin::Item-->
												<!--begin::Item for Orderan Masuk-->
												<?php
												// Query untuk mengambil orderan masuk dan data pelanggan yang sesuai
												$queryOrderanMasuk = "SELECT t.*, c.nama AS nama FROM t_pesanan t
																	  JOIN customer c ON t.kode_cus = c.kode_cus
																	  WHERE t.status = 'Pesanan Menunggu Diproses'";
												$resultOrderanMasuk = mysqli_query($conn, $queryOrderanMasuk);
												while ($rowOrderanMasuk = mysqli_fetch_assoc($resultOrderanMasuk)) {
													$detailPesanan = json_decode($rowOrderanMasuk['detail_pesanan'], true);
												?>
													<div class="d-flex flex-stack py-4">
														<div class="d-flex align-items-center me-2">
															<a href="#" class="text-gray-800 text-hover-primary fw-semibold min-w-125px" data-bs-toggle="modal" data-bs-target="#ModalViewPesananDiproses_<?= $rowOrderanMasuk['kode_p'];  ?>"><?= $rowOrderanMasuk["nama"]; ?></a>
															<span class="w-190px badge badge-light-warning me-4"><?= $rowOrderanMasuk["status"]; ?></span>
															<span class="w-150px badge badge-light-warning me-4">
															<?php
																foreach ($detailPesanan as $item) {
																	echo "Nama  : " . $item['nama_produk'] . "<br>";
																	echo "Jumlah : " . $item['jumlah'] . " Item" . "<br>";
																	echo "Harga Per Item : " . $item['harga_per_item'] . "<br><br>";
																}
															?>
															</span>
														</div>
													</div>
												<?php
												}
												?>
												<!--end::Item-->
											</div>
											<!--end::Items-->
											<!--begin::View more-->
											<div class="py-3 text-center border-top">
												<a href="rating.php" class="btn btn-color-gray-600 btn-active-color-primary">Semua
													<i class="ki-duotone ki-arrow-right fs-5">
														<span class="path1"></span>
														<span class="path2"></span>
													</i></a>
											</div>
											<!--end::View more-->
										</div>
										<?php
										}
										?>
										<!--end::Tab panel Ulasan-->
										<!--begin::Tab panel User-->
										<?php
										if ($_SESSION['kategori_user'] == 'User') {
										// Tampilkan menu User jika kategori_user adalah 'Admin' atau 'User'
										?>
										<div class="tab-pane fade" id="kt_topbar_notifications" role="tabpanel">
											<!--begin::Items-->
											<div class="scroll-y mh-325px my-5 px-8">
												<!--begin::Item-->
												<?php
												$queryUlasan = "SELECT t.*, c.nama AS nama, r.rating, r.komentar
															    FROM t_pesanan t
															    JOIN customer c ON t.kode_cus = c.kode_cus
															    JOIN rating r ON t.kode_p = r.kode_p 
																WHERE status_rating = 'Sudah Dinilai'";
												$resultUlasan = mysqli_query($conn, $queryUlasan);
												while ($rowUlasan = mysqli_fetch_assoc($resultUlasan)) {
													$detailPesanan = json_decode($rowUlasan['detail_pesanan'], true);
												?>
												<div class="d-flex flex-stack py-4">
													<div class="d-flex align-items-center me-2">
														<a href="#" class="text-gray-800 text-hover-primary fw-semibold min-w-125px" data-bs-toggle="modal" data-bs-target="#ModalViewRating_<?= $rowUlasan['kode_p'];  ?>"><?= $rowUlasan["nama"]; ?></a>
														<span class="w-150px badge badge-light-warning me-4">
														<?php
															$rating = $rowUlasan['rating']; // Nilai rating dari database

															// Tentukan path menuju gambar ikon sesuai dengan nilai rating
															$iconPath = 'assets/media/emoji/';
															$ratingText = ''; // Variabel untuk menyimpan teks rating

															// Tentukan ikon dan teks berdasarkan nilai rating
															if ($rating == 5) {
																$iconPath .= '5.png';
																$ratingText = 'Sangat Puas';
															} elseif ($rating == 4) {
																$iconPath .= '4.png';
																$ratingText = 'Puas';
															} elseif ($rating == 3) {
																$iconPath .= '3.png';
																$ratingText = 'Cukup Puas';
															} elseif ($rating == 2) {
																$iconPath .= '2.png';
																$ratingText = 'Kurang Puas';
															} elseif ($rating == 1) {
																$iconPath .= '1.png';
																$ratingText = 'Kecewa';
															} else {
																$iconPath .= '5.png'; // Ikon default jika nilai rating tidak sesuai
																$ratingText = 'Tidak Ada Rating';
															}
															?>
															<img src="<?= $iconPath ?>" alt="Rating <?= $rating ?>" style="width: 50px; height: 35px;">
															<span><?= $ratingText ?></span>
														</span>
														<span class="w-150px badge badge-light-warning me-4">
														<?php
															foreach ($detailPesanan as $item) {
																echo "Nama  : " . $item['nama_produk'] . "<br>";
																echo "Jumlah : " . $item['jumlah'] . " Item" . "<br>";
																echo "Harga Per Item : " . $item['harga_per_item'] . "<br><br>";
															}
														?>
														</span>
													</div>
												</div>
												<?php
												}
												?>
												<!--end::Item-->
											</div>
											<!--end::Items-->
											<!--begin::View more-->
											<div class="py-3 text-center border-top">
												<a href="rating.php" class="btn btn-color-gray-600 btn-active-color-primary">Semua
													<i class="ki-duotone ki-arrow-right fs-5">
														<span class="path1"></span>
														<span class="path2"></span>
													</i></a>
											</div>
											<!--end::View more-->
										</div>
										<!--end::Tab panel User-->
										<!--begin::Tab panel Orderan-->
										<div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
											<!--begin::Items-->
											<div class="scroll-y mh-325px my-5 px-8">
												<!--begin::Item-->
												<!--begin::Item for Orderan Masuk-->
												<?php
												// Query untuk mengambil orderan masuk dan data pelanggan yang sesuai
												$queryOrderanMasuk = "SELECT t.*, c.nama AS nama FROM t_pesanan t
																	  JOIN customer c ON t.kode_cus = c.kode_cus
																	  WHERE t.status = 'Pesanan Menunggu Diproses'";
												$resultOrderanMasuk = mysqli_query($conn, $queryOrderanMasuk);
												while ($rowOrderanMasuk = mysqli_fetch_assoc($resultOrderanMasuk)) {
													$detailPesanan = json_decode($rowOrderanMasuk['detail_pesanan'], true);
												?>
													<div class="d-flex flex-stack py-4">
														<div class="d-flex align-items-center me-2">
															<a href="#" class="text-gray-800 text-hover-primary fw-semibold min-w-125px" data-bs-toggle="modal" data-bs-target="#ModalViewPesananDiproses_<?= $rowOrderanMasuk['kode_p'];  ?>"><?= $rowOrderanMasuk["nama"]; ?></a>
															<span class="w-190px badge badge-light-warning me-4"><?= $rowOrderanMasuk["status"]; ?></span>
															<span class="w-150px badge badge-light-warning me-4">
															<?php
																foreach ($detailPesanan as $item) {
																	echo "Nama  : " . $item['nama_produk'] . "<br>";
																	echo "Jumlah : " . $item['jumlah'] . " Item" . "<br>";
																	echo "Harga Per Item : " . $item['harga_per_item'] . "<br><br>";
																}
															?>
															</span>
														</div>
													</div>
												<?php
												}
												?>
												<!--end::Item-->
											</div>
											<!--end::Items-->
											<!--begin::View more-->
											<div class="py-3 text-center border-top">
												<a href="pesanan.php" class="btn btn-color-gray-600 btn-active-color-primary">Semua
													<i class="ki-duotone ki-arrow-right fs-5">
														<span class="path1"></span>
														<span class="path2"></span>
													</i></a>
											</div>
											<!--end::View more-->
										</div>
										<?php
										}
										?>
										<!--end::Tab panel Orderan-->
										<?php
										if ($_SESSION['kategori_user'] == 'Driver') {
										// Tampilkan menu User jika kategori_user adalah 'Admin' atau 'User'
										?>
										<!--begin::Tab panel Orderan-->
										<div class="tab-pane fade show active" id="kt_topbar_notifications_2" role="tabpanel">
											<!--begin::Items-->
											<div class="scroll-y mh-325px my-5 px-8">
												<!--begin::Item-->
												<!--begin::Item for Orderan Masuk-->
												<?php
												// Query untuk mengambil orderan masuk dan data pelanggan yang sesuai
												$queryOrderanMasuk = "SELECT t.*, c.nama AS nama, c.alamat AS alamat FROM t_pesanan t
																	  JOIN customer c ON t.kode_cus = c.kode_cus
																	  WHERE t.status = 'Pesanan Diproses' ORDER BY kode_p ASC";
												$resultOrderanMasuk = mysqli_query($conn, $queryOrderanMasuk);
												while ($rowOrderanMasuk = mysqli_fetch_assoc($resultOrderanMasuk)) {
													$detailPesanan = json_decode($rowOrderanMasuk['detail_pesanan'], true);
												?>
													<div class="d-flex flex-stack py-4">
														<div class="d-flex align-items-center me-2">
															<a href="#" class="text-gray-800 text-hover-primary fw-semibold min-w-125px" data-bs-toggle="modal" data-bs-target="#ModalViewPesananDikirim_<?= $rowOrderanMasuk['kode_p'];  ?>"><?= $rowOrderanMasuk["nama"]; ?></a>
															<span class="w-100px badge badge-light-warning me-4"><?= $rowOrderanMasuk["alamat"]; ?></span>
															<span class="w-150px badge badge-light-warning me-4">
															<?php
																foreach ($detailPesanan as $item) {
																	echo "Nama  : " . $item['nama_produk'] . "<br>";
																	echo "Jumlah : " . $item['jumlah'] . " Item" . "<br>";
																	echo "Harga Per Item : " . $item['harga_per_item'] . "<br><br>";
																}
															?>
															</span>
														</div>
													</div>
												<?php
												}
												?>
												<!--end::Item-->
											</div>
											<!--end::Items-->
											<!--begin::View more-->
											<div class="py-3 text-center border-top">
												<a href="pesananDalamPengiriman.php" class="btn btn-color-gray-600 btn-active-color-primary">Semua
													<i class="ki-duotone ki-arrow-right fs-5">
														<span class="path1"></span>
														<span class="path2"></span>
													</i></a>
											</div>
											<!--end::View more-->
										</div>
										<?php
										}
										?>
										<!--end::Tab panel Orderan-->
									</div>
									<!--end::Tab content-->
								</div>
								<!--end::Menu-->
								<!--end::Menu wrapper-->
							</div>
							<!--end::Notifications-->
							<!--begin::Theme mode-->
							<div class="app-navbar-item ms-1 ms-md-3">
								<!--begin::Menu toggle-->
								<a href="#" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
									<!--begin::Svg Icon | path: icons/duotune/general/gen060.svg-->
									<span class="svg-icon theme-light-show svg-icon-2 text-warning">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M11.9905 5.62598C10.7293 5.62574 9.49646 5.9995 8.44775 6.69997C7.39903 7.40045 6.58159 8.39619 6.09881 9.56126C5.61603 10.7263 5.48958 12.0084 5.73547 13.2453C5.98135 14.4823 6.58852 15.6185 7.48019 16.5104C8.37186 17.4022 9.50798 18.0096 10.7449 18.2557C11.9818 18.5019 13.2639 18.3757 14.429 17.8931C15.5942 17.4106 16.5901 16.5933 17.2908 15.5448C17.9915 14.4962 18.3655 13.2634 18.3655 12.0023C18.3637 10.3119 17.6916 8.69129 16.4964 7.49593C15.3013 6.30056 13.6808 5.62806 11.9905 5.62598Z" fill="currentColor" />
											<path d="M22.1258 10.8771H20.627C20.3286 10.8771 20.0424 10.9956 19.8314 11.2066C19.6204 11.4176 19.5018 11.7038 19.5018 12.0023C19.5018 12.3007 19.6204 12.5869 19.8314 12.7979C20.0424 13.0089 20.3286 13.1274 20.627 13.1274H22.1258C22.4242 13.1274 22.7104 13.0089 22.9214 12.7979C23.1324 12.5869 23.2509 12.3007 23.2509 12.0023C23.2509 11.7038 23.1324 11.4176 22.9214 11.2066C22.7104 10.9956 22.4242 10.8771 22.1258 10.8771Z" fill="currentColor" />
											<path d="M11.9905 19.4995C11.6923 19.5 11.4064 19.6187 11.1956 19.8296C10.9848 20.0405 10.8663 20.3265 10.866 20.6247V22.1249C10.866 22.4231 10.9845 22.7091 11.1953 22.9199C11.4062 23.1308 11.6922 23.2492 11.9904 23.2492C12.2886 23.2492 12.5746 23.1308 12.7854 22.9199C12.9963 22.7091 13.1147 22.4231 13.1147 22.1249V20.6247C13.1145 20.3265 12.996 20.0406 12.7853 19.8296C12.5745 19.6187 12.2887 19.5 11.9905 19.4995Z" fill="currentColor" />
											<path d="M4.49743 12.0023C4.49718 11.704 4.37865 11.4181 4.16785 11.2072C3.95705 10.9962 3.67119 10.8775 3.37298 10.8771H1.87445C1.57603 10.8771 1.28984 10.9956 1.07883 11.2066C0.867812 11.4176 0.749266 11.7038 0.749266 12.0023C0.749266 12.3007 0.867812 12.5869 1.07883 12.7979C1.28984 13.0089 1.57603 13.1274 1.87445 13.1274H3.37299C3.6712 13.127 3.95706 13.0083 4.16785 12.7973C4.37865 12.5864 4.49718 12.3005 4.49743 12.0023Z" fill="currentColor" />
											<path d="M11.9905 4.50058C12.2887 4.50012 12.5745 4.38141 12.7853 4.17048C12.9961 3.95954 13.1147 3.67361 13.1149 3.3754V1.87521C13.1149 1.57701 12.9965 1.29103 12.7856 1.08017C12.5748 0.869313 12.2888 0.750854 11.9906 0.750854C11.6924 0.750854 11.4064 0.869313 11.1955 1.08017C10.9847 1.29103 10.8662 1.57701 10.8662 1.87521V3.3754C10.8664 3.67359 10.9849 3.95952 11.1957 4.17046C11.4065 4.3814 11.6923 4.50012 11.9905 4.50058Z" fill="currentColor" />
											<path d="M18.8857 6.6972L19.9465 5.63642C20.0512 5.53209 20.1343 5.40813 20.1911 5.27163C20.2479 5.13513 20.2772 4.98877 20.2774 4.84093C20.2775 4.69309 20.2485 4.54667 20.192 4.41006C20.1355 4.27344 20.0526 4.14932 19.948 4.04478C19.8435 3.94024 19.7194 3.85734 19.5828 3.80083C19.4462 3.74432 19.2997 3.71531 19.1519 3.71545C19.0041 3.7156 18.8577 3.7449 18.7212 3.80167C18.5847 3.85845 18.4607 3.94159 18.3564 4.04633L17.2956 5.10714C17.1909 5.21147 17.1077 5.33543 17.0509 5.47194C16.9942 5.60844 16.9649 5.7548 16.9647 5.90264C16.9646 6.05048 16.9936 6.19689 17.0501 6.33351C17.1066 6.47012 17.1895 6.59425 17.294 6.69878C17.3986 6.80332 17.5227 6.88621 17.6593 6.94272C17.7959 6.99923 17.9424 7.02824 18.0902 7.02809C18.238 7.02795 18.3844 6.99865 18.5209 6.94187C18.6574 6.88509 18.7814 6.80195 18.8857 6.6972Z" fill="currentColor" />
											<path d="M18.8855 17.3073C18.7812 17.2026 18.6572 17.1195 18.5207 17.0627C18.3843 17.006 18.2379 16.9767 18.0901 16.9766C17.9423 16.9764 17.7959 17.0055 17.6593 17.062C17.5227 17.1185 17.3986 17.2014 17.2941 17.3059C17.1895 17.4104 17.1067 17.5345 17.0501 17.6711C16.9936 17.8077 16.9646 17.9541 16.9648 18.1019C16.9649 18.2497 16.9942 18.3961 17.0509 18.5326C17.1077 18.6691 17.1908 18.793 17.2955 18.8974L18.3563 19.9582C18.4606 20.0629 18.5846 20.146 18.721 20.2027C18.8575 20.2595 19.0039 20.2887 19.1517 20.2889C19.2995 20.289 19.4459 20.26 19.5825 20.2035C19.7191 20.147 19.8432 20.0641 19.9477 19.9595C20.0523 19.855 20.1351 19.7309 20.1916 19.5943C20.2482 19.4577 20.2772 19.3113 20.277 19.1635C20.2769 19.0157 20.2476 18.8694 20.1909 18.7329C20.1341 18.5964 20.051 18.4724 19.9463 18.3681L18.8855 17.3073Z" fill="currentColor" />
											<path d="M5.09528 17.3072L4.0345 18.368C3.92972 18.4723 3.84655 18.5963 3.78974 18.7328C3.73294 18.8693 3.70362 19.0156 3.70346 19.1635C3.7033 19.3114 3.7323 19.4578 3.78881 19.5944C3.84532 19.7311 3.92822 19.8552 4.03277 19.9598C4.13732 20.0643 4.26147 20.1472 4.3981 20.2037C4.53473 20.2602 4.68117 20.2892 4.82902 20.2891C4.97688 20.2889 5.12325 20.2596 5.25976 20.2028C5.39627 20.146 5.52024 20.0628 5.62456 19.958L6.68536 18.8973C6.79007 18.7929 6.87318 18.6689 6.92993 18.5325C6.98667 18.396 7.01595 18.2496 7.01608 18.1018C7.01621 17.954 6.98719 17.8076 6.93068 17.671C6.87417 17.5344 6.79129 17.4103 6.68676 17.3058C6.58224 17.2012 6.45813 17.1183 6.32153 17.0618C6.18494 17.0053 6.03855 16.9763 5.89073 16.9764C5.74291 16.9766 5.59657 17.0058 5.46007 17.0626C5.32358 17.1193 5.19962 17.2024 5.09528 17.3072Z" fill="currentColor" />
											<path d="M5.09541 6.69715C5.19979 6.8017 5.32374 6.88466 5.4602 6.94128C5.59665 6.9979 5.74292 7.02708 5.89065 7.02714C6.03839 7.0272 6.18469 6.99815 6.32119 6.94164C6.45769 6.88514 6.58171 6.80228 6.68618 6.69782C6.79064 6.59336 6.87349 6.46933 6.93 6.33283C6.9865 6.19633 7.01556 6.05003 7.01549 5.9023C7.01543 5.75457 6.98625 5.60829 6.92963 5.47184C6.87301 5.33539 6.79005 5.21143 6.6855 5.10706L5.6247 4.04626C5.5204 3.94137 5.39643 3.8581 5.25989 3.80121C5.12335 3.74432 4.97692 3.71493 4.82901 3.71472C4.68109 3.71452 4.53458 3.7435 4.39789 3.80001C4.26119 3.85652 4.13699 3.93945 4.03239 4.04404C3.9278 4.14864 3.84487 4.27284 3.78836 4.40954C3.73185 4.54624 3.70287 4.69274 3.70308 4.84066C3.70329 4.98858 3.73268 5.135 3.78957 5.27154C3.84646 5.40808 3.92974 5.53205 4.03462 5.63635L5.09541 6.69715Z" fill="currentColor" />
										</svg>
									</span>
									<!--end::Svg Icon-->
									<!--begin::Svg Icon | path: icons/duotune/general/gen061.svg-->
									<span class="svg-icon theme-dark-show svg-icon-2 text-warning">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M19.0647 5.43757C19.3421 5.43757 19.567 5.21271 19.567 4.93534C19.567 4.65796 19.3421 4.43311 19.0647 4.43311C18.7874 4.43311 18.5625 4.65796 18.5625 4.93534C18.5625 5.21271 18.7874 5.43757 19.0647 5.43757Z" fill="currentColor" />
											<path d="M20.0692 9.48884C20.3466 9.48884 20.5714 9.26398 20.5714 8.98661C20.5714 8.70923 20.3466 8.48438 20.0692 8.48438C19.7918 8.48438 19.567 8.70923 19.567 8.98661C19.567 9.26398 19.7918 9.48884 20.0692 9.48884Z" fill="currentColor" />
											<path d="M12.0335 20.5714C15.6943 20.5714 18.9426 18.2053 20.1168 14.7338C20.1884 14.5225 20.1114 14.289 19.9284 14.161C19.746 14.034 19.5003 14.0418 19.3257 14.1821C18.2432 15.0546 16.9371 15.5156 15.5491 15.5156C12.2257 15.5156 9.48884 12.8122 9.48884 9.48886C9.48884 7.41079 10.5773 5.47137 12.3449 4.35752C12.5342 4.23832 12.6 4.00733 12.5377 3.79251C12.4759 3.57768 12.2571 3.42859 12.0335 3.42859C7.32556 3.42859 3.42857 7.29209 3.42857 12C3.42857 16.7079 7.32556 20.5714 12.0335 20.5714Z" fill="currentColor" />
											<path d="M13.0379 7.47998C13.8688 7.47998 14.5446 8.15585 14.5446 8.98668C14.5446 9.26428 14.7693 9.48891 15.0469 9.48891C15.3245 9.48891 15.5491 9.26428 15.5491 8.98668C15.5491 8.15585 16.225 7.47998 17.0558 7.47998C17.3334 7.47998 17.558 7.25535 17.558 6.97775C17.558 6.70015 17.3334 6.47552 17.0558 6.47552C16.225 6.47552 15.5491 5.76616 15.5491 4.93534C15.5491 4.65774 15.3245 4.43311 15.0469 4.43311C14.7693 4.43311 14.5446 4.65774 14.5446 4.93534C14.5446 5.76616 13.8688 6.47552 13.0379 6.47552C12.7603 6.47552 12.5357 6.70015 12.5357 6.97775C12.5357 7.25535 12.7603 7.47998 13.0379 7.47998Z" fill="currentColor" />
										</svg>
									</span>
									<!--end::Svg Icon-->
								</a>
								<!--begin::Menu toggle-->
								<!--begin::Menu-->
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
									<!--begin::Menu item-->
									<div class="menu-item px-3 my-0">
										<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
											<span class="menu-icon" data-kt-element="icon">
												<i class="ki-duotone ki-night-day fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
													<span class="path3"></span>
													<span class="path4"></span>
													<span class="path5"></span>
													<span class="path6"></span>
													<span class="path7"></span>
													<span class="path8"></span>
													<span class="path9"></span>
													<span class="path10"></span>
												</i>
											</span>
											<span class="menu-title">Light</span>
										</a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu item-->
									<div class="menu-item px-3 my-0">
										<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
											<span class="menu-icon" data-kt-element="icon">
												<i class="ki-duotone ki-moon fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</span>
											<span class="menu-title">Dark</span>
										</a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu item-->
									<div class="menu-item px-3 my-0">
										<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
											<span class="menu-icon" data-kt-element="icon">
												<i class="ki-duotone ki-screen fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
													<span class="path3"></span>
													<span class="path4"></span>
												</i>
											</span>
											<span class="menu-title">System</span>
										</a>
									</div>
									<!--end::Menu item-->
								</div>
								<!--end::Menu-->
							</div>
							<!--end::Theme mode-->
							<!--begin::User menu-->
							<div class="app-navbar-item ms-3 ms-lg-4 me-lg-2" id="kt_header_user_menu_toggle">
								<!--begin::Menu wrapper-->
								<div class="cursor-pointer symbol symbol-30px symbol-lg-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
									<img src="proses/<?php echo $_SESSION['foto_user']; ?>" alt="user" />
								</div>
								<!--begin::User account menu-->
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
									<!--begin::Menu item-->
									<div class="menu-item px-3">
										<div class="menu-content d-flex align-items-center px-3">
											<!--begin::Avatar-->
											<div class="symbol symbol-50px me-5">
												<img alt="user" src="proses/<?= $_SESSION['foto_user']; ?>" />
											</div>
											<!--end::Avatar-->
											<!--begin::Username-->
											<div class="d-flex flex-column">
												<div class="fw-bold d-flex align-items-center fs-5"><?= $_SESSION['nama']; ?></div>
												<a href="https://www.whatsapp.com/" class="fw-semibold text-muted text-hover-primary fs-7"><i class="fa fa-phone" style="color:green"></i>&nbsp;&nbsp;0<?= $_SESSION['no_telp']; ?></a>
											</div>
											<!--end::Username-->
										</div>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu separator-->
									<div class="separator my-2"></div>
									<!--end::Menu separator-->
									<!--begin::Menu item-->
									<div class="menu-item px-5">
										<a href="overview.php" class="menu-link px-5">Profilku</a>
									</div>
									<!--end::Menu item-->
									<?php
										if ($_SESSION['kategori_user'] == 'Admin') {
										// Tampilkan menu User hanya jika kategori_user adalah 'admin'
									?>
									<!--begin::Menu item-->
									<div class="menu-item px-5">
										<a href="proses/backup.php" class="menu-link px-5">Backup Database</a>
									</div>
									<!--end::Menu item-->
									<!--begin::Menu item-->
									<div class="menu-item px-5">
										<a href="proses/retrieve.php" class="menu-link px-5">Retrieve Database</a>
									</div>
									<!--end::Menu item-->
									<?php
									}
									?>
									<!--begin::Menu item-->
									<div class="menu-item px-5">
										<a href="#" onclick="confirmLogout()" class="menu-link px-5">Keluar</a>
									</div>
									<!--end::Menu item-->
								</div>
								<!--end::User account menu-->
								<!--end::Menu wrapper-->
							</div>
							<!--end::User menu-->
						</div>
						<!--end::Navbar-->
					</div>
					<!--end::Header main-->
					<!--begin::Separator-->
					<div class="app-header-separator"></div>
					<!--end::Separator-->
				</div>
				<!--end::Header-->
				
<!--begin::Modal - View Pesanan-->
<?php
	$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, c.alamat AS alamat, p.kode_b, p.alasan
								   FROM t_pesanan t
								   JOIN customer c ON t.kode_cus = c.kode_cus
								   LEFT JOIN t_pembatalan p ON t.kode_p = p.kode_p");

while ($row = mysqli_fetch_assoc($result)) {
	// Ubah JSON menjadi bentuk array menggunakan json_decode
	$detailPesanan = json_decode($row['detail_pesanan'], true);
	
	$isDisable = false;
    $isSelesaiDisabled = false; // Tambah variabel untuk tombol "Selesai"
    
    if ($row['status'] == 'Pesanan Selesai' || $row['status'] == 'Pesanan Dibatalkan' || $row['status'] == 'Pesanan Diproses' || $row['status'] == 'Pesanan Dalam Pengiriman' || $row['status'] == 'Pesanan Sampai Tujuan') {
        $isDisable = true;
        if ($row['status'] == 'Pesanan Dalam Pengiriman') {
            $isSelesaiDisabled = false; // Tombol "Selesai" diaktifkan jika status "Pesanan Dalam Pengiriman"
        } else {
            $isSelesaiDisabled = true; // Tombol "Selesai" dinonaktifkan untuk status lainnya
        }
    }
?>
<div class="modal fade" id="ModalViewPesananDikirim_<?= $row['kode_p'];  ?>" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header" id="kt_modal_edit_user_header">
				<!--begin::Modal title-->
				<h2 class="fw-bold">Detail Pesanan</h2>
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
				<form id="kt_modal_edit_user_form" class="form" action="#" method="POST">
					<!--begin::Scroll-->
					<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_edit_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="200px">
						<div class="row g-5">
							<div class="col-lg-12">
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
										<div id="kt_docs_card_collapsible" class="collapse show">
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
															<label for="exampleFormControlInput1" class="form-label fs-5">Alamat</label>
														</div>
													</div>
													<div class="col-lg-6">
														<div>:
															<label for="exampleFormControlInput1" class="form-label fs-5"><?= $row['alamat'];  ?></label>
														</div>
													</div>
												</div>
												<div class="row g-5">
													<div class="col-lg-6">
														<div class="mb-5">
															<label for="exampleFormControlInput1" class="form-label fs-5">Detail Pesanan</label>
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
								</table>
							</div>
						</div>
					</div>
					<!--end::Scroll-->
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

<!--begin::Modal - Pesanan Diproses-->
<?php
	$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, c.alamat AS alamat, p.kode_b, p.alasan
								   FROM t_pesanan t
								   JOIN customer c ON t.kode_cus = c.kode_cus
								   LEFT JOIN t_pembatalan p ON t.kode_p = p.kode_p");

while ($row = mysqli_fetch_assoc($result)) {
	// Ubah JSON menjadi bentuk array menggunakan json_decode
	$detailPesanan = json_decode($row['detail_pesanan'], true);
	
	$isDisable = false;
    $isSelesaiDisabled = false; // Tambah variabel untuk tombol "Selesai"
    
    if ($row['status'] == 'Pesanan Selesai' || $row['status'] == 'Pesanan Dibatalkan' || $row['status'] == 'Pesanan Diproses' || $row['status'] == 'Pesanan Dalam Pengiriman' || $row['status'] == 'Pesanan Sampai Tujuan') {
        $isDisable = true;
        if ($row['status'] == 'Pesanan Dalam Pengiriman') {
            $isSelesaiDisabled = false; // Tombol "Selesai" diaktifkan jika status "Pesanan Dalam Pengiriman"
        } else {
            $isSelesaiDisabled = true; // Tombol "Selesai" dinonaktifkan untuk status lainnya
        }
    }
?>
<div class="modal fade" id="ModalViewPesananDiproses_<?= $row['kode_p'];  ?>" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header" id="kt_modal_edit_user_header">
				<!--begin::Modal title-->
				<h2 class="fw-bold">Detail Pesanan Customer</h2>
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
				<form id="kt_modal_edit_user_form" class="form" action="#" method="POST">
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
										<div id="kt_docs_card_collapsible" class="collapse show">
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
															<label for="exampleFormControlInput1" class="form-label fs-5">Alamat</label>
														</div>
													</div>
													<div class="col-lg-6">
														<div>:
															<label for="exampleFormControlInput1" class="form-label fs-5"><?= $row['alamat'];  ?></label>
														</div>
													</div>
												</div>
												<div class="row g-5">
													<div class="col-lg-6">
														<div class="mb-5">
															<label for="exampleFormControlInput1" class="form-label fs-5">Detail Pesanan</label>
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
<!--end::Modal-->

<!--begin::Modal - Pesanan Ditolak-->
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
<div class="modal fade" id="modalTolak_<?= $row['kode_p'];  ?>" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header" id="kt_modal_edit_user_header">
				<!--begin::Modal title-->
				<h2 class="fw-bold">Alasan Pesanan Ditolak</h2>
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
				<form id="kt_modal_edit_user_form" class="form" action="proses/pesananDitolak.php" method="POST">
					<div class="mb-5">
						<label for="exampleFormControlInput1" class="required form-label fs-5">Alasan Ditolak</label>
						<input type="hidden" name="kode_p" id="kode_p" value="<?= $row['kode_p']; ?>">
						<input type="hidden" name="kode_cus" id="kode_cus" value="<?= $row['kode_cus']; ?>">
						<input type="hidden" name="nama_cus" id="nama_cus" value="<?= $row['nama_cus']; ?>">
						<textarea class="form-control form-control-solid" placeholder="Masukkan Alasan" name="alasan"></textarea>
					</div>
					<br>
					<!--begin::Actions-->
					<div class="text-end">
						<?php
						if ($_SESSION['kategori_user'] == 'User') {
						// Tampilkan menu User hanya jika kategori_user adalah 'admin'
						?>
						<button type="button" class="btn btn-secondary text-end" data-bs-toggle="modal" data-bs-dismiss="modal">Batal</button>
						<?php 
						} 
						?>
						<?php
						if ($_SESSION['kategori_user'] == 'User') {
						// Tampilkan menu User hanya jika kategori_user adalah 'admin'
						?>
						<button type="submit" name="submit" class="btn btn-danger text-end" 
							<?= $isDisable ? 'disabled' : ''; ?>>
							Tolak
						</button>
						<?php 
						} 
						?>
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
<!--end::Modal-->

<!--begin::Modal - View Rating Pesanan-->
<?php
	$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, r.rating, r.komentar
								   FROM t_pesanan t
								   JOIN customer c ON t.kode_cus = c.kode_cus
								   JOIN rating r ON t.kode_p = r.kode_p");

	while ($row = mysqli_fetch_assoc($result)) {
    // Lakukan sesuatu dengan data yang diperoleh

	// Ubah JSON menjadi bentuk array menggunakan json_decode
	$detailPesanan = json_decode($row['detail_pesanan'], true);
?>
<div class="modal fade" id="ModalViewRating_<?= $row['kode_p'];  ?>" tabindex="-1" aria-hidden="true">
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
										<div id="kt_docs_card_collapsible" class="collapse show">
											<div class="card-body">
												<div class="row g-5">
													<div class="col-lg-6">
														<div class="mb-3">
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
														<div class="mb-3">
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
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label fs-5">Detail Pesanan</label>
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
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label fs-5">Rating Produk</label>
														</div>
													</div>
													<div class="col-lg-6">
														<div>:
															<label for="exampleFormControlInput1" class="form-label fs-5">
															<?php
															$rating = $row['rating']; // Nilai rating dari database

															// Tentukan path menuju gambar ikon sesuai dengan nilai rating
															$iconPath = 'assets/media/emoji/';
															$ratingText = ''; // Variabel untuk menyimpan teks rating

															// Tentukan ikon dan teks berdasarkan nilai rating
															if ($rating == 5) {
																$iconPath .= '5.png';
																$ratingText = 'Sangat Puas';
															} elseif ($rating == 4) {
																$iconPath .= '4.png';
																$ratingText = 'Puas';
															} elseif ($rating == 3) {
																$iconPath .= '3.png';
																$ratingText = 'Cukup Puas';
															} elseif ($rating == 2) {
																$iconPath .= '2.png';
																$ratingText = 'Kurang Puas';
															} elseif ($rating == 1) {
																$iconPath .= '1.png';
																$ratingText = 'Kecewa';
															} else {
																$iconPath .= '5.png'; // Ikon default jika nilai rating tidak sesuai
																$ratingText = 'Tidak Ada Rating';
															}
															?>

															<img src="<?= $iconPath ?>" alt="Rating <?= $rating ?>" style="width: 50px; height: 35px;">
															<span><?= $ratingText ?></span>
															</label>
														</div>
													</div>
												</div>
												<div class="row g-5">
													<div class="col-lg-6">
														<div class="mb-3">
															<label for="exampleFormControlInput1" class="form-label fs-5">Ulasan Produk</label>
														</div>
													</div>
													<div class="col-lg-6">
														<div>:
															<label for="exampleFormControlInput1" class="form-label fs-5"><?= $row['komentar'];  ?></label>
														</div>
													</div>
												</div>
												<div class="row g-5">
													<div class="col-lg-6">
														<div class="mb-3">
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
														<div class="mb-3">
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
<!--end::Modal-->

<!--begin::Modal - Pesanan Dikirim-->
<div class="modal fade" id="modalPesananDikirim" tabindex="-1" aria-hidden="true">
<!--begin::Modal dialog-->
<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
	<!--begin::Modal content-->
	<div class="modal-content">
		<!--begin::Modal header-->
		<div class="modal-header" id="kt_modal_add_user_header">
			<!--begin::Modal title-->
			<h2 class="fw-bold">Pesanan Dalam Pengiriman</h2>
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
							<th class="min-w-100px">Pesanan</th>
							<th class="text-center min-w-70px">Total QTY</th>
							<th class="text-center min-w-70px">Total Harga</th>
							<th class="text-start min-w-250px">Detail Pesanan</th>
							<th class="text-center min-w-60px">Aksi</th>
						</tr>
					</thead>
					<tbody class="text-gray-600 fw-semibold">
					
					<?php
						$no = 1;
						$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, 
														CASE 
														WHEN t.status = 'Pesanan Diproses' THEN 'Pesanan Diproses' 
														WHEN t.status = 'Pesanan Dalam Pengiriman' THEN 'Pesanan Dalam Pengiriman' 
														END AS status
														FROM t_pesanan t
														JOIN customer c ON t.kode_cus = c.kode_cus
														WHERE t.status = 'Pesanan Diproses' OR t.status = 'Pesanan Dalam Pengiriman'
														ORDER BY t.kode_p ASC");

						while ($row = mysqli_fetch_assoc($result)) {
							// Ubah JSON menjadi bentuk array menggunakan json_decode
							$detailPesanan = json_decode($row['detail_pesanan'], true);
					?>
					
						<tr>
							<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
							<td class="text-gray-800 text-hover-primary">
								<!--begin::User details-->
								<div class="d-flex flex-column">
									<a href="#" class="text-gray-800 text-hover-primary mb-1"><h5><?= $row['nama'];  ?></h5></a>
									<span><?= $row['kode_p'];  ?></span>
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
								<!--begin::Menu item-->
								<div class="menu-item px-2">
									<div class="btn-group" role="group">
										<form id="kt_modal_edit_user_form" class="form" action="proses/prosesAntar.php" method="POST">
											<div class="mb-3">
												<input type="hidden" name="kode_p" id="kode_p" value="<?= $row['kode_p']; ?>">
											</div>
											<?php
											// Tentukan status pesanan
											$status = $row['status'];

											// Tambahkan kondisi untuk men-disable tombol berdasarkan status
											if ($status == 'Pesanan Diproses') {
											// Tombol "Proses" hanya aktif jika status "Pesanan Menunggu Diproses" atau "Pesanan Dibuat"
											?>
											<button type="submit" name="submit" class="btn btn-warning">
												<img src="assets/media/logos/delivery.svg" alt="Ikon Kustom" width="28" height="28">
											</button>
											<?php
											} else {
											// Tombol "Proses" dinonaktifkan untuk status lainnya
											?>
											<button type="submit" name="submit" class="btn btn-warning" disabled>
												<img src="assets/media/logos/delivery.svg" alt="Ikon Kustom" width="28" height="28">
											</button>
											<?php
											}
											?>
										</form>
										&nbsp;
										<form id="kt_modal_edit_user_form" class="form" action="proses/prosesSelesai.php" method="POST">
											<div class="mb-3">
												<input type="hidden" name="kode_p" id="kode_p" value="<?= $row['kode_p']; ?>">
											</div>
											<?php
											// Tombol "Tolak" hanya aktif jika status "Pesanan Dibuat"
											if ($status == 'Pesanan Dalam Pengiriman') {
											?>
											<button type="submit" name="submit" class="btn btn-success">
												<img src="assets/media/logos/selesai1.svg" alt="Ikon Kustom" width="28" height="28">
											</button>
											<?php
											} else {
											// Tombol "Tolak" dinonaktifkan untuk status lainnya
											?>
											<button type="submit" name="submit" class="btn btn-success" disabled>
												<img src="assets/media/logos/selesai1.svg" alt="Ikon Kustom" width="28" height="28">
											</button>
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
			</div>
			<!--end::Modal body-->
		</div>
		<!--end::Modal content-->
	</div>
	<!--end::Modal dialog-->
</div>
<!--end::Modal--->

<!--begin::Modal - Pesanan Sampai-->
<div class="modal fade" id="modalPesananSampai" tabindex="-1" aria-hidden="true">
<!--begin::Modal dialog-->
<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
	<!--begin::Modal content-->
	<div class="modal-content">
		<!--begin::Modal header-->
		<div class="modal-header" id="kt_modal_add_user_header">
			<!--begin::Modal title-->
			<h2 class="fw-bold">Pesanan Sampai Tujuan</h2>
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
							<th class="min-w-100px">Pesanan</th>
							<th class="text-center min-w-70px">Total QTY</th>
							<th class="text-center min-w-70px">Total Harga</th>
							<th class="text-start min-w-100px">Detail Pesanan</th>
							<th class="text-center min-w-100px">Tanggal</th>
						</tr>
					</thead>
					<tbody class="text-gray-600 fw-semibold">
					
					<?php
						$no = 1;
						$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, 'Pesanan Sampai Tujuan' AS status
													   FROM t_pesanan t
													   JOIN customer c ON t.kode_cus = c.kode_cus
													   WHERE t.status = 'Pesanan Sampai Tujuan'
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
									<a href="#" class="text-gray-800 text-hover-primary mb-1"><h5><?= $row['nama'];  ?></h5></a>
									<span><?= $row['kode_p'];  ?></span>
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
							<td class="text-center"><?= $row['tgl_sampai'];  ?></td>
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
				$queryTotalSampai = "SELECT COUNT(*) AS total_sampai FROM t_pesanan WHERE status = 'Pesanan Sampai Tujuan'";
				$resultTotalSampai = mysqli_query($conn, $queryTotalSampai);
				$rowTotalSampai = mysqli_fetch_assoc($resultTotalSampai);
				$totalPesananSampai = $rowTotalSampai['total_sampai'];
				?>
				<div class="text-start">
					<div class="d-flex flex-column">
						<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Pesanan : <?= $totalPesananSampai; ?> Pesanan</h5></span>
					</div>
				</div>
			</div>
		</div>
		<!--end::Modal content-->
	</div>
	<!--end::Modal dialog-->
</div>
<!--end::Modal--->