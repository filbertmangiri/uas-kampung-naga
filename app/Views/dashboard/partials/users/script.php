<script type="text/javascript">
	$(document).ready(function() {
		<?= session('show_editing_modal'); ?>

		// Non Deleted Users Table
		let nonDeletedTable = $('#nonDeletedTable').DataTable({
			ajax: '<?= base_url('account/account/getallaccounts'); ?>',
			deferRender: true,
			responsive: {
				details: false
			},
			columns: [{
				className: 'dt-control',
				orderable: false,
				searchable: false,
				data: null,
				defaultContent: ''
			}, {
				autowidth: true,
				data: 'id'
			}, {
				autowidth: true,
				data: 'email'
			}, {
				autowidth: true,
				data: 'username'
			}, {
				autowidth: true,
				data: 'first_name',
				render: function(data, type, row, meta) {
					return (data + ' ' + row.last_name).trim();
				}
			}, {
				orderable: false,
				searchable: false,
				data: null,
				render: function(data, type, row, meta) {
					if (row.id == <?= session('acc_id'); ?>) {
						return '';
					}

					if (row.username.toLocaleLowerCase() == '<?= getenv('ADMIN_USERNAME'); ?>'.toLocaleLowerCase()) {
						return '';
					}

					if (row.is_management == 1 &&
						'<?= session('acc_username'); ?>'.toLocaleLowerCase() != '<?= getenv('ADMIN_USERNAME'); ?>'.toLocaleLowerCase()) {
						return '';
					}

					return '<button type="button" class="btn btn-warning btn-sm" id="editButton" data-acc-id="' + row.id + '">Edit</button> ' +
						'<button type="button" class="btn btn-danger btn-sm" id="deleteButton" data-acc-id="' + row.id + '">Hapus</button>';
				}
			}],
			order: [
				[1, 'asc']
			]
		});

		$('#nonDeletedTable tbody').on('click', 'td.dt-control', function() {
			let tr = $(this).closest('tr');
			let row = nonDeletedTable.row(tr);

			if (row.child.isShown()) {
				row.child.hide();
				tr.removeClass('shown');
			} else {
				let data = row.data();

				row.child(() => {
					let str = '';

					str +=
						'<img src="<?= base_url('assets/img/profile-pictures'); ?>/' + data.profile_picture + '" alt="Foto profil ' + data.profile_picture + '" width="150px" id="profilePicture" class="img-thumbnail" role="button" title="Foto profil ' + data.profile_picture + '" style="border-radius: 50%;">' +
						'<br><br>';

					if (data.username == '<?= getenv('ADMIN_USERNAME'); ?>')
						str += '<span class="badge bg-danger">Admin</span>';
					else if (data.is_management == 1)
						str += '<span class="badge bg-success">Management</span>';
					else
						str += '<span class="badge bg-secondary">User</span>';

					str +=
						'<br><br>' +
						'<span style="display: inline-block; width: 140px;">ID</span> = ' + data.id + '<br>' +
						'<span style="display: inline-block; width: 140px;">Email</span> = ' + data.email + '<br>' +
						'<span style="display: inline-block; width: 140px;">Username</span> = ' + data.username + '<br>' +
						'<span style="display: inline-block; width: 140px;">Nama</span> = ' + (data.first_name + ' ' + data.last_name).trim() + '<br>' +
						'<span style="display: inline-block; width: 140px;">Tanggal Lahir</span> = ' + data.birth_date + '<br>' +
						'<span style="display: inline-block; width: 140px;">Jenis Kelamin</span> = ' + (data.gender == 0 ? 'Laki-laki' : 'Perempuan') + '<br>' +
						'<span style="display: inline-block; width: 140px;">Terakhir di update</span> = ' + data.updated_at + '<br>' +
						'<button type="button" class="btn btn-warning btn-sm" id="editButton" data-acc-id="' + data.id + '">Edit</button> ' +
						'<button type="button" class="btn btn-danger btn-sm" id="deleteButton" data-acc-id="' + data.id + '">Hapus</button>'
					'</div>';

					return str;
				}).show();

				tr.addClass('shown');
			}
		});

		$('#nonDeletedTable > tbody').on('click', '#profilePicture', function() {
			$('#profilePictureZoomedImage').prop('src', $(this).prop('src'));
			$('#profilePictureModal').modal('show');
		});

		// Deleted Users Table
		let DeletedTable = $('#deletedTable').DataTable({
			ajax: '<?= base_url('account/account/getallaccounts/1'); ?>',
			deferRender: true,
			responsive: {
				details: false
			},
			columns: [{
				className: 'dt-control',
				orderable: false,
				searchable: false,
				data: null,
				defaultContent: ''
			}, {
				autowidth: true,
				data: 'id'
			}, {
				autowidth: true,
				data: 'email'
			}, {
				autowidth: true,
				data: 'username'
			}, {
				autowidth: true,
				data: 'first_name',
				render: function(data, type, row, meta) {
					return (data + ' ' + row.last_name).trim();
				}
			}, {
				orderable: false,
				searchable: false,
				data: null,
				render: function(data, type, row, meta) {
					if (row.id == <?= session('acc_id'); ?>) {
						return '';
					}

					if (row.username.toLocaleLowerCase() == '<?= getenv('ADMIN_USERNAME'); ?>'.toLocaleLowerCase()) {
						return '';
					}

					if (row.is_management == 1 &&
						'<?= session('acc_username'); ?>'.toLocaleLowerCase() != '<?= getenv('ADMIN_USERNAME'); ?>'.toLocaleLowerCase()) {
						return '';
					}

					return '<button type="button" class="btn btn-primary btn-sm" id="restoreButton" data-acc-id="' + row.id + '">Pulih</button> ' +
						'<button type="button" class="btn btn-danger btn-sm" id="deleteButton" data-acc-id="' + row.id + '" data-acc-delete-purge>Hapus</button>';
				}
			}],
			order: [
				[1, 'asc']
			]
		});

		$('#deletedTable tbody').on('click', 'td.dt-control', function() {
			let tr = $(this).closest('tr');
			let row = DeletedTable.row(tr);

			if (row.child.isShown()) {
				row.child.hide();
				tr.removeClass('shown');
			} else {
				let data = row.data();

				row.child(() => {
					let str = '';

					str +=
						'<img src="<?= base_url('assets/img/profile-pictures'); ?>/' + data.profile_picture + '" alt="Foto profil ' + data.profile_picture + '" width="150px" id="profilePicture" class="img-thumbnail" role="button" title="Foto profil ' + data.profile_picture + '" style="border-radius: 50%;">' +
						'<br><br>';

					if (data.username == '<?= getenv('ADMIN_USERNAME'); ?>')
						str += '<span class="badge bg-danger">Admin</span>';
					else if (data.is_management == 1)
						str += '<span class="badge bg-success">Management</span>';
					else
						str += '<span class="badge bg-secondary">User</span>';

					str +=
						'<br><br>' +
						'<span style="display: inline-block; width: 140px;">ID</span> = ' + data.id + '<br>' +
						'<span style="display: inline-block; width: 140px;">Email</span> = ' + data.email + '<br>' +
						'<span style="display: inline-block; width: 140px;">Username</span> = ' + data.username + '<br>' +
						'<span style="display: inline-block; width: 140px;">Nama</span> = ' + (data.first_name + ' ' + data.last_name).trim() + '<br>' +
						'<span style="display: inline-block; width: 140px;">Tanggal Lahir</span> = ' + data.birth_date + '<br>' +
						'<span style="display: inline-block; width: 140px;">Jenis Kelamin</span> = ' + (data.gender == 0 ? 'Laki-laki' : 'Perempuan') + '<br>' +
						'<span style="display: inline-block; width: 140px;">Tanggal Terhapus</span> = ' + data.deleted_at + '<br>' +
						'<button type="button" class="btn btn-primary btn-sm" id="restoreButton" data-acc-id="' + data.id + '">Pulih</button> ' +
						'<button type="button" class="btn btn-danger btn-sm" id="deleteButton" data-acc-id="' + data.id + '" data-acc-delete-purge>Hapus</button>'
					'</div>';

					return str;
				}).show();

				tr.addClass('shown');
			}
		});

		$('#deletedTable > tbody').on('click', '#profilePicture', function() {
			$('#profilePictureZoomedImage').prop('src', $(this).prop('src'));
			$('#profilePictureModal').modal('show');
		});

		// Actions

		// Edit
		$('#nonDeletedTable').on('click', '#editButton', function() {
			let id = $(this).attr('data-acc-id');
			let data = nonDeletedTable.row($(this).closest('tr')).data();

			// $('#accSettingsForm input[name=id]').val(id);

			$('#accSettingsForm input[name=email]').val(data.email);
			$('#accSettingsForm input[name=username]').val(data.username);
			$('#accSettingsForm input[name=first_name]').val(data.first_name);
			$('#accSettingsForm input[name=last_name]').val(data.last_name);
			$('#accSettingsForm input[name=birth_date]').val(data.birth_date);

			$('#accSettingsForm').attr('action', '<?= base_url('user/update'); ?>/' + id);

			$('#accountEditModal').modal('show');
		});

		$('#accountEditModal').on('hidden.bs.modal', function() {
			$('#accSettingsForm .invalid-feedback').html('');
			$('#accSettingsForm input').removeClass('is-invalid');
		});

		// Delete
		$('#nonDeletedTable,#deletedTable').on('click', '#deleteButton', function() {
			let id = $(this).attr('data-acc-id');
			let purge = $(this).attr('data-acc-delete-purge') != undefined;

			Swal.fire({
				title: 'Hapus Akun',
				text: 'Anda yakin ingin menghapus ' + (purge ? 'permanen ' : '') + 'akun ini?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#ff0000',
				confirmButtonText: 'Hapus' + (purge ? ' Permanen' : ''),
				cancelButtonText: 'Kembali'
			}).then(function(result) {
				if (result.isConfirmed) {
					$.ajax({
						url: '<?= base_url('user/delete'); ?>',
						type: 'post',
						data: {
							id: Number(id),
							purge: Number(purge)
						},
						success: function(data) {
							if (data) {
								Swal.fire({
									icon: 'error',
									title: 'Gagal menghapus ' + (purge ? 'permanen ' : '') + 'akun',
									text: data,
									// showConfirmButton: false,
								});
							} else {
								Swal.fire({
									icon: 'success',
									text: 'Akun berhasil dihapus' + (purge ? ' permanen' : ''),
									showConfirmButton: false,
									timer: 1500
								}).then(function() {
									location.reload();
								});
							}
						}
					});
				}
			});
		});

		// Restore
		$('#deletedTable').on('click', '#restoreButton', function() {
			let id = $(this).attr('data-acc-id');

			Swal.fire({
				title: 'Pulihkan Akun',
				text: 'Anda yakin ingin pulihkan akun ini?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#0000ff',
				confirmButtonText: 'Pulihkan',
				cancelButtonText: 'Kembali'
			}).then(function(result) {
				if (result.isConfirmed) {
					$.ajax({
						url: '<?= base_url('user/restore'); ?>',
						type: 'post',
						data: {
							id: Number(id)
						},
						success: function(data) {
							if (data) {
								Swal.fire({
									icon: 'error',
									title: 'Gagal memulihkan akun',
									text: data,
									// showConfirmButton: false,
								});
							} else {
								Swal.fire({
									icon: 'success',
									text: 'Akun berhasil dipulihkan',
									showConfirmButton: false,
									timer: 1500
								}).then(function() {
									location.reload();
								});
							}
						}
					});
				}
			});
		});
	});
</script>