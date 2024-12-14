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
                        <h2>Tentang Kami</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Beranda</a>
                            <span>Tentang Kami</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Form Begin -->
	<div class="contact-form spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<?php
						$nama = "Gambar Tentang Kami Halaman About"; // Ganti dengan nama yang ingin dicari
						$result = mysqli_query($conn, "SELECT * FROM about");
						while ($row = mysqli_fetch_assoc($result)) {
							if ($row['nama'] == $nama) {
					?>
					<center>
					<img src="back/dist/proses/<?= $row['gambar_a']; ?>" alt="Gambar" class="full-image">
					</center>
					<?php
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
	<!-- Contact Form End -->


<?php include 'base/footer.php'; ?>