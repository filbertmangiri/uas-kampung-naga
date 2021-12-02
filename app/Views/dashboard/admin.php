<?= $this->extend('layouts/main'); ?>

<?= $this->section('styles'); ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/r-2.2.9/datatables.min.css">

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<h1>Dashboard | Admin</h1>

<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
	<li class="nav-item" role="presentation">
		<button class="nav-link dashboard-accordion active" id="usersTab" data-bs-toggle="pill" data-bs-target="#users" type="button" role="tab" aria-controls="users" aria-selected="true">Users</button>
	</li>

	<li class="nav-item" role="presentation">
		<button class="nav-link dashboard-accordion" id="facilitiesTab" data-bs-toggle="pill" data-bs-target="#facilities" type="button" role="tab" aria-controls="facilities" aria-selected="false">Facilities</button>
	</li>

	<li class="nav-item" role="presentation">
		<button class="nav-link dashboard-accordion" id="requestsTab" data-bs-toggle="pill" data-bs-target="#requests" type="button" role="tab" aria-controls="requests" aria-selected="false">Requests</button>
	</li>
</ul>

<div class="tab-content" id="pills-tabContent">
	<div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="usersTab">
		<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link users-accordion active" id="nonDeletedUsersTab" data-bs-toggle="pill" data-bs-target="#nonDeletedUsers" type="button" role="tab" aria-controls="nonDeletedUsers" aria-selected="true">Semua</button>
			</li>

			<li class="nav-item" role="presentation">
				<button class="nav-link users-accordion" id="deletedUsersTab" data-bs-toggle="pill" data-bs-target="#deletedUsers" type="button" role="tab" aria-controls="deletedUsers" aria-selected="false">Terhapus</button>
			</li>
		</ul>

		<div class="tab-content" id="pills-tabContent">
			<div class="tab-pane fade show active" id="nonDeletedUsers" role="tabpanel" aria-labelledby="nonDeletedUsersTab">
				<table id="nonDeletedTable" class="table table-striped" style="width:100%">
					<thead>
						<tr>
							<!-- <th></th> -->
							<th>ID</th>
							<th>Email</th>
							<th>Username</th>
							<th>Nama</th>
							<th>Tanggal Lahir</th>
							<th>Jenis Kelamin</th>
							<!-- <th>Foto Profil</th> -->
							<th>Management</th>
							<th>Terakhir Update</th>
							<!-- <th>Aksi</th> -->
						</tr>
					</thead>

					<tbody>
						<?php foreach ($accounts as $key) : ?>
							<tr>
								<!-- <td></td> -->
								<td><?= $key['id']; ?></td>
								<td><?= $key['email']; ?></td>
								<td><?= $key['username']; ?></td>
								<td><?= trim($key['first_name'] . ' ' . $key['last_name']); ?></td>
								<td><?= $key['birth_date']; ?></td>
								<td><?= $key['gender']; ?></td>
								<!-- <td><= $key['profile_picture']; ?></td> -->
								<td><?= $key['is_management']; ?></td>
								<td><?= $key['updated_at']; ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<div class="tab-pane fade" id="deletedUsers" role="tabpanel" aria-labelledby="deletedUsersTab">
				<h2>Deleted Users</h2>
			</div>
		</div>
	</div>

	<div class="tab-pane fade" id="facilities" role="tabpanel" aria-labelledby="facilitiesTab">
		<h2>Facilities</h2>
	</div>

	<div class="tab-pane fade" id="requests" role="tabpanel" aria-labelledby="requestsTab">
		<h2>Requests</h2>
	</div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('modals'); ?>

<div class="modal fade" id="profilePictureModal" tabindex="-1" aria-labelledby="profilePictureModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<img id="profilePictureZoomedImage">
	</div>
</div>

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

		let usersAccordion = localStorage.getItem('usersAccordion');

		if (usersAccordion) {
			let targetFrom = $('.users-accordion[aria-selected=true]').attr('data-bs-target');
			$('.users-accordion[aria-selected=true]').removeClass('active').attr('aria-selected', 'false');
			let targetTo = $('#' + usersAccordion).attr('data-bs-target');
			$('#' + usersAccordion).addClass('active').attr('aria-selected', 'true');

			$(targetFrom).removeClass('active show');
			$(targetTo).addClass('active show');
		}

		$('.users-accordion').click(function() {
			localStorage.setItem('usersAccordion', $(this).prop('id'));
		});

		// let table = $('#nonDeletedTable').DataTable({
		// 	ajax: '<= base_url('dashboard/getaccounts'); ?>',
		// 	columns: [{
		// 		className: 'dt-control',
		// 		orderable: false,
		// 		data: null,
		// 		defaultContent: ''
		// 	}, {
		// 		data: 'id'
		// 	}, {
		// 		data: 'email'
		// 	}, {
		// 		data: 'username'
		// 	}, {
		// 		data: 'first_name',
		// 		render: function(data, type, row, meta) {
		// 			return data + ' ' + row.last_name;
		// 		}
		// 	}, {
		// 		data: 'last_name',
		// 		visible: false
		// 	}],
		// 	order: [
		// 		[1, 'asc']
		// 	]
		// });

		// $('#nonDeletedTable tbody').on('click', 'td.dt-control', function() {
		// 	let tr = $(this).closest('tr');
		// 	let row = table.row(tr);

		// 	if (row.child.isShown()) {
		// 		row.child.hide();
		// 		tr.removeClass('shown');
		// 	} else {
		// 		let data = row.data();

		// 		row.child(() => {
		// 			let str = '';

		// 			str +=
		// 				'<img src="<= base_url('assets/img/profile-pictures'); ?>/' + data.profile_picture + '" alt="Foto profil ' + data.profile_picture + '" width="150px" id="profilePicture" class="img-thumbnail" role="button" title="Foto profil ' + data.profile_picture + '" style="border-radius: 50%;">' +
		// 				'<br><br>';

		// 			if (data.username == '<= getenv('ADMIN_USERNAME'); ?>')
		// 				str += '<span class="badge bg-danger">Admin</span>';
		// 			else if (data.is_management == 1)
		// 				str += '<span class="badge bg-success">Management</span>';
		// 			else
		// 				str += '<span class="badge bg-secondary">User</span>';

		// 			str +=
		// 				'<br><br>' +
		// 				'<span style="display: inline-block; width: 140px;">ID</span> = ' + data.id + '<br>' +
		// 				'<span style="display: inline-block; width: 140px;">Email</span> = ' + data.email + '<br>' +
		// 				'<span style="display: inline-block; width: 140px;">Username</span> = ' + data.username + '<br>' +
		// 				'<span style="display: inline-block; width: 140px;">Nama</span> = ' + data.first_name + ' ' + data.last_name + '<br>' +
		// 				'<span style="display: inline-block; width: 140px;">Tanggal Lahir</span> = ' + data.birth_date + '<br>' +
		// 				'<span style="display: inline-block; width: 140px;">Jenis Kelamin</span> = ' + (data.gender == 0 ? 'Laki-laki' : 'Perempuan') + '<br>' +
		// 				'<span style="display: inline-block; width: 140px;">Terakhir di update</span> = ' + data.updated_at + '<br>' +
		// 				'</div>';

		// 			return str;
		// 		}).show();

		// 		tr.addClass('shown');
		// 	}
		// });

		$('#nonDeletedTable').DataTable({
			responsive: {
				details: {
					// display: $.fn.dataTable.Responsive.display.modal({
					// 	header: function(row) {
					// 		let data = row.data();
					// 		return 'Detail';
					// 	}
					// }),
					// renderer: $.fn.dataTable.Responsive.renderer.tableAll({
					// 	tableClass: 'table'
					// })
					renderer: function(api, rowIdx, columns) {
						let data = $.map(columns, function(col, i) {
							return col.hidden ?
								'<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
								'<td width="125px">' + col.title + '</td> ' +
								'<td>:</td>' +
								'<td>' + col.data + '</td>' +
								'</tr>' :
								'';
						}).join('');

						return data ?
							$('<table/>').append(data) :
							false;
					}
				}
			}
		});

		$('#nonDeletedTable > tbody').on('click', '#profilePicture', function() {
			$('#profilePictureZoomedImage').prop('src', $(this).prop('src'));
			$('#profilePictureModal').modal('show');
		});
	});
</script>

<?= $this->endSection(); ?>