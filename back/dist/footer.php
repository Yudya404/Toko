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
							<!--end:::Main-->
						</div>
						<!--end::Wrapper-->
					</div>
					<!--end::Page-->
				</div>
				<!--end::App-->
				
<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
	<i class="ki-duotone ki-arrow-up">
		<span class="path1"></span>
		<span class="path2"></span>
	</i>
</div>
<!--end::Scrolltop-->
		
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
<!-- Script untuk menggambar grafik -->
<script>
// Data pengunjung per hari
var dailyData = [100, 150, 120, 180, 200, 250, 170];

// Data pengunjung per minggu
var weeklyData = [800, 900, 1000, 1200, 1100, 950, 1050];

// Label untuk sumbu x (hari atau minggu)
var labels = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];

// Buat grafik menggunakan Chart.js
var ctx = document.getElementById('visitorChart').getContext('2d');
var visitorChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Pengunjung per Hari',
            data: dailyData,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }, {
            label: 'Pengunjung per Minggu',
            data: weeklyData,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true, // Aktifkan responsif
        maintainAspectRatio: false, // Matikan aspek rasio agar dapat menyesuaikan dengan lebar kontainer
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Atur ulang ukuran grafik saat ukuran window berubah
window.addEventListener('resize', function() {
    var chartContainer = document.getElementById('chartContainer');
    var chartWidth = chartContainer.offsetWidth;
    var chartHeight = chartContainer.offsetHeight;
    visitorChart.canvas.width = chartWidth;
    visitorChart.canvas.height = chartHeight;
    visitorChart.update();
});
</script>
<script>
document.getElementById('print-button').addEventListener('click', function() {
  window.print();
});
</script>
<script>
const buttonSpnAsesmodalKirim = document.getElementById('modalKirim');

buttonSpnAsesmodalKirim.addEventListener('click', eSpnAsesmodalKirim => {
	eSpnAsesmodalKirim.preventDefault();
	var tanggallengkap = new String();
	var jamlengkap = new String();
	var namahari = ("Minggu Senin Selasa Rabu Kamis Jumat Sabtu");
	namahari = namahari.split(" ");
	var namabulan = ("Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember");
	namabulan = namabulan.split(" ");
	var tgl = new Date();
	var hari = tgl.getDay();
	var tanggal = tgl.getDate();
	var bulan = tgl.getMonth();
	var tahun = tgl.getFullYear();
	var jam = new Date().getHours();
	var menit = new Date().getMinutes();
	var detik = new Date().getSeconds();

	tanggallengkap = tanggal + " " + namabulan[bulan] + " " + tahun;
	jamlengkap = " " + jam + ":" + menit + ":" + detik;

	Swal.fire({
		text: "Berhasil merepson Kritik & Saran dengan ID Formulir KS001 terkirim pada " + tanggallengkap + jamlengkap,
		icon: "success",
		buttonsStyling: false,
		confirmButtonText: "Selesai",
		customClass: {
			confirmButton: "btn btn-primary"
		}
	}).then(function(result) {


	});
});
</script>
<script>
	  <?php 
		// Memasukkan kode ulasan ke dalam array JavaScript untuk digunakan dalam script di bawah ini
		$ulasanList = array();
		$result = mysqli_query($conn, "SELECT kode_ulasan FROM ulasan");
		while ($row = mysqli_fetch_assoc($result)) {
			$ulasanList[] = $row['kode_ulasan'];
		}
		echo "var ulasanList = " . json_encode($ulasanList) . ";"; 
	  ?>

	  // Function to handle form submission and show SweetAlert
	  function handleFormSubmit(kodeUlasan) {
		var form = document.getElementById('formRespon_' + kodeUlasan);
		var formData = new FormData(form);

		// Use AJAX to submit the form data to proses/ulasan.php
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
		  if (xhr.readyState === XMLHttpRequest.DONE) {
			if (xhr.status === 200) {
			  // Success response, show SweetAlert
			  Swal.fire({
				icon: 'success',
				title: 'Respon berhasil disimpan',
				text: 'Status ulasan telah diubah menjadi "sudah".',
				onClose: function() {
				  // Close the modal after SweetAlert is closed
				  document.getElementById('modalRespon_' + kodeUlasan).modal('hide');
				}
			  });
			} else {
			  // Error response, show SweetAlert error
			  Swal.fire({
				icon: 'error',
				title: 'Terjadi kesalahan',
				text: 'Terjadi kesalahan saat mengirim respon.'
			  });
			}
		  }
		};
		
		xhr.open('POST', 'ulasan.php', true);
		xhr.send(formData);
	  }

	  // Add event listeners for each "Kirim" button with ID "modalKirim_kodeUlasan"
	  ulasanList.forEach(function(kodeUlasan) {
		var modalKirimBtn = document.getElementById('modalKirim_' + kodeUlasan);
		if (modalKirimBtn) {
		  modalKirimBtn.addEventListener('click', function() {
			handleFormSubmit(kodeUlasan);
		  });
		}
	  });
	</script>
	<script>
	// Mendapatkan referensi elemen input
	var userInput = document.getElementById('user_id');

	// Menonaktifkan elemen input
	userInput.disabled = true;
	</script>
	 <!-- Letakkan kode JavaScript Delete Data Tabel -->
    <script>
        const tabelConfig = {
            user: {
                deleteUrl: 'proses/user_delete.php',
                deleteParameter: 'kode_user',
                deleteMessage: 'Apakah Anda yakin ingin menghapus User ini?'
            },
            ulasan: {
                deleteUrl: 'proses/ulasan_delete.php',
                deleteParameter: 'kode_ulasan',
                deleteMessage: 'Apakah Anda yakin ingin menghapus Ulasan ini?'
            },
			customer: {
                deleteUrl: 'proses/cus_delete.php',
                deleteParameter: 'kode_cus',
                deleteMessage: 'Apakah Anda yakin ingin menghapus Customer ini?'
            },
			produk: {
                deleteUrl: 'proses/produk_delete.php',
                deleteParameter: 'kode_produk',
                deleteMessage: 'Apakah Anda yakin ingin menghapus Produk ini?'
            },
			respon: {
                deleteUrl: 'proses/respon_delete.php',
                deleteParameter: 'kode_respon',
                deleteMessage: 'Apakah Anda yakin ingin menghapus Respon ini?'
            },
			about: {
                deleteUrl: 'proses/about_delete.php',
                deleteParameter: 'kode_a',
                deleteMessage: 'Apakah Anda yakin ingin menghapus Gambar ini?'
            },
			contact: {
                deleteUrl: 'proses/contact_delete.php',
                deleteParameter: 'kode_c',
                deleteMessage: 'Apakah Anda yakin ingin menghapus Data ini?'
            },
			pesanan: {
                deleteUrl: 'proses/pesanan_delete.php',
                deleteParameter: 'kode_p',
                deleteMessage: 'Apakah Anda yakin ingin menghapus Data Pesanan ini?'
            },
            // Tambahkan konfigurasi untuk tabel lain di sini jika diperlukan
        };

        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.btn-danger');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const tabel = this.getAttribute('data-tabel');
					const kodeData = tabel === 'user' ? this.getAttribute('data-kode-user') : 
									 tabel === 'ulasan' ? this.getAttribute('data-kode-ulasan') : 
									 tabel === 'customer' ? this.getAttribute('data-kode-cus') : 
									 tabel === 'produk' ? this.getAttribute('data-kode-pro') : 
									 tabel === 'respon' ? this.getAttribute('data-kode-res') : 
									 tabel === 'about' ? this.getAttribute('data-kode-abt') : (tabel === 'kontak' ? this.getAttribute('data-kode-kon') : this.getAttribute('data-kode-p'));	
						
                    const config = tabelConfig[tabel]; // Dapatkan konfigurasi untuk tabel tertentu
                    
                    Swal.fire({
                        text: config.deleteMessage,
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Tidak, batal",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton: "btn fw-bold btn-active-light-primary"
                        }
                    }).then(function (result) {
                        if (result.value) {
                            // Panggil fungsi untuk menghapus data melalui AJAX
                            deleteData(config, kodeData);
                        }
                    });
                });
            });

            function deleteData(config, kodeData) {
                fetch(config.deleteUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `${config.deleteParameter}=${encodeURIComponent(kodeData)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
						Swal.fire({
							text: "Data berhasil dihapus.",
							icon: "success",
							buttonsStyling: false,
							confirmButtonText: "Selesai",
							customClass: {
								confirmButton: "btn fw-bold btn-primary",
							}
						}).then(function () {
							// Refresh halaman atau ambil tindakan lain yang diperlukan
						});
					} else {
						Swal.fire({
							text: "Terjadi kesalahan saat menghapus data.",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Selesai",
							customClass: {
								confirmButton: "btn fw-bold btn-primary",
							}
						});
					}
                });
            }
        });
	</script>
	<script>
    function cetakUser(elementId) {
        const modalBody = document.getElementById(elementId).innerHTML;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
	<html>
	<head>
    <title>Data User</title>
    <style>
        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
		
		/* Tambahkan style CSS sesuai kebutuhan */
         img {
            max-width: 50px;
            max-height: 50px;
        }

        /* Container */
        .pdf-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 10px;
        }

        /* Page title */
        .page-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Breadcrumb */
        .breadcrumb {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item {
            display: inline;
            margin-right: 5px;
        }

        .breadcrumb-item a {
            color: #333;
            text-decoration: none;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Card */
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 20px;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 8px 12px;
            margin-right: 10px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            border: 1px solid #ccc;
            background-color: #f2f2f2;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }

        /* Add more styles as needed */

        /* Custom styles for printing */
        @media print {
            body {
                font-size: 12px;
            }
            .breadcrumb,
            .btn {
                display: none;
            }
            table {
                font-size: 12px;
                margin-top: 10px;
            }
            th, td {
                border: 1px solid #ccc;
                padding: 6px;
            }
            .btn-primary,
            .btn-danger {
                display: none;
            }
        }
    </style>
		</head>
			<body>
				<div class="pdf-container">
					<h1 class="page-title">Data User</h1>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Informasi</a></li>
						<li class="breadcrumb-item">User</li>
					</ul>
					<div class="card">
						<div class="card-body py-4">
							<table class="table align-middle table-row-dashed fs-6 gy-5">
									<thead>
										<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
											<th class="min-w-10px">No</th>
											<th class="min-w-100px">Nama</th>
											<th class="min-w-70px">ID</th>
											<th class="min-w-100px">Akses</th>
											<th class="min-w-125px">Alamat</th>
											<th class="min-w-110px">Tanggal Join</th>
										</tr>
									</thead>
									<tbody class="text-gray-600 fw-semibold" id="tableBody">
										<?php
											$no = 1;
											$result = mysqli_query($conn, "SELECT * FROM user ORDER BY kode_user DESC");
											while ($row = mysqli_fetch_assoc($result)) {
										?>
											<tr>
												<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
												<td class="d-flex align-items-center">
													<!--begin:: Avatar -->
													<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
														<a href="#">
															<div class="symbol-label">
																<img src="proses/<?= $row['foto_user']; ?>" alt="Foto User" class="w-100" />
															</div>
														</a>
													</div>
													<!--end::Avatar-->
													<!--begin::User details-->
													<div class="d-flex flex-column">
														<a href="#" class="text-gray-800 text-hover-primary mb-1"><?= $row['nama'];  ?></a>
														<br>
														<span><span>0</span><?= $row['no_telp'];  ?></span>
													</div>
													<!--begin::User details-->
												</td>
												<td><?= $row['kode_user'];  ?></td>
												<td>
													<?php
														// Cek status kategori_user dan tampilkan badge sesuai kondisi
														if ($row['kategori_user'] == 'Admin') {
															echo '<span class="badge badge-light-success form-label fs-5">' . $row['kategori_user'] . '</span>';
														} elseif ($row['kategori_user'] == 'User') {
															echo '<span class="badge badge-light-primary form-label fs-5">' . $row['kategori_user'] . '</span>';
														} else {
															echo '<span class="badge badge-light-warning form-label fs-5">' . $row['kategori_user'] . '</span>';
														}
													?>
												</td>
												<td><?= $row['alamat'];  ?></td>
												<td><?= formatTanggalIndonesia($row['tgl_join']); ?></td>
											</tr>
										<?php
										}
										?>
								</tbody>
							</table>
							<?php
							// Query untuk menghitung total pesanan dengan status "Pesanan Selesai"
							$queryTotalUser = "SELECT COUNT(*) AS total_user FROM user";
							$resultTotalUser = mysqli_query($conn, $queryTotalUser);
							$rowTotalUser = mysqli_fetch_assoc($resultTotalUser);
							$totalUser = $rowTotalUser['total_user'];
							?>
							<div class="text-start">
								<div class="d-flex flex-column">
									<span class="text-gray-800 text-hover-primary mb-1"><h5>Total User : <?= $totalUser; ?> Orang</h5></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</body>
		</html>
        `);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
	</script>
	<script>
    function cetakUlasan(elementId) {
        const modalBody = document.getElementById(elementId).innerHTML;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
    <!DOCTYPE html>
	<html>
		<head>
		<title>Data Ulasan Pelanggan</title>
		<style>
			/* Global styles */
			body {
				font-family: Arial, sans-serif;
				font-size: 14px;
			}
			
			/* Tambahkan style CSS sesuai kebutuhan */
			 img {
				max-width: 50px;
				max-height: 50px;
			}

			/* Container */
			.pdf-container {
				max-width: 100%;
				margin: 0 auto;
				padding: 10px;
			}

			/* Page title */
			.page-title {
				font-size: 24px;
				font-weight: bold;
				margin-bottom: 20px;
			}

			/* Breadcrumb */
			.breadcrumb {
				list-style: none;
				padding: 0;
				margin: 0;
			}

			.breadcrumb-item {
				display: inline;
				margin-right: 5px;
			}

			.breadcrumb-item a {
				color: #333;
				text-decoration: none;
			}

			/* Table */
			table {
				width: 100%;
				border-collapse: collapse;
			}

			th, td {
				border: 1px solid #ccc;
				padding: 8px;
			}

			th {
				background-color: #f2f2f2;
			}

			/* Card */
			.card {
				border: 1px solid #ccc;
				border-radius: 5px;
				margin-bottom: 20px;
				padding: 20px;
			}

			/* Buttons */
			.btn {
				display: inline-block;
				padding: 8px 12px;
				margin-right: 10px;
				text-decoration: none;
				border-radius: 4px;
				font-weight: bold;
				cursor: pointer;
				text-align: center;
				border: 1px solid #ccc;
				background-color: #f2f2f2;
			}

			.btn-primary {
				background-color: #007bff;
				color: #fff;
				border: none;
			}

			.btn-danger {
				background-color: #dc3545;
				color: #fff;
				border: none;
			}

			/* Add more styles as needed */

			/* Custom styles for printing */
			@media print {
				body {
					font-size: 12px;
				}
				.breadcrumb,
				.btn {
					display: none;
				}
				table {
					font-size: 12px;
					margin-top: 10px;
				}
				th, td {
					border: 1px solid #ccc;
					padding: 6px;
				}
				.btn-primary,
				.btn-danger {
					display: none;
				}
			}
		</style>
			</head>
				<body>
					<div class="pdf-container">
						<h1 class="page-title">Data Ulasan Pelanggan</h1>
						<div class="card">
							<div class="card-body py-4">
								<table class="table align-middle table-row-dashed fs-6 gy-5">
									<thead>
										<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
											<th class="min-w-10px">No</th>
											<th class="min-w-125px">Nama</th>
											<th class="min-w-60px">ID</th>
											<th class="min-w-100px">No. Telp</th>
											<th class="min-w-150px">Alamat</th>
											<th class="text-center min-w-110px">Tanggal Ulasan</th>
										</tr>
									</thead>
									<tbody class="text-gray-600 fw-semibold">
									<?php
									$no = 1;
									$result = mysqli_query($conn, "SELECT * FROM ulasan");
									while ($row = mysqli_fetch_assoc($result)) {
										?>
										
										<tr>
										<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
										<td class="d-flex align-items-center">
										<!--begin::User details-->
										<div class="d-flex flex-column">
										<a href="#" class="text-gray-800 text-hover-primary mb-1"><?= $row['nama'];  ?></a>
										<br>
										<span><?= $row['email'];  ?></span>
										</div>
										<!--begin::User details-->
										</td>
										<td><?= $row['kode_ulasan'];  ?></td>
										<td><?= $row['no_telp'];  ?></td>
										<td><div class="text-gray-800 text-hover-primary"><?= $row['alamat'];  ?></div></td>
										<td class="text-center">
										<?php
										// Cek status jika sudah direspon
										if ($row['status'] == 'Sudah Direspon') {
											echo '<span class="badge badge-light-success form-label fs-5">' . $row['status'] . '</span>';
										} else {
											echo '<span class="badge badge-light-danger form-label fs-5">' . $row['status'] . '</span>';
										}
										?><br>
										<span class="fw-bold text-primary ms-3"><?= $row['tgl_ulasan'];  ?></span>
										</td>
										</tr>
										
										<?php
									}
									?>
									
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</body>
			</html>
        `);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
	</script>
	<script>
    function cetakCus(elementId) {
        const modalBody = document.getElementById(elementId).innerHTML;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
    <!DOCTYPE html>
	<html>
		<head>
		<title>Data Pelanggan</title>
		<style>
			/* Global styles */
			body {
				font-family: Arial, sans-serif;
				font-size: 14px;
			}
			
			/* Tambahkan style CSS sesuai kebutuhan */
			 img {
				max-width: 50px;
				max-height: 50px;
			}

			/* Container */
			.pdf-container {
				max-width: 100%;
				margin: 0 auto;
				padding: 10px;
			}

			/* Page title */
			.page-title {
				font-size: 24px;
				font-weight: bold;
				margin-bottom: 20px;
			}

			/* Breadcrumb */
			.breadcrumb {
				list-style: none;
				padding: 0;
				margin: 0;
			}

			.breadcrumb-item {
				display: inline;
				margin-right: 5px;
			}

			.breadcrumb-item a {
				color: #333;
				text-decoration: none;
			}

			/* Table */
			table {
				width: 100%;
				border-collapse: collapse;
			}

			th, td {
				border: 1px solid #ccc;
				padding: 8px;
			}

			th {
				background-color: #f2f2f2;
			}

			/* Card */
			.card {
				border: 1px solid #ccc;
				border-radius: 5px;
				margin-bottom: 20px;
				padding: 20px;
			}

			/* Buttons */
			.btn {
				display: inline-block;
				padding: 8px 12px;
				margin-right: 10px;
				text-decoration: none;
				border-radius: 4px;
				font-weight: bold;
				cursor: pointer;
				text-align: center;
				border: 1px solid #ccc;
				background-color: #f2f2f2;
			}

			.btn-primary {
				background-color: #007bff;
				color: #fff;
				border: none;
			}

			.btn-danger {
				background-color: #dc3545;
				color: #fff;
				border: none;
			}

			/* Add more styles as needed */

			/* Custom styles for printing */
			@media print {
				body {
					font-size: 12px;
				}
				.breadcrumb,
				.btn {
					display: none;
				}
				table {
					font-size: 12px;
					margin-top: 10px;
				}
				th, td {
					border: 1px solid #ccc;
					padding: 6px;
				}
				.btn-primary,
				.btn-danger {
					display: none;
				}
			}
		</style>
			</head>
				<body>
					<div class="pdf-container">
						<h1 class="page-title">Data Pelanggan</h1>
						<div class="card">
							<div class="card-body py-4">
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
													<br>
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
						</div>
					</div>
				</body>
			</html>
        `);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
	</script>
	<script>
    function cetakProduk(elementId) {
        const modalBody = document.getElementById(elementId).innerHTML;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
    <!DOCTYPE html>
	<html>
		<head>
		<title>Data Produk</title>
		<style>
			/* Global styles */
			body {
				font-family: Arial, sans-serif;
				font-size: 14px;
			}
			
			/* Tambahkan style CSS sesuai kebutuhan */
			 img {
				max-width: 50px;
				max-height: 50px;
			}

			/* Container */
			.pdf-container {
				max-width: 100%;
				margin: 0 auto;
				padding: 10px;
			}

			/* Page title */
			.page-title {
				font-size: 24px;
				font-weight: bold;
				margin-bottom: 20px;
			}

			/* Breadcrumb */
			.breadcrumb {
				list-style: none;
				padding: 0;
				margin: 0;
			}

			.breadcrumb-item {
				display: inline;
				margin-right: 5px;
			}

			.breadcrumb-item a {
				color: #333;
				text-decoration: none;
			}

			/* Table */
			table {
				width: 100%;
				border-collapse: collapse;
			}

			th, td {
				border: 1px solid #ccc;
				padding: 8px;
			}

			th {
				background-color: #f2f2f2;
			}

			/* Card */
			.card {
				border: 1px solid #ccc;
				border-radius: 5px;
				margin-bottom: 20px;
				padding: 20px;
			}

			/* Buttons */
			.btn {
				display: inline-block;
				padding: 8px 12px;
				margin-right: 10px;
				text-decoration: none;
				border-radius: 4px;
				font-weight: bold;
				cursor: pointer;
				text-align: center;
				border: 1px solid #ccc;
				background-color: #f2f2f2;
			}

			.btn-primary {
				background-color: #007bff;
				color: #fff;
				border: none;
			}

			.btn-danger {
				background-color: #dc3545;
				color: #fff;
				border: none;
			}

			/* Add more styles as needed */

			/* Custom styles for printing */
			@media print {
				body {
					font-size: 12px;
				}
				.breadcrumb,
				.btn {
					display: none;
				}
				table {
					font-size: 12px;
					margin-top: 10px;
				}
				th, td {
					border: 1px solid #ccc;
					padding: 6px;
				}
				.btn-primary,
				.btn-danger {
					display: none;
				}
			}
		</style>
			</head>
				<body>
					<div class="pdf-container">
						<h1 class="page-title">Data Produk</h1>
						<div class="card">
							<div class="card-body py-4">
								<table class="table align-middle table-row-dashed fs-6 gy-5">
									<thead>
										<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
											<th class="min-w-5px">No</th>
											<th class="min-w-200px">Produk</th>
											<th class="text-center min-w-50px">Stok</th>
											<th class="text-center min-w-70px">Harga</th>
											<th class="text-center min-w-300px">Deskripsi</th>
											<th class="text-center min-w-50px">Satuan</th>
											<th class="text-center min-w-150px">Tgl EXP</th>
										</tr>
									</thead>
									<tbody class="text-gray-600 fw-semibold">
									
									<?php
										$no = 1;
										$totalHargaSemuaProduk = 0; // Inisialisasi total harga semua pesanan
										$totalQtySemuaProduk = 0; // Inisialisasi total jumlah semua pesanan
										$result = mysqli_query($conn, "SELECT * FROM produk ORDER BY kode_produk DESC");
										while ($row = mysqli_fetch_assoc($result)) {
											
											// Hitung total harga pesanan saat ini dan tambahkan ke total keseluruhan
											$totalHargaSemuaProduk += floatval($row['harga']);
											
											// Hitung total jumlah pesanan saat ini dan tambahkan ke total keseluruhan
											$totalQtySemuaProduk += intval($row['stok']);
									?>
									
										<tr>
											<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
											<td class="d-flex align-items-center">
												<!--begin:: Avatar -->
												<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
													<a href="#">
														<div class="symbol-label">
															<img src="proses/<?= $row['foto_produk']; ?>" alt="Gambar Produk" class="w-100" />
														</div>
													</a>
												</div>
												<!--end::Avatar-->
												<!--begin::User details-->
												<div class="d-flex flex-column">
													<a href="#" class="text-gray-800 text-hover-primary mb-1"><?= $row['nama'];  ?></a>
													<br>
													<span><?= $row['kode_produk'];  ?></span>
												</div>
												<!--begin::User details-->
											</td>
											<td class="text-center">
												<?php
												$stok = $row['stok'];

												if ($stok < 10 && $stok > 0) {
													echo '<span class="badge badge-light-warning">Re-stock</span>';
													echo '<span class="fw-bold text-warning ms-3">' . $stok . '</span>';
												} elseif ($stok == 0) {
													echo '<span class="badge badge-light-danger">Stok Habis</span>';
													echo '<span class="fw-bold text-danger ms-3">' . $stok . '</span>';
												} else {
													echo '<span class="fw-bold text-success ms-3">' . $stok . '</span>';
												}
												?>
											</td>
											<td class="text-center"><?= $row['harga'];  ?></td>
											<td class="text-center"><?= $row['deskripsi'];  ?></td>
											<td class="text-center"><div class="text-gray-800 text-hover-primary"><?= $row['satuan'];  ?></div></td>
											<td class="text-center"><?= formatTanggalIndonesia($row['tgl_exp']); ?></td>
										</tr>
										<?php
										}
										?>
										
									</tbody>
								</table>
								<?php
								// Query untuk menghitung total pesanan dengan status "Pesanan Selesai"
								$queryTotalProduk = "SELECT COUNT(*) AS total_produk FROM produk";
								$resultTotalProduk = mysqli_query($conn, $queryTotalProduk);
								$rowTotalProduk = mysqli_fetch_assoc($resultTotalProduk);
								$totalProduk= $rowTotalProduk['total_produk'];
								?>
								<div class="text-start">
									<div class="d-flex flex-column">
										<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Semua Produk: <?= $totalProduk; ?> Produk</h5></span>
										<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Semua Stok Produk	: <?= $totalQtySemuaProduk; ?> Item</h5></span>
										<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Harga Produk	: Rp. <?= number_format($totalHargaSemuaProduk, 2); ?></h5></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</body>
			</html>
        `);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
	</script>
	<script>
    function cetakRespon(elementId) {
        const modalBody = document.getElementById(elementId).innerHTML;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
    <!DOCTYPE html>
	<html>
		<head>
		<title>Data Respon Ulasan</title>
		<style>
			/* Global styles */
			body {
				font-family: Arial, sans-serif;
				font-size: 14px;
			}
			
			/* Tambahkan style CSS sesuai kebutuhan */
			 img {
				max-width: 50px;
				max-height: 50px;
			}

			/* Container */
			.pdf-container {
				max-width: 100%;
				margin: 0 auto;
				padding: 10px;
			}

			/* Page title */
			.page-title {
				font-size: 24px;
				font-weight: bold;
				margin-bottom: 20px;
			}

			/* Breadcrumb */
			.breadcrumb {
				list-style: none;
				padding: 0;
				margin: 0;
			}

			.breadcrumb-item {
				display: inline;
				margin-right: 5px;
			}

			.breadcrumb-item a {
				color: #333;
				text-decoration: none;
			}

			/* Table */
			table {
				width: 100%;
				border-collapse: collapse;
			}

			th, td {
				border: 1px solid #ccc;
				padding: 8px;
			}

			th {
				background-color: #f2f2f2;
			}

			/* Card */
			.card {
				border: 1px solid #ccc;
				border-radius: 5px;
				margin-bottom: 20px;
				padding: 20px;
			}

			/* Buttons */
			.btn {
				display: inline-block;
				padding: 8px 12px;
				margin-right: 10px;
				text-decoration: none;
				border-radius: 4px;
				font-weight: bold;
				cursor: pointer;
				text-align: center;
				border: 1px solid #ccc;
				background-color: #f2f2f2;
			}

			.btn-primary {
				background-color: #007bff;
				color: #fff;
				border: none;
			}

			.btn-danger {
				background-color: #dc3545;
				color: #fff;
				border: none;
			}

			/* Add more styles as needed */

			/* Custom styles for printing */
			@media print {
				body {
					font-size: 12px;
				}
				.breadcrumb,
				.btn {
					display: none;
				}
				table {
					font-size: 12px;
					margin-top: 10px;
				}
				th, td {
					border: 1px solid #ccc;
					padding: 6px;
				}
				.btn-primary,
				.btn-danger {
					display: none;
				}
			}
		</style>
			</head>
				<body>
					<div class="pdf-container">
						<h1 class="page-title">Data Respon Ulasan</h1>
						<div class="card">
							<div class="card-body py-4">
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
							</div>
						</div>
					</div>
				</body>
			</html>
        `);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
	</script>
	<script>
    function cetakAbout(elementId) {
        const modalBody = document.getElementById(elementId).innerHTML;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
    <!DOCTYPE html>
	<html>
		<head>
		<title>Data About</title>
		<style>
			/* Global styles */
			body {
				font-family: Arial, sans-serif;
				font-size: 14px;
			}
			
			/* Tambahkan style CSS sesuai kebutuhan */
			 img {
				max-width: 50px;
				max-height: 50px;
			}

			/* Container */
			.pdf-container {
				max-width: 100%;
				margin: 0 auto;
				padding: 10px;
			}

			/* Page title */
			.page-title {
				font-size: 24px;
				font-weight: bold;
				margin-bottom: 20px;
			}

			/* Breadcrumb */
			.breadcrumb {
				list-style: none;
				padding: 0;
				margin: 0;
			}

			.breadcrumb-item {
				display: inline;
				margin-right: 5px;
			}

			.breadcrumb-item a {
				color: #333;
				text-decoration: none;
			}

			/* Table */
			table {
				width: 100%;
				border-collapse: collapse;
			}

			th, td {
				border: 1px solid #ccc;
				padding: 8px;
			}

			th {
				background-color: #f2f2f2;
			}

			/* Card */
			.card {
				border: 1px solid #ccc;
				border-radius: 5px;
				margin-bottom: 20px;
				padding: 20px;
			}

			/* Buttons */
			.btn {
				display: inline-block;
				padding: 8px 12px;
				margin-right: 10px;
				text-decoration: none;
				border-radius: 4px;
				font-weight: bold;
				cursor: pointer;
				text-align: center;
				border: 1px solid #ccc;
				background-color: #f2f2f2;
			}

			.btn-primary {
				background-color: #007bff;
				color: #fff;
				border: none;
			}

			.btn-danger {
				background-color: #dc3545;
				color: #fff;
				border: none;
			}

			/* Add more styles as needed */

			/* Custom styles for printing */
			@media print {
				body {
					font-size: 12px;
				}
				.breadcrumb,
				.btn {
					display: none;
				}
				table {
					font-size: 12px;
					margin-top: 10px;
				}
				th, td {
					border: 1px solid #ccc;
					padding: 6px;
				}
				.btn-primary,
				.btn-danger {
					display: none;
				}
			}
		</style>
			</head>
				<body>
					<div class="pdf-container">
						<h1 class="page-title">Data About</h1>
						<div class="card">
							<div class="card-body py-4">
									<table class="table align-middle table-row-dashed fs-6 gy-5">
									<thead>
										<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
											<th class="min-w-5px">No</th>
											<th class="min-w-200px">Gambar</th>
											<th class="text-center min-w-50px">Kode</th>
											<th class="text-center min-w-70px">Nama</th>
											<th class="text-center min-w-150px">Tanggal Input</th>
										</tr>
									</thead>
									<tbody class="text-gray-600 fw-semibold">
									
									<?php
										$no = 1;
										$result = mysqli_query($conn, "SELECT * FROM about");
										while ($row = mysqli_fetch_assoc($result)) {
									?>
									
										<tr>
											<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
											<td class="d-flex align-items-center">
												<!--begin:: Avatar -->
												<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
													<a href="#">
														<div class="symbol-label">
															<img src="proses/<?= $row['gambar_a']; ?>" alt="Gambar Produk" class="w-100" />
														</div>
													</a>
												</div>
												<!--end::Avatar-->
											</td>
											<td class="text-center"><?= $row['kode_a'];  ?></td>
											<td class="text-center"><?= $row['nama'];  ?></td>
											<td class="text-center"><?= formatTanggalIndonesia($row['tgl_input']); ?></td>
										</tr>
										<?php
										}
										?>
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</body>
			</html>
        `);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
	</script>
	<script>
    function cetakContact(elementId) {
        const modalBody = document.getElementById(elementId).innerHTML;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
    <!DOCTYPE html>
	<html>
		<head>
		<title>Data Contact</title>
		<style>
			/* Global styles */
			body {
				font-family: Arial, sans-serif;
				font-size: 14px;
			}
			
			/* Tambahkan style CSS sesuai kebutuhan */
			 img {
				max-width: 50px;
				max-height: 50px;
			}

			/* Container */
			.pdf-container {
				max-width: 100%;
				margin: 0 auto;
				padding: 10px;
			}

			/* Page title */
			.page-title {
				font-size: 24px;
				font-weight: bold;
				margin-bottom: 20px;
			}

			/* Breadcrumb */
			.breadcrumb {
				list-style: none;
				padding: 0;
				margin: 0;
			}

			.breadcrumb-item {
				display: inline;
				margin-right: 5px;
			}

			.breadcrumb-item a {
				color: #333;
				text-decoration: none;
			}

			/* Table */
			table {
				width: 100%;
				border-collapse: collapse;
			}

			th, td {
				border: 1px solid #ccc;
				padding: 8px;
			}

			th {
				background-color: #f2f2f2;
			}

			/* Card */
			.card {
				border: 1px solid #ccc;
				border-radius: 5px;
				margin-bottom: 20px;
				padding: 20px;
			}

			/* Buttons */
			.btn {
				display: inline-block;
				padding: 8px 12px;
				margin-right: 10px;
				text-decoration: none;
				border-radius: 4px;
				font-weight: bold;
				cursor: pointer;
				text-align: center;
				border: 1px solid #ccc;
				background-color: #f2f2f2;
			}

			.btn-primary {
				background-color: #007bff;
				color: #fff;
				border: none;
			}

			.btn-danger {
				background-color: #dc3545;
				color: #fff;
				border: none;
			}

			/* Add more styles as needed */

			/* Custom styles for printing */
			@media print {
				body {
					font-size: 12px;
				}
				.breadcrumb,
				.btn {
					display: none;
				}
				table {
					font-size: 12px;
					margin-top: 10px;
				}
				th, td {
					border: 1px solid #ccc;
					padding: 6px;
				}
				.btn-primary,
				.btn-danger {
					display: none;
				}
			}
		</style>
			</head>
				<body>
					<div class="pdf-container">
						<h1 class="page-title">Data Contact</h1>
						<div class="card">
							<div class="card-body py-4">
									<table class="table align-middle table-row-dashed fs-6 gy-5">
									<thead>
										<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
											<th class="min-w-5px">No</th>
											<th class="text-center min-w-70px">Kode</th>
											<th class="text-center min-w-150px">Nama</th>
											<th class="text-center min-w-200px">Isi</th>
											<th class="text-center min-w-150px">Tanggal Input</th>
										</tr>
									</thead>
									<tbody class="text-gray-600 fw-semibold">
									
									<?php
										$no = 1;
										$result = mysqli_query($conn, "SELECT * FROM kontak");
										while ($row = mysqli_fetch_assoc($result)) {
									?>
									
										<tr>
											<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
											<td class="text-center"><?= $row['kode_c'];  ?></td>
											<td class="text-center"><?= $row['nama'];  ?></td>
											<td class="text-center"><?= $row['isi'];  ?></td>
											<td class="text-center"><?= formatTanggalIndonesia($row['tgl_input']); ?></td>
										</tr>
										<?php
										}
										?>
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</body>
			</html>
        `);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
	</script>
	<script>
    function cetakPesanan(elementId) {
        const modalBody = document.getElementById(elementId).innerHTML;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
    <!DOCTYPE html>
	<html>
		<head>
		<title>Data Pesanan</title>
		<style>
			/* Global styles */
			body {
				font-family: Arial, sans-serif;
				font-size: 14px;
			}
			
			/* Tambahkan style CSS sesuai kebutuhan */
			 img {
				max-width: 50px;
				max-height: 50px;
			}

			/* Container */
			.pdf-container {
				max-width: 100%;
				margin: 0 auto;
				padding: 10px;
			}

			/* Page title */
			.page-title {
				font-size: 24px;
				font-weight: bold;
				margin-bottom: 20px;
			}

			/* Breadcrumb */
			.breadcrumb {
				list-style: none;
				padding: 0;
				margin: 0;
			}

			.breadcrumb-item {
				display: inline;
				margin-right: 5px;
			}

			.breadcrumb-item a {
				color: #333;
				text-decoration: none;
			}

			/* Table */
			table {
				width: 100%;
				border-collapse: collapse;
			}

			th, td {
				border: 1px solid #ccc;
				padding: 8px;
			}

			th {
				background-color: #f2f2f2;
			}

			/* Card */
			.card {
				border: 1px solid #ccc;
				border-radius: 5px;
				margin-bottom: 20px;
				padding: 20px;
			}

			/* Buttons */
			.btn {
				display: inline-block;
				padding: 8px 12px;
				margin-right: 10px;
				text-decoration: none;
				border-radius: 4px;
				font-weight: bold;
				cursor: pointer;
				text-align: center;
				border: 1px solid #ccc;
				background-color: #f2f2f2;
			}

			.btn-primary {
				background-color: #007bff;
				color: #fff;
				border: none;
			}

			.btn-danger {
				background-color: #dc3545;
				color: #fff;
				border: none;
			}

			/* Add more styles as needed */

			/* Custom styles for printing */
			@media print {
				body {
					font-size: 12px;
				}
				.breadcrumb,
				.btn {
					display: none;
				}
				table {
					font-size: 12px;
					margin-top: 10px;
				}
				th, td {
					border: 1px solid #ccc;
					padding: 6px;
				}
				.btn-primary,
				.btn-danger {
					display: none;
				}
			}
		</style>
			</head>
				<body>
					<div class="pdf-container">
						<h1 class="page-title">Data Pesanan</h1>
						<div class="card">
							<div class="card-body py-4">
									<table class="table align-middle table-row-dashed fs-6 gy-5">
									<thead>
										<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
											<th class="min-w-5px">No</th>
											<th class="min-w-200px">Pesanan</th>
											<th class="text-center min-w-70px">Total QTY</th>
											<th class="text-center min-w-70px">Total Harga</th>
											<th class="text-start min-w-150px">Detail Pesanan</th>
											<th class="text-center min-w-50px">Status</th>
											<th class="text-center min-w-150px">Tanggal Pesanan</th>
										</tr>
									</thead>
									<tbody class="text-gray-600 fw-semibold">
									
									<?php
										$no = 1;
										$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, 
																	   CASE 
																		 WHEN t.status = 'Pesanan Menunggu Diproses' THEN 'Pesanan Menunggu Diproses' 
																		 WHEN t.status = 'Pesanan Diproses' THEN 'Pesanan Diproses' 
																	   END AS status
																	   FROM t_pesanan t
																	   JOIN customer c ON t.kode_cus = c.kode_cus
																	   WHERE t.status = 'Pesanan Menunggu Diproses' OR t.status = 'Pesanan Diproses'
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
													<a href="#" class="text-gray-800 text-hover-primary mb-1 text-center"><h5><?= $row['nama'];  ?></h5></a>
													<br>
													<span class="text-center"><?= $row['kode_p'];  ?></span>
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
												<?php
												// Cek status untuk menentukan kelas CSS
												$status = $row['status'];
												$statusClass = '';

												if ($status == 'Pesanan Selesai') {
													$statusClass = 'badge-light-primary';
												} elseif ($status == 'Pesanan Sampai Tujuan') {
													$statusClass = 'badge-light-success';
												} elseif ($status == 'Pesanan Dalam Pengiriman') {
													$statusClass = 'badge-light-warning';
												} elseif ($status == 'Pesanan Diproses') {
													$statusClass = 'badge-light-warning';
												} elseif ($status == 'Pesanan Menunggu Diproses') {
													$statusClass = 'badge-light-warning';
												} elseif ($status == 'Pesanan Dibuat') {
													$statusClass = 'badge-light-secondary';
												} elseif ($status == 'Pesanan Dibatalkan') {
													$statusClass = 'badge-light-danger';
												}

												// Tampilkan status dengan kelas CSS yang sesuai
												echo '<span class="badge form-label fs-5 ' . $statusClass . '">' . $status . '</span>';
												?>
											</td>
											<td class="text-center"><?= formatTanggalIndonesia($row['tgl_pesan']); ?></td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</body>
			</html>
        `);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
	</script>
	<script>
    function cetakPenjualan(elementId) {
        const modalBody = document.getElementById(elementId).innerHTML;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
    <!DOCTYPE html>
	<html>
		<head>
		<title>Data Penjualan</title>
		<style>
			/* Global styles */
			body {
				font-family: Arial, sans-serif;
				font-size: 14px;
			}
			
			/* Tambahkan style CSS sesuai kebutuhan */
			 img {
				max-width: 50px;
				max-height: 50px;
			}

			/* Container */
			.pdf-container {
				max-width: 100%;
				margin: 0 auto;
				padding: 10px;
			}

			/* Page title */
			.page-title {
				font-size: 24px;
				font-weight: bold;
				margin-bottom: 20px;
			}

			/* Breadcrumb */
			.breadcrumb {
				list-style: none;
				padding: 0;
				margin: 0;
			}

			.breadcrumb-item {
				display: inline;
				margin-right: 5px;
			}

			.breadcrumb-item a {
				color: #333;
				text-decoration: none;
			}

			/* Table */
			table {
				width: 100%;
				border-collapse: collapse;
			}

			th, td {
				border: 1px solid #ccc;
				padding: 8px;
			}

			th {
				background-color: #f2f2f2;
			}

			/* Card */
			.card {
				border: 1px solid #ccc;
				border-radius: 5px;
				margin-bottom: 20px;
				padding: 20px;
			}

			/* Buttons */
			.btn {
				display: inline-block;
				padding: 8px 12px;
				margin-right: 10px;
				text-decoration: none;
				border-radius: 4px;
				font-weight: bold;
				cursor: pointer;
				text-align: center;
				border: 1px solid #ccc;
				background-color: #f2f2f2;
			}

			.btn-primary {
				background-color: #007bff;
				color: #fff;
				border: none;
			}

			.btn-danger {
				background-color: #dc3545;
				color: #fff;
				border: none;
			}

			/* Add more styles as needed */

			/* Custom styles for printing */
			@media print {
				body {
					font-size: 12px;
				}
				.breadcrumb,
				.btn {
					display: none;
				}
				table {
					font-size: 12px;
					margin-top: 10px;
				}
				th, td {
					border: 1px solid #ccc;
					padding: 6px;
				}
				.btn-primary,
				.btn-danger {
					display: none;
				}
			}
		</style>
			</head>
				<body>
					<div class="pdf-container">
						<h1 class="page-title">Data Penjualan</h1>
						<div class="card">
							<div class="card-body py-4">
									<table class="table align-middle table-row-dashed fs-6 gy-5">
									<thead>
										<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
											<th class="min-w-5px">No</th>
											<th class="min-w-200px">Pesanan</th>
											<th class="text-center min-w-70px">Total QTY</th>
											<th class="text-center min-w-70px">Total Harga</th>
											<th class="text-start min-w-150px">Detail Pesanan</th>
											<th class="text-center min-w-50px">Status</th>
											<th class="text-center min-w-150px">Tanggal Pesanan</th>
										</tr>
									</thead>
									<tbody class="text-gray-600 fw-semibold">
									
									<?php
										$no = 1;
										$totalHargaSemuaPesanan = 0; // Inisialisasi total harga semua pesanan
										$totalQtySemuaPesanan = 0; // Inisialisasi total jumlah semua pesanan
										$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, 'Pesanan Selesai' AS status
																	   FROM t_pesanan t
																	   JOIN customer c ON t.kode_cus = c.kode_cus
																	   WHERE t.status = 'Pesanan Selesai'
																	   ORDER BY t.kode_p DESC");

										while ($row = mysqli_fetch_assoc($result)) {
											// Ubah JSON menjadi bentuk array menggunakan json_decode
											$detailPesanan = json_decode($row['detail_pesanan'], true);
											
											// Hitung total harga pesanan saat ini dan tambahkan ke total keseluruhan
											$totalHargaSemuaPesanan += floatval($row['t_harga']);
																				
											// Hitung total jumlah pesanan saat ini dan tambahkan ke total keseluruhan
											$totalQtySemuaPesanan += intval($row['t_item']);
									?>
									
										<tr>
											<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
											<td class="text-gray-800 text-hover-primary">
												<!--begin::User details-->
												<div class="d-flex flex-column">
													<a href="#" class="text-gray-800 text-hover-primary mb-1 text-center"><h5><?= $row['nama'];  ?></h5></a>
													<br>
													<span class="text-center"><?= $row['kode_p'];  ?></span>
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
												<?php
												// Cek status untuk menentukan kelas CSS
												$status = $row['status'];
												$statusClass = '';

												if ($status == 'Pesanan Selesai') {
													$statusClass = 'badge-light-primary';
												} elseif ($status == 'Pesanan Sampai Tujuan') {
													$statusClass = 'badge-light-success';
												} elseif ($status == 'Pesanan Dalam Pengiriman') {
													$statusClass = 'badge-light-warning';
												} elseif ($status == 'Pesanan Diproses') {
													$statusClass = 'badge-light-warning';
												} elseif ($status == 'Pesanan Menunggu Diproses') {
													$statusClass = 'badge-light-warning';
												} elseif ($status == 'Pesanan Dibuat') {
													$statusClass = 'badge-light-secondary';
												} elseif ($status == 'Pesanan Dibatalkan') {
													$statusClass = 'badge-light-danger';
												}

												// Tampilkan status dengan kelas CSS yang sesuai
												echo '<span class="badge form-label fs-5 ' . $statusClass . '">' . $status . '</span>';
												?>
											</td>
											<td class="text-center"><?= formatTanggalIndonesia($row['tgl_pesan']); ?></td>
										</tr>
										<?php
										}
										?>
										
									</tbody>
								</table>
								<?php
								// Query untuk menghitung total pesanan dengan status "Pesanan Selesai"
								$queryTotalSelesai = "SELECT COUNT(*) AS total_selesai FROM t_pesanan WHERE status = 'Pesanan Selesai'";
								$resultTotalSelesai = mysqli_query($conn, $queryTotalSelesai);
								$rowTotalSelesai = mysqli_fetch_assoc($resultTotalSelesai);
								$totalPesananSelesai = $rowTotalSelesai['total_selesai'];
								?>
								<div class="text-start">
									<div class="d-flex flex-column">
										<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Pendapatan      : Rp. <?= number_format($totalHargaSemuaPesanan, 2); ?></h5></span>
										<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Pesanan Selesai : <?= $totalPesananSelesai; ?> Pesanan</h5></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</body>
			</html>
        `);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
	</script>
	<script>
    function cetakPesananDibatalkan(elementId) {
        const modalBody = document.getElementById(elementId).innerHTML;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
    <!DOCTYPE html>
	<html>
		<head>
		<title>Data Pesanan Dibatalkan</title>
		<style>
			/* Global styles */
			body {
				font-family: Arial, sans-serif;
				font-size: 14px;
			}
			
			/* Tambahkan style CSS sesuai kebutuhan */
			 img {
				max-width: 50px;
				max-height: 50px;
			}

			/* Container */
			.pdf-container {
				max-width: 100%;
				margin: 0 auto;
				padding: 10px;
			}

			/* Page title */
			.page-title {
				font-size: 24px;
				font-weight: bold;
				margin-bottom: 20px;
			}

			/* Breadcrumb */
			.breadcrumb {
				list-style: none;
				padding: 0;
				margin: 0;
			}

			.breadcrumb-item {
				display: inline;
				margin-right: 5px;
			}

			.breadcrumb-item a {
				color: #333;
				text-decoration: none;
			}

			/* Table */
			table {
				width: 100%;
				border-collapse: collapse;
			}

			th, td {
				border: 1px solid #ccc;
				padding: 8px;
			}

			th {
				background-color: #f2f2f2;
			}

			/* Card */
			.card {
				border: 1px solid #ccc;
				border-radius: 5px;
				margin-bottom: 20px;
				padding: 20px;
			}

			/* Buttons */
			.btn {
				display: inline-block;
				padding: 8px 12px;
				margin-right: 10px;
				text-decoration: none;
				border-radius: 4px;
				font-weight: bold;
				cursor: pointer;
				text-align: center;
				border: 1px solid #ccc;
				background-color: #f2f2f2;
			}

			.btn-primary {
				background-color: #007bff;
				color: #fff;
				border: none;
			}

			.btn-danger {
				background-color: #dc3545;
				color: #fff;
				border: none;
			}

			/* Add more styles as needed */

			/* Custom styles for printing */
			@media print {
				body {
					font-size: 12px;
				}
				.breadcrumb,
				.btn {
					display: none;
				}
				table {
					font-size: 12px;
					margin-top: 10px;
				}
				th, td {
					border: 1px solid #ccc;
					padding: 6px;
				}
				.btn-primary,
				.btn-danger {
					display: none;
				}
			}
		</style>
			</head>
				<body>
					<div class="pdf-container">
						<h1 class="page-title">Data Pesanan Dibatalkan</h1>
						<div class="card">
							<div class="card-body py-4">
									<table class="table align-middle table-row-dashed fs-6 gy-5">
									<thead>
										<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
											<th class="min-w-5px">No</th>
											<th class="min-w-200px">Pesanan</th>
											<th class="text-center min-w-70px">Total QTY</th>
											<th class="text-center min-w-70px">Total Harga</th>
											<th class="text-start min-w-150px">Detail Pesanan</th>
											<th class="text-center min-w-50px">Status</th>
											<th class="text-center min-w-150px">Tanggal Pesanan</th>
										</tr>
									</thead>
									<tbody class="text-gray-600 fw-semibold">
									
									<?php
										$no = 1;
										$totalHargaSemuaPesanan = 0; // Inisialisasi total harga semua pesanan
										$totalQtySemuaPesanan = 0; // Inisialisasi total jumlah semua pesanan
										$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, 'Pesanan Dibatalkan' AS status
																	   FROM t_pesanan t
																	   JOIN customer c ON t.kode_cus = c.kode_cus
																	   WHERE t.status = 'Pesanan Dibatalkan'
																	   ORDER BY t.kode_p DESC");

										while ($row = mysqli_fetch_assoc($result)) {
											// Ubah JSON menjadi bentuk array menggunakan json_decode
											$detailPesanan = json_decode($row['detail_pesanan'], true);
											
											// Hitung total harga pesanan saat ini dan tambahkan ke total keseluruhan
											$totalHargaSemuaPesanan += floatval($row['t_harga']);
																				
											// Hitung total jumlah pesanan saat ini dan tambahkan ke total keseluruhan
											$totalQtySemuaPesanan += intval($row['t_item']);
									?>
									
										<tr>
											<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
											<td class="text-gray-800 text-hover-primary">
												<!--begin::User details-->
												<div class="d-flex flex-column">
													<a href="#" class="text-gray-800 text-hover-primary mb-1 text-center"><h5><?= $row['nama'];  ?></h5></a>
													<br>
													<span class="text-center"><?= $row['kode_p'];  ?></span>
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
												<?php
												// Cek status untuk menentukan kelas CSS
												$status = $row['status'];
												$statusClass = '';

												if ($status == 'Pesanan Selesai') {
													$statusClass = 'badge-light-primary';
												} elseif ($status == 'Pesanan Sampai Tujuan') {
													$statusClass = 'badge-light-success';
												} elseif ($status == 'Pesanan Dalam Pengiriman') {
													$statusClass = 'badge-light-warning';
												} elseif ($status == 'Pesanan Diproses') {
													$statusClass = 'badge-light-warning';
												} elseif ($status == 'Pesanan Menunggu Diproses') {
													$statusClass = 'badge-light-warning';
												} elseif ($status == 'Pesanan Dibuat') {
													$statusClass = 'badge-light-secondary';
												} elseif ($status == 'Pesanan Dibatalkan') {
													$statusClass = 'badge-light-danger';
												}

												// Tampilkan status dengan kelas CSS yang sesuai
												echo '<span class="badge form-label fs-5 ' . $statusClass . '">' . $status . '</span>';
												?>
											</td>
											<td class="text-center"><?= formatTanggalIndonesia($row['tgl_pesan']); ?></td>
										</tr>
										<?php
										}
										?>
										
									</tbody>
								</table>
								<?php
								// Query untuk menghitung total pesanan dengan status "Pesanan Batal"
								$queryTotalBatal = "SELECT COUNT(*) AS total_batal FROM t_pesanan WHERE status = 'Pesanan Dibatalkan'";
								$resultTotalBatal = mysqli_query($conn, $queryTotalBatal);
								$rowTotalBatal = mysqli_fetch_assoc($resultTotalBatal);
								$totalPesananBatal = $rowTotalBatal['total_batal'];
								?>
								<div class="text-start">
									<div class="d-flex flex-column">
										<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Harga              : Rp. <?= number_format($totalHargaSemuaPesanan, 2); ?></h5></span>
										<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Pesanan Dibatalkan : <?= $totalPesananBatal; ?> Pesanan</h5></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</body>
			</html>
        `);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
	</script>
	<script>
    function cetakSemuaPesanan(elementId) {
        const modalBody = document.getElementById(elementId).innerHTML;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
    <!DOCTYPE html>
	<html>
		<head>
		<title>Data Semua Pesanan</title>
		<style>
			/* Global styles */
			body {
				font-family: Arial, sans-serif;
				font-size: 14px;
			}
			
			/* Tambahkan style CSS sesuai kebutuhan */
			 img {
				max-width: 50px;
				max-height: 50px;
			}

			/* Container */
			.pdf-container {
				max-width: 100%;
				margin: 0 auto;
				padding: 10px;
			}

			/* Page title */
			.page-title {
				font-size: 24px;
				font-weight: bold;
				margin-bottom: 20px;
			}

			/* Breadcrumb */
			.breadcrumb {
				list-style: none;
				padding: 0;
				margin: 0;
			}

			.breadcrumb-item {
				display: inline;
				margin-right: 5px;
			}

			.breadcrumb-item a {
				color: #333;
				text-decoration: none;
			}

			/* Table */
			table {
				width: 100%;
				border-collapse: collapse;
			}

			th, td {
				border: 1px solid #ccc;
				padding: 8px;
			}

			th {
				background-color: #f2f2f2;
			}

			/* Card */
			.card {
				border: 1px solid #ccc;
				border-radius: 5px;
				margin-bottom: 20px;
				padding: 20px;
			}

			/* Buttons */
			.btn {
				display: inline-block;
				padding: 8px 12px;
				margin-right: 10px;
				text-decoration: none;
				border-radius: 4px;
				font-weight: bold;
				cursor: pointer;
				text-align: center;
				border: 1px solid #ccc;
				background-color: #f2f2f2;
			}

			.btn-primary {
				background-color: #007bff;
				color: #fff;
				border: none;
			}

			.btn-danger {
				background-color: #dc3545;
				color: #fff;
				border: none;
			}

			/* Add more styles as needed */

			/* Custom styles for printing */
			@media print {
				body {
					font-size: 12px;
				}
				.breadcrumb,
				.btn {
					display: none;
				}
				table {
					font-size: 12px;
					margin-top: 10px;
				}
				th, td {
					border: 1px solid #ccc;
					padding: 6px;
				}
				.btn-primary,
				.btn-danger {
					display: none;
				}
			}
		</style>
			</head>
				<body>
					<div class="pdf-container">
						<h1 class="page-title">Data Semua Pesanan</h1>
						<div class="card">
							<div class="card-body py-4">
									<table class="table align-middle table-row-dashed fs-6 gy-5">
									<thead>
										<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
											<th class="min-w-5px">No</th>
											<th class="min-w-200px">Pesanan</th>
											<th class="text-center min-w-70px">Total QTY</th>
											<th class="text-center min-w-70px">Total Harga</th>
											<th class="text-start min-w-150px">Detail Pesanan</th>
											<th class="text-center min-w-50px">Status</th>
											<th class="text-center min-w-150px">Tanggal Pesanan</th>
										</tr>
									</thead>
									<tbody class="text-gray-600 fw-semibold">
									
									<?php
										$no = 1;
										$totalHargaSemuaPesanan = 0; // Inisialisasi total harga semua pesanan
										$totalQtySemuaPesanan = 0; // Inisialisasi total jumlah semua pesanan

										$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama
																	   FROM t_pesanan t
																	   JOIN customer c ON t.kode_cus = c.kode_cus
																	   ORDER BY t.kode_p DESC");

										while ($row = mysqli_fetch_assoc($result)) {
											// Ubah JSON menjadi bentuk array menggunakan json_decode
											$detailPesanan = json_decode($row['detail_pesanan'], true);
											
											// Hitung total harga pesanan saat ini dan tambahkan ke total keseluruhan
											$totalHargaSemuaPesanan += floatval($row['t_harga']);
											
											// Hitung total jumlah pesanan saat ini dan tambahkan ke total keseluruhan
											$totalQtySemuaPesanan += intval($row['t_item']);
										?>


										<tr>
											<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
											<td class="text-gray-800 text-hover-primary">
												<!--begin::User details-->
												<div class="d-flex flex-column">
													<a href="#" class="text-gray-800 text-hover-primary mb-1 text-center"><h5><?= $row['nama'];  ?></h5></a>
													<br>
													<span class="text-center"><?= $row['kode_p'];  ?></span>
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
												<?php
												// Cek status untuk menentukan kelas CSS
												$status = $row['status'];
												$statusClass = '';

												if ($status == 'Pesanan Selesai') {
													$statusClass = 'badge-light-primary';
												} elseif ($status == 'Pesanan Sampai Tujuan') {
													$statusClass = 'badge-light-success';
												} elseif ($status == 'Pesanan Dalam Pengiriman') {
													$statusClass = 'badge-light-warning';
												} elseif ($status == 'Pesanan Diproses') {
													$statusClass = 'badge-light-warning';
												} elseif ($status == 'Pesanan Menunggu Diproses') {
													$statusClass = 'badge-light-warning';
												} elseif ($status == 'Pesanan Dibuat') {
													$statusClass = 'badge-light-secondary';
												} elseif ($status == 'Pesanan Dibatalkan') {
													$statusClass = 'badge-light-danger';
												}

												// Tampilkan status dengan kelas CSS yang sesuai
												echo '<span class="badge form-label fs-5 ' . $statusClass . '">' . $status . '</span>';
												?>
											</td>
											<td class="text-center"><?= formatTanggalIndonesia($row['tgl_pesan']); ?></td>
										</tr>
										<?php
										}
										?>
									</tbody>
									<!-- Setelah iterasi selesai -->
								</table>
								<?php
								// Query untuk menghitung total pesanan dengan status "Pesanan Selesai"
								$queryTotalSelesai = "SELECT COUNT(*) AS total_selesai FROM t_pesanan WHERE status = 'Pesanan Selesai'";
								$resultTotalSelesai = mysqli_query($conn, $queryTotalSelesai);
								$rowTotalSelesai = mysqli_fetch_assoc($resultTotalSelesai);
								$totalPesananSelesai = $rowTotalSelesai['total_selesai'];
								
								// Query untuk menghitung total pesanan dengan status "Pesanan Batal"
								$queryTotalBatal = "SELECT COUNT(*) AS total_batal FROM t_pesanan WHERE status = 'Pesanan Dibatalkan'";
								$resultTotalBatal = mysqli_query($conn, $queryTotalBatal);
								$rowTotalBatal = mysqli_fetch_assoc($resultTotalBatal);
								$totalPesananBatal = $rowTotalBatal['total_batal'];
								?>
								<div class="text-start">
									<div class="d-flex flex-column">
										<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Semua Pesanan	: <?= $totalQtySemuaPesanan; ?> Pesanan</h5></span>
										<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Pesanan Selesai: <?= $totalPesananSelesai; ?> Pesanan</h5></span>
										<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Pesanan Batal: <?= $totalPesananBatal; ?> Pesanan</h5></span>
										<span class="text-gray-800 text-hover-primary mb-1"><h5>Total Harga	: Rp. <?= number_format($totalHargaSemuaPesanan, 2); ?></h5></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</body>
			</html>
        `);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
	</script>
	<script>
    function cetakRating(elementId) {
        const modalBody = document.getElementById(elementId).innerHTML;

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
    <!DOCTYPE html>
	<html>
		<head>
		<title>Data Rating Produk</title>
		<style>
			/* Global styles */
			body {
				font-family: Arial, sans-serif;
				font-size: 14px;
			}
			
			/* Tambahkan style CSS sesuai kebutuhan */
			 img {
				max-width: 50px;
				max-height: 50px;
			}

			/* Container */
			.pdf-container {
				max-width: 100%;
				margin: 0 auto;
				padding: 10px;
			}

			/* Page title */
			.page-title {
				font-size: 24px;
				font-weight: bold;
				margin-bottom: 20px;
			}

			/* Breadcrumb */
			.breadcrumb {
				list-style: none;
				padding: 0;
				margin: 0;
			}

			.breadcrumb-item {
				display: inline;
				margin-right: 5px;
			}

			.breadcrumb-item a {
				color: #333;
				text-decoration: none;
			}

			/* Table */
			table {
				width: 100%;
				border-collapse: collapse;
			}

			th, td {
				border: 1px solid #ccc;
				padding: 8px;
			}

			th {
				background-color: #f2f2f2;
			}

			/* Card */
			.card {
				border: 1px solid #ccc;
				border-radius: 5px;
				margin-bottom: 20px;
				padding: 20px;
			}

			/* Buttons */
			.btn {
				display: inline-block;
				padding: 8px 12px;
				margin-right: 10px;
				text-decoration: none;
				border-radius: 4px;
				font-weight: bold;
				cursor: pointer;
				text-align: center;
				border: 1px solid #ccc;
				background-color: #f2f2f2;
			}

			.btn-primary {
				background-color: #007bff;
				color: #fff;
				border: none;
			}

			.btn-danger {
				background-color: #dc3545;
				color: #fff;
				border: none;
			}

			/* Add more styles as needed */

			/* Custom styles for printing */
			@media print {
				body {
					font-size: 12px;
				}
				.breadcrumb,
				.btn {
					display: none;
				}
				table {
					font-size: 12px;
					margin-top: 10px;
				}
				th, td {
					border: 1px solid #ccc;
					padding: 6px;
				}
				.btn-primary,
				.btn-danger {
					display: none;
				}
			}
		</style>
			</head>
				<body>
					<div class="pdf-container">
						<h1 class="page-title">Data Rating Produk</h1>
						<div class="card">
							<div class="card-body py-4">
									<table class="table align-middle table-row-dashed fs-6 gy-5">
									<thead>
										<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
											<th class="min-w-5px">No</th>
											<th class="min-w-200px">Produk</th>
											<th class="text-center min-w-70px">Harga</th>
											<th class="text-center min-w-100px">Rating</th>
											<th class="text-center min-w-250px">Komentar</th>
											<th class="text-center min-w-150px">Tanggal</th>
										</tr>
									</thead>
									<tbody class="text-gray-600 fw-semibold">
									
									<?php
										$no = 1;
										$result = mysqli_query($conn, "SELECT r.*, p.*
																	   FROM rating r
																	   LEFT JOIN produk p ON r.kode_produk = p.kode_produk");

										while ($row = mysqli_fetch_assoc($result)) {
									?>
									
										<tr>
											<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
											<td class="d-flex align-items-center">
												<!--begin:: Avatar -->
												<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
													<a href="#">
														<div class="symbol-label">
															<img src="proses/<?= $row['foto_produk']; ?>" alt="Gambar Produk" class="w-100" />
														</div>
													</a>
												</div>
												<!--end::Avatar-->
												<!--begin::User details-->
												<div class="d-flex flex-column">
													<a href="#" class="text-gray-800 text-hover-primary mb-1"><?= $row['nama'];  ?></a>
													<br>
													<span><?= $row['kode_produk'];  ?></span>
												</div>
												<!--begin::User details-->
											</td>
											<td class="text-center"><?= $row['harga'];  ?></td>
											<td class="text-center">
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
												<br>
												<span><?= $ratingText ?></span>
											</td>
											<td class="text-center"><?= $row['komentar'];  ?></td>
											<td class="text-center"><?= formatTanggalIndonesia($row['tgl_input']); ?></td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</body>
			</html>
        `);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }
	</script>
	<script>
	   // Ambil referensi ke elemen input pencarian dan tabel
	   var input = document.getElementById("searchInput");
	   var table = document.getElementById("kt_table_users");
	   
	   // Event listener untuk input pencarian
	   input.addEventListener("input", function () {
		   var filter, tr, td, i, txtValue;
		   filter = input.value.toUpperCase();
		   tr = table.getElementsByTagName("tr");
		   
		   // Loop melalui semua baris tabel, sembunyikan yang tidak cocok
		   for (i = 0; i < tr.length; i++) {
			   td1 = tr[i].getElementsByTagName("td")[1]; // Kolom kedua
			   td2 = tr[i].getElementsByTagName("td")[2]; // Kolom ketiga
			   td3 = tr[i].getElementsByTagName("td")[3]; // Kolom ketiga
			   td4 = tr[i].getElementsByTagName("td")[4]; // Kolom ketiga
			   td5 = tr[i].getElementsByTagName("td")[5]; // Kolom ketiga
			   if (td1 && td2 && td3 && td4 && td5) {
				   txtValue = td1.textContent + td2.textContent + td3.textContent + td4.textContent + td5.textContent || td1.innerText + td2.innerText + td3.textContent + td4.textContent + td5.textContent;
				   if (txtValue.toUpperCase().indexOf(filter) > -1) {
					   tr[i].style.display = "";
				   } else {
					   tr[i].style.display = "none";
				   }
			   }
		   }
	   });
	</script>
	<!--Begin Pencarian-->
	<script>
	function filterTable(filterValue) {
	  var table, tr, td, i, txtValue;
	  table = document.getElementById("myTable");
	  tr = table.getElementsByTagName("tr");
	  for (i = 1; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[1];
		if (td) {
		  txtValue = td.textContent || td.innerText;
		  if (txtValue.toUpperCase() === filterValue.toUpperCase()) {
			tr[i].style.display = "";
		  } else {
			tr[i].style.display = "none";
		  }
		}       
	  }
	}
	</script>
	<script>
        // polling.js
		function checkForUpdatesUnproses() {
			// Kirim permintaan ke server untuk memeriksa pembaruan
			$.ajax({
				url: 'proses/check_updates_diproses.php', // Gantilah dengan URL yang sesuai
				method: 'GET',
				dataType: 'json',
				success: function(data) {
					// Callback ketika pembaruan ditemukan
					if (data && data.totalUnproses > 0) {
						$('#notificationDiproses').html(data.totalUnproses);
						// Anda bisa menambahkan logika lain di sini untuk menampilkan notifikasi
					}
				},
				error: function(error) {
					console.error('Terjadi kesalahan:', error);
				},
				complete: function() {
					// Set interval polling (misalnya setiap 5 detik)
					setTimeout(checkForUpdatesUnproses, 3000);
				}
			});
		}

		$(document).ready(function() {
			// Mulai polling saat halaman dimuat
			checkForUpdatesUnproses();
		});
    </script>
	<script>
		function checkForUpdates() {
		  $.ajax({
			url: 'proses/check_updates.php', // Gantilah dengan URL yang sesuai
			method: 'GET',
			dataType: 'json',
			success: function(data) {
			  if (data && data.totalUnproses > 0) {
				$('#notificationCount').html(data.totalUnproses + ' Pesanan Masuk');
				$('#notificationDiproses').addClass('new-order');
			  } else {
				$('#notificationCount').html('Pesanan Masuk');
				$('#notificationDiproses').removeClass('new-order');
			  }
			},
			error: function(error) {
			  console.error('Terjadi kesalahan:', error);
			},
			complete: function() {
			  setTimeout(checkForUpdates, 3000);
			}
		  });
		}

		$(document).ready(function() {
		  checkForUpdates();
		});
	</script>
	<script>
		// Buat koneksi awal ke server SSE
		let eventSource = new EventSource('proses/ssePesanan.php'); // Sesuaikan dengan URL server SSE yang sesuai.

		eventSource.onopen = function () {
		  console.log('Koneksi SSE berhasil.');
		};

		eventSource.onmessage = function (event) {
		  const data = JSON.parse(event.data);
		  // Update tabel dengan data yang diterima dari server
		  // Cari baris yang sesuai dengan kode pesanan
		  const existingRow = document.getElementById('row_' + data.kode_p);

		  // Jika baris sudah ada, perbarui data di dalamnya
		  if (existingRow) {
			existingRow.cells[1].textContent = data.customer;
			existingRow.cells[2].textContent = data.t_item;
			existingRow.cells[3].textContent = data.t_harga;

			// Menggabungkan detail pesanan menjadi satu teks
			var detailPesananText = '';
			data.detail_pesanan.forEach(function (item) {
			  detailPesananText += 'Nama Barang: ' + item.nama_produk + '<br>';
			  detailPesananText += 'Jumlah Item: ' + item.jumlah + '<br>';
			  detailPesananText += 'Harga Per Item: ' + item.harga_per_item + '<br><br>';
			});
			existingRow.cells[4].innerHTML = detailPesananText;
			// Hapus konten sel aksi sebelum menambahkan tombol
			existingRow.cells[5].innerHTML = '';

			// Tambahkan tombol "Proses" dan "Tolak" ke dalam sel aksi
			const actionsCell = document.createElement('td');
			actionsCell.className = 'text-center';

			// Tombol "Proses"
			const processButton = document.createElement('button');
			processButton.className = 'btn btn-warning mb-2';
			processButton.textContent = 'Proses';
			processButton.addEventListener('click', function () {
			  // Tangani logika ketika tombol "Proses" ditekan
			  // Anda bisa menggunakan data.kode_p untuk mengidentifikasi pesanan yang diproses
			  // Ambil kode pesanan dari data
			  const kodePesanan = data.kode_p;

			  // Kirim data atau lakukan tindakan lain sesuai kebutuhan
			  // Contoh: Kirim permintaan AJAX untuk memproses pesanan
			  // Gantilah URL dan payload sesuai kebutuhan
			  const url = 'proses/prosesPesanan.php';
			  const payload = { kode_p: kodePesanan };

			  // Kirim permintaan AJAX
			  fetch(url, {
				method: 'POST',
				headers: {
				  'Content-Type': 'application/json',
				},
				body: JSON.stringify(payload),
			  })
				.then((response) => response.json())
				.then((result) => {
				  // Tangani respons dari server jika diperlukan
				  console.log('Hasil dari pemrosesan pesanan:', result);

				  // Tambahkan logika lain jika diperlukan, seperti menampilkan notifikasi
				  showNotification('Pesanan berhasil diproses.');
				})
				.catch((error) => {
				  console.error('Terjadi kesalahan saat memproses pesanan:', error);
				});
			});

			// Tombol "Tolak"
			const rejectButton = document.createElement('button');
			rejectButton.className = 'btn btn-danger';
			rejectButton.textContent = 'Tolak';
			rejectButton.addEventListener('click', function () {
			  // Tangani logika ketika tombol "Tolak" ditekan
			  // Anda bisa menggunakan data.kode_p untuk mengidentifikasi pesanan yang ditolak
			  // Tampilkan modal atau lakukan tindakan lain sesuai kebutuhan
			});

			actionsCell.appendChild(processButton);
			actionsCell.appendChild(rejectButton);

			existingRow.cells[5].appendChild(actionsCell);
		  } else {
			// Jika baris belum ada, tambahkan baris baru ke tabel
			const table = document.getElementById('kt_ecommerce_products_table');
			const newRow = table.insertRow(1); // 1 karena baris pertama adalah header
			newRow.id = 'row_' + data.kode_p; // Atur id untuk baris baru
			// Kolom-kolom tabel
			const cellNoPesanan = newRow.insertCell(0);
			const cellCustomer = newRow.insertCell(1);
			const cellTotalQty = newRow.insertCell(2);
			const cellTotalHarga = newRow.insertCell(3);
			const cellDetailPesanan = newRow.insertCell(4);
			const cellAksi = newRow.insertCell(5);

			// Isi kolom-kolom tabel dengan data pesanan
			cellNoPesanan.textContent = data.kode_p;
			cellCustomer.textContent = data.customer;
			cellTotalQty.textContent = data.t_item;
			cellTotalHarga.textContent = data.t_harga;

			// Menggabungkan detail pesanan menjadi satu teks
			var detailPesananText = '';
			data.detail_pesanan.forEach(function (item) {
			  detailPesananText += 'Nama Barang: ' + item.nama_produk + '<br>';
			  detailPesananText += 'Jumlah Item: ' + item.jumlah + '<br>';
			  detailPesananText += 'Harga Per Item: ' + item.harga_per_item + '<br><br>';
			});
			cellDetailPesanan.innerHTML = detailPesananText;
			// Tambahkan tombol "Proses" dan "Tolak" ke dalam sel aksi
			const actionsCell = document.createElement('td');
			actionsCell.className = 'text-center';

			// Tombol "Proses"
			const processButton = document.createElement('button');
			processButton.className = 'btn btn-warning mb-2';
			processButton.textContent = 'Proses';
			processButton.addEventListener('click', function () {
			  // Tangani logika ketika tombol "Proses" ditekan
			  // Anda bisa menggunakan data.kode_p untuk mengidentifikasi pesanan yang diproses

			  // Ambil kode pesanan dari data
			  const kodePesanan = data.kode_p;

			  // Kirim data atau lakukan tindakan lain sesuai kebutuhan
			  // Contoh: Kirim permintaan AJAX untuk memproses pesanan
			  // Gantilah URL dan payload sesuai kebutuhan
			  const url = 'proses/prosesPesanan.php';
			  const payload = { kode_p: kodePesanan };

			  // Kirim permintaan AJAX
			  fetch(url, {
				method: 'POST',
				headers: {
				  'Content-Type': 'application/json',
				},
				body: JSON.stringify(payload),
			  })
				.then((response) => response.json())
				.then((result) => {
				  // Tangani respons dari server jika diperlukan
				  console.log('Hasil dari pemrosesan pesanan:', result);

				  // Tambahkan logika lain jika diperlukan, seperti menampilkan notifikasi
				  showNotification('Pesanan berhasil diproses.');
				})
				.catch((error) => {
				  console.error('Terjadi kesalahan saat memproses pesanan:', error);
				});
			});

			// Tombol "Tolak"
			const rejectButton = document.createElement('button');
			rejectButton.className = 'btn btn-danger';
			rejectButton.textContent = 'Tolak';
			rejectButton.addEventListener('click', function () {
			  // Tangani logika ketika tombol "Tolak" ditekan
			  // Anda bisa menggunakan data.kode_p untuk mengidentifikasi pesanan yang ditolak
			  // Tampilkan modal atau lakukan tindakan lain sesuai kebutuhan
			});

			actionsCell.appendChild(processButton);
			actionsCell.appendChild(rejectButton);

			cellAksi.appendChild(actionsCell);
		  }
		};

		eventSource.onerror = function (error) {
		  console.error('Terjadi kesalahan SSE:', error);

		  // Coba menyambung kembali jika terjadi kesalahan koneksi
		  setTimeout(function () {
			eventSource.close(); // Tutup koneksi yang terputus
			eventSource = new EventSource('proses/ssePesanan.php'); // Buat koneksi baru
			eventSource.onopen = function () {
			  console.log('Koneksi SSE berhasil disambungkan kembali.');
			};
		  }, 5000); // Coba menyambung kembali setelah 3 detik (sesuaikan dengan kebutuhan Anda)
		};

		// Anda dapat menambahkan event listeners di sini jika diperlukan
		eventSource.addEventListener('customEvent', function (event) {
		  // Tangani peristiwa khusus yang diberikan oleh server SSE
		  const eventData = JSON.parse(event.data);

		  // Contoh: Menampilkan pesan notifikasi kepada pengguna
		  const notificationMessage = `Pesanan ${eventData.kode_p} telah diperbarui menjadi ${eventData.status}`;
		  showNotification(notificationMessage);
		});

		// Fungsi untuk menampilkan pesan notifikasi (contoh)
		function showNotification(message) {
		  // Tambahkan logika untuk menampilkan pesan notifikasi kepada pengguna di sini
		  console.log('Notifikasi:', message);
		}
	</script>
	<script>
        function confirmLogout() {
            if (confirm("Apakah Anda yakin ingin logout?")) {
                window.location.href = "proses/logout.php?alert=logout";
            }
        }
    </script>
	<!--begin::Global Javascript Bundle(mandatory for all pages)-->
	<script src="assets/plugins/global/plugins.bundle.js"></script>
	<script src="assets/js/scripts.bundle.js"></script>
	<!--end::Global Javascript Bundle-->
	<!--begin::Vendors Javascript(used for this page only)-->
	<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
	<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<!--end::Vendors Javascript-->
	<!--begin::Custom Javascript(used for this page only)-->
	<script src="assets/js/custom/pages/user-profile/general.js"></script>
	<script src="assets/js/custom/account/settings/signin-methods.js"></script>
	<script src="assets/js/custom/account/settings/profile-details.js"></script>
	<script src="assets/js/custom/account/settings/deactivate-account.js"></script>
	<script src="assets/js/custom/apps/user-management/users/list/table.js"></script>
	<script src="assets/js/custom/apps/user-management/users/list/export-users.js"></script>
	<script src="assets/js/custom/apps/user-management/users/list/add.js"></script>
	<script src="assets/js/custom/apps/user-management/users/list/edit.js"></script>
	<script src="assets/js/custom/apps/ecommerce/catalog/laporan.js"></script>
	<script src="assets/js/widgets.bundle.js"></script>
	<script src="assets/js/custom/widgets.js"></script>
	<script src="assets/js/custom/apps/chat/chat.js"></script>
	<script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
	<script src="assets/js/custom/utilities/modals/create-account.js"></script>
	<script src="assets/js/custom/utilities/modals/create-app.js"></script>
	<script src="assets/js/custom/utilities/modals/users-search.js"></script>
	<script src="assets/js/custom/utilities/modals/offer-a-deal/type.js"></script>
	<script src="assets/js/custom/utilities/modals/offer-a-deal/details.js"></script>
	<script src="assets/js/custom/utilities/modals/offer-a-deal/finance.js"></script>
	<script src="assets/js/custom/utilities/modals/offer-a-deal/complete.js"></script>
	<script src="assets/js/custom/utilities/modals/offer-a-deal/main.js"></script>
	<script src="assets/js/custom/utilities/modals/two-factor-authentication.js"></script>
	<script src="assets/js/custom/authentication/sign-in/general.js"></script>
	<!--end::Custom Javascript-->
	<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>