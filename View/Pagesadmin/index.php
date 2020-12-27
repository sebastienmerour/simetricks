<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('location: '. BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Panneau d\'Administration'; ?>
<?php require('pages_menu.php'); ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="table-responsive">
  <h2 id="lastpages">Pages Publiées</h2>

	  <div class="table-responsive">
	  <table class="table table-striped table-sm">
	    <thead>
	      <tr>
	        <th>Date</th>
	        <th>Auteur</th>
	        <th>Titre</th>
					<th>Brouillon</th>
	        <th>Modification</th>
	        <th>Suppression</th>
	      </tr>
	    </thead>
	    <tbody>
	      <?php
	      while ($page = $pages->fetch()) {
	      ?>
	      <tr>
	        <td><h6 class="mt-2 text-left"><?= $this->clean($page['date_creation_fr']); ?></h6></td>
	        <td><h6 class="mt-2 text-left"><a target="_blank" href="<?= BASE_ADMIN_URL.'users/userread/' . $this->clean($page['id_user']) ?>">
	        <?= $this->clean($page['firstname']); ?>&nbsp;<?= $this->clean($page['name']);?></a></span></td>
	        <td><span class="text-body newstitle"><a href="<?= BASE_ADMIN_URL.'pagesadmin/pageread/' . $this->clean($page['pageid'])?>">
					<h6 class="mt-2 text-left"><?= $this->clean($page['title']); ?></h6></a></span></td>
					<td><?php if ($this->clean($page['draft']) == "yes"){ ?><span class="badge badge-warning">Br.</span><?php };?></td>
	        <td><a href="<?= BASE_ADMIN_URL. 'pagesadmin/pageread/' . $this->clean($page['pageid'])?>" role="button" class="btn btn-sm btn-primary">Modifier</a></td>
	        <td><a href="<?= BASE_ADMIN_URL. 'pagesadmin/movepagetobin/' . $this->clean($page['pageid'])?>" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>
	      </tr>
	      <?php
	        }
	      ?>
	    </tbody>
	  </table>

	  <?php
	  if ($pages_current_page > $number_of_pages_pages) {
	  	require __DIR__ . '/../errors/pages_not_found.php';
	  }
	  else {
	  require('pages_pagination.php');}
	  ?>
	</div>
	</div>
	<?php
	};
	?>
