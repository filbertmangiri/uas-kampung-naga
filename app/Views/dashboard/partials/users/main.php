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
			<symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
				<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
			</symbol>

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