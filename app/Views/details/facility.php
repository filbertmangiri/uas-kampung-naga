<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<?php if (!$facility) : ?>
	<?php throw new \Exception("Fasilitas $name tidak ditemukan.", 404); ?>
<?php else : ?>
	<div class="col-12 col-sm-11 col-md-8 col-lg-6 mx-auto text-center">
		<h3><?= $facility['name']; ?></h3>
		<img src="<?= base_url('assets/img/facilities/' . $facility['image']); ?>" alt="Foto <?= $facility['image']; ?>" width="400px" id="facilityImage" class="img-thumbnail" role="button" title="Foto <?= $facility['image']; ?>">

		<div class="mt-3 mb-5">
			<?= $facility['description']; ?>
		</div>

		<?php if ($facility['customer_id'] == session('acc_id')) : ?>
			<button class="btn btn-primary" disabled>Disewa</button>
		<?php elseif (session('acc_management') != true && session('acc_admin') != true) : ?>
			<button class="btn btn-primary" id="requestButton">Sewa</button>
		<?php endif; ?>
		<a class="btn btn-secondary" role="button" href="<?= base_url('dashboard'); ?>">Listing</a>
	</div>
<?php endif; ?>

<?= $this->endSection(); ?>

<?= $this->section('modals'); ?>

<div class="modal fade" id="profilePictureModal" tabindex="-1" aria-labelledby="profilePictureModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<img id="profilePictureZoomedImage">
	</div>
</div>

<div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestRequestModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="requestRequestModalLabel">Sewa Fasilitas</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="requestRequestForm" action="<?= base_url('request/insert'); ?>" method="post">
				<div class="modal-body">
					<?php

					if (session('request_error_msg')) : ?>
						<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
							<symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
								<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
							</symbol>
						</svg>

						<div class="alert alert-danger alert-dismissible" role="alert">
							<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
								<use xlink:href="#exclamation-triangle-fill">
							</svg>

							<?= session('request_error_msg'); ?>

							<button type="button" class="btn-close" id="errorCloseButton" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php endif; ?>

					<?= csrf_field(); ?>

					<input type="hidden" name="customer_id" value="<?= session('acc_id'); ?>">

					<div class="form-floating mb-3">
						<input type="number" name="facility_id" class="form-control" placeholder=" " value="<?= $facility['id']; ?>" readonly>
						<label>ID</label>
					</div>

					<div class="form-floating mb-3">
						<input type="text" name="name" class="form-control" placeholder=" " value="<?= $facility['name']; ?>" readonly>
						<label>Nama Fasilitas</label>
					</div>

					<div class="form-floating mb-3">
						<input type="datetime-local" name="start_date" class="form-control <?= $validation->hasError('start_date') ? ' is-invalid' : ''; ?>" placeholder=" " value="<?= (string) (old('start_date') ?? ''); ?>" autofocus>
						<label>Tanggal & Waktu Mulai</label>

						<div class="invalid-feedback">
							<?= $validation->getError('start_date'); ?>
						</div>
					</div>

					<div class="form-floating mb-3">
						<input type="number" name="duration" class="form-control <?= $validation->hasError('duration') ? ' is-invalid' : ''; ?>" placeholder=" " value="<?= (string) (old('duration') ?? ''); ?>">
						<label>Durasi (jam)</label>

						<div class="invalid-feedback">
							<?= $validation->getError('duration'); ?>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
						<button type="submit" class="btn btn-primary">Konfirmasi</button>
					</div>
			</form>
		</div>
	</div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<script type="text/javascript">
	$(document).ready(function() {
		<?= session('show_request_modal'); ?>

		$('#profilePicture').click(function() {
			$('#profilePictureZoomedImage').prop('src', $(this).prop('src'));
			$('#profilePictureModal').modal('show');
		});

		$('#requestButton').click(function() {
			$('#requestModal').modal('show');
		});
	});
</script>

<?= $this->endSection(); ?>