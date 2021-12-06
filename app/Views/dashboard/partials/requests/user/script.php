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
		$('#requestsTable').DataTable({
			deferRender: true,
			responsive: true
		});
		// =========================================================
	});
</script>