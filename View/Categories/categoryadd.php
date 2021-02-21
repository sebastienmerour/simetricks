<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' | Ajout d\'une nouvelle catégorie'; ?>
<?php require('categories_menu.php'); ?>
<?php require __DIR__ . '/../errors/errors.php'; ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="card my-4">
	<h5 class="card-header"><em class="far fa-plus-square mr-1"></em>Ajout d'une <strong>Catégorie</strong></h5>
	<div class="card-body">
		<form action="<?= BASE_ADMIN_URL; ?>categories/createcategory" method="post">
			<div class="form-group">
				<div class="row">
					<div class="col-12">
						<input class="form-control" id="name" name="name" placeholder="Nom de la Catégorie" type="text"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<input class="form-control" id="slugcategory" name="slugcategory" placeholder="Slug de la Catégorie" type="text"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<textarea class="form-control" id="description" name="description" rows="5">Description</textarea>
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
