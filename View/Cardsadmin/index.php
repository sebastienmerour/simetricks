<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('location: '. BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Panneau d\'Administration'; ?>
<?php require('cards_menu.php'); ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="table-responsive">
  <h2 id="lastcards">Cards Publiées</h2>
  <div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Date</th>
				<th>Image</th>
        <th>Titre</th>
        <th>Modification</th>
        <th>Suppression</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($card = $cards->fetch()) {
      ?>
      <tr>
        <td><h6 class="mt-2 text-left"><?= $this->clean($card['date_creation_fr']); ?></h6></td>
				<td><a href="<?= BASE_ADMIN_URL.'cardsadmin/cardread/' . $this->clean($card['id'])?>">
				<img width="125px" src="<?= BASE_URL. 'public/images/card_images/' .$this->clean($card['image'])?>" class="figure-img img-fluid rounded-right"
				alt="<?= $this->clean($card['title']) ?>" title="<?= $this->clean($card['title']) ?>"></a></td>
        <td><span class="text-body newstitle"><a href="<?= BASE_ADMIN_URL.'cardsadmin/cardread/' . $this->clean($card['id'])?>">
				<h6 class="mt-2 text-left"><?= $this->clean($card['title']); ?></h6></a></span></td>
        <td><a href="<?= BASE_ADMIN_URL. 'cardsadmin/cardread/' . $this->clean($card['id'])?>" role="button" class="btn btn-sm btn-primary">Modifier</a></td>
        <td><a href="<?= BASE_ADMIN_URL. 'cardsadmin/movecardtobin/' . $this->clean($card['id'])?>" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>
      </tr>
      <?php
        }
      ?>
    </tbody>
  </table>

  <?php
  if ($cards_current_page > $number_of_cards_pages) {
  	require __DIR__ . '/../errors/card_not_found.php';
  }
  else {
  require('cards_pagination.php');}
  ?>
</div>
</div>
<?php
};
?>
