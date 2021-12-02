<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<?php if (!$account) : ?>
	<?php throw new \Exception("User $username tidak ditemukan.", 404); ?>
<?php else : ?>
	<div class="col-12 col-sm-11 col-md-8 col-lg-6 mx-auto text-center">
		<img src="<?= base_url('assets/img/profile-pictures/' . $account['profile_picture']); ?>" alt="Foto profil <?= $account['username']; ?>" width="150px" id="profilePicture" class="img-thumbnail" role="button" title="Foto profil <?= $account['username']; ?>" style="border-radius: 50%;">

		<div class="card">
			<ul class="list-group list-group-flush">
				<li class="list-group-item"><?= $account['email']; ?></li>
				<li class="list-group-item"><?= $account['username']; ?></li>
				<li class="list-group-item"><?= trim($account['first_name'] . ' ' . $account['last_name']); ?></li>
				<li class="list-group-item"><?= $account['birth_date']; ?></li>
				<li class="list-group-item"><?= !(bool) $account['gender'] ? 'Laki-laki' : 'Perempuan'; ?></li>
			</ul>
		</div>
	</div>
<?php endif; ?>

<?= $this->endSection(); ?>

<?= $this->section('modals'); ?>

<div class="modal fade" id="profilePictureModal" tabindex="-1" aria-labelledby="profilePictureModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<img id="profilePictureZoomedImage">
	</div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<script type="text/javascript">
	$(document).ready(function() {
		$('#profilePicture').click(function() {
			$('#profilePictureZoomedImage').prop('src', $(this).prop('src'));
			$('#profilePictureModal').modal('show');
		});
	});
</script>

<?= $this->endSection(); ?>