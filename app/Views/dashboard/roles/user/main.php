<?= $this->extend('layouts/main'); ?>

<?= $this->section('styles'); ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/r-2.2.9/datatables.min.css">

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<div class="container">
	<h1>Dashboard</h1>

	<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
		<li class="nav-item" role="presentation">
			<button class="nav-link dashboard-accordion" id="facilitiesTab" data-bs-toggle="pill" data-bs-target="#facilities" type="button" role="tab" aria-controls="facilities" aria-selected="false">Facilities</button>
		</li>

		<li class="nav-item" role="presentation">
			<button class="nav-link dashboard-accordion" id="requestsTab" data-bs-toggle="pill" data-bs-target="#requests" type="button" role="tab" aria-controls="requests" aria-selected="false">Requests</button>
		</li>
	</ul>

	<div class="tab-content" id="pills-tabContent">
		<div class="tab-pane fade" id="facilities" role="tabpanel" aria-labelledby="facilitiesTab">
			<?= $this->include('dashboard/partials/facilities/user/main'); ?>
		</div>

		<div class="tab-pane fade" id="requests" role="tabpanel" aria-labelledby="requestsTab">
			<?= $this->include('dashboard/partials/requests/user/main'); ?>
		</div>
	</div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('modals'); ?>

<?= $this->include('dashboard/partials/facilities/user/modal'); ?>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/r-2.2.9/datatables.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		let dashboardAccordion = localStorage.getItem('dashboardAccordion');

		if (dashboardAccordion) {
			let targetFrom = $('.dashboard-accordion[aria-selected=true]').attr('data-bs-target');
			$('.dashboard-accordion[aria-selected=true]').removeClass('active').attr('aria-selected', 'false');
			let targetTo = $('#' + dashboardAccordion).attr('data-bs-target');
			$('#' + dashboardAccordion).addClass('active').attr('aria-selected', 'true');

			$(targetFrom).removeClass('active show');
			$(targetTo).addClass('active show');
		}

		$('.dashboard-accordion').click(function() {
			localStorage.setItem('dashboardAccordion', $(this).prop('id'));
		});
	});
</script>

<?= $this->include('dashboard/partials/facilities/user/script'); ?>
<?= $this->include('dashboard/partials/requests/user/script'); ?>

<?= $this->endSection(); ?>