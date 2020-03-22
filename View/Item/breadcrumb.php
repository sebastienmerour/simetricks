<div class="d-flex justify-content-between align-items-center mb-3">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?= DOMAIN_NAME; ?>">Accueil</a>
      </li>
      <li class="breadcrumb-item">
        <a href="category/<?= $this->clean($category['id']).'/1/' . $this->clean($category['slug']) ;?>"><?= $this->clean($category['name']); ?></a>
      </li>
      <li class="breadcrumb-item">
        <?= $this->clean($item['title']); ?>
      </li>
    </ol>
  </nav>
</div>
