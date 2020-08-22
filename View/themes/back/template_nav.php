<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
<a class="navbar-brand text-white bg-dark" href="<?= BASE_ADMIN_URL; ?>"><img alt="<?= WEBSITE_NAME; ?>" title="<?= WEBSITE_NAME; ?>" src="<?= BASE_URL; ?>public/images/logos/logo-sm-white.png"> | Panneau d'Administration</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarCollapse">
<ul class="navbar-nav mr-auto">
  <li class="nav-item">
  </li>
</ul>
<div class="form-inline mt-2 mt-md-0">
  <?php if(ISSET($_SESSION['id_user_admin']))
  {?>
    <a href="<?= BASE_ADMIN_URL; ?>lock/logoutadmin"><button class="btn-sm btn-danger my-2 my-sm-0">Déconnexion&nbsp;<em class="fas fa-sign-out-alt"></em></button></a>
    <a href="<?= BASE_URL; ?>" target="_blank"><button class="btn-sm btn-success my-2 my-sm-0 ml-2">Site Public&nbsp;<em class="fas fa-external-link-alt"></em></button></a>
  <?php }
  else { ?>
    <a href="<?= BASE_URL; ?>" target="_blank"><button class="btn-sm btn-success my-2 my-sm-0 ml-2">Site Public&nbsp;<em class="fas fa-external-link-alt"></em></button></a>
  <?php }; ?>
</div>
</div>
</nav>
