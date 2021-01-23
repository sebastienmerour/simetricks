<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('location: '. BASE_ADMIN_URL);
	}
	else {
?>

<?php $this->title =  WEBSITE_NAME . ' |  Panneau d\'Administration'; ?>
<?php require('extendedcards_menu.php'); ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="table-responsive">
  <h2 id="lastitems">Extended Cards Publiées</h2>
	<div>
		<select id="items-list" class="form-select mt-4 mb-4 custom-select" autocomplete="off">
				<?php
        if (isset($_GET['catid']) && is_numeric($_GET['catid'])) {
            $id_category = intval($_GET['catid']);
            echo '<option data-url="'.BASE_ADMIN_URL.'extendedcardsadmin/'.$category['catid'].'/1" value = "'.$category['catid'].'">'.$category['name'].'</option>
            <option data-url="'.BASE_ADMIN_URL.'extendedcardsadmin/">Supprimer le Filtre</option>';
}
						else {?><option>Supprimer le filtre</option><?php
	}				?>
			</select>
	</div>

	<img width="30px" src="<?php echo BASE_URL; ?>public/images/icons/loading.gif" id="loader">
	<div id="items-data"></div>
	<?php
	if ($number_of_items == 0 AND $id_category > 0) {
		echo "<h3>Aucune Extended Card dans cette Catégorie</h3>";
	}
	else{?>
	<div id="items-default" class="table-responsive">
		<table class="table table-striped table-sm">
					<thead>
						<tr>
							<th>Date</th>
							<th>Auteur</th>
							<th>Image</th>
							<th>Titre</th>
							<th>Brouillon</th>
							<th>Modification</th>
							<th>Suppression</th>
						</tr>
					</thead>
					<tbody>

	      <?php
	      while ($item = $items->fetch()) {
					?>
	      	<tr>
	        <td><h6 class="mt-2 text-left"><?= $this->clean($item['date_creation_fr']); ?></h6></td>
	        <td><h6 class="mt-2 text-left"><a target="_blank" href="<?= BASE_ADMIN_URL.'users/userread/' . $this->clean($item['id_user']) ?>">
	        <?= $this->clean($item['firstname']); ?>&nbsp;<?= $this->clean($item['name']);?></a></td>
					<td><a href="<?= BASE_ADMIN_URL.'extendedcardsadmin/extendedcardread/' . $this->clean($item['itemid'])?>">
					<img width="125px" src="<?= BASE_URL. 'public/images/extendedcard_images/' .$this->clean($item['image'])?>" class="figure-img img-fluid rounded-right"
					alt="<?= $this->clean($item['title']) ?>" title="<?= $this->clean($item['title']) ?>"></a></td>
	        <td><span class="text-body newstitle"><a href="<?= BASE_ADMIN_URL.'extendedcardsadmin/extendedcardread/' . $this->clean($item['itemid'])?>">
					<h6 class="mt-2 text-left"><?= $this->clean($item['title']); ?></h6></a></span></td>
					<td><?php if ($this->clean($item['draft']) == "yes"){ ?><span class="badge badge-warning">Br.</span><?php };?></td>
	        <td><a href="<?= BASE_ADMIN_URL. 'extendedcardsadmin/extendedcardread/' . $this->clean($item['itemid'])?>" role="button" class="btn btn-sm btn-primary">Modifier</a></td>
	        <td><a href="<?= BASE_ADMIN_URL. 'extendedcardsadmin/moveitemtobin/' . $this->clean($item['itemid'])?>" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>
	      </tr>
	      <?php
	        }
	      ?>
	    </tbody>
	  </table>

	  <?php

	  require('filtercategory_pagination.php');
	};
	  ?>
	</div>
	</div>

	<?php
	};
	?>
