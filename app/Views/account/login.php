<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="col-12 col-sm-11 col-md-8 col-lg-6 mx-auto">
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
			<input type="text" name="email_username" class="form-control" placeholder=" " value="<?= (string) old('email_username'); ?>" autofocus>
			<label>Email atau username</label>
		</div>

		<div class="form-floating mb-3">
			<input type="password" name="password" class="form-control" placeholder=" ">
			<label>Password</label>
		</div>

		<button type="submit" class="btn btn-primary col-12 mb-5">Masuk</button>
	</form>
</div>

<?= $this->endSection(); ?>