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
  <div class="table-responsive">
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
        <?= $this->clean($item['firstname']); ?>&nbsp;<?= $this->clean($item['name']);?></a></span></td>
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
  if ($items_current_page > $number_of_items_pages) {
  	require __DIR__ . '/../errors/item_not_found.php';
  }
  else {
  require('extendedcards_pagination.php');}
  ?>
</div>
</div>
<?php
};
?>
