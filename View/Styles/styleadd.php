<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' | Ajout d\'un nouveau style'; ?>
<?php require('styles_menu.php'); ?>
<?php require __DIR__ . '/../errors/errors.php'; ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="card my-4">
	<h5 class="card-header"><em class="far fa-plus-square mr-1"></em>Ajout d'un <strong>Style</strong></h5>
	<div class="card-body">
		<form action="<?= BASE_ADMIN_URL; ?>styles/createstyle" method="post">
			<div class="form-group">
				<div class="row">
					<div class="col-12">
						<input class="form-control" id="name" name="name" placeholder="Nom du Style" type="text"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<input class="form-control" id="description" name="description" placeholder="Description"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<input class="form-control" id="hexadecimal" name="hexadecimal" placeholder="#"><br>
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
