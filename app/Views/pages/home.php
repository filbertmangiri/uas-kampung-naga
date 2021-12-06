<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<div style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1543781363-aa532fb5b77f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1228&q=80'); background-attachment: fixed;">
	<section class="py-5">
		<div class="container py-5">
			<div class="row">
				<div class="col-6 text-white">
					<h2>Sewa Fasilitas Kampung Naga</h2>
					<p class="lead  fw-bold">Facility Booking</p>
					<p class="mb-0 display-6">Menyediakan fasilitas yang bisa disewa dengan harga terjangkau dan
						pastinya lengkap.</p>
				</div>

				<?php if (session('acc_logged_in') !== true) : ?>
					<div class="col-6">
						<?php

						if (session('login_error_msg')) : ?>
							<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
								<symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
									<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
								</symbol>
							</svg>

							<div class="alert alert-danger alert-dismissible" role="alert">
								<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
									<use xlink:href="#exclamation-triangle-fill">
								</svg>

								<?= session('login_error_msg'); ?>

								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						<?php endif; ?>

						<form action="<?= base_url('login'); ?>" method="post">
							<?= csrf_field(); ?>

							<div class="form-floating mb-3">
								<input type="text" name="email_username" class="form-control" placeholder=" " value="<?= (string) old('email_username'); ?>">
								<label>Email atau username</label>
							</div>

							<div class="form-floating mb-3">
								<input type="password" name="password" class="form-control" placeholder=" ">
								<label>Password</label>s=""
							</div>

							<button type="submit" class="btn btn-dark text-white">Login</button>

							<p class="text-white" style="padding:10px 0 0 8px">Belum punya akun, <a href="#" class="link-light">Daftar</a> dulu yuk!</p>
						</form>
					</div>
				<?php endif; ?>
			</div>

			<?php

			date_default_timezone_set('Asia/Jakarta');

			$now = date('Y-m-d H:i:s');
			$i = 0;
			foreach ($facilities as $value) : ?>
				<?php if ($now < $value['start_date'] || $now > $value['end_date']) : ?>
					<div class="row" role="button" onclick="window.location.href = '<?= base_url('f/' . $value['name_slug']); ?>'">
						<h4 class="text-white"><?= $value['name']; ?></h4>
						<div class="col-md-4">
							<img src="<?= base_url('assets/img/facilities/' . $value['image']); ?>" alt="Foto <?= $value['name']; ?>" title="Foto <?= $value['name']; ?>" width="100%">
						</div>
						<div class="col-md-4">
							<h4 class="text-white"><?= $value['description']; ?></h4>
						</div>
					</div>
				<?php endif; ?>
			<?php $i++;
			endforeach; ?>
		</div>
	</section>



	<footer id="footer" class="footer" style="width: 100%; height: 50; background: none;">
		<div class="footer-top">
			<div class="container">
				<div class="row gy-5">
					<div class="col-lg-6 col-md-12 gx-5 footer-info text-white">
						<h4>Kampung Naga Facilities</h4>
						<p>
							Jl. Scientia Boulevard, Curug Sangerang, Kecamatan Kelapa Dua, <br>
							Kabupaten Tangerang, Banten 15810<br>
							Indonesia <br>
						</p>
					</div>

					<div class="col-lg-3 col-md-12 footer-contact text-center text-md-start text-white">
						<h4>Useful Links</h4>
						<ul>
							<li><i class="bi bi-chevron-right"></i> <a class="link-light" href="<?= base_url(); ?>">Home</a></li>
						</ul>
						<h4>Our Services</h4>
						<ul>
							<li><i class="bi bi-chevron-right"></i> <a class="link-light" href="<?= base_url('dashboard') ?>">Facility Request</a></li>
						</ul>
					</div>

					<div class="col-lg-3 col-md-12 footer-contact text-center text-md-start text-white">
						<h4>Hubungi Kami</h4>
						<p>
							<strong>Telepon:</strong> +62 21 5422 0808<br>
							<strong>Email:</strong> info@umn.ac.id<br>
						<div class="social-links mt-3 text-white">
							<a href="https://www.twitter.com/" class="twitter link-light"><i class="bi bi-twitter"></i></a>
							<a href="https://www.facebook.com/" class="facebook link-light"><i class="bi bi-facebook"></i></a>
							<a href="https://www.instagram.com/" class="instagram link-light"><i class="bi bi-instagram"></i></a>
							<a href="https://www.linkedin.com/" class="linkedin link-light"><i class="bi bi-linkedin"></i></a>
						</div>
						</p>
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<script type="text/javascript">
	$(document).ready(function() {
		<?= session('show_success_modal'); ?>
	});
</script>

<?= $this->endSection(); ?>