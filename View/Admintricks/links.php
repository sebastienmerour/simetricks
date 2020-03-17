<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('location: '. BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Panneau d\'Administration'; ?>
<?php require('links_menu.php'); ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="table-responsive">
  <h2 id="lastitems">Liens Publiés</h2>
  <div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Nom</th>
        <th>URL</th>
				<th>Extended Card ID</th>
				<th>Modification</th>
        <th>Suppression</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($link = $links->fetch()) {
      ?>
      <tr>
        <td><h6 class="mt-2 text-left"><a href="<?= BASE_ADMIN_URL.'linkread/' . $this->clean($link['id']) ?>">
        <?= $this->clean($link['name']); ?></a></span></td>
				<td><h6 class="mt-2 text-left"><?= $this->clean($link['url']); ?></h6></td>
				<td><h6 class="mt-2 text-left"><a href="<?= BASE_URL.'item/' . $this->clean($link['extended_cards']) ?>/1" target="_blank"><button type="button" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="right" title="<?= $this->clean($link['title']); ?>"><?= $this->clean($link['extended_cards']); ?></button></a></span></td>
				<td><a href="<?= BASE_ADMIN_URL. 'linkread/' . $this->clean($link['id'])?>" role="button" class="btn btn-sm btn-primary">Modifier</a></td>
        <td><a href="<?= BASE_ADMIN_URL. 'movelinktobin/' . $this->clean($link['id'])?>" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>
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
