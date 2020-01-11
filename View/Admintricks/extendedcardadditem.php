<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' | Ajout d\'un nouvel article'; ?>
<?php require('extendedcards_menu.php'); ?>
<?php require __DIR__ . '/../errors/errors.php'; ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="card my-4">
	<h5 class="card-header">Ajout d'une <strong>Extended Card</strong></h5>
	<div class="card-body">
		<form action="<?= BASE_ADMIN_URL; ?>createitem" enctype="multipart/form-data" method="post">
			<div class="form-group">
				<div class="row">
					<div class="col-12">
						<input class="form-control" id="title" name="title" placeholder="Titre" type="text"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<label for="date_native">Date de création :</label><br>
						<input class="form-control" id="date_native" name="date_native" type="date"><br>
					</div>
					<div class="col-6">
						<label for="licence">Licence :</label><br>
						<input class="form-control" id="licence" name="licence" placeholder="Licence" type="text"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<label for="sgbdr">SGBDR :</label><br>
						<input class="form-control" id="sgbdr" name="sgbdr" placeholder="SGBDR" type="text"><br>
					</div>
					<div class="col-6">
						<label for="pdm">Part de Marché :</label><br>
						<input class="form-control" id="pdm" name="pdm" placeholder="Part de Marché" type="text"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<label for="langage">Langage :</label><br>
						<input class="form-control" id="langage" name="langage" placeholder="Langage" type="text"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<label for="features">Fonctionnalités :</label><br>
						<textarea class="form-control" id="features" name="features" rows="5">Fonctionnalités...</textarea><br>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<label for="links">Liens :</label><br>
						<textarea class="form-control" id="links" name="links" rows="5">https://</textarea>
						<hr>
						<label for="itemimage"></label>
						<h5><label for="itemimage">Image principale de l'article :</label></h5><br>
						<div class="custom-file">
							<input class="custom-file-input" name="image" type="file"> <label class="custom-file-label" data-browse="Parcourir..." for="image"></label>
						</div><label for="image">(Formats autorisés : JPG, PNG ou GIF | max. 1 Mo)</label> <input name="MAX_FILE_SIZE" type="hidden" value="1048576">
						<hr>
						<textarea class="form-control" id="content" name="content" rows="10">Aux dernières news...</textarea>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12">
					<br>
					<button class="btn btn-md btn-success" name="modify" type="submit">Enregistrer</button>
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
