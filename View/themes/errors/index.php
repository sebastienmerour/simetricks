<?php require('View/themes/front/template_header.php'); ?>
<?php $this->title = WEBSITE_NAME . ' | Erreur'; ?>
<div class="min-vh-100 bg-primary-3 text-light py-5 o-hidden">
  <div class="container">
    <div class="row justify-content-center mb-md-6">
      <div class="col-auto">
        <a href="<?= BASE_URL; ?>">
          <img src="<?= BASE_URL; ?>public/images/logos/logo-xl-white.png" alt="<?= WEBSITE_NAME; ?>" title="<?= WEBSITE_NAME; ?>" class="icon icon-lg">
        </a>
      </div>
    </div>
    <div class="row text-center py-6">
      <div class="col layer-2">
        <h1 class="display-1 mb-0">Erreur</h1>
        <h2 class="h1"><?= $content ?></h2>
        <a class="btn btn-primary btn-lg" href="<?= $_SERVER['HTTP_REFERER']; ?>">Page précédente</a>
      </div>
    </div>
  </div>
</div>
<?php require('template_footer.php'); ?>
