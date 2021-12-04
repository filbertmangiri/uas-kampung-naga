<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<!-- AOS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<section class="py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.6) ), url('https://images.unsplash.com/photo-1543781363-aa532fb5b77f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1228&q=80')">
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
							<label>Password</label>
						</div>

						<button type="submit" class="btn btn-dark text-white">Login</button>

						<p class="text-white" style="padding:10px 0 0 8px">Belum punya akun, <a href="#" class="link-light">Daftar</a> dulu yuk!</p>
					</form>
				</div>
			<?php endif; ?>
		</div>

		<div class="container text-white" style="padding-top: 100px">
			<div class="row justify-content-center">
				<div class="col-lg-6">
					<h2>Tentang Perpustakaan Kami</h2>
					<p class="lead">The background images used in this template are sourced from Unsplash and are
						open
						source and free to use.</p>
					<p class="mb-0">I can't tell you how many people say they were turned off from science because
						of a
						science teacher that completely sucked out all the inspiration and enthusiasm they had for
						the
						course.</p>
				</div>
			</div>
		</div>
</section>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		<?= session('show_success_modal'); ?>
	});
</script>

<?= $this->endSection(); ?>