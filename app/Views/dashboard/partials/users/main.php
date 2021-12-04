<div class="container">
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
						<th></th>
						<th>ID</th>
						<th>Email</th>
						<th>Username</th>
						<th>Nama</th>
						<th>Aksi</th>
					</tr>
				</thead>

				<tbody>
					<!-- SCRIPTS -->
				</tbody>
			</table>
		</div>

		<div class="tab-pane fade" id="deletedUsers" role="tabpanel" aria-labelledby="deletedUsersTab">
			<table id="deletedTable" class="table table-striped" style="width:100%">
				<thead>
					<tr>
						<th></th>
						<th>ID</th>
						<th>Email</th>
						<th>Username</th>
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