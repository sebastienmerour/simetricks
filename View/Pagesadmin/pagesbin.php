<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('location: '. BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Panneau d\'Administration'; ?>
<?php require('pages_menu.php'); ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
  <h2 id="pagesbin">Corbeille</h2>
  <?php
  if ($pages_deleted_current_page > $number_of_pages_deleted_pages) {
  	require __DIR__ . '/../errors/empty_bin.php';
  }
  else {?>
		<div class="table-responsive">
	  <table class="table table-striped table-sm">
	    <thead>
	      <tr>
	        <th>Date</th>
	        <th>Auteur</th>
	        <th>Titre</th>
	        <th>Restauration</th>
	        <th>Suppression</th>
	      </tr>
	    </thead>
	    <tbody>
	      <?php
	      while ($page = $pages_deleted->fetch()) {
	      ?>
	      <tr>
	        <td><h6 class="mt-2 text-left"><?= $this->clean($page['date_creation_fr']); ?></h6></td>
	        <td><h6 class="mt-2 text-left"><a target="_blank" href="<?= BASE_ADMIN_URL.'users/userread/' . $this->clean($page['id_user']) ?>">
	        <?= $this->clean($page['firstname']); ?>&nbsp;<?= $this->clean($page['name']);?></a></span></td>
	        <td><span class="text-body newstitle"><a href="<?= BASE_ADMIN_URL.'pagesadmin/pageread/' . $this->clean($page['pageid'])?>">
					<h6 class="mt-2 text-left"><?= $this->clean($page['title']); ?></h6></a></span></td>
	        <td><a href="<?= BASE_ADMIN_URL. 'pagesadmin/restorethispage/' . $this->clean($page['pageid'])?>" role="button" class="btn btn-sm btn-success">Restaurer</a></td>
	        <td><a href="<?= BASE_ADMIN_URL. 'pagesadmin/removepage/' . $this->clean($page['pageid'])?>" role="button" class="btn btn-sm btn-danger">Supprimer définitivement</a></td>
	      </tr>
	      <?php
	        }
	      ?>
	    </tbody>
	  </table>
		<?php require('pagesbin_pagination.php');  ?>
		<div class="d-flex flex-row-reverse btn-toolbar mb-3 mb-md-0">
			<div class="btn-group mr-2">
				<a href="<?= BASE_ADMIN_URL; ?>pagesadmin/emptypages" role="button" class="float-right btn btn-sm btn-dark">Vider la Corbeille</a>
			</div>
		</div>
	</div>
<?php };  ?>
<?php };  ?>
