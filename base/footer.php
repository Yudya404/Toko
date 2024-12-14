<!-- Footer Section Begin -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__about__logo">
							<?php
								$nama = "Gambar Logo Header"; // Ganti dengan nama yang ingin dicari
								$result = mysqli_query($conn, "SELECT * FROM about");
								while ($row = mysqli_fetch_assoc($result)) {
								if ($row['nama'] == $nama) {
							?>
                            <a href="./index.php"><img src="back/dist/proses/<?= $row['gambar_a']; ?>" alt=""></a>
							<?php
								}		
							}
							?>
                        </div>
                        <ul>
							<?php
								$nama = "Alamat"; // Ganti dengan nama yang ingin dicari
								$result = mysqli_query($conn, "SELECT * FROM kontak");
								while ($row = mysqli_fetch_assoc($result)) {
								if ($row['nama'] == $nama) {
							?>
                            <li><i class="fa fa-home" style="color:blue"></i>		: <?= $row['isi']; ?></li>
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
                            <li><i class="fa fa-whatsapp" style="color:green"></i>	: <?= $row['isi']; ?></li>
							<?php
								}
							}
							?>
							<?php
								$nama = "Email"; // Ganti dengan nama yang ingin dicari
								$result = mysqli_query($conn, "SELECT * FROM kontak");
								while ($row = mysqli_fetch_assoc($result)) {
								if ($row['nama'] == $nama) {
							?>
                            <li><i class="fa fa-envelope" style="color:red"></i>		: <?= $row['isi']; ?></li>
							<?php
								}
							}
							?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text"><p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
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
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p></div>
						<?php
							$nama = "Gambar Payment Footer"; // Ganti dengan nama yang ingin dicari
							$result = mysqli_query($conn, "SELECT * FROM about");
							while ($row = mysqli_fetch_assoc($result)) {
							if ($row['nama'] == $nama) {
						?>
                        <div class="footer__copyright__payment"><img src="back/dist/proses/<?= $row['gambar_a']; ?>" alt="Gambar Payment"></div>
						<?php
							}
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->
	
	<!-- Modal -->
	<div class="modal fade" id="bantuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content" style="background-image: url('img/blog/blog-2.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center;">
				<div class="modal-header">
					<h5 class="modal-title" style="color:green" id="exampleModalLabel">Customer Help Toko Bu Heru</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?php
						$nama = "Gambar Bantuan"; // Ganti dengan nama yang ingin dicari
						$result = mysqli_query($conn, "SELECT * FROM about");
						while ($row = mysqli_fetch_assoc($result)) {
						if ($row['nama'] == $nama) {
					?>
					<img src="back/dist/proses/<?= $row['gambar_a']; ?>" style="width:100%; height:80%; display:block; margin:auto;" alt="Helpdesk BHS" />
					<?php
						}
					}
					?>
				</div>
				<div class="modal-footer">
					<div class="text-center">
						<a href="https://www.whatsapp.com/"><i class="fa fa-whatsapp" style="color:green"></i> Whatsapp.com</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->

    <!-- Js Plugins -->
	<script>
        function confirmLogout() {
            if (confirm("Apakah Anda yakin ingin logout?")) {
                window.location.href = "proses/logout.php?alert=logout";
            }
        }
    </script>
	<script>
		// Fungsi untuk menghapus parameter "keyword" dari URL
		function removeKeywordParam() {
			var newUrl = window.location.href.replace(/[?&]keyword=[^&]+/, '');
			history.replaceState({}, document.title, newUrl);
		}

		// Panggil fungsi untuk menghapus parameter "keyword" saat halaman dimuat
		window.onload = function() {
			removeKeywordParam();
		};
	</script>
	<script>
		// Ambil semua elemen collapsible
		var collapsibles = document.querySelectorAll(".collapsible");
		var contents = document.querySelectorAll(".content");

		// Tambahkan event listener untuk setiap collapsible
		collapsibles.forEach(function(collapsible, index) {
			collapsible.addEventListener("click", function() {
				// Toggle class "active" untuk collapsible yang diklik
				this.classList.toggle("active");

				// Toggle tampilan content yang sesuai
				if (contents[index].style.display === "block") {
					contents[index].style.display = "none";
				} else {
					contents[index].style.display = "block";
				}
			});
		});
	</script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

</body>
</html>