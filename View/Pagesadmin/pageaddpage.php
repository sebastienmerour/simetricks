<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' | Ajout d\'une nouvelle page'; ?>
<?php require('pages_menu.php'); ?>
<?php require __DIR__ . '/../errors/errors.php'; ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="card my-4">
	<h5 class="card-header">Ajout d'une <strong>Page</strong></h5>
	<div class="card-body">
		<form id="repeater_form" action="<?= BASE_ADMIN_URL; ?>pagesadmin/createpage" enctype="multipart/form-data" method="post">
			<div class="form-group">
				<div class="row">
					<div class="col-12 text-right">
						<h4><label for="draft">Pubication :</label></h4>
						<div class="custom-control custom-switch">
						  <input type="checkbox" class="custom-control-input" name="draft" id="draft" value="Y">
						  <label class="custom-control-label" for="draft">Activer pour Publier</label>
						</div>
					<br>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<input class="form-control font-weight-bold" id="title" name="title" placeholder="Titre" type="text"><br>
						<input class="form-control" id="slug" name="slug" placeholder="Slug" type="text"><br>
					</div>
				</div>
        <div class="row">
					<div class="col-12">
						<label for="content">Description :</label><br>
						<textarea class="form-control" id="content" name="content" rows="5"></textarea><br>
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
