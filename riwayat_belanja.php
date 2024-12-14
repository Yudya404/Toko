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
                        <h2>Riwayat Belanja</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Beranda</a>
                            <span>Riwayat Belanja</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Form Begin -->
			<!--begin::Content-->
			<div class="app-content flex-column-fluid">
				<!--begin::Content container-->
				<div class="app-container container-fluid">
					<!--begin::Navbar-->
					<div class="card mb-3 mb-xl-10">
						<div class="card-body pt-9 pb-0">
							<!--begin::Navs-->
							<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
								<!--begin::Nav item-->
								<li class="nav-item mt-2">
									<a class="nav-link text-active-primary ms-0 me-10 py-1" href="riwayat_belanja.php">Riwayat Belanja</a>
								</li>
								<!--end::Nav item-->
							</ul>
							<!--begin::Navs-->
						</div>
					</div>
					<!--end::Navbar-->
					<!--begin::details View-->
					<div class="card mb-5 mb-xl-10">
						<!--begin::Card header-->
						<div class="card-header cursor-pointer">
							<!--begin::Card title-->
							<div class="card-title m-0">
								<h3 class="fw-bold m-0">Riwayat Belanja</h3>
							</div>
							<!--end::Card title-->
						</div>
						<!--begin::Card header-->
						<!--begin::Card body-->
						<div class="card-body border-top p-9">
							<div class="table-responsive">
								<!--begin::Table-->
								<table class="table align-middle table-row-dashed">
									<thead>
										<tr class="text-center">
											<th class="min-w-5px">No</th>
											<th class="min-w-300px">Nama </th>
											<th class="min-w-300px">Status </th>
											<th class="min-w-300px">Detail</th>
										</tr>
									</thead>
									<tbody class="text-gray-600 fw-semibold">
										<?php
											if (isset($_SESSION['kode_cus'])) {
												$kode_cus = $_SESSION['kode_cus'];

												// Jumlah item per halaman
												$itemsPerPage = 5; // Ubah sesuai kebutuhan

												if (isset($_GET['page'])) {
													$currentPage = $_GET['page'];
												} else {
													$currentPage = 1;
												}

												// Hitung offset untuk query
												$offset = ($currentPage - 1) * $itemsPerPage;

												// Query untuk mendapatkan data pesanan dengan limit dan offset
												$query = "SELECT t.*, c.nama AS nama, c.foto_cus AS foto_cus FROM t_pesanan t
														  JOIN customer c ON t.kode_cus = c.kode_cus 
														  WHERE c.kode_cus = '$kode_cus'
														  ORDER BY t.kode_p DESC
														  LIMIT $offset, $itemsPerPage";
												$result = mysqli_query($conn, $query);
												
												// Hitung jumlah total data
												$result_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM t_pesanan t
																					  JOIN customer c ON t.kode_cus = c.kode_cus 
																					  WHERE c.kode_cus = '$kode_cus'");
												$row_total = mysqli_fetch_assoc($result_total);
												$totalData = $row_total['total'];
												
												// Hitung total halaman
												$totalPages = ceil($totalData / $itemsPerPage);

												$no = $offset + 1; // Nomor urut berdasarkan halaman

												while ($row = mysqli_fetch_assoc($result)) {
													// Tentukan apakah tombol "Batalkan" harus dinonaktifkan
													$isDisable = false;
													if ($row['status'] == 'Pesanan Dibatalkan') {
														$isDisable = true;
													}
													// Ubah JSON menjadi bentuk array menggunakan json_decode
													$detailPesanan = json_decode($row['detail_pesanan'], true);
										?>
											<tr>
												<td><div class="text-gray-800 text-hover-primary"><?php echo $no++; ?></div></td>
												<td class="min-w-300px">
													<!--begin::User details-->
													<div class="d-flex flex-column">
														<a href="profilku.php" class="text-gray-800 text-hover-primary mb-1"><?= $row['nama'];  ?></a>
														<span><h6>(<?= $row['kode_p'];  ?>)</h6></span>
													</div>
													<!--begin::User details-->
												</td>
												<td class="text-center">
													<?php
														$status = $row['status'];
														$statusClass = '';

														if ($status == 'Pesanan Selesai') {
															$statusClass = 'text-primary';
														} elseif ($status == 'Pesanan Sampai Tujuan') {
															$statusClass = 'text-success';
														} elseif ($status == 'Pesanan Dalam Pengiriman') {
															$statusClass = 'text-warning';
														} elseif ($status == 'Pesanan Diproses') {
															$statusClass = 'text-warning';
														} elseif ($status == 'Pesanan Menunggu Diproses') {
															$statusClass = 'text-warning';
														} elseif ($status == 'Pesanan Dibuat') {
															$statusClass = 'text-secondary';
														} elseif ($status == 'Pesanan Dibatalkan') {
															$statusClass = 'text-danger';
														}
														
														echo '<span class="badge form-label fs-5 ' . $statusClass . '">' . $status . '</span>';
													?>
												</td>
												<td class="text-center">
													<!--begin::Menu item-->
													<div class="menu-item px-2">
														<div class="btn-group" role="group">
															<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#statusModal_<?= $row['kode_p'];  ?>"><i class="fa fa-eye"></i></button>
															<button type="button" class="btn btn-success" data-toggle="modal" data-target="#invoiceModal_<?= $row['kode_p'];  ?> <?= $isDisable ? 'disabled' : ''; ?>"><i class="fa fa-print"></i></button>
														</div>
													</div>
													<!--end::Menu item-->
												</td>
											</tr>
										<!-- Notifikasi atau Peringatan -->
										<?php
											}
										} else {
											// Tampilkan pesan jika keranjang kosong
											?>
											<div class="row">
												<div class="col-lg-12">
													<table>
														<div class="col-lg-12">
															<div class="checkout__order">
																<p>Kamu belum memiliki riwayat belanja.</p>
															</div>
														</div>
													</table>
												</div>
											</div>
											<?php
												}
											?>
										<!-- Notifikasi atau Peringatan -->
									</tbody>
								</table>
								<!--end::Table-->
								<!--begin::Pagination-->
								<div class="d-flex justify-content-center mt-4">
									<nav aria-label="Page navigation">
										<ul class="pagination">
											<?php
												for ($page = 1; $page <= $totalPages; $page++) {
													$activeClass = ($page == $currentPage) ? 'active' : '';
													echo '<li class="page-item ' . $activeClass . '">';
													echo '<a class="page-link" href="?page=' . $page . '">' . $page . '</a>';
													echo '</li>';
												}
											?>
										</ul>
									</nav>
								</div>
								<!--end::Pagination-->
							</div>
						</div>
						<!--end::Card body-->
					</div>
					<!--end::details View-->
				</div>
				<!--end::Content container-->
			</div>
			<!--end::Content-->
	<!-- Contact Form End -->
<!-- Modal -->
<?php
$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, c.foto_cus AS foto_cus FROM t_pesanan t JOIN customer c ON t.kode_cus = c.kode_cus");
while ($row = mysqli_fetch_assoc($result)) {
	
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
<div class="modal fade" id="statusModal_<?= $row['kode_p'];  ?>" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pesanan Anda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
            </div>
            <div class="modal-body_<?= $row['kode_p'];  ?>">
				<div class="container">
					<div class="row">
						<div class="col-lg-6">
							<div class="card shadow-lg mb-1" style="max-height: 300px;">
								<!--begin::Card header-->
								<div class="card-header border-3 cursor-pointer">
									<!--begin::Card title-->
									<div class="card-title">
										<h5 class="fw-bold">Detail Pesanan</h5>
									</div>
									<!--end::Card title-->
								</div>
								<!--begin::Card header-->
								<div class="card-body overflow-auto">
									<!--begin::Input group-->
									<div class="fv-row mb-7">
										<div class="row g-5">
											<div class="col-lg-6">
												<div class="mb-1">
													<label class="form-label fs-5"><b>Detail Pesanan :</b></label>
												</div>
											</div>
											<div class="col-lg-6">
												<div>
													<?php foreach ($detailPesanan as $item) { ?>
														<ul>
															<li>Nama Barang :<?php echo $item['nama_produk']; ?>
																<ul>
																	<li class="list-unstyled">Jumlah Item : <?php echo $item['jumlah']; ?></li>
																	<li class="list-unstyled">Harga Per Item : Rp <?php echo number_format($item['harga_per_item'], 0, ',', '.'); ?></li>
																</ul>
															</li>
														</ul>
														<br>
													<?php } ?>
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
												<div class="mb-1">
													<label class="form-label fs-5"><b>Total Item :</b></label>
												</div>
											</div>
											<div class="col-lg-6">
												<label class="form-label fs-5"><?= $row['t_item'];  ?> <span>Item</span></label>
											</div>
										</div>
									</div>
									<!--end::Input group-->
									<!--begin::Input group-->
									<div class="fv-row mb-7">
										<!--begin::Label-->
										<div class="row g-5">
											<div class="col-lg-6">
												<div class="mb-1">
													<label class="form-label fs-5"><b>Total Bayar :</b></label>
												</div>
											</div>
											<div class="col-lg-6">
												<label class="form-label fs-5">Rp.<?= number_format($row['t_harga']); ?></label>
											</div>
										</div>
									</div>
									<!--end::Input group-->
									<!-- Continue adding rows for other form data -->
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="card shadow-lg mb-1" style="max-height: 300px;">
								<!--begin::Card header-->
								<div class="card-header border-3 cursor-pointer">
									<!--begin::Card title-->
									<div class="card-title">
										<h5 class="fw-bold">Track Record Pesanan</h5>
									</div>
									<!--end::Card title-->
								</div>
								<!--begin::Card header-->
								<div class="card-body overflow-auto">
									<div class="timeline-label ms-10" id="timeline-label">
										<?php if ($row['tgl_pesan'] != 0) { ?>
											<div class="timeline-item">
												<div class="timeline-badge">
													<i class="fa fa-genderless text-secondary fs-1"></i>
												</div>
												<div class="timeline-text">
													<div class="fw-bold text-gray-800"><span>Tanggal :</span> <?= formatTanggalIndonesia($row['tgl_pesan']); ?></div>
													<div class="fw-bold text-gray-800"><span>Status :</span> <span class="text-secondary">Pesanan Dibuat</span></div>
												</div>
											</div>
										<?php } ?>
										
										<?php if ($row['tgl_pesan'] != 0) { ?>
											<div class="timeline-item">
												<div class="timeline-badge">
													<i class="fa fa-genderless text-warning fs-1"></i>
												</div>
												<div class="timeline-text">
													<div class="fw-bold text-gray-800"><span>Tanggal :</span> <?= formatTanggalIndonesia($row['tgl_pesan']); ?></div>
													<div class="fw-bold text-gray-800"><span>Status :</span> <span class="text-warning">Pesanan menunggu Diproses</span></div>
												</div>
											</div>
										<?php } ?>

										<?php if ($row['tgl_proses'] != 0) { ?>
											<div class="timeline-item">
												<div class="timeline-badge">
													<i class="fa fa-genderless text-warning fs-1"></i>
												</div>
												<div class="timeline-text">
													<div class="fw-bold text-gray-800"><span>Tanggal :</span> <?= formatTanggalIndonesia($row['tgl_proses']); ?></div>
													<div class="fw-bold text-gray-800"><span>Status :</span> <span class="text-warning">Pesanan Diproses</span></div>
												</div>
											</div>
										<?php } ?>

										<?php if ($row['tgl_kirim'] != 0) { ?>
											<div class="timeline-item">
												<div class="timeline-badge">
													<i class="fa fa-genderless text-success fs-1"></i>
												</div>
												<div class="timeline-text">
													<div class="fw-bold text-gray-800"><span>Tanggal :</span> <?= formatTanggalIndonesia($row['tgl_kirim']); ?></div>
													<div class="fw-bold text-gray-800"><span>Status :</span> <span class="text-success">Pesanan Dalam Pengiriman</span></div>
												</div>
											</div>
										<?php } ?>

										<?php if ($row['tgl_selesai'] != 0) { ?>
											<div class="timeline-item">
												<div class="timeline-badge">
													<i class="fa fa-genderless text-primary fs-1"></i>
												</div>
												<div class="timeline-text">
													<div class="fw-bold text-gray-800"><span>Tanggal :</span> <?= formatTanggalIndonesia($row['tgl_selesai']); ?></div>
													<div class="fw-bold text-gray-800"><span>Status :</span> <span class="text-primary">Pesanan Selesai</span></div>
												</div>
											</div>
										<?php } ?>
										
										<?php if ($row['tgl_batal'] != 0) { ?>
											<div class="timeline-item">
												<div class="timeline-badge">
													<i class="fa fa-genderless text-danger fs-1"></i>
												</div>
												<div class="timeline-text">
													<div class="fw-bold text-gray-800"><span>Tanggal :</span> <?= formatTanggalIndonesia($row['tgl_batal']); ?></div>
													<div class="fw-bold text-gray-800"><span>Status :</span> <span class="text-danger">Pesanan Dibatalkan</span></div>
												</div>
											</div>
										<?php } ?>
										<!-- Add more items as needed -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
			<!--End Modal Body-->
			<div class="modal-footer">
				<div class="text-center">
					<button type="submit" name="submit" class="btn btn-danger" data-toggle="modal" data-target="#modalBatal_<?= $row['kode_p']; ?>"
                            <?= $isDisable ? 'disabled' : ''; ?>>
                        Batalkan
                    </button>
                    <button type="submit" name="submit" class="btn btn-primary" data-toggle="modal" data-target="#modalSelesai_<?= $row['kode_p']; ?>"
                            <?= $isSelesaiDisabled ? 'disabled' : ''; ?>>
                        Selesai
                    </button>
				</div>
			</div>
        </div>
    </div>
</div>
<?php
}
?>
<!--End Modal-->
<!-- Loop through pesanan data -->
<?php
$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, c.foto_cus AS foto_cus FROM t_pesanan t JOIN customer c ON t.kode_cus = c.kode_cus");
while ($row = mysqli_fetch_assoc($result)) {
	
    $detail_pesanan = json_decode($row['detail_pesanan'], true);

    $kode_produk_array = array();
    foreach ($detail_pesanan as $item) {
        $kode_produk_array[] = $item['kode_produk'];
    }
    $kode_produk_list = "'" . implode("','", $kode_produk_array) . "'";

    $query_produk = "SELECT p.*, r.rating, r.status_rating, r.komentar FROM produk p
                    LEFT JOIN rating r ON p.kode_produk = r.kode_produk AND r.kode_cus = '{$row['kode_cus']}'
                    WHERE p.kode_produk IN ($kode_produk_list)";
    $result_produk = mysqli_query($conn, $query_produk);

    ?>
    <div class="modal fade" id="modalSelesai_<?= $row['kode_p'];  ?>" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Beri Rating Pesanan Anda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
				<div class="modal-body_<?= $row['kode_p'];  ?>">
				<?php while ($produk_row = mysqli_fetch_assoc($result_produk)) { ?>
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="card shadow-lg mb-1" style="max-height: 500px;">
								<div class="card-body overflow-auto">
									<!--begin::Input group-->
									<div class="fv-row mb-7">
										<!--begin::Label-->
										<div class="row g-5">
											<div class="col-lg-6">
												<div class="mb-1">
													<label class="form-label fs-5"><b>Nama Produk :</b></label>
												</div>
											</div>
											<div class="col-lg-6">
												<label class="form-label fs-5"><?= $produk_row['nama'];  ?></label>
											</div>
										</div>
									</div>
									<!--end::Input group-->
									<!--begin::Input group-->
									<div class="fv-row mb-7">
										<!--begin::Label-->
										<div class="row g-5">
											<div class="col-lg-6">
												<div class="mb-1">
													<label class="form-label fs-5"><b>Total Item :</b></label>
												</div>
											</div>
											<div class="col-lg-6">
												<label class="form-label fs-5"><?= $row['t_item'];  ?> <span>Item</span></label>
											</div>
										</div>
									</div>
									<!--end::Input group-->
									<!--begin::Input group-->
									<div class="fv-row mb-7">
										<!--begin::Label-->
										<div class="row g-5">
											<div class="col-lg-6">
												<div class="mb-1">
													<label class="form-label fs-5"><b>Total Bayar :</b></label>
												</div>
											</div>
											<div class="col-lg-6">
												<label class="form-label fs-5">Rp.<?= number_format($row['t_harga']); ?></label>
											</div>
										</div>
									</div>
									<!--end::Input group-->
									<!--begin::Input group-->
									<!-- Tampilkan rating produk -->
									<div class="product__details__rating">
										<form action="proses/rating_add.php" method="post">
											<input type="hidden" name="kode_cus" value="<?= $row['kode_cus']; ?>">
											<input type="hidden" name="kode_produk" value="<?= $produk_row['kode_produk']; ?>">
											<input type="hidden" name="kode_p" value="<?= $row['kode_p']; ?>">
											<div class="rating-input">
												<div class="fv-row mb-7">
													<div class="row g-5">
														<div class="col-lg-6">
															<div class="mb-1">
																<span><b>Beri Rating:</b></span>
															</div>
														</div>
													</div>
												</div>
												<div class="fv-row mb-7">
													<div class="row g-5">
														<div class="col-lg-12">
															<div class="mb-2">
															<?php for ($i = 1; $i <= 5; $i++) { ?>
																<input type="radio" name="rating" value="<?= $i; ?>" <?= $i == $produk_row['rating'] ? 'checked' : ''; ?>>
																<?php
																$iconPath = ''; // Tentukan path menuju gambar ikon sesuai dengan nilai rating
																if ($i == 1) {
																	$iconPath = 'img/emoji/1.png';
																} elseif ($i == 2) {
																	$iconPath = 'img/emoji/2.png';
																} elseif ($i == 3) {
																	$iconPath = 'img/emoji/3.png';
																} elseif ($i == 4) {
																	$iconPath = 'img/emoji/4.png';
																} elseif ($i == 5) {
																	$iconPath = 'img/emoji/5.png';
																}
																?>
																<img src="<?= $iconPath ?>" alt="Rating <?= $i ?>" style="width: 50px; height: 35px;">
															<?php } ?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="fv-row mb-7">
											<div class="row g-5">
												<div class="col-lg-6">
													<div class="mb-1">
														<span><b>Beri Ulasan Produk:</b></span>
													</div>
												</div>
											</div>
										</div>
										<div class="fv-row mb-7">
											<div class="row g-5">
												<div class="col-lg-12">
													<textarea name="komentar" id="komentar" rows="3" class="form-control"><?= isset($produk_row['komentar']) ? $produk_row['komentar'] : ''; ?></textarea>
												</div>
											</div>
										</div>
										<br>
										<div class="text-right">
											<button type="submit" class="btn btn-danger">Simpan</button>
										</div>
									</form>	
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
            </div>
			<!--End Modal Body-->
            </div>
        </div>
    </div>
<?php
}
?>
<!--End Modal-->
<!-- Modal -->
<?php
	$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, c.foto_cus AS foto_cus FROM t_pesanan t
									JOIN customer c ON t.kode_cus = c.kode_cus");
	while ($row = mysqli_fetch_assoc($result)) {
?>
<div class="modal fade" id="modalBatal_<?= $row['kode_p'];  ?>" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Detail Pembatalan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
            </div>
            <div class="modal-body_<?= $row['kode_p'];  ?>">
				<form class="form" action="proses/pembatalan.php" method="POST">
					<input type="hidden" name="kode_cus" value="<?= $row['kode_cus']; ?>">
					<input type="hidden" name="nama_cus" value="<?= $row['nama']; ?>">
					<input type="hidden" name="kode_p" value="<?= $row['kode_p']; ?>">
					<textarea class="form-control" placeholder="Alasan Pembatalan" name="alasan_pembatalan" required></textarea>
            </div>
			<!--End Modal Body-->
			<div class="modal-footer">
				<div class="text-center">
					<button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
					<button type="submit" name="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin akan membatalkan pesanan? Lanjutkan')">Kirim</button>
				</div>
			</div>
			</form>
        </div>
    </div>
</div>
<?php
}
?>
<!--End Modal-->
<!-- Modal -->
<?php
    $result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, c.foto_cus AS foto_cus FROM t_pesanan t
                                    JOIN customer c ON t.kode_cus = c.kode_cus");
    while ($row = mysqli_fetch_assoc($result)) {
        $isDisable = false;
        if ($row['status'] == 'Pesanan Dibatalkan') {
            $isDisable = true;
        }
?>
<div class="modal fade" id="invoiceModal_<?= $row['kode_p'];  ?>" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Cetak Pesanan <?= $_SESSION['nama']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
            </div>
            <div class="modal-body_<?= $row['kode_p'];  ?>">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="card shadow-lg mb-1" style="max-height: 600px;">
								<div class="card-body overflow-auto">
									<!-- Isi konten invoice di sini -->
									<form action="#" method="post">
										<div class="row">
											<div class="col-lg-12">
												<div class="order-info">
													<h6>Tanggal Order : <?= formatTanggalIndonesia($row['tgl_pesan']); ?></h6>
													<h6>Kode Order : <?= $row['kode_p']; ?></h6>
												</div>
											</div>
											<?php foreach ($detailPesanan as $item) { ?>
												<div class="col-lg-12 col-md-6">
													<div class="checkout__order">
														<div class="checkout__order__products">Produk <span><?= $item['nama_produk']; ?></span></div>
														<div class="checkout__order__price">Harga per Item <span>Rp.<?= number_format($item['harga_per_item']); ?></span></div>
														<div class="checkout__order__quantity">Jumlah per Item <span><?= $item['jumlah']; ?> pcs</span></div>
														<div class="checkout__order__subtotal">Subtotal per Item <span>Rp.<?= number_format($item['subtotal']); ?></span></div>
													</div>
												</div>
											<?php
											}
											?>
												<div class="col-lg-12 col-md-6">
													<div class="checkout__order">
														<div class="checkout__order__products">Total Barang <span><?= $row['t_item']; ?> Item</span></div>
														<div class="checkout__order__total">Total Bayar <span>Rp.<?= number_format($row['t_harga']); ?></span></div>
													</div>
												</div>
												<?php
												// Cek status untuk menentukan kelas CSS
												$status = $row['status'];
												$statusClass = '';

												if ($status == 'Pesanan Selesai' || $status == 'Pesanan Dalam Pengiriman') {
													$statusClass = 'text-success';
												} elseif ($status == 'Pesanan Diproses' || $status == 'Pesanan Menunggu Diproses') {
													$statusClass = 'text-warning';
												} elseif ($status == 'Pesanan Dibuat') {
													$statusClass = 'text-secondary';
												} elseif ($status == 'Pesanan Dibatalkan') {
													$statusClass = 'text-danger';
												}
												?>
												<div class="col-lg-12 col-md-6">
													<div class="checkout__order">
														<div class="checkout__order__products">
															Status Order :
															<span class="badge form-label fs-5 <?= $statusClass; ?>">
																<?= $status; ?>
															</span>
														</div>
														<div class="checkout__order__products">Syarat&Ketentuan <span class="text-success"><?= $row['checkbox']; ?></span></div>
													</div>
												</div>
											</div>
										</form>
									<!-- End Isi konten invoice di sini -->
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
			<!--End Modal Body-->
			<div class="modal-footer">
				<div class="text-center">
					<button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
					<button type="button" class="btn btn-primary" onclick="printInvoice('<?= $row['kode_p']; ?>')" <?= $isDisable ? 'disabled' : ''; ?>>Cetak</button>
				</div>
			</div>
        </div>
    </div>
</div>
<?php
}
?>
<!--End Modal-->
			<br>
			<br>
<script>
    function printContent(content) {
        const printWindow = window.open('', '_blank');
        printWindow.document.write(content);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }

    function printInvoice(kode_p) {
    const modalBody = document.getElementById('invoiceModal_' + kode_p).innerHTML;
    const content = `
        <!DOCTYPE html>
		<html>
		<head>
			<title>Invoice Cetak</title>
			<link rel="stylesheet" href="css/style.css" type="text/css">
			<style>
				.order-info {
					display: flex;
					justify-content: space-between;
					align-items: center;
					margin-bottom: 20px;
				}
			</style>
		</head>
		<body>
			<div class="row">
				<!-- Isi konten invoice di sini -->
					<form action="#" method="post">
						<div class="row">
						<?php
							$kode_p = $_GET['kode_p'];
							$result = mysqli_query($conn, "SELECT t.*, c.nama AS nama, c.foto_cus AS foto_cus FROM t_pesanan t
															JOIN customer c ON t.kode_cus = c.kode_cus WHERE t.kode_p = '$kode_p'");
							while ($row = mysqli_fetch_assoc($result)) {
						?>
						<div class="col-lg-12">
							<div class="order-info">
								<h6>Nama Customer : <?= $row['nama']; ?></h6>
								<h6>Tanggal Order : <?= formatTanggalIndonesia($row['tgl_pesan']); ?></h6>
								<h6>Kode Order : <?= $row['kode_p']; ?></h6>
							</div>
						</div>
						<?php foreach ($detailPesanan as $item) { ?>
							<div class="col-lg-12 col-md-6">
								<div class="checkout__order">
									<div class="checkout__order__products">Produk <span><?= $item['nama_produk']; ?></span></div>
									<div class="checkout__order__price">Harga per Item <span>Rp.<?= number_format($item['harga_per_item']); ?></span></div>
									<div class="checkout__order__quantity">Jumlah per Item <span><?= $item['jumlah']; ?> pcs</span></div>
									<div class="checkout__order__subtotal">Subtotal per Item <span>Rp.<?= number_format($item['subtotal']); ?></span></div>
								</div>
							</div>
						<?php
						}
						?>
							<div class="col-lg-12 col-md-6">
								<div class="checkout__order">
									<div class="checkout__order__products">Total Barang <span><?= $row['t_item']; ?> Item</span></div>
									<div class="checkout__order__total">Total Bayar <span>Rp.<?= number_format($row['t_harga']); ?></span></div>
								</div>
							</div>
							<?php
							$status = $row['status'];
							$statusClass = '';

							if ($status == 'Pesanan Selesai' || $status == 'Pesanan Dalam Pengiriman') {
								$statusClass = 'text-success';
							} elseif ($status == 'Pesanan Diproses' || $status == 'Pesanan Menunggu Diproses') {
								$statusClass = 'text-warning';
							} elseif ($status == 'Pesanan Dibuat') {
								$statusClass = 'text-secondary';
							} elseif ($status == 'Pesanan Dibatalkan') {
								$statusClass = 'text-danger';
							}
							?>
							<div class="col-lg-12 col-md-6">
								<div class="checkout__order">
									<div class="checkout__order__products">
										Status Order :
										<span class="badge form-label fs-5 <?= $statusClass; ?>">
											<?= $status; ?>
										</span>
									</div>
									<div class="checkout__order__products">Syarat&Ketentuan <span class="text-success"><?= $row['checkbox']; ?></span></div>
								</div>
							</div>
						<?php
						}
						?>
						</div>
						<br>
						<div class="col-lg-12">
							<center><p>Terima Kasih telah melakukan pembelian. <br> Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan.</p></center>
						</div>
					</form>
				</div>
			</body>
			</html>
    `;
    printContent(content);
}
</script>

<?php include 'base/footer.php'; ?>