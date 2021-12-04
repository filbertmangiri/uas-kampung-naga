<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<h1>Dashboard | Management</h1>

<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
	<li class="nav-item" role="presentation">
		<button class="nav-link active" id="usersListingTab" data-bs-toggle="pill" data-bs-target="#usersListing" type="button" role="tab" aria-controls="usersListing" aria-selected="true">Users</button>
	</li>

	<li class="nav-item" role="presentation">
		<button class="nav-link" id="facilitiesListingTab" data-bs-toggle="pill" data-bs-target="#facilitiesListing" type="button" role="tab" aria-controls="facilitiesListing" aria-selected="false">Facilities</button>
	</li>

	<li class="nav-item" role="presentation">
		<button class="nav-link" id="requestsListingTab" data-bs-toggle="pill" data-bs-target="#requestsListing" type="button" role="tab" aria-controls="requestsListing" aria-selected="false">Requests</button>
	</li>
</ul>

<div class="tab-content" id="pills-tabContent">
	<div class="tab-pane fade show active" id="usersListing" role="tabpanel" aria-labelledby="usersListingTab">
		<h2>Users Listing</h2>
	</div>

	<div class="tab-pane fade" id="facilitiesListing" role="tabpanel" aria-labelledby="facilitiesListingTab">
		<h2>Facilities Listing</h2>
	</div>

	<div class="tab-pane fade" id="requestsListing" role="tabpanel" aria-labelledby="requestsListingTab">
		<h2>Requests Listing</h2>
	</div>
</div>

<?= $this->endSection(); ?>