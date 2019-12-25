<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' | Ajout d\'un nouvel article'; ?>
<?php require __DIR__ . '/../errors/errors.php'; ?>

<div class="card my-4">
	<h5 class="card-header">Ajout d'une <strong>Extended Card</strong></h5>
    <div class="card-body">
			<form action="<?= BASE_ADMIN_URL; ?>createitem" method="post" enctype="multipart/form-data">
				<div class="form-group">
						<div class="row">
						<div class="col-12">
							<input class="form-control" id="title" name="title" type="text" placeholder="Titre"><br>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
					<label for="date_native">Date de création :</label><br>
          <input class="form-control" id="date_native" name="date_native" type="date"><br>
				</div>

					<div class="col-6">
					<label for="licence">Licence :</label><br>
					<input class="form-control" id="licence" name="licence" type="text" placeholder="Licence"><br>
					</div>
				</div>
				<div class="row">
				<div class="col-12">
					<input class="form-control" id="langage" name="langage" type="text" placeholder="Langage"><br>
					<label for="links">Liens :</label><br>
					<textarea class="form-control" id="links" name="links" rows="5">https://</textarea>
						<hr>
				 	<label for="itemimage"><h5>Image principale de l'article :</h5></label><br>
					<div class="custom-file">
					<input type="file" name="image" class="custom-file-input">
					<label class="custom-file-label" data-browse="Parcourir..." for="image"></label>

					</div>
					<label for="image">(Formats autorisés : JPG, PNG ou GIF | max. 1 Mo)</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="1048576">
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
