<script type="text/javascript">
	$(document).ready(function() {
		// =================== Accordion Routing ===================
		let requestsAccordion = localStorage.getItem('requestsAccordion');

		if (requestsAccordion) {
			let targetFrom = $('.requests-accordion[aria-selected=true]').attr('data-bs-target');
			$('.requests-accordion[aria-selected=true]').removeClass('active').attr('aria-selected', 'false');
			let targetTo = $('#' + requestsAccordion).attr('data-bs-target');
			$('#' + requestsAccordion).addClass('active').attr('aria-selected', 'true');

			$(targetFrom).removeClass('active show');
			$(targetTo).addClass('active show');
		}

		$('.requests-accordion').click(function() {
			localStorage.setItem('requestsAccordion', $(this).prop('id'));
		});
		// =========================================================

		// ====================== DataTables =======================
		$('#pendingRequestsTable').DataTable({
			deferRender: true,
			responsive: true
		});

		$('#acceptedRequestsTable').DataTable({
			deferRender: true,
			responsive: true
		});
		// =========================================================

		// ======================== Buttons ========================
		$('#pendingRequestsTable tbody').on('click', '#requestDeleteButton', function() {
			let id = $(this).attr('data-request-id');

			Swal.fire({
				title: 'Hapus Request',
				text: 'Anda yakin ingin menghapus request ini?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#ff0000',
				confirmButtonText: 'Hapus',
				cancelButtonText: 'Kembali'
			}).then(function(result) {
				if (result.isConfirmed) {
					$.ajax({
						url: '<?= base_url('request/delete'); ?>',
						type: 'post',
						data: {
							id: id
						},
						success: function(data) {
							if (data) {
								Swal.fire({
									icon: 'error',
									title: 'Gagal menghapus request',
									text: data,
								});
							} else {
								Swal.fire({
									icon: 'success',
									text: 'Request berhasil dihapus',
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

		$('#pendingRequestsTable tbody').on('click', '#requestDecisionButton', function() {
			let id = $(this).attr('data-request-id');
			let accept = $(this).attr('data-request-accept') == 'true';
			let customer_id = $(this).attr('data-customer-id');
			let facility_id = $(this).attr('data-request-facility-id');
			let start_date = $(this).attr('data-request-start-date');
			let end_date = $(this).attr('data-request-end-date');

			Swal.fire({
				title: `${accept ? 'Terima' : 'Tolak'} Request`,
				text: `Anda yakin ingin ${accept ? 'menerima' : 'menolak'} request ini?`,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: accept ? '#007e33' : '#ff4444',
				confirmButtonText: accept ? 'Terima' : 'Tolak',
				cancelButtonText: 'Kembali'
			}).then(function(result) {
				if (result.isConfirmed) {
					$.ajax({
						url: '<?= base_url('request/decision'); ?>',
						type: 'post',
						data: {
							id: id,
							decision: accept ? 2 : 1,
							customer_id: customer_id,
							facility_id: facility_id,
							start_date: start_date,
							end_date: end_date
						},
						success: function(data) {
							if (data) {
								Swal.fire({
									icon: 'error',
									title: `Gagal ${accept ? 'menerima' : 'menolak'} request`,
									text: data,
								});
							} else {
								Swal.fire({
									icon: 'success',
									text: `Request berhasil di${accept ? 'terima' : 'tolak'}`,
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
		// =========================================================
	});
</script>