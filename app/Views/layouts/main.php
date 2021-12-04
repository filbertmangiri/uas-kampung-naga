<!DOCTYPE html>

<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?= $title ?? 'Kampung Naga'; ?></title>

	<!-- BOOTSTRAP 5.1.3 -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css" rel="stylesheet">

	<style type="text/css">
		html {
			scroll-behavior: smooth;
		}
	</style>

	<?= $this->renderSection('styles'); ?>
</head>

<body>
	<?= $this->include('partials/navbar/main'); ?>

	<div class="container mt-5">
		<?= $this->renderSection('content'); ?>
	</div>

	<?= $this->renderSection('modals'); ?>

	<!-- jQuery 3.6.0 -->
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

	<!-- BOOTSTRAP 5.1.3 -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

	<!-- BOOTBOX -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script> -->

	<!-- SweetAlert2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.2.1/dist/sweetalert2.all.min.js" integrity="sha256-0xzVI/HVXp5ozonHpkYE3CAY413dT/sCdB7MyiUNP2Q=" crossorigin="anonymous"></script>

	<?= $this->include('partials/navbar/script'); ?>

	<?= $this->renderSection('scripts'); ?>
</body>

</html>