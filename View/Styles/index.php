<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('location: '. BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Panneau d\'Administration'; ?>
<?php require('styles_menu.php'); ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="table-responsive">
  <h2 id="lastitems">Styles Publiés</h2>
  <div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Nom</th>
        <th>Description</th>
				<th>Couleur</th>
				<th>Modification</th>
        <th>Suppression</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($style = $styles->fetch()) {
      ?>
      <tr>
        <td><h6 class="mt-2 text-left"><a href="<?= BASE_ADMIN_URL.'styles/styleread/' . $this->clean($style['id']) ?>">
        <?= $this->clean($style['name']); ?></a></span></td>
				<td><h6 class="mt-2 text-left"><?= $this->clean($style['description']); ?></h6></td>
				<td><h6 class="mt-2 mr-3 btn-sm rounded text-white" style="background-color:<?= $this->clean($style['hexadecimal']); ?>"><?= $this->clean($style['description']); ?>&nbsp;</h6></td>
				<td><a href="<?= BASE_ADMIN_URL. 'styles/styleread/' . $this->clean($style['id'])?>" role="button" class="mt-2 btn btn-sm btn-primary">Modifier</a></td>
        <td><a href="<?= BASE_ADMIN_URL. 'styles/movestyletobin/' . $this->clean($style['id'])?>" role="button" class="mt-2 btn btn-sm btn-danger">Supprimer</a></td>
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
