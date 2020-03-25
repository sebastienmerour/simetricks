<div class="d-flex justify-content-between align-items-center mb-3">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?= BASE_URL; ?>">Accueil</a>
      </li>
      <li class="breadcrumb-item">
        <?= $this->clean($category['name']); ?>
      </li>
    </ol>
  </nav>
</div>
