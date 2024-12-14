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
								<li class="breadcrumb-item text-gray-700">Ulasan</li>
								<!--end::Item-->
							</ul>
							<!--end::Breadcrumb-->
							<!--begin::Title-->
							<h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0">Ulasan</h1>
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
									<button type="button" data-bs-toggle="modal" data-bs-target="#modalCetakUlasan" class="btn btn-light-primary me-3"><i class="fa fa-print"></i>Cetak</button>
									<!--end::Export-->
									<!--begin::Modal - Cetak-->
									<div class="modal fade" id="modalCetakUlasan" tabindex="-1" aria-hidden="true">
										<!--begin::Modal dialog-->
										<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
											<!--begin::Modal content-->
											<div class="modal-content">
												<!--begin::Modal header-->
												<div class="modal-header" id="kt_modal_add_user_header">
													<!--begin::Modal title-->
													<h2 class="fw-bold">Cetak Ulasan Pelanggan</h2>
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
																<th class="min-w-125px">Nama</th>
																<th class="min-w-70px">No. Telp</th>
																<th class="min-w-250px">Alamat</th>
																<th class="min-w-300px">Isi Kritik&Saran</th>
																<th class="text-center min-w-150px">Tanggal Ulasan</th>
															</tr>
														</thead>
														<tbody class="text-gray-600 fw-semibold" id="tableBody">
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
																			<span><?= $row['email'];  ?></span>
																		</div>
																		<!--begin::User details-->
																	</td>
																	<td><?= $row['no_telp'];  ?></td>
																	<td><?= $row['alamat'];  ?></td>																
																	<td><div class="text-gray-800 text-hover-primary"><?= $row['isi_pesan'];  ?></div></td>
																	<td class="text-center">
																		<?php
																		// Cek status jika sudah direspon
																		if ($row['status'] == 'Sudah Direspon') {
																			echo '<span class="badge badge-light-success form-label fs-5">' . $row['status'] . '</span>';
																		} else {
																			echo '<span class="badge badge-light-danger form-label fs-5">' . $row['status'] . '</span>';
																		}
																	?><br>
																	<span class="fw-bold text-primary ms-3"><?= formatTanggalIndonesia($row['tgl_ulasan']); ?></span>
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
													<button type="button" onclick="cetakUlasan('modalBody')" class="btn btn-primary"><i class="fa fa-print"></i> Cetak</button>
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
									<th class="min-w-125px">Nama</th>
									<th class="min-w-50px">ID</th>
									<th class="min-w-70px">No. Telp</th>
									<th class="min-w-200px">Alamat</th>
									<th class="text-center min-w-150px">Tanggal Ulasan</th>
									<th class="text-center min-w-100px">Aksi</th>
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
												<span><?= $row['email'];  ?></span>
											</div>
											<!--begin::User details-->
										</td>
										<td><?= $row['kode_ulasan'];  ?></td>
										<td><span>0</span><?= $row['no_telp'];  ?></td>
										<td><?= $row['alamat'];  ?></td>
										<td class="text-center">
											<?php
											// Cek status jika sudah direspon
												if ($row['status'] == 'Sudah Direspon') {
													echo '<span class="badge badge-light-success form-label fs-5">' . $row['status'] . '</span>';
												} else {
													echo '<span class="badge badge-light-danger form-label fs-5">' . $row['status'] . '</span>';
												}
											?><br>
											<span class="fw-bold text-primary ms-3"><?= formatTanggalIndonesia($row['tgl_ulasan']); ?></span>
										</td>
										<td class="text-center">
											<!--begin::Menu item-->
											<div class="menu-item px-2">
												<div class="btn-group" role="group">
													<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_user_<?= $row['kode_ulasan'];  ?>"><i class="fa fa-eye"></i></button>
													<?php
														if ($_SESSION['kategori_user'] == 'Admin') {
														// Tampilkan menu User hanya jika kategori_user adalah 'admin'
													?>
													<button type="button" class="btn btn-danger" data-tabel="ulasan" data-kode-ulasan="<?= $row['kode_ulasan']; ?>"><i class="fa fa-trash"></i></button>
													<?php
													}
													?>
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

<!--begin::Modals-->
<!--begin::Modal - View Ulasan-->
<?php 
$result = mysqli_query($conn, "SELECT * FROM ulasan");
while ($row = mysqli_fetch_assoc($result)) {
?>
<div class="modal fade" id="kt_modal_edit_user_<?= $row['kode_ulasan'];  ?>" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-dialog-centered mw-950px">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header" id="kt_modal_edit_user_header">
				<!--begin::Modal title-->
				<h2 class="fw-bold">View Ulasan</h2>
				<!--end::Modal title-->
				<!--begin::Close-->
				<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
					<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
				</div>
				<!--end::Close-->
			</div>
			<!--end::Modal header-->
			<!--begin::Modal body-->
			<div class="modal-body scroll-y mx-5 mx-xl-15 my-7_<?= $row['kode_ulasan'];  ?>">
				<!--begin::Form-->
				<form id="kt_modal_edit_user_form" class="form" action="#">
					<!--begin::Scroll-->
					<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_edit_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
						<!--begin::Input group-->
						<div class="fv-row mb-7">
							<!--begin::Label-->
							<div class="row g-5">
								<div class="col-lg-6">
									<div class="mb-5">
										<label for="exampleFormControlInput1" class="form-label fs-5">Kode Ulasan</label>
									</div>
								</div>
								<div class="col-lg-6">
									<div>:
										<label for="exampleFormControlInput1" class="form-label fs-5"><?= $row['kode_ulasan'];  ?></label>
									</div>
								</div>
							</div>
							<!--end::Input-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="fv-row mb-7">
							<!--begin::Label-->
							<div class="row g-5">
								<div class="col-lg-6">
									<div class="mb-5">
										<label for="exampleFormControlInput1" class="form-label fs-5">Nama</label>
									</div>
								</div>
								<div class="col-lg-6">
									<div>:
										<label for="exampleFormControlInput1" class="form-label fs-5"><?= $row['nama'];  ?></label>
									</div>
								</div>
							</div>
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="fv-row mb-7">
							<!--begin::Label-->
							<div class="row g-5">
								<div class="col-lg-6">
									<div class="mb-5">
										<label for="exampleFormControlInput1" class="form-label fs-5">No, Telp</label>
									</div>
								</div>
								<div class="col-lg-6">
									<div>:
										<label for="exampleFormControlInput1" class="form-label fs-5"><?= $row['no_telp'];  ?></label>
									</div>
								</div>
							</div>
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="fv-row mb-7">
							<!--begin::Label-->
							<div class="row g-5">
								<div class="col-lg-6">
									<div class="mb-5">
										<label for="exampleFormControlInput1" class="form-label fs-5">Email</label>
									</div>
								</div>
								<div class="col-lg-6">
									<div>:
										<label for="exampleFormControlInput1" class="form-label fs-5"><?= $row['email'];  ?></label>
									</div>
								</div>
							</div>
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="fv-row mb-7">
							<!--begin::Label-->
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
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="fv-row mb-7">
							<!--begin::Label-->
							<div class="row g-5">
								<div class="col-lg-6">
									<div class="mb-5">
										<label for="exampleFormControlInput1" class="form-label fs-5">Pesan</label>
									</div>
								</div>
								<div class="col-lg-6">
									<div>:
										<label for="exampleFormControlInput1" class="form-label fs-5"><?= $row['isi_pesan'];  ?></label>
									</div>
								</div>
							</div>
							<!--end::Input-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="fv-row mb-7">
							<!--begin::Label-->
							<div class="row g-5">
								<div class="col-lg-6">
									<div class="mb-5">
										<label for="exampleFormControlInput1" class="form-label fs-5">Status</label>
									</div>
								</div>
								<div class="col-lg-6">
									<div>:
										<?php
											// Cek status jika sudah direspon
										if ($row['status'] == 'Sudah Direspon') {
											echo '<span class="badge badge-light-success form-label fs-5">' . $row['status'] . '</span>';
										} else {
											echo '<span class="badge badge-light-danger form-label fs-5">' . $row['status'] . '</span>';
										}
										?>
									</div>
								</div>
							</div>
							<!--end::Input-->
						</div>
						<!--end::Input group-->

					</div>
					<!--end::Scroll-->
					<!--begin::Actions-->
					<div class="text-end">
						<button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
						<button type="button" data-toggle="modal" data-bs-stacked-modal="#modalRespon_<?= $row['kode_ulasan'];  ?>" class="btn btn-primary">Respon</button>
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
<!--end::Modal - View Ulasan->
	<!--Begin::Modal -Respon-->
	<?php
// Tentukan zona waktu Anda
date_default_timezone_set("Asia/Jakarta"); // Ganti "Asia/Jakarta" sesuai dengan zona waktu Anda

// Ambil tanggal sekarang dengan format yang diinginkan (misalnya, Y-m-d H:i:s)
$tgl_input = date("Y-m-d H:i:s");

// Kode PHP untuk menyimpan respon dan mengubah status ulasan
if (isset($_POST['submit'])) {
	// Ambil data dari form respon
	$kode_ulasan = $_POST['kode_ulasan'];
	$isi_respon = $_POST['isi_respon'];

	// Query untuk mendapatkan kode_respon terakhir dari tabel respons
	$kode_respon_query = mysqli_query($conn, "SELECT kode_respon FROM respon ORDER BY kode_respon DESC LIMIT 1");
	$data_respon = mysqli_fetch_assoc($kode_respon_query);

	// Mendapatkan kode_respon berikutnya berdasarkan data terakhir atau membuat "KS001" jika belum ada data
	if ($data_respon) {
		$num_respon = substr($data_respon['kode_respon'], 2);
		$add_respon = (int) $num_respon + 1;
	} else {
		$add_respon = 1;
	}

	// Format kode_respon dengan kombinasi "KS" dan angka urutan
	$kode_respon = "R" . str_pad($add_respon, 3, '0', STR_PAD_LEFT);

	// Simpan data respon ke tabel respons
	$query_respon = mysqli_query($conn, "INSERT INTO respon (kode_respon, kode_ulasan, isi_respon, status, tgl_input)
		VALUES ('$kode_respon', '$kode_ulasan', '$isi_respon', 'Sudah Direspon', '$tgl_input')");

	// Ubah status ulasan dari "belum" menjadi "sudah" di tabel ulasan
	$query_ubah_status = mysqli_query($conn, "UPDATE ulasan SET status = 'Sudah Direspon' WHERE kode_ulasan = '$kode_ulasan'");
}
?>

<!--Begin::Modal -Respon-->
<?php 
$result = mysqli_query($conn, "SELECT * FROM ulasan");
while ($row = mysqli_fetch_assoc($result)) {
	// Query untuk mendapatkan kode_respon terakhir dari tabel respons
	$kode_respon_query = mysqli_query($conn, "SELECT kode_respon FROM respon ORDER BY kode_respon DESC LIMIT 1");
	$data_respon = mysqli_fetch_assoc($kode_respon_query);

	// Mendapatkan kode_respon berikutnya berdasarkan data terakhir atau membuat "KS001" jika belum ada data
	if ($data_respon) {
		$num_respon = substr($data_respon['kode_respon'], 2);
		$add_respon = (int) $num_respon + 1;
	} else {
		$add_respon = 1;
	}

	// Format kode_respon dengan kombinasi "KS" dan angka urutan
	$kode_respon = "R" . str_pad($add_respon, 3, '0', STR_PAD_LEFT);
	?>
	<div class="modal fade" tabindex="-1" id="modalRespon_<?= $row['kode_ulasan']; ?>">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Respon Kritik & Saran</h3>
					<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
						<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
					</div>
				</div>
				<form id="formRespon_<?= $row['kode_ulasan']; ?>" class="form" action="" method="POST">
					<div class="modal-body">
						<input type="hidden" name="kode_ulasan" value="<?= $row['kode_ulasan']; ?>">
						<input type="hidden" name="kode_respon" value="<?= $kode_respon; ?>">
						<textarea class="form-control" placeholder="Isi Respon Anda" name="isi_respon" required></textarea>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
						<button type="button" class="btn btn-primary" name="submit" id="modalKirim_<?= $row['kode_ulasan']; ?>">Kirim</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
}
?>
<!--end::Modal -Respon-->
<!--end::Modals-->

<?php include 'footer.php'; ?>