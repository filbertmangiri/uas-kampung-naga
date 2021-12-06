<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js" integrity="sha256-TAzGN4WNZQPLqSYvi+dXQMKehTYFoVOnveRqbi42frA=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js" integrity="sha256-+NPi2ReKyI6yhNClJ78JSzbMmihq7Kjml84LwR631hM=" crossorigin="anonymous"></script>

<script type="text/javascript">
	$(document).ready(function() {
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

		<?= session('show_user_editing_modal'); ?>

		// Non Deleted Users Table
		let nonDeletedUsersTable = $('#nonDeletedUsersTable').DataTable({
			ajax: '<?= base_url('user/getallaccounts'); ?>',
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
				data: null,
				render: function(data, type, row, meta) {
					return (row.first_name + ' ' + row.last_name).trim();
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

					return `
						<button type="button" class="btn btn-warning btn-sm" id="editButton" data-acc-id="${row.id}">Edit</button>
						<button type="button" class="btn btn-danger btn-sm" id="deleteButton" data-acc-id="${row.id}">Hapus</button>`;
				}
			}],
			order: [
				[1, 'asc']
			]
		});

		$('#nonDeletedUsersTable tbody').on('click', 'td.dt-control', function() {
			let tr = $(this).closest('tr');
			let row = nonDeletedUsersTable.row(tr);

			if (row.child.isShown()) {
				row.child.hide();
				tr.removeClass('shown');
			} else {
				let data = row.data();

				row.child(() => {
					let str = '';

					str +=
						'<div class="text-center">' +
						'<img src="<?= base_url('assets/img/users'); ?>/' + data.profile_picture + '" alt="Foto profil ' + data.username + '" width="150px" id="profilePicture" class="img-thumbnail" role="button" title="Foto profil ' + data.username + '" style="border-radius: 50%;">' +
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
						'<span style="display: inline-block; width: 140px;">Tanggal Daftar</span> = ' + data.created_at + '<br>' +
						'<span style="display: inline-block; width: 140px;">Terakhir Diubah</span> = ' + data.updated_at + '<br>' +
						'<button type="button" class="btn btn-warning btn-sm" id="editButton" data-acc-id="' + data.id + '" data-acc-child="true">Edit</button> ' +
						'<button type="button" class="btn btn-danger btn-sm" id="deleteButton" data-acc-id="' + data.id + '">Hapus</button>'
					'</div>'
					'</div>';

					return str;
				}).show();

				tr.addClass('shown');
			}
		});

		$('#nonDeletedUsersTable > tbody').on('click', '#profilePicture', function() {
			$('#profilePictureZoomedImage').prop('src', $(this).prop('src'));
			$('#profilePictureZoomedImage').prop('width', $(this).prop('width'));
			$('#profilePictureModal').modal('show');
		});

		// Deleted Users Table
		let deletedUsersTable = $('#deletedUsersTable').DataTable({
			ajax: '<?= base_url('user/getallaccounts/1'); ?>',
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
				data: null,
				render: function(data, type, row, meta) {
					return (row.first_name + ' ' + row.last_name).trim();
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

					return `
						<button type="button" class="btn btn-primary btn-sm" id="restoreButton" data-acc-id="${row.id}">Pulih</button>
						<button type="button" class="btn btn-danger btn-sm" id="deleteButton" data-acc-id="${row.id}" data-acc-delete-purge>Hapus</button>`;
				}
			}],
			order: [
				[1, 'asc']
			]
		});

		$('#deletedUsersTable tbody').on('click', 'td.dt-control', function() {
			let tr = $(this).closest('tr');
			let row = deletedUsersTable.row(tr);

			if (row.child.isShown()) {
				row.child.hide();
				tr.removeClass('shown');
			} else {
				let data = row.data();

				row.child(() => {
					let str = '';

					str +=
						'<img src="<?= base_url('assets/img/users'); ?>/' + data.profile_picture + '" alt="Foto profil ' + data.username + '" width="150px" id="profilePicture" class="img-thumbnail" role="button" title="Foto profil ' + data.username + '" style="border-radius: 50%;">' +
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
						'<span style="display: inline-block; width: 140px;">Tanggal Daftar</span> = ' + data.created_at + '<br>' +
						'<span style="display: inline-block; width: 140px;">Tanggal Terhapus</span> = ' + data.deleted_at + '<br>' +
						'<button type="button" class="btn btn-primary btn-sm" id="restoreButton" data-acc-id="' + data.id + '">Pulih</button> ' +
						'<button type="button" class="btn btn-danger btn-sm" id="deleteButton" data-acc-id="' + data.id + '" data-acc-delete-purge>Hapus</button>'
					'</div>';

					return str;
				}).show();

				tr.addClass('shown');
			}
		});

		$('#deletedUsersTable > tbody').on('click', '#profilePicture', function() {
			$('#profilePictureZoomedImage').prop('src', $(this).prop('src'));
			$('#profilePictureModal').modal('show');
		});

		// Actions

		// Edit
		$('#nonDeletedUsersTable').on('click', '#editButton', function() {
			let id = $(this).attr('data-acc-id');
			let row;

			if ($(this).attr('data-acc-child') == true) {
				row = $(this).closest('tr').prev('tr.dt-hasChild.shown')[0];
			} else {
				row = $(this).closest('tr');
			}

			let data = nonDeletedUsersTable.row(row).data();

			$('#accSettingsForm input[name=old_profile_picture]').val(data.profile_picture);
			$('#accSettingsForm input[name=email]').val(data.email);
			$('#accSettingsForm input[name=username]').val(data.username);
			$('#accSettingsForm input[name=first_name]').val(data.first_name);
			$('#accSettingsForm input[name=last_name]').val(data.last_name);
			$('#accSettingsForm input[name=birth_date]').val(data.birth_date);

			$('#accSettingsForm input[name=gender][value=' + data.gender + ']').prop('checked', 'true');

			$('#accSettingsForm').attr('action', '<?= base_url('user/update'); ?>/' + id);

			$('#accountEditModal').modal('show');

			$('input[name=email]').blur(() => validation('email', 'The email field must contain a unique value.', data.email));
			$('#accSettingsForm').submit(() => validation('email', 'The email field must contain a unique value.', data.email));

			$('input[name=username]').blur(() => validation('username', 'The username field must contain a unique value.', data.username));
			$('#accSettingsForm').submit(() => validation('username', 'The username field must contain a unique value.', data.username));
		});

		$('#accountEditModal').on('hidden.bs.modal', function() {
			$('#errorCloseButton').click();

			$('#accSettingsForm .invalid-feedback').html('');
			$('#accSettingsForm input').removeClass('is-invalid');
		});

		// Delete
		$('#nonDeletedUsersTable,#deletedUsersTable').on('click', '#deleteButton', function() {
			let id = $(this).attr('data-acc-id');
			let purge = $(this).attr('data-acc-delete-purge') != undefined;

			Swal.fire({
				title: 'Hapus ' + (purge ? 'Permanen ' : '') + 'Akun',
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
		$('#deletedUsersTable').on('click', '#restoreButton', function() {
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

<script type="text/javascript">
	function validation(key, error, old) {
		let element = $('input[name=' + key + ']');

		if (element.val().toLocaleLowerCase() != old.toLocaleLowerCase()) {
			$.ajax({
				data: {
					key: key,
					value: element.val()
				},
				type: 'post',
				url: '<?= base_url('user/isexist') ?>',
				success: function(data) {
					if (data) {
						element.addClass('is-invalid');
						element.next().next('.invalid-feedback').html(error);
					}
				}
			});
		}
	}

	$(document).ready(function() {
		$.validator.addMethod('lettersOnly', function(value, element) {
			return this.optional(element) || /^[A-Za-z áãâäàéêëèíîïìóõôöòúûüùçñ]+$/i.test(value);
		});

		$.validator.addMethod('emailEx', function(value, element) {
			return /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
		});

		$.validator.addMethod('noSpaceSymbol', function(value, element) {
			return this.optional(element) || /^[a-zA-Z0-9_]+$/i.test(value);
		});

		$.validator.addMethod('lessThanToday', function(value, element) {
			return new Date(value) < new Date();
		});

		$.validator.addMethod('fileTypeImage', function(value, element) {
			return this.optional(element) || (element.files[0].size <= param * 1048576);
		});

		$('#accSettingsForm').validate({
			ignore: 'input[name=profile_picture]',

			rules: {
				first_name: {
					required: true,
					lettersOnly: true,
					minlength: 2
				},
				last_name: {
					lettersOnly: true,
				},
				email: {
					required: true,
					emailEx: true
				},
				username: {
					required: true,
					noSpaceSymbol: true,
					minlength: 5,
					maxlength: 50
				},
				birth_date: {
					required: true,
					dateISO: true,
					lessThanToday: true
				},
				gender: {
					required: true,
				}
			},

			errorPlacement: function(error, element) {
				element.next().next('.invalid-feedback').html(error.html());
			},

			highlight: function(element, errorClass, validClass) {
				if ($(element).prop('type') != 'radio') {
					$(element).addClass('is-invalid');
				}
			},

			unhighlight: function(element, errorClass, validClass) {
				$(element).removeClass('is-invalid');
			},

			submitHandler: function(form) {
				form.submit();
			}
		});
	});
</script>