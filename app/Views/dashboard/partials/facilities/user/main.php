<div class="container">
	<?php foreach ($facilities as $value) : ?>
		<div class="row" role="button" onclick="window.location.href = '<?= base_url('f/' . $value['name_slug']); ?>'">
			<h4><?= $value['name']; ?></h4>
			<div class="col-lg-6">
				<img src="<?= base_url('assets/img/facilities/' . $value['image']); ?>" alt="Foto <?= $value['name']; ?>" title="Foto <?= $value['name']; ?>" width="100%">
			</div>
			<div class="col-lg-6">
				<h4><?= $value['description']; ?></h4>
			</div>
		</div>
		<br><br>
	<?php endforeach; ?>
</div>