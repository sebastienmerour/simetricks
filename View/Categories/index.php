<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('location: '. BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Panneau d\'Administration'; ?>
<?php require('categories_menu.php'); ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="table-responsive">
  <h2 id="lastitems">Catégories Publiées</h2>
  <div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Nom</th>
        <th>Description</th>
				<th>Nombre d'Articles</th>
				<th>Modification</th>
        <th>Suppression</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($category = $categories->fetch()) {
      ?>
      <tr>
        <td><h6 class="mt-2 text-left"><a href="<?= BASE_ADMIN_URL.'categories/categoryread/' . $this->clean($category['id']) ?>">
        <?= $this->clean($category['name']); ?></a></span></td>
				<td><h6 class="mt-2 text-left"><?= $this->clean($category['description']); ?></h6></td>
				<td><h6 class="mt-2 text-left"><?= $this->clean($category['count']); ?></h6></td>
				<td><a href="<?= BASE_ADMIN_URL. 'categories/categoryread/' . $this->clean($category['id'])?>" role="button" class="btn btn-sm btn-primary">Modifier</a></td>
        <td><a href="<?= BASE_ADMIN_URL. 'categories/movecategorytobin/' . $this->clean($category['id'])?>" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>
		  </tr>
      <?php
        }
      ?>
    </tbody>
  </table>
</div>
</div>
<?php
};
?>
