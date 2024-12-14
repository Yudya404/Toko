<?php 
include 'koneksi/koneksi.php';
// Tentukan waktu timeout (dalam detik)
$sessionTimeout = 1800; // 30 menit

// Mulai sesi
session_start();

// Set waktu timeout pada sesi
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $sessionTimeout)) {
    // Sesuatu yang ingin Anda lakukan saat sesi kedaluwarsa
    session_unset();
    session_destroy();
    header("Location: index.php"); // Redirect ke halaman login
}
$_SESSION['last_activity'] = time();

if(isset($_SESSION['kode_cus'])){
	$kode_cus = $_SESSION['kode_cus'];// Ambil data pengguna dari database berdasarkan kode_user yang sedang login
	$nama = $_SESSION['nama'];
	$email = $_SESSION['email'];
	$alamat = $_SESSION['alamat'];
	$no_telp = $_SESSION['no_telp'];
	$tgl_join = $_SESSION['tgl_join'];
	$foto_cus = $_SESSION['foto_cus'];
	$query = "SELECT * FROM customer WHERE kode_cus = '$kode_cus'";
	$result = mysqli_query($conn, $query);
	$userData = mysqli_fetch_assoc($result);
}

$login_required_pages = array("profilku", "cart", "checkout", "riwayat_belanja", "edit_profilku", "sukses", "riwayat_retur"); // Daftar halaman yang memerlukan login

// Ambil nama halaman saat ini
$current_page = basename($_SERVER['PHP_SELF'], ".php");

// Cek apakah halaman saat ini memerlukan login
if (in_array($current_page, $login_required_pages)) {
    if (session_status() === PHP_SESSION_NONE || !isset($_SESSION['kode_cus'])) {
        header('Location: index.php'); // Mengarahkan ke halaman index.php jika belum login atau sesi tidak dimulai
        exit();
    }
}

if (isset($_SESSION['error_message'])) {
echo '<div class="error" style="text-align: center;">' . $_SESSION['error_message'] . '</div>';
unset($_SESSION['error_message']); // Hapus pesan kesalahan setelah ditampilkan
}

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
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Toko Bu Heru</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Css Styles -->
	<link rel="shortcut icon" href="img/favicon.ico" />
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
	<style>
        .custom-card {
            max-width: 800px; /* Ubah nilai sesuai kebutuhan lebar yang diinginkan */
            margin: 0 auto; /* Agar card berada di tengah halaman */
        }
    </style>
	<style>
		.error {
			color: red;
			font-weight: bold;
		}
	</style>
	<style>
	/* Gaya untuk menu dropdown user */
	.header__user-dropdown {
	  position: relative;
	  display: inline-block;
	}

	.header__user-dropdown-toggle {
	  display: flex;
	  align-items: center;
	  font-size: 14px;
	  color: #333;
	  cursor: pointer;
	  padding: 8px 16px;
	  transition: background-color 0.3s ease;
	}

	.header__user-dropdown-toggle:hover {
	  background-color: #f8f8f8;
	}

	.header__user-dropdown-toggle i {
	  margin-right: 10px;
	  font-size: 18px;
	}

	.header__user-dropdown-menu {
	  display: none;
	  position: absolute;
	  top: 100%;
	  left: -10px;
	  width: 200px;
	  background-color: #fff;
	  border: 1px solid #ddd;
	  border-top: none;
	  padding: 10px 0;
	  z-index: 1;
	  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
	  border-radius: 4px;
	  transition: opacity 0.3s ease, transform 0.3s ease;
	  opacity: 0;
	  transform: translateY(-10px);
	}

	.header__user-dropdown:hover .header__user-dropdown-menu {
	  display: block;
	  opacity: 1;
	  transform: translateY(0);
	}

	.header__user-dropdown-menu li {
	  padding: 10px 20px;
	  list-style: none;
	}

	.header__user-dropdown-menu li a {
	  text-decoration: none;
	  color: #333;
	  display: block;
	  transition: background-color 0.3s ease, color 0.3s ease;
	}

	.header__user-dropdown-menu li a:hover {
	  background-color: #f8f8f8;
	  color: #007bff;
	}

	/* Gaya untuk link login */
	.header__login-link {
	  text-decoration: none;
	  font-size: 14px;
	  color: #333;
	}

	/* Gaya untuk ikon tombol login */
	.header__login-icon {
	  font-size: 18px;
	  margin-right: 8px;
	}
	</style>
	<style>
		/* Style for the order date and order code container */
		.order-info {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 20px;
		}
	</style>
	<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .timeline-label {
            margin-left: 50px;
        }

        .timeline-item {
            position: relative;
            padding: 15px;
            border-left: 2px solid #ccc;
            margin-bottom: 20px;
        }

        .timeline-label .timeline-item:first-child {
            margin-top: -8px;
        }

        .timeline-badge {
            position: absolute;
            left: -32px;
            top: 15px;
        }

        .timeline-badge i {
            font-size: 20px;
        }

        .timeline-text {
            margin-top: 5px;
        }
		.card {
            border: none;
        }
    </style>
	<style>
		.list-unstyled {
		  list-style: none;
		  padding-left: 0;
		}
	</style>
	<style>
		.collapsible {
			cursor: pointer;
			padding: 18px;
			width: 100%;
			text-align: left;
			border: none;
			outline: none;
			transition: 0.4s;
			margin-bottom: 10px; /* Tambahkan margin bawah di sini */
		}

		.content {
			padding: 0 18px;
			display: none;
			overflow: hidden;
			background-color: #f1f1f1;
		}
	</style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
			<?php
				$nama = "Gambar Logo Header"; // Ganti dengan nama yang ingin dicari
				$result = mysqli_query($conn, "SELECT * FROM about");
				while ($row = mysqli_fetch_assoc($result)) {
				if ($row['nama'] == $nama) {
			?>
            <a href="index.php"><img src="back/dist/proses/<?= $row['gambar_a']; ?>" alt="Gambar Logo"></a>
			<?php
				}
			}
			?>
        </div>
        <div class="humberger__menu__cart text-center">
            <ul>
				<?php
				// Periksa apakah customer sudah login
				if (isset($_SESSION['kode_cus'])) {
					// Ambil kode customer dari sesi
					$kode_cus = $_SESSION['kode_cus'];

					// Query untuk menghitung jumlah barang di keranjang customer
					$query_barang = "SELECT COUNT(*) AS total_barang FROM cart WHERE kode_cus = '$kode_cus'";
					$result_barang = mysqli_query($conn, $query_barang);
					$row_barang = mysqli_fetch_assoc($result_barang);
					$total_barang = $row_barang['total_barang'];

					// Query untuk menghitung total harga dari barang di keranjang customer
					$query_total_harga = "SELECT SUM(harga * jumlah) AS total_harga FROM cart WHERE kode_cus = '$kode_cus'";
					$result_total_harga = mysqli_query($conn, $query_total_harga);
					$row_total_harga = mysqli_fetch_assoc($result_total_harga);
					$total_harga = $row_total_harga['total_harga'];

					// Tampilkan jumlah barang di keranjang dan total harga
					echo '<li><a href="./cart.php"><i class="fa fa-shopping-cart" style="color:orange"></i> <span>' . $total_barang . '</span></a></li>';
				} else {
					// Jika belum login, tampilkan jumlah 0
					echo '<li><a href="#" data-toggle="modal" data-target="#loginCus" class="header__login-link">
							  <i class="fa fa-shopping-cart" style="color:orange"></i> <span>0</span></a></li>';
				}
				?>
				<?php
				// Periksa apakah customer sudah login
				if (isset($_SESSION['kode_cus'])) {
					// Ambil kode customer dari sesi
					$kode_cus = $_SESSION['kode_cus'];

					// Query untuk menghitung jumlah pesanan yang sedang dalam status "Pesanan Menunggu Diproses" dan "Pesanan Diproses"
					$query_pesanan = "SELECT COUNT(*) AS total_pesanan FROM t_pesanan WHERE kode_cus = '$kode_cus' AND (status = 'Pesanan Menunggu Diproses' OR status = 'Pesanan Diproses')";
					$result_pesanan = mysqli_query($conn, $query_pesanan);
					$row_pesanan = mysqli_fetch_assoc($result_pesanan);
					$total_pesanan = $row_pesanan['total_pesanan'];

					// Tampilkan jumlah pesanan di keranjang
					echo '<li><a href="./riwayat_belanja.php"><i class="fa fa-shopping-bag" style="color:green"></i> <span>' . $total_pesanan . '</span></a></li>';
				} else {
					// Jika belum login, tampilkan jumlah 0
					echo '<li><a href="#" data-toggle="modal" data-target="#loginCus" class="header__login-link"><i class="fa fa-shopping-bag" style="color:green"></i> <span>0</span></a></li>';
				}
				?>
				<?php
				if (isset($_SESSION['kode_cus'])) {
					// Ambil kode customer dari sesi
					$kode_cus = $_SESSION['kode_cus'];

					// Query untuk menghitung jumlah rating dengan status "Belum Dinilai" atau "Periksa"
					$query_rating = "SELECT COUNT(*) AS total_rating FROM rating WHERE kode_cus = '$kode_cus' AND (status_rating = 'Belum Dinilai')";
					$result_rating = mysqli_query($conn, $query_rating);
					$row_rating = mysqli_fetch_assoc($result_rating);
					$total_rating = $row_rating['total_rating'];

					// Tampilkan jumlah rating belum dinilai
					echo '<li><a href="./riwayat_rating.php"><i class="fa fa-heart" style="color:red"></i> <span>' . $total_rating . '</span></a></li>';
				}
				?>
			</ul>
        </div>
		<div class="humberger__menu__widget">
            <div class="header__top__right__auth">
			   <?php if (isset($_SESSION["kode_cus"])) { ?>
					<div class="header__user-dropdown">
						<a href="#" class="header__user-dropdown-toggle">
							<i class="fa fa-user"></i> <?= $_SESSION['nama']; ?>
						</a>
						<ul class="header__user-dropdown-menu text-left">
							<li><a href="profilku.php"><i class="fa fa-user"></i>&nbsp;&nbsp; Profilku</a></li>
							<li><a href="riwayat_belanja.php"><i class="fa fa-shopping-bag"></i>&nbsp;&nbsp;Riwayat Belanja</a></li>
							<li><a href="#" onclick="confirmLogout()"><i class="fa fa-sign-out"></i>&nbsp;&nbsp; Logout</a></li>
						</ul>
					</div>
				<?php } else { ?>
					<a href="#" data-toggle="modal" data-target="#loginCus" class="header__login-link">
						<i class="fa fa-user"></i> Login
					</a>
				<?php } ?>
				<!-- Modal -->
				<div class="modal fade" id="loginCus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="false" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content" style="background-image: url('img/blog/blog-2.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center;">
							<div class="modal-header">
								<h5 class="modal-title" style="color:green" id="exampleModalLabel">Halaman Login Customer</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<!--begin::Heading-->
								<div class="px-10 text-center mb-10">
									<?php
										$nama = "Gambar Login Customer"; // Ganti dengan nama yang ingin dicari
										$result = mysqli_query($conn, "SELECT * FROM about");
										while ($row = mysqli_fetch_assoc($result)) {
											if ($row['nama'] == $nama) {
									?>
										<img src="back/dist/proses/<?= $row['gambar_a']; ?>" height="100px" alt="Gambar Logo">
									<?php
										}		
									}
									?>
								</div>
								<!-- Form Login -->
								<form action="proses/verifikasi_login.php" method="POST">
									<div class="form-group text-left">
										<label for="email">Email:</label>
										<input type="email" class="form-control" id="email" name="email" required>
									</div>
									<div class="form-group text-left">
										<label for="password">Password:</label>
										<input type="password" class="form-control" id="pass" name="pass" required>
									</div>
									<button type="submit" class="site-btn w-100 mb-5">Login</button>
									<div class="text-center">Belum punya akun? <a href="register.php" class="text-primary" id="signup-link">Buat akun baru</a></div>
								</form>
							</div>
							<div class="modal-footer">
								<div class="text-center">
									<a href="#" data-toggle="modal" data-target="#bantuan" class="text-primary" id="help-link">Butuh bantuan? </a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Modal -->
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="./index.php">Beranda</a></li>
				<li><a href="./produk.php">Produk</a></li>
				<li><a href="./mohonMaaf.php">Blog</a></li>
                <li><a href="./about.php">Tentang Kami</a></li>
				<?php
					if (isset($_SESSION['kode_cus'])) {
					// User sudah login, tampilkan elemen
					echo '<li><a href="./mohonMaaf.php">Ulasan</a></li>';
				}
				?>
                <li><a href="./contact.php">Kontak</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
			<a href="https://www.facebook.com/"><i class="fa fa-facebook" style="color:blue"></i></a>
			<a href="https://www.instagram.com/"><i class="fa fa-instagram" style="color:pink"></i></a>
			<a href="https://www.whatsapp.com/"><i class="fa fa-whatsapp" style="color:green"></i></a>
			<a href="https://www.google.com/intl/id/gmail/about/"><i class="fa fa-envelope" style="color:red"></i></a>
		</div>
        <div class="humberger__menu__contact">
            <ul>
				<?php
					$nama = "Email"; // Ganti dengan nama yang ingin dicari
					$result = mysqli_query($conn, "SELECT * FROM kontak");
					while ($row = mysqli_fetch_assoc($result)) {
					if ($row['nama'] == $nama) {
				?>
                <li><i class="fa fa-whatsapp" style="color:green"></i><?= $row['isi']; ?></li>
				<?php
					}
				}
				?>
				<?php
					$nama = "No Telp & WA"; // Ganti dengan nama yang ingin dicari
					$result = mysqli_query($conn, "SELECT * FROM kontak");
					while ($row = mysqli_fetch_assoc($result)) {
					if ($row['nama'] == $nama) {
				?>
				<li><i class="fa fa-envelope" style="color:red"></i><?= $row['isi']; ?></li>
				<?php
					}
				}
				?>
				<?php
					$nama = "Keterangan"; // Ganti dengan nama yang ingin dicari
					$result = mysqli_query($conn, "SELECT * FROM kontak");
					while ($row = mysqli_fetch_assoc($result)) {
					if ($row['nama'] == $nama) {
				?>
                <li><i class="fa fa-shopping-bag" style="color:orange"></i><?= $row['isi']; ?></li>
				<?php
					}
				}
				?>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->