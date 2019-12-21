<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' | Ajout d\'un nouvel article'; ?>
<?php require __DIR__ . '/../errors/errors.php'; ?>

<!-- Ajout  d'un nouvel article via TINYMCE -->
<div class="card my-4">
  <h5 class="card-header">Ajout d'un nouvel article</h5>
    <div class="card-body">
			<form action="<?= BASE_ADMIN_URL; ?>createitem" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <input class="form-control" id="title" name="title" type="text" placeholder="Titre"><br>
						<hr>
				 	<label for="itemimage"><h5>Image principale de l'article :</h5></label><br>
					<div class="custom-file">
					<input type="file" name="image" class="custom-file-input">
					<label class="custom-file-label" for="customFile">Parcourir...</label>
					</div>
					<label for="image">(Formats autorisés : JPG, PNG ou GIF | max. 1 Mo)</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="1048576">
					<hr>
					<textarea class="form-control" id="content" name="content" rows="10">Ecrivez ici votre article</textarea>
				</div>
				<button class="btn btn-md btn-success" name="modify" type="submit">Enregistrer</button>
				<input class="btn btn-md btn-secondary" type="reset" value="Annuler">
				<a href="<?= BASE_ADMIN_URL; ?>" role="button" class="btn btn-md btn-primary">Retour</a>
</form>
</div>
</div>
<?php
};
?>