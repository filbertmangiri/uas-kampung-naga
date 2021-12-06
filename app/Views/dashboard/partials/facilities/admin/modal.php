<div class="modal fade" id="facilityImageModal" tabindex="-1" aria-labelledby="facilityImageModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<img id="facilityImageZoomedImage">
	</div>
</div>

<div class="modal fade" id="facilityModal" tabindex="-1" aria-labelledby="facilityModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="facilityModalLabel"></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="facilityForm" action="" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<?php

					if (session('facility_error_msg')) : ?>
						<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
							<symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
								<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
							</symbol>
						</svg>

						<div class="alert alert-danger alert-dismissible" role="alert">
							<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
								<use xlink:href="#exclamation-triangle-fill">
							</svg>

							<?= session('facility_error_msg'); ?>

							<button type="button" class="btn-close" id="errorCloseButton" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php endif; ?>

					<?= csrf_field(); ?>

					<div class="form-floating mb-3">
						<input type="text" name="name" class="form-control <?= $validation->hasError('name') ? ' is-invalid' : ''; ?>" placeholder=" " value="<?= (string) (old('name') ?? ''); ?>" autofocus>
						<label>Nama Fasilitas</label>

						<div class="invalid-feedback">
							<?= $validation->getError('name'); ?>
						</div>
					</div>

					<div class="mb-3">
						<textarea name="description" cols="30" rows="10" placeholder="Deskripsi"></textarea>
					</div>

					<div class="mb-4 text-center">
						<img src="" alt="Foto Fasilitas" width="200px" id="previewImage" class="img-thumbnail" role="button" title="Upload Gambar Fasilitas">
						<input type="file" name="image" id="image" class="form-control <?= $validation->hasError('image') ? ' is-invalid' : ''; ?>" accept="image/*">
						<input type="hidden" name="old_image">

						<div class="invalid-feedback">
							<?= $validation->getError('image'); ?>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
						<button type="submit" class="btn btn-primary"></button>
					</div>
			</form>
		</div>
	</div>
</div>