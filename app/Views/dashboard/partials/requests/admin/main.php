<div class="container">
	<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
		<li class="nav-item" role="presentation">
			<button class="nav-link requests-accordion active" id="pendingRequestsTab" data-bs-toggle="pill" data-bs-target="#pendingRequests" type="button" role="tab" aria-controls="pendingRequests" aria-selected="true">Tertunda</button>
		</li>

		<li class="nav-item" role="presentation">
			<button class="nav-link requests-accordion" id="acceptedRequestsTab" data-bs-toggle="pill" data-bs-target="#acceptedRequests" type="button" role="tab" aria-controls="acceptedRequests" aria-selected="false">Diterima</button>
		</li>

		<li class="nav-item" role="presentation">
			<button class="nav-link requests-accordion" id="rejectedRequestsTab" data-bs-toggle="pill" data-bs-target="#rejectedRequests" type="button" role="tab" aria-controls="rejectedRequests" aria-selected="false">Ditolak</button>
		</li>
	</ul>

	<div class="tab-content" id="pills-tabContent">
		<div class="tab-pane fade show active" id="pendingRequests" role="tabpanel" aria-labelledby="pendingRequestsTab">
			<table id="pendingRequestsTable" class="table table-striped" style="width:100%">
				<thead>
					<tr>
						<th>No.</th>
						<th>Fasilitas</th>
						<th>Customer</th>
						<th>Mulai</th>
						<th>Selesai</th>
						<th>Aksi</th>
					</tr>
				</thead>

				<tbody>
					<?php

					$i = 1;

					foreach ($requests as $value) : ?>

						<?php if ($value['status'] == 0) : ?>
							<tr>
								<td><?= $i++; ?></td>
								<td><a class="link-dark" href="<?= base_url('f/' . $value['facility_name_slug']); ?>"><?= $value['facility_name']; ?></a></td>
								<td><a class="link-dark" href="<?= base_url('u/' . $value['customer_username']); ?>"><?= trim($value['customer_first_name'] . ' ' . $value['customer_last_name']); ?></a></td>
								<td><?= $value['start_date']; ?></td>
								<td><?= $value['end_date']; ?></td>
								<td>
									<?php if (session('acc_admin') == true) : ?>
										<button type="button" class="btn btn-danger" id="requestDeleteButton" data-request-id="<?= $value['id']; ?>">Hapus</button>
									<?php else : ?>
										<button type="button" class="btn btn-success" id="requestDecisionButton" data-request-accept="true" data-request-id="<?= $value['id']; ?>" data-request-facility-id="<?= $value['facility_id']; ?>" data-customer-id="<?= $value['customer_id']; ?>" data-request-start-date="<?= $value['start_date']; ?>" data-request-end-date="<?= $value['end_date']; ?>">Terima</button>
										<button type="button" class="btn btn-danger" id="requestDecisionButton" data-request-accept="false" data-request-id="<?= $value['id']; ?>">Tolak</button>
									<?php endif; ?>
								</td>
							</tr>
						<?php endif; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<div class="tab-pane fade" id="acceptedRequests" role="tabpanel" aria-labelledby="acceptedRequestsTab">
			<table id="acceptedRequestsTable" class="table table-striped" style="width:100%">
				<thead>
					<tr>
						<th>No.</th>
						<th>Fasilitas</th>
						<th>Customer</th>
						<th>Management</th>
						<th>Mulai</th>
						<th>Selesai</th>
					</tr>
				</thead>

				<tbody>
					<?php

					$i = 1;

					foreach ($requests as $value) : ?>

						<?php if ($value['status'] == 2) : ?>
							<tr>
								<td><?= $i++; ?></td>
								<td><a class="link-dark" href="<?= base_url('f/' . $value['facility_name_slug']); ?>"><?= $value['facility_name']; ?></a></td>
								<td><a class="link-dark" href="<?= base_url('u/' . $value['customer_username']); ?>"><?= trim($value['customer_first_name'] . ' ' . $value['customer_last_name']); ?></a></td>
								<td><a class="link-dark" href="<?= base_url('u/' . $value['management_username']); ?>"><?= trim($value['management_first_name'] . ' ' . $value['management_last_name']); ?></a></td>
								<td><?= $value['start_date']; ?></td>
								<td><?= $value['end_date']; ?></td>
							</tr>
						<?php endif; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<div class="tab-pane fade" id="rejectedRequests" role="tabpanel" aria-labelledby="rejectedRequestsTab">
			<table id="rejectedRequestsTable" class="table table-striped" style="width:100%">
				<thead>
					<tr>
						<th>No.</th>
						<th>Fasilitas</th>
						<th>Customer</th>
						<th>Management</th>
						<th>Mulai</th>
						<th>Selesai</th>
					</tr>
				</thead>

				<tbody>
					<?php

					$i = 1;

					foreach ($requests as $value) : ?>

						<?php if ($value['status'] == 1) : ?>
							<tr>
								<td><?= $i++; ?></td>
								<td><a class="link-dark" href="<?= base_url('f/' . $value['facility_name_slug']); ?>"><?= $value['facility_name']; ?></a></td>
								<td><a class="link-dark" href="<?= base_url('u/' . $value['customer_username']); ?>"><?= trim($value['customer_first_name'] . ' ' . $value['customer_last_name']); ?></a></td>
								<td><a class="link-dark" href="<?= base_url('u/' . $value['management_username']); ?>"><?= trim($value['management_first_name'] . ' ' . $value['management_last_name']); ?></a></td>
								<td><?= $value['start_date']; ?></td>
								<td><?= $value['end_date']; ?></td>
							</tr>
						<?php endif; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>