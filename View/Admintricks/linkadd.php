<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' | Ajout d\'un nouveau Lien'; ?>
<?php require('links_menu.php'); ?>
<?php require __DIR__ . '/../errors/errors.php'; ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="card my-4">
	<h5 class="card-header">Ajout d'un <strong>Lien</strong></h5>
	<div class="card-body">
		<form action="<?= BASE_ADMIN_URL; ?>createlink" method="post">
			<div class="form-group">
				<div class="row">
					<div class="col-12">
						<input class="form-control" id="id_item" name="id_item" placeholder="ID de l'Extended Card" type="text">
						<small id="id_item" class="form-text text-muted">
						  &nbsp;<strong>Attention : </strong>renseigner l'ID d'une Extended Card déjà publiée. Ne rentrer qu'une valeur numérique uniquement.
						</small><br>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<input class="form-control" id="name" name="name" placeholder="Nom du Lien" type="text"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<input class="form-control" id="url" name="url" placeholder="http://" type="url"><br>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12">
					<br>
					<button class="btn btn-md btn-success" name="create" type="submit">Enregistrer</button>
					<input class="btn btn-md btn-secondary" type="reset" value="Annuler">
					<a href="<?= $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-md btn-primary">Retour</a>
				</div>
			</div>
		</form>
	</div>
</div>
<?php
};
?>
