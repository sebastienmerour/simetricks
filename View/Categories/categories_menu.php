<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1 border-bottom">
  <h1 id="home" class="h2">Catégories</h1>
  <div class="btn-toolbar mb-3 mb-md-0">
    <div class="btn-group mr-2">
      <?php if(ISSET($_SESSION['id_user_admin'])){?>
      <a href="<?= BASE_ADMIN_URL; ?>categories/categoryadd" role="button" class="btn btn-sm btn-success mr-2"><em class="far fa-plus-square mr-1"></em>Créer</a>
      <a href="<?= BASE_ADMIN_URL; ?>categories" role="button" class="btn btn-sm btn-primary mr-2"><em class="far fa-folder-open mr-1"></em>Catégories Publiées</a>
      <a href="<?= BASE_ADMIN_URL; ?>categories/categoriesbin" role="button" class="btn btn-sm btn-danger"><em class="far fa-trash-alt mr-1"></em>Corbeille</a>
    <?php } else {}?>
    </div>
  </div>
</div>
