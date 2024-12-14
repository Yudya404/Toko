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
                        <h2>Kontak Kami</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Beranda</a>
                            <span>Kontak Kami</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_phone"></span>
                        <h4>No Telp</h4>
                        <?php
							$nama = "No Telp & WA"; // Ganti dengan nama yang ingin dicari
							$result = mysqli_query($conn, "SELECT * FROM kontak");
							while ($row = mysqli_fetch_assoc($result)) {
							if ($row['nama'] == $nama) {
						?>
                        <p><?= $row['isi']; ?></p>
						<?php
							}
						}
						?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_pin_alt"></span>
                        <h4>Alamat</h4>
                        <?php
							$nama = "Alamat"; // Ganti dengan nama yang ingin dicari
							$result = mysqli_query($conn, "SELECT * FROM kontak");
							while ($row = mysqli_fetch_assoc($result)) {
							if ($row['nama'] == $nama) {
						?>
                        <p><?= $row['isi']; ?></p>
						<?php
							}
						}
						?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_clock_alt"></span>
                        <h4>Jam Buka - Tutup</h4>
                        <?php
							$nama = "Jam Operasional"; // Ganti dengan nama yang ingin dicari
							$result = mysqli_query($conn, "SELECT * FROM kontak");
							while ($row = mysqli_fetch_assoc($result)) {
							if ($row['nama'] == $nama) {
						?>
                        <p><?= $row['isi']; ?></p>
						<?php
							}
						}
						?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_mail_alt"></span>
                        <h4>Email</h4>
						<?php
							$nama = "Email"; // Ganti dengan nama yang ingin dicari
							$result = mysqli_query($conn, "SELECT * FROM kontak");
							while ($row = mysqli_fetch_assoc($result)) {
							if ($row['nama'] == $nama) {
						?>
                        <p><?= $row['isi']; ?></p>
						<?php
							}
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- Map Begin -->
    <div class="map">
		<?php
			$nama = "Maps"; // Ganti dengan nama yang ingin dicari
			$result = mysqli_query($conn, "SELECT * FROM kontak");
			while ($row = mysqli_fetch_assoc($result)) {
			if ($row['nama'] == $nama) {
		?>
        <iframe src="<?= $row['isi']; ?>" height="500" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
		<?php
			}
		}
		?>
    </div>
    <!-- Map End -->

    <!-- Contact Form Begin -->
    <div class="contact-form spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact__form__title">
                        <h2>Kritik & Saran</h2>
                    </div>
                </div>
            </div>
            <form action="proses/ulasan.php" method="POST">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <input type="text" placeholder="Nama" name="nama" required>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <input type="text" placeholder="Email" name="email" required>
                    </div>
					<div class="col-lg-6 col-md-6">
                        <input type="text" placeholder="No. Telp" name="no_telp" required>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <input type="text" placeholder="Alamat" name="alamat" required>
                    </div>
                    <div class="col-lg-12 text-center" required>
                        <textarea placeholder="Kritik & Saran Anda" name="isi_pesan"></textarea>
                        <button type="submit" class="site-btn">Kirim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Contact Form End -->

<?php include 'base/footer.php'; ?>