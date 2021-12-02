<?= $this->extend('layouts/main'); ?>

<?= $this->section('styles'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" integrity="sha512-zxBiDORGDEAYDdKLuYU9X/JaJo/DPzE42UubfBw9yg8Qvb2YRRIQ8v4KsGHOx2H1/+sdSXyXxLXv5r7tHc9ygg==" crossorigin="anonymous" referrerpolicy="no-referrer">

<style type="text/css">
	#currentProfile {
		transition: 0.5s;
	}

	#currentProfile:hover {
		opacity: 0.8;
	}

	#croppie {
		width: 250px;
		height: 250px;
	}
</style>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<div class="col-12 col-sm-11 col-md-8 col-lg-6 mx-auto">
	<?php

	if (session('settings_error_msg')) : ?>
		<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
			<symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
				<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
			</symbol>
		</svg>

		<div class="alert alert-danger alert-dismissible" role="alert">
			<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
				<use xlink:href="#exclamation-triangle-fill">
			</svg>

			<?= session('settings_error_msg'); ?>

			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	<?php endif; ?>

	<form id="settingsForm" action="<?= base_url('u/settings'); ?>" method="post" enctype="multipart/form-data">
		<?= csrf_field(); ?>

		<div class="mb-4 text-center">
			<img src="<?= base_url('assets/img/profile-pictures/' . $account['profile_picture']); ?>" alt="Foto Profil" width="150px" id="currentProfile" class="img-thumbnail" role="button" title="Upload foto profil" style="border-radius: 50%;">
			<input type="hidden" name="old_profile_picture" value="<?= $account['profile_picture']; ?>">
			<input type="file" name="profile_picture" id="profilePicture" class="form-control <?= $validation->hasError('profile_picture') ? ' is-invalid' : ''; ?>" style="display: none;" accept="image/*">
			<input type="hidden" name="profile_picture_canvas">

			<div class="invalid-feedback">
				<?= $validation->getError('profile_picture'); ?>
			</div>
		</div>

		<div class="form-floating mb-3">
			<input type="email" name="email" class="form-control <?= $validation->hasError('email') ? ' is-invalid' : ''; ?>" placeholder=" " value="<?= (string) (old('email') ?? $account['email']); ?>" autofocus>
			<label>Email</label>

			<div class="invalid-feedback">
				<?= $validation->getError('email'); ?>
			</div>
		</div>

		<div class="form-floating mb-3">
			<input type="text" name="username" class="form-control <?= $validation->hasError('username') ? ' is-invalid' : ''; ?>" placeholder=" " value="<?= (string) (old('username') ?? $account['username']); ?>">
			<label>Username</label>

			<div class="invalid-feedback">
				<?= $validation->getError('username'); ?>
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-12 col-sm-6 mb-2">
				<div class="form-floating mb-3">
					<input type="password" name="password" class="form-control <?= $validation->hasError('password') ? ' is-invalid' : ''; ?>" placeholder=" ">
					<label>Password</label>

					<div class="invalid-feedback">
						<?= $validation->getError('password'); ?>
					</div>
				</div>
			</div>

			<div class="col-12 col-sm-6 mb-2">
				<div class="form-floating mb-3">
					<input type="password" name="password_confirm" class="form-control <?= $validation->hasError('password_confirm') ? ' is-invalid' : ''; ?>" placeholder=" ">
					<label>Konfirmasi Password</label>

					<div class="invalid-feedback">
						<?= $validation->getError('password_confirm'); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-12 col-sm-6 mb-2">
				<div class="form-floating mb-3">
					<input type="text" name="first_name" class="form-control <?= $validation->hasError('first_name') ? ' is-invalid' : ''; ?>" placeholder=" " value="<?= (string) (old('first_name') ?? $account['first_name']); ?>">
					<label>Nama Depan</label>

					<div class="invalid-feedback">
						<?= $validation->getError('first_name'); ?>
					</div>
				</div>
			</div>

			<div class="col-12 col-sm-6 mb-2">
				<div class="form-floating mb-3">
					<input type="text" name="last_name" class="form-control <?= $validation->hasError('last_name') ? ' is-invalid' : ''; ?>" placeholder=" " value="<?= (string) (old('last_name') ?? $account['last_name']); ?>">
					<label>Nama Belakang</label>

					<div class="invalid-feedback">
						<?= $validation->getError('last_name'); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="form-floating mb-3">
			<input type="date" name="birth_date" class="form-control <?= $validation->hasError('birth_date') ? ' is-invalid' : ''; ?>" placeholder=" " value="<?= (string) (old('birth_date') ?? $account['birth_date']); ?>">
			<label>Tanggal Lahir</label>

			<div class="invalid-feedback">
				<?= $validation->getError('birth_date'); ?>
			</div>
		</div>

		<div class="form-group mb-4">
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="gender" id="genderMale" value="0" <?= !(bool) (old('gender') ?? $account['gender']) ? 'checked' : '' ?>>
				<label class="form-check-label" for="genderMale">Laki-laki</label>
			</div>

			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="gender" id="genderFemale" value="1" <?= (bool) (old('gender') ?? $account['gender']) ? 'checked' : '' ?>>
				<label class="form-check-label" for="genderFemale">Perempuan</label>
			</div>
		</div>

		<div class="invalid-feedback">
			<?= $validation->getError('gender'); ?>
		</div>

		<button type="submit" class="btn btn-primary col-12 mb-5">Simpan</button>
	</form>
</div>

<?= $this->endSection(); ?>

<?= $this->section('modals'); ?>

<div class="modal fade" id="imageCropModal" tabindex="-1" aria-labelledby="imageCropModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="imageCropModalLabel">Image Crop</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="croppie"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="imageCropButton" data-bs-dismiss="modal">Simpan</button>
				<button type="button" class="btn btn-secondary" id="imageCropCancel" data-bs-dismiss="modal">Kembali</button>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<!-- Croppie -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js" integrity="sha256-TAzGN4WNZQPLqSYvi+dXQMKehTYFoVOnveRqbi42frA=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js" integrity="sha256-+NPi2ReKyI6yhNClJ78JSzbMmihq7Kjml84LwR631hM=" crossorigin="anonymous"></script>

<script type="text/javascript">
	let rawImg;

	function readFile(input) {
		if (input.files && input.files[0]) {
			let reader = new FileReader();
			reader.onload = function(e) {
				$('#imageCropModal #croppie').addClass('ready');
				$('#imageCropModal').modal('show');
				rawImg = e.target.result;
			}
			reader.readAsDataURL(input.files[0]);
		} else {
			alert('Mohon maaf, browser anda tidak mendukung API FileReader');
		}
	}

	let uploadCrop = $('#imageCropModal #croppie').croppie({
		viewport: {
			width: 150,
			height: 150,
			type: 'square'
		},
		enforceBoundary: false,
		enableExif: true
	});

	$('#imageCropModal').on('shown.bs.modal', function() {
		uploadCrop.croppie('bind', {
			url: rawImg
		});
	});

	$('#profilePicture').on('change', function() {
		let imageId = $(this).data('id');
		tempFilename = $(this).val();
		$('#imageCropCancel').data('id', imageId);
		readFile(this);
	});

	$('#imageCropButton').on('click', function(ev) {
		uploadCrop.croppie('result', {
			type: 'base64',
			format: 'jpeg',
			size: 'viewport'
		}).then(function(resp) {
			$('input[name=profile_picture_canvas]').val(resp);
			$('#currentProfile').attr('src', resp);
			$('#imageCropModal').modal('hide');
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#currentProfile').click(function() {
			$('#profilePicture').click();
		});

		// $('#profilePicture').on('change', function() {
		// 	const [file] = $(this).prop('files');
		// 	if (file) {
		// 		console.log(URL.createObjectURL(file));
		// 		$('#currentProfile').attr('src', URL.createObjectURL(file));
		// 	}
		// });

		/**
		 * @param {string} key Input name and database field key
		 * @param {string} error Error message
		 * @param {string} old Old value
		 */

		function validation(key, error, old) {
			let element = $('input[name=' + key + ']');

			if (element.val().toLocaleLowerCase() != old.toLocaleLowerCase()) {
				$.ajax({
					data: {
						key: key,
						value: element.val()
					},
					type: 'post',
					url: '<?= base_url('u/isexist') ?>',
					success: function(data) {
						if (data) {
							element.addClass('is-invalid');
							element.next().next('.invalid-feedback').html(error);
						}
					}
				});
			}
		}
		$('input[name=email]').blur(() => validation('email', 'The email field must contain a unique value.', '<?= $account['email']; ?>'));
		$('#settingsForm').submit(() => validation('email', 'The email field must contain a unique value.', '<?= $account['email']; ?>'));

		$('input[name=username]').blur(() => validation('username', 'The username field must contain a unique value.', '<?= $account['username']; ?>'));
		$('#settingsForm').submit(() => validation('username', 'The username field must contain a unique value.', '<?= $account['username']; ?>'));

		$.validator.addMethod('lettersOnly', function(value, element) {
			return this.optional(element) || /^[A-Za-z áãâäàéêëèíîïìóõôöòúûüùçñ]+$/i.test(value);
		});

		$.validator.addMethod('emailEx', function(value, element) {
			return /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
		});

		$.validator.addMethod('noSpaceSymbol', function(value, element) {
			return this.optional(element) || /^[a-zA-Z0-9_]+$/i.test(value);
		});

		$.validator.addMethod('lessThanToday', function(value, element) {
			return new Date(value) < new Date();
		});

		$.validator.addMethod('fileTypeImage', function(value, element) {
			return this.optional(element) || (element.files[0].size <= param * 1048576);
		});

		$('#settingsForm').validate({
			ignore: 'input[name=profile_picture]',

			rules: {
				first_name: {
					required: true,
					lettersOnly: true,
					minlength: 2
				},
				last_name: {
					lettersOnly: true,
				},
				email: {
					required: true,
					emailEx: true
				},
				username: {
					required: true,
					noSpaceSymbol: true,
					minlength: 5,
					maxlength: 50
				},
				password: {
					required: true,
					minlength: 6
				},
				password_confirm: {
					required: true,
					equalTo: 'input[name=password]'
				},
				birth_date: {
					required: true,
					dateISO: true,
					lessThanToday: true
				},
				profile_picture: {
					fileTypeImage: true,
					extension: 'jpg,jpeg,png,gif',
					accept: 'image/*'
				},
				gender: {
					required: true,
				}
			},

			errorPlacement: function(error, element) {
				element.next().next('.invalid-feedback').html(error.html());
			},

			highlight: function(element, errorClass, validClass) {
				if ($(element).prop('type') != 'radio') {
					$(element).addClass('is-invalid');
				}
			},

			unhighlight: function(element, errorClass, validClass) {
				$(element).removeClass('is-invalid');
			},

			submitHandler: function(form) {
				form.submit();
			}
		});
	});
</script>

<?= $this->endSection(); ?>