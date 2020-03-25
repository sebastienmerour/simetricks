	<div class="navbar-container">
		<nav class="navbar navbar-expand-lg navbar-light">
			<div class="container">
				<a class="navbar-brand" href="<?= BASE_URL; ?>"><img alt="<?= WEBSITE_NAME; ?>" title="<?= WEBSITE_NAME; ?>" src="<?= BASE_URL; ?>public/images/logos/logo-sm.png"></a>
        <button aria-controls="navbarmenu" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarmenu" data-toggle="collapse" type="button">
          <span class="navbar-toggler-icon"></span></button>
					<div class="collapse navbar-collapse justify-content-between" id="navbarmenu">
						<div class="py-2 py-lg-0">
							<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="cards">Cards</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="extendedcards">Extended Cards</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="category/1/1/web">Web</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="category/2/1/langages">Langages</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="category/3/1/it">IT</a>
						</li>
					</ul>
				</div>
				<?php if(ISSET($_SESSION['id_user']))
				{?>
						<a href="user" role="button"  role="button" class="btn btn-md btn-success btn-sm">Mon Compte</a>
				<?php }
				else { ?>
						<a href="login/" role="button" class="btn btn-md btn-success btn-sm mr-1">Se connecter</a>
				<?php }; ?>
			</div>
		</div>
		</nav>
	</div>
