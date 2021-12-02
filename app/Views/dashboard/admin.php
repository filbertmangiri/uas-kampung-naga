<?= $this->extend('layouts/main'); ?>

<?= $this->section('styles'); ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/r-2.2.9/datatables.min.css">

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<h1>Dashboard | Admin</h1>

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
		<table id="nonDeletedTable" class="table table-striped" style="width:100%">
			<thead>
				<tr>
					<th></th>
					<th>ID</th>
					<th>Email</th>
					<th>Username</th>
					<th>Nama Depan</th>
					<th>Nama Belakang</th>
					<th>Tanggal Lahir</th>
					<th>Jenis Kelamin</th>
					<th>profile_picture</th>
					<th>Manager</th>
					<th>updated_at</th>
					<th>deleted_at</th>
				</tr>
			</thead>

			<tbody>
				<!-- SCRIPTS -->
			</tbody>
		</table>
	</div>

	<div class="tab-pane fade" id="facilitiesListing" role="tabpanel" aria-labelledby="facilitiesListingTab">
		<h2>Facilities Listing</h2>
	</div>

	<div class="tab-pane fade" id="requestsListing" role="tabpanel" aria-labelledby="requestsListingTab">
		<h2>Requests Listing</h2>
	</div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/r-2.2.9/datatables.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		var table = $('#nonDeletedTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: '<?= base_url('dashboard/getaccounts'); ?>',
				type: 'post'
			},
			columns: [{
					className: 'dt-control',
					orderable: false,
					data: null,
					defaultContent: ''
				},
				{
					data: 'id',
					render: function(data, type, row, meta) {
						return '<a href="' + data + '">Download</a>';
					}
				},
				{
					data: 'name'
				},
				{
					data: 'extension'
				}
			],
			order: [
				[1, 'asc']
			]
		});

		$('#nonDeletedTable tbody').on('click', 'td.dt-control', function() {
			let tr = $(this).closest('tr');
			let row = table.row(tr);

			if (row.child.isShown()) {
				row.child.hide();
				tr.removeClass('shown');
			} else {
				let data = row.data();
				row.child(() => '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
					'<tr>' +
					'<td>Full name:</td>' +
					'<td>' + 'blah' + '</td>' +
					'</tr>' +
					'<tr>' +
					'<td>Extension number:</td>' +
					'<td>' + 'blah' + '</td>' +
					'</tr>' +
					'<tr>' +
					'<td>Extra info:</td>' +
					'<td>And any further details here (images etc)...</td>' +
					'</tr>' +
					'</table>').show();
				tr.addClass('shown');
			}
		});
	});
</script>

<?= $this->endSection(); ?>