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
                        <h2>Register</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Beranda</a>
                            <span>Register</span>
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
										<h3 class="text-center">Registrasi Akun Baru</h3>
									</div>
									<div class="card-body col-md-12">
										<form action="proses/cus_add.php" method="POST" enctype="multipart/form-data">
											<div class="row g-5 mb-1">
												<div class="col-lg-6">
													<div class="form-group">
														<label for="nama">Nama:</label>
														<input type="text" class="form-control" id="cus_nama" name="cus_nama" placeholder="Nama Anda" required>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group">
														<label for="no_telp">Nomor Telepon:</label>
														<input type="tel" class="form-control" id="cus_telp" name="cus_telp" placeholder="No Telp Anda" required>
													</div>
												</div>
											</div>
											<div class="row g-5 mb-1">
												<div class="col-lg-6">
													<div class="form-group">
														<label for="email">Email:</label>
														<input type="email" class="form-control" id="cus_email" name="cus_email" placeholder="Email Anda" required>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label for="password">Sandi:</label>
														<input type="password" class="form-control" id="cus_pass" name="cus_pass" placeholder="Sandi Anda" required>
													</div>
													<!--begin::Hint-->
													<div class="form-text">Gunakan minimal 8 charakter campuran huruf , Angka , & Simbol.</div>
													<!--end::Hint-->
													<!--begin::Password Strength Indicator-->
													<div id="password-strength"></div>
													<!--end::Password Strength Indicator-->
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label for="password">Ulangi Sandi:</label>
														<input type="password" class="form-control" id="confirmPass" name="confirmPass" placeholder="Ulangi Sandi Anda" required>
													</div>
												</div>
											</div>
											<div class="row g-5 mb-1">
												<div class="col-lg-6">
													<div class="form-group">
														<label for="alamat">Alamat:</label>
														<textarea class="form-control" id="cus_alamat" name="cus_alamat" placeholder="Alamat Anda" required></textarea>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group">
														<label for="foto">Foto Profil:</label>
														<input type="file" class="form-control-file" id="avatar" name="avatar" accept=".png, .jpg, .jpeg" required>
														<!--begin::Hint-->
														<div class="form-text">File tipe yang dapat di unggah: png, jpg, jpeg. <br> Minimal 1 Mb Maksimal 10 Mb.</div>
														<!--end::Hint-->
													</div>
												</div>
											</div>
											<button type="submit" class="btn btn-lg btn-primary w-100 mb-3">Register</button>
										</form>
									</div>
								</div>
							</div>
						</div>
			<!-- Contact Form End -->
			<br>
			<br>

<?php include 'base/footer.php'; ?>