<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('location: '. BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Panneau d\'Administration'; ?>
<?php require('cards_menu.php'); ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
  <h2 id="cardsbin">Corbeille</h2>
  <?php
  if ($cards_deleted_current_page > $number_of_cards_deleted_pages) {
		require __DIR__ . '/../errors/empty_bin.php';
  }
  else {?>
		<div class="table-responsive">
	  <table class="table table-striped table-sm">
	    <thead>
	      <tr>
	        <th>Date</th>
					<th>Image</th>
	        <th>Titre</th>
	        <th>Restauration</th>
	        <th>Suppression</th>
	      </tr>
	    </thead>
	    <tbody>
	      <?php
	      while ($card = $cards_deleted->fetch()) {
	      ?>
	      <tr>
	        <td><h6 class="mt-2 text-left"><?= $this->clean($card['date_creation_fr']); ?></h6></td>
					<td><a href="<?= BASE_ADMIN_URL.'cardsadmin/cardread/' . $this->clean($card['id'])?>">
					<img width="125px" src="<?= BASE_URL. 'public/images/card_images/' .$this->clean($card['image'])?>" class="figure-img img-fluid rounded-right"
					alt="<?= $this->clean($card['title']) ?>" title="<?= $this->clean($card['title']) ?>"></a></td>
	        <td><span class="text-body newstitle"><a href="<?= BASE_ADMIN_URL.'cardsadmin/cardread/' . $this->clean($card['id'])?>">
					<h6 class="mt-2 text-left"><?= $this->clean($card['title']); ?></h6></a></span></td>
	        <td><a href="<?= BASE_ADMIN_URL. 'cardsadmin/restorethiscard/' . $this->clean($card['id'])?>" role="button" class="btn btn-sm btn-success">Restaurer</a></td>
	        <td><a href="<?= BASE_ADMIN_URL. 'cardsadmin/removecard/' . $this->clean($card['id'])?>" role="button" class="btn btn-sm btn-danger">Supprimer définitivement</a></td>
	      </tr>
	      <?php
	        }
	      ?>
	    </tbody>
	  </table>
		<?php require('cardsbin_pagination.php');  ?>
		<div class="d-flex flex-row-reverse btn-toolbar mb-3 mb-md-0">
			<div class="btn-group mr-2">
				<a href="<?= BASE_ADMIN_URL; ?>cardsadmin/emptycards" role="button" class="float-right btn btn-sm btn-dark">Vider la Corbeille</a>
			</div>
		</div>
	</div>
<?php };  ?>
<?php };  ?>
