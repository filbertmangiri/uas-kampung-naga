<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js" integrity="sha256-TAzGN4WNZQPLqSYvi+dXQMKehTYFoVOnveRqbi42frA=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js" integrity="sha256-+NPi2ReKyI6yhNClJ78JSzbMmihq7Kjml84LwR631hM=" crossorigin="anonymous"></script>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		let facilitiesAccordion = localStorage.getItem('facilitiesAccordion');

		if (facilitiesAccordion) {
			let targetFrom = $('.facilities-accordion[aria-selected=true]').attr('data-bs-target');
			$('.facilities-accordion[aria-selected=true]').removeClass('active').attr('aria-selected', 'false');
			let targetTo = $('#' + facilitiesAccordion).attr('data-bs-target');
			$('#' + facilitiesAccordion).addClass('active').attr('aria-selected', 'true');

			$(targetFrom).removeClass('active show');
			$(targetTo).addClass('active show');
		}

		$('.facilities-accordion').click(function() {
			localStorage.setItem('facilitiesAccordion', $(this).prop('id'));
		});

		// Non Deleted Facilities Table
		let nonDeletedFacilitiesTable = $('#nonDeletedFacilitiesTable').DataTable({
			ajax: '<?= base_url('facility/getallfacilities'); ?>',
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
				data: 'name',
				render: function(data, type, row, meta) {
					return `<a class="link-dark" href="<?= base_url('f'); ?>/${row.name_slug}">${data}</a>`;
				}
			}, {
				orderable: false,
				searchable: false,
				autowidth: true,
				data: null,
				render: function(data, type, row, meta) {
					let check = new Date();
					let start = new Date(row.start_date);
					let end = new Date(row.end_date);

					if (check >= start && check <= end)
						return `<span class="badge bg-secondary">Terisi</span>`;
					else
						return `<span class="badge bg-success">Kosong</span>`;
				}
			}, {
				orderable: false,
				searchable: false,
				data: null,
				render: function(data, type, row, meta) {
					let check = new Date();
					let start = new Date(row.start_date);
					let end = new Date(row.end_date);

					if (check >= start && check <= end)
						return 'Sedang Disewa';

					return `
						<button type="button" class="btn btn-warning btn-sm" id="editButton" data-facility-id="${row.id}">Edit</button>
						<button type="button" class="btn btn-danger btn-sm" id="deleteButton" data-facility-id="${row.id}">Hapus</button>`;
				}
			}],
			order: [
				[1, 'asc']
			]
		});

		$('#nonDeletedFacilitiesTable tbody').on('click', 'td.dt-control', function() {
			let tr = $(this).closest('tr');
			let row = nonDeletedFacilitiesTable.row(tr);

			if (row.child.isShown()) {
				row.child.hide();
				tr.removeClass('shown');
			} else {
				let data = row.data();

				row.child(() => {
					let check = new Date();
					let start = new Date(data.start_date);
					let end = new Date(data.end_date);

					return `
						<img src="<?= base_url('assets/img/facilities'); ?>/${data.image}" alt="Foto ${data.name}" width="400px" id="facilityImage" class="img-thumbnail" role="button" title="Foto ${data.name}">
						<br><br>
						${
							check >= start && check <= end
								? `<span class="badge bg-secondary">Terisi</span>`
								: `<span class="badge bg-success">Kosong</span>`
						}
						<br><br>

						<span style="display: inline-block; width: 140px;">ID</span>= ${data.id}<br>
						<span style="display: inline-block; width: 140px;">Nama</span>= ${data.name}<br>
						<br>
						${
							check >= start && check <= end
								? `
									Informasi Penyewaan :<br>
									<span style="display: inline-block; width: 140px;">Customer</span>= <a class="text-dark" href="<?= base_url('u/'); ?>/${data.customer_username}">${(data.customer_first_name + ' ' + data.customer_last_name).trim()}</a><br>`
								: `
									<button type="button" class="btn btn-warning btn-sm" id="editButton" data-facility-id="${data.id}">Edit</button>
									<button type="button" class="btn btn-danger btn-sm" id="deleteButton" data-facility-id="${data.id}">Hapus</button>`
						}`;
				}).show();

				tr.addClass('shown');
			}
		});

		$('#nonDeletedFacilitiesTable > tbody').on('click', '#facilityImage', function() {
			$('#facilityImageZoomedImage').prop('src', $(this).prop('src'));
			$('#facilityImageZoomedImage').prop('width', $(this).prop('width'));
			$('#facilityImageModal').modal('show');
		});

		// Deleted Facilities Table
		let deletedFacilitiesTable = $('#deletedFacilitiesTable').DataTable({
			ajax: '<?= base_url('facility/getallfacilities/1'); ?>',
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
				data: 'name'
			}, {
				orderable: false,
				searchable: false,
				data: null,
				render: function(data, type, row, meta) {
					return `
						<button type="button" class="btn btn-primary btn-sm" id="restoreButton" data-facility-id="${row.id}">Pulih</button>
						<button type="button" class="btn btn-danger btn-sm" id="deleteButton" data-facility-id="${row.id}" data-facility-delete-purge>Hapus</button>`;
				}
			}],
			order: [
				[1, 'asc']
			]
		});

		$('#deletedFacilitiesTable tbody').on('click', 'td.dt-control', function() {
			let tr = $(this).closest('tr');
			let row = deletedFacilitiesTable.row(tr);

			if (row.child.isShown()) {
				row.child.hide();
				tr.removeClass('shown');
			} else {
				let data = row.data();

				row.child(() => {
					return `
						<img src="<?= base_url('assets/img/facilities'); ?>/${data.image}" alt="Foto ${data.name}" width="400px" id="facilityImage" class="img-thumbnail" role="button" title="Foto ${data.name}">
						<br><br>
						<span style="display: inline-block; width: 140px;">ID</span>= ${data.id}<br>
						<span style="display: inline-block; width: 140px;">Nama</span>= ${data.name}<br>
						<br>
						<button type="button" class="btn btn-primary btn-sm" id="restoreButton" data-facility-id="${data.id}">Pulih</button>
						<button type="button" class="btn btn-danger btn-sm" id="deleteButton" data-facility-id="${data.id}" data-facility-delete-purge>Hapus</button>`;
				}).show();

				tr.addClass('shown');
			}
		});

		$('#deletedFacilitiesTable > tbody').on('click', '#facilityImage', function() {
			$('#facilityImageZoomedImage').prop('src', $(this).prop('src'));
			$('#facilityImageZoomedImage').prop('width', $(this).prop('width'));
			$('#facilityImageModal').modal('show');
		});

		// Actions

		<?= session('show_facility_modal'); ?>

		let facilityDescription;

		ClassicEditor
			.create(document.querySelector('#facilityForm textarea[name=description]'))
			.then(function(editor) {
				window.editor = editor;
				facilityDescription = editor;
			});

		// Add
		$('#facilitiesInsertButton').click(function() {
			$('#facilityModalLabel').html('Tambah Fasilitas')
			$('#facilityModal .modal-footer :submit').html('Tambah');

			$('#facilityForm').attr('action', '<?= base_url('facility/insert'); ?>');

			$('#facilityForm #previewImage').attr('src', '<?= base_url('assets/img/facilities'); ?>/default.png');

			$('#facilityModal').modal('show');
		});

		$('#facilityForm input[name=image]').on('change', function() {
			const [file] = $(this).prop('files');
			if (file) {
				$('#facilityForm #previewImage').prop('src', URL.createObjectURL(file));
			}
		});

		// Edit
		$('#nonDeletedFacilitiesTable').on('click', '#editButton', function() {
			let id = $(this).attr('data-facility-id');
			let row;

			if ($(this).attr('data-facility-child') == true) {
				row = $(this).closest('tr').prev('tr.dt-hasChild.shown')[0];
			} else {
				row = $(this).closest('tr');
			}

			$('#facilityModalLabel').html('Ubah Fasilitas')
			$('#facilityModal .modal-footer :submit').html('Simpan');

			let data = nonDeletedFacilitiesTable.row(row).data();

			$('#facilityForm').attr('action', '<?= base_url('facility/update'); ?>/' + id);

			$('#facilityForm input[name=name]').val(data.name);
			$('#facilityForm input[name=old_image]').val(data.image);

			$('#facilityForm #previewImage').attr('src', '<?= base_url('assets/img/facilities'); ?>/' + data.image);

			facilityDescription.setData(data.description);

			$('#facilityModal').modal('show');
		});

		$('#facilityModal').on('hidden.bs.modal', function() {
			$('#facilityForm input[name=name]').val('');
			$('#facilityForm input[name=old_image]').val('');
			$('#facilityForm #previewImage').attr('src', '<?= base_url('assets/img/facilities'); ?>/default.png');

			$('#facilityForm input[name=image]').wrap('<form>').closest('form').get(0).reset();
			$('#facilityForm input[name=image]').unwrap();

			facilityDescription.setData('');

			$('#facilityForm .invalid-feedback').html('');
			$('#facilityForm input').removeClass('is-invalid');
		});

		// Delete
		$('#nonDeletedFacilitiesTable,#deletedFacilitiesTable').on('click', '#deleteButton', function() {
			let id = $(this).attr('data-facility-id');
			let purge = $(this).attr('data-facility-delete-purge') != undefined;

			Swal.fire({
				title: 'Hapus ' + (purge ? 'Permanen ' : '') + 'Fasilitas',
				text: 'Anda yakin ingin menghapus ' + (purge ? 'permanen ' : '') + 'fasilitas ini?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#ff0000',
				confirmButtonText: 'Hapus' + (purge ? ' Permanen' : ''),
				cancelButtonText: 'Kembali'
			}).then(function(result) {
				if (result.isConfirmed) {
					$.ajax({
						url: '<?= base_url('facility/delete'); ?>',
						type: 'post',
						data: {
							id: Number(id),
							purge: Number(purge)
						},
						success: function(data) {
							if (data) {
								Swal.fire({
									icon: 'error',
									title: 'Gagal menghapus ' + (purge ? 'permanen ' : '') + 'fasilitas',
									text: data,
									// showConfirmButton: false,
								});
							} else {
								Swal.fire({
									icon: 'success',
									text: 'Fasilitas berhasil dihapus' + (purge ? ' permanen' : ''),
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
		$('#deletedFacilitiesTable').on('click', '#restoreButton', function() {
			let id = $(this).attr('data-facility-id');

			Swal.fire({
				title: 'Pulihkan Fasilitas',
				text: 'Anda yakin ingin pulihkan fasilitas ini?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#0000ff',
				confirmButtonText: 'Pulihkan',
				cancelButtonText: 'Kembali'
			}).then(function(result) {
				if (result.isConfirmed) {
					$.ajax({
						url: '<?= base_url('facility/restore'); ?>',
						type: 'post',
						data: {
							id: Number(id)
						},
						success: function(data) {
							if (data) {
								Swal.fire({
									icon: 'error',
									title: 'Gagal memulihkan fasilitas',
									text: data,
									// showConfirmButton: false,
								});
							} else {
								Swal.fire({
									icon: 'success',
									text: 'Fasilitas berhasil dipulihkan',
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
	$(document).ready(function() {
		$.validator.addMethod('alphaNumSpace', function(value, element) {
			return this.optional(element) || /^[A-Za-z0-9 áãâäàéêëèíîïìóõôöòúûüùçñ]+$/i.test(value);
		});

		$.validator.addMethod('fileTypeImage', function(value, element) {
			return this.optional(element) || (element.files[0].size <= param * 1048576);
		});

		$('#facilityInsertForm').validate({
			ignore: '.ignore',

			rules: {
				name: {
					required: true,
					alphaNumSpace: true,
					minlength: 5,
					maxlength: 100
				},
				image: {
					fileTypeImage: true,
					extension: 'png,jpg,jpeg,gif',
					accept: 'image/*'
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