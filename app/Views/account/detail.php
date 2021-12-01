<?= $this->extend('layouts/main'); ?>

<?= $this->section('styles'); ?>

<style type="text/css">
	#profilePicture {
		transition: 0.5s;
	}

	#profilePicture:hover {
		opacity: 0.8;
	}

	.modal {
		display: none;
		position: fixed;
		z-index: 1;
		padding-top: 100px;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: rgb(0, 0, 0);
		background-color: rgba(0, 0, 0, 0.9);
	}

	.modal-content {
		margin: auto;
		display: block;
		width: 80%;
		max-width: 700px;
	}

	#caption {
		margin: auto;
		display: block;
		width: 80%;
		max-width: 700px;
		text-align: center;
		color: #ccc;
		padding: 10px 0;
		height: 150px;
	}

	.modal-content,
	#caption {
		-webkit-animation-name: zoom;
		-webkit-animation-duration: 0.6s;
		animation-name: zoom;
		animation-duration: 0.6s;
	}

	@-webkit-keyframes zoom {
		from {
			-webkit-transform: scale(0)
		}

		to {
			-webkit-transform: scale(1)
		}
	}

	@keyframes zoom {
		from {
			transform: scale(0)
		}

		to {
			transform: scale(1)
		}
	}

	#closeBtn {
		position: absolute;
		top: 15px;
		right: 35px;
		color: #f1f1f1;
		font-size: 40px;
		font-weight: bold;
		transition: 0.3s;
	}

	#closeBtn:hover,
	#closeBtn:focus {
		color: #bbb;
		text-decoration: none;
		cursor: pointer;
	}

	@media only screen and (max-width: 700px) {
		.modal-content {
			width: 100%;
		}
	}
</style>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<?php if (!$account) : ?>
	<?php throw new \Exception("User $username tidak ditemukan.", 404); ?>
<?php else : ?>
	<div class="col-12 col-sm-11 col-md-8 col-lg-6 mx-auto text-center">
		<img src="<?= base_url('img/profile-pictures/' . $account['profile_picture']); ?>" alt="Foto profil <?= $account['username']; ?>" width="150px" id="profilePicture" class="img-thumbnail" role="button" title="Foto profil <?= $account['username']; ?>" style="border-radius: 50%;">

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

<div id="myModal" class="modal">
	<span id="closeBtn">&times;</span>
	<img class="modal-content" id="img01">
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<script type="text/javascript">
	$(document).ready(function() {
		let modal = $('#myModal');

		$('#profilePicture').click(function() {
			modal.css('display', 'block');
			$('#img01').prop('src', $(this).prop('src'));
		});

		$('#closeBtn').click(function() {
			modal.css('display', 'none');
		});
	});
</script>

<?= $this->endSection(); ?>