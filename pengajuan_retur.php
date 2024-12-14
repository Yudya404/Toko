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
                        <h2>Pengajuan Retur Produk</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Beranda</a>
                            <span>Form Pengajuan Retur</span>
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
								<div class="card">
									<div class="card-header">
										<h3 class="text-center">Form Pengajuan Retur</h3>
									</div>
									<div class="card-body col-md-12">
										<form action="proses/retur_add.php" method="POST" enctype="multipart/form-data">
											<div class="row g-5 mb-1">
												<div class="col-lg-6">
													<div class="form-group">
														<label for="nomor">Nomor Pesanan:</label>
														<input type="hidden" name="cus_id" class="form-control form-control-solid mb-3 mb-lg-0" id="user_id"  value="<?= $_SESSION['kode_cus']; ?>">
														<input type="text" class="form-control" id="kode_p" name="kode_p" placeholder="Nomor Pesanan EX: KPC-0001" required>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group">
														<label for="detail">Detail Retur:</label>
														<textarea class="form-control" id="detail_retur" name="detail_retur" placeholder="Detail Retur Ex: Kapal api jumlah 1, Good day Jumlah 3" required></textarea>
													</div>
												</div>
											</div>
											<div class="row g-5 mb-1">
												<div class="col-lg-6">
													<div class="form-group">
														<label for="alasan">Alasan Retur:</label>
														<textarea class="form-control" id="alasan_retur" name="alasan_retur" placeholder="Alasan Retur Ex Produk 1 : Exp, Kemasan Rusak , Produk 2 : Kemasan Rusak, Barang Tidak sesuai pesanan" required></textarea>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label for="foto_produk">Foto Produk :</label>
														<input type="file" class="form-control-file" id="foto_produk" name="foto_produk" accept=".png, .jpg, .jpeg" multiple required>
														<!--begin::Hint-->
														<div class="form-text">File tipe yang dapat di unggah: png, jpg, jpeg. <br> Minimal 1 Mb Maksimal 10 Mb.</div>
														<!--end::Hint-->
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label for="foto_produk">Foto Invoice :</label>
														<input type="file" class="form-control-file" id="foto_invoice" name="foto_invoice" accept=".png, .jpg, .jpeg" required>
														<!--begin::Hint-->
														<div class="form-text">File tipe yang dapat di unggah: png, jpg, jpeg. <br> Minimal 1 Mb Maksimal 10 Mb.</div>
														<!--end::Hint-->
													</div>
												</div>
											</div>
											<button type="submit" class="btn btn-lg btn-primary w-100 mb-3">Retur</button>
										</form>
									</div>
								</div>
							</div>
						</div>
			<!-- Contact Form End -->
			<br>
			<br>

<?php include 'base/footer.php'; ?>