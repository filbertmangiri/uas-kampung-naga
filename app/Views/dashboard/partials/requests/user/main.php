<div class="container">
	<table id="requestsTable" class="table table-striped" style="width:100%">
		<thead>
			<tr>
				<th>No.</th>
				<th>Fasilitas</th>
				<th>Tanggal & Waktu Mulai</th>
				<th>Tanggal & Waktu Selesai</th>
				<th>Status</th>
			</tr>
		</thead>

		<tbody>
			<?php

			$i = 1;

			foreach ($requests as $value) : ?>
				<tr>
					<td><?= $i++; ?></td>
					<td><a href="<?= base_url('f/' . $value['facility_name_slug']); ?>"><?= $value['facility_name']; ?></a></td>
					<td><?= $value['start_date']; ?></td>
					<td><?= $value['end_date']; ?></td>
					<td>
						<?php
						switch ($value['status']) {
							case 0:
								echo '<span class="badge bg-secondary">Menunggu Persetujuan</span>';
								break;
							case 1:
								echo '<span class="badge bg-danger">Ditolak</span>';
								break;
							case 2:
								echo '<span class="badge bg-success">Diterima</span>';
								break;
							default:
								echo 'ERROR';
								break;
						}
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>