<div class="modal fade" id="accountEditModal" tabindex="-1" aria-labelledby="accountEditModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="accountEditModalLabel">Update User</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="accSettingsForm" action="" method="post">
				<div class="modal-body">
					<?php

					if (session('acc_settings_error_msg')) : ?>
						<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
							<symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
								<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
							</symbol>
						</svg>

						<div class="alert alert-danger alert-dismissible" role="alert">
							<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
								<use xlink:href="#exclamation-triangle-fill">
							</svg>

							<?= session('acc_settings_error_msg'); ?>

							<button type="button" class="btn-close" id="errorCloseButton" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php endif; ?>

					<?= csrf_field(); ?>

					<input type="hidden" name="old_profile_picture" value="<?= (string) (old('old_profile_picture') ?? ''); ?>">

					<div class="form-floating mb-3">
						<input type="email" name="email" class="form-control <?= $validation->hasError('email') ? ' is-invalid' : ''; ?>" placeholder=" " value="<?= (string) (old('email') ?? ''); ?>" autofocus>
						<label>Email</label>

						<div class="invalid-feedback">
							<?= $validation->getError('email'); ?>
						</div>
					</div>

					<div class="form-floating mb-3">
						<input type="text" name="username" class="form-control <?= $validation->hasError('username') ? ' is-invalid' : ''; ?>" placeholder=" " value="<?= (string) (old('username') ?? ''); ?>">
						<label>Username</label>

						<div class="invalid-feedback">
							<?= $validation->getError('username'); ?>
						</div>
					</div>

					<div class="row mb-3">
						<div class="col-12 col-sm-6 mb-2">
							<div class="form-floating mb-3">
								<input type="text" name="first_name" class="form-control <?= $validation->hasError('first_name') ? ' is-invalid' : ''; ?>" placeholder=" " value="<?= (string) (old('first_name') ?? ''); ?>">
								<label>Nama Depan</label>

								<div class="invalid-feedback">
									<?= $validation->getError('first_name'); ?>
								</div>
							</div>
						</div>

						<div class="col-12 col-sm-6 mb-2">
							<div class="form-floating mb-3">
								<input type="text" name="last_name" class="form-control <?= $validation->hasError('last_name') ? ' is-invalid' : ''; ?>" placeholder=" " value="<?= (string) (old('last_name') ?? ''); ?>">
								<label>Nama Belakang</label>

								<div class="invalid-feedback">
									<?= $validation->getError('last_name'); ?>
								</div>
							</div>
						</div>
					</div>

					<div class="form-floating mb-3">
						<input type="date" name="birth_date" class="form-control <?= $validation->hasError('birth_date') ? ' is-invalid' : ''; ?>" placeholder=" " value="<?= (string) (old('birth_date') ?? ''); ?>">
						<label>Tanggal Lahir</label>

						<div class="invalid-feedback">
							<?= $validation->getError('birth_date'); ?>
						</div>
					</div>

					<div class="form-group mb-4">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="gender" id="genderMale" value="0">
							<label class="form-check-label" for="genderMale">Laki-laki</label>
						</div>

						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="gender" id="genderFemale" value="1">
							<label class="form-check-label" for="genderFemale">Perempuan</label>
						</div>
					</div>

					<div class="invalid-feedback">
						<?= $validation->getError('gender'); ?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>