<?php $uri = new \CodeIgniter\HTTP\URI(current_url(true)); ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container">
		<a class="navbar-brand" href="<?= base_url(); ?>"><?= getenv('WEB_NAME'); ?></a>

		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarText">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link <?= !$uri->getSegment(2) || $uri->getSegment(2) == 'home' ? 'active' : ''; ?>" href="<?= base_url(); ?>">Beranda</a>
				</li>

				<li class="nav-item">
					<a class="nav-link <?= $uri->getSegment(2) == 'about' ? 'active' : ''; ?>" href="<?= base_url('about'); ?>">Tentang Kami</a>
				</li>
			</ul>

			<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
				<?php if (session('acc_logged_in') === true) : ?>
					<li class="nav-item dropdown">
						<a class="nav-link" href="#" id="myAccount" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="<?= base_url('assets/img/users/' . session('acc_profile_picture')); ?>" alt="Foto Profil Saya" height="30px" style="border-radius: 50%;">
							<?= trim(session('acc_first_name') . ' ' . session('acc_last_name')); ?>
						</a>

						<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="myAccount">
							<li><a class="dropdown-item" href="<?= base_url('u'); ?>">Profil Saya</a></li>
							<li><a class="dropdown-item" href="<?= base_url('account/settings'); ?>">Ubah Profil</a></li>
							<li><a class="dropdown-item" href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item" href="<?= base_url('logout'); ?>">Keluar</a></li>
						</ul>
					</li>
				<?php else : ?>
					<li class="nav-item">
						<a class="nav-link <?= $uri->getSegment(2) == 'login' ? 'active' : ''; ?>" href="<?= base_url('login'); ?>">Masuk</a>
					</li>

					<li class="nav-item">
						<a class="nav-link <?= $uri->getSegment(2) == 'register' ? 'active' : ''; ?>" href="<?= base_url('register'); ?>">Daftar</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</nav>