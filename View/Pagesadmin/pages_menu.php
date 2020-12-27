<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1 border-bottom">
  <h1 id="home" class="h2">Pages</h1>
  <div class="btn-toolbar mb-3 mb-md-0">
    <div class="btn-group mr-2">
      <?php if(ISSET($_SESSION['id_user_admin'])){?>
      <a href="<?= BASE_ADMIN_URL; ?>pagesadmin/pageaddpage" role="button" class="btn btn-sm btn-success">Créer une Page</a>
      <a href="<?= BASE_ADMIN_URL; ?>pagesadmin" role="button" class="btn btn-sm btn-primary">Pages Publiées</a>
      <a href="<?= BASE_ADMIN_URL; ?>pagesadmin/pagesbin" role="button" class="btn btn-sm btn-danger">Corbeille</a>
    <?php } else {}?>
    </div>
  </div>
</div>
