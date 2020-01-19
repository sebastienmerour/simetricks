<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('location: '. BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Panneau d\'Administration'; ?>
<?php require('categories_menu.php'); ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
  <h2 id="itemsbin">Corbeille</h2>
  <?php
  if ($number_of_categories_deleted == 0) {
  	require __DIR__ . '/../errors/empty_bin.php';
  }
  else {?>
		<div class="table-responsive">
	  <table class="table table-striped table-sm">
	    <thead>
	      <tr>
	        <th>Nom</th>
	        <th>Description</th>
	        <th>Restauration</th>
	        <th>Suppression</th>
	      </tr>
	    </thead>
	    <tbody>
	      <?php
	      while ($category = $categories_deleted->fetch()) {
	      ?>
	      <tr>
	        <td><h6 class="mt-2 text-left"><a href="<?= BASE_ADMIN_URL.'categoryread/' . $this->clean($category['id']) ?>">
	        <?= $this->clean($category['name']); ?></a></span></td>
					<td><h6 class="mt-2 text-left"><?= $this->clean($category['description']); ?></h6></td>
	        <td><a href="<?= BASE_ADMIN_URL. 'restorethiscategory/' . $this->clean($category['id'])?>" role="button" class="btn btn-sm btn-success">Restaurer</a></td>
	        <td><a href="<?= BASE_ADMIN_URL. 'removecategory/' . $this->clean($category['id'])?>" role="button" class="btn btn-sm btn-danger">Supprimer définitivement</a></td>
	      </tr>
	      <?php
	        }
	      ?>
	    </tbody>
	  </table>
		<div class="d-flex flex-row-reverse btn-toolbar mb-3 mb-md-0">
			<div class="btn-group mr-2">
				<a href="<?= BASE_ADMIN_URL; ?>emptycategories" role="button" class="float-right btn btn-sm btn-dark">Vider la Corbeille</a>
			</div>
		</div>
	</div>
<?php };  ?>
<?php };  ?>
