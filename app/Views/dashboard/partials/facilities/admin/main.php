<div class="container">
	<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
		<li class="nav-item" role="presentation">
			<button class="nav-link facilities-accordion active" id="nonDeletedFacilitiesTab" data-bs-toggle="pill" data-bs-target="#nonDeletedFacilities" type="button" role="tab" aria-controls="nonDeletedFacilities" aria-selected="true">Semua</button>
		</li>

		<li class="nav-item" role="presentation">
			<button class="nav-link facilities-accordion" id="deletedFacilitiesTab" data-bs-toggle="pill" data-bs-target="#deletedFacilities" type="button" role="tab" aria-controls="deletedFacilities" aria-selected="false">Terhapus</button>
		</li>
	</ul>

	<div class="tab-content" id="pills-tabContent">
		<div class="tab-pane fade show active" id="nonDeletedFacilities" role="tabpanel" aria-labelledby="nonDeletedFacilitiesTab">
			<button type="button" class="btn btn-primary mb-3" id="facilitiesInsertButton">Tambah Fasilitas</button>

			<table id="nonDeletedFacilitiesTable" class="table table-striped" style="width:100%">
				<thead>
					<tr>
						<th></th>
						<th>ID</th>
						<th>Nama</th>
						<th>Status</th>
						<th>Aksi</th>
					</tr>
				</thead>

				<tbody>
					<!-- SCRIPTS -->
				</tbody>
			</table>
		</div>

		<div class="tab-pane fade" id="deletedFacilities" role="tabpanel" aria-labelledby="deletedFacilitiesTab">
			<table id="deletedFacilitiesTable" class="table table-striped" style="width:100%">
				<thead>
					<tr>
						<th></th>
						<th>ID</th>
						<th>Nama</th>
						<th>Aksi</th>
					</tr>
				</thead>

				<tbody>
					<!-- SCRIPTS -->
				</tbody>
			</table>
		</div>
	</div>
</div>