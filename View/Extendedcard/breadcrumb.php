<div class="d-flex justify-content-between align-items-center mb-3">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?= BASE_URL; ?>">Accueil</a>
      </li>
      <li class="breadcrumb-item">
        <a href="category/<?= $this->clean($category['catid']).'/1/' . $this->clean($category['slug']) ;?>"><?= $this->clean($category['name']); ?></a>
      </li>
      <li class="breadcrumb-item">
        <?= $this->clean($item['title']); ?>
      </li>
    </ol>
  </nav>
  <span class="badge bg-primary-alt text-primary">
    <em class="far fa-eye"></em>&nbsp;&nbsp;<?= $this->clean($item['views']); ?> vues</span>
</div>
