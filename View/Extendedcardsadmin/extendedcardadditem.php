<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' | Ajout d\'une nouvelle extended card'; ?>
<?php require('extendedcards_menu.php'); ?>
<?php require __DIR__ . '/../errors/errors.php'; ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="card my-4">
	<h5 class="card-header">Ajout d'une <strong>Extended Card</strong></h5>
	<div class="card-body">
		<form id="repeater_form" action="<?= BASE_ADMIN_URL; ?>extendedcardsadmin/createitem" enctype="multipart/form-data" method="post">
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
						<label for="category">Catégorie :</label>
						<select class="form-control" id="category" name="category">
							<option selected>Sélectionnez une catégorie</option>
							<?php
							foreach ($categories as $category):?>
							<option value="<?= $this->clean($category['id']);?>" id="<?= $this->clean($category['id']);?>"><?= $this->clean($category['name']); ?></option>
						<?php endforeach; ?>
					</select><br>
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
						<textarea class="form-control" id="content" name="content" rows="5">Description...</textarea><br>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<label for="features">Fonctionnalités :</label><br>
						<textarea class="form-control" id="features" name="features" rows="5">Fonctionnalités...</textarea><br>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<label for="date_native">Date de création :</label><br>
						<input class="form-control" id="date_native" name="date_native" type="date"><br>
					</div>
					<div class="col-6">
						<label for="year_native">Année de création :</label><br>
						<input class="form-control" id="year_native" name="year_native" type="text"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<label for="owner">Créateur :</label><br>
						<input class="form-control" id="owner" name="owner" placeholder="Créateur" type="text"><br>
					</div>
					<div class="col-6">
						<label for="os_supported">OS supportés :</label><br>
						<input class="form-control" id="os_supported" name="os_supported" placeholder="OS supportés" type="text"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<label for="version">Version :</label><br>
						<input class="form-control" id="version" name="version" placeholder="Version" type="text"><br>
					</div>
					<div class="col-6">
						<label for="licence">Licence :</label><br>
						<input class="form-control" id="licence" name="licence" placeholder="Licence" type="text"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<label for="langage">Langage :</label><br>
						<input class="form-control" id="langage" name="langage" placeholder="Langage" type="text"><br>
					</div>
					<div class="col-6">
						<label for="sgbdr">SGBDR :</label><br>
						<input class="form-control" id="sgbdr" name="sgbdr" placeholder="SGBDR" type="text"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<label for="number_of_users">Nombre d'utilisateurs :</label><br>
						<input class="form-control" id="number_of_users" name="number_of_users" placeholder="Nombre d'utilisateurs" type="text"><br>
					</div>
					<div class="col-6">
						<label for="pdm">Part de Marché :</label><br>
						<input class="form-control" id="pdm" name="pdm" placeholder="Part de Marché" type="text"><br>
					</div>
				</div>
				<label for="links">Liens :</label><br>
				<div class="wrapper">
				<div class="row">
					<div class="col-4">
						<label for="linkname">Nom du site :</label><br>
						<input class="form-control" id="linkname" name="linkname[]" placeholder="Nom du site" type="text"><br>
					</div>
					<div class="col-4">
						<label for="linkurl">URL</label><br>
						<input class="form-control" id="linkurl" name="linkurl[]" placeholder="http://" type="url"><br>
					</div>
					<div class="col-4">
						<label for="addlinks">Ajout / Suppression de liens</label><br>
						<p><button class="btn btn-md btn-success add_fields">+</button></p>
					</div>
				</div>
			</div>

				<div class="">
				</div>
					<div class="row">
					<div class="col-12">
						<hr>
						<label for="itemimage"></label>
						<h5><label for="itemimage">Image principale de l'extended card :</label></h5>
						<div class="custom-file">
							<input class="custom-file-input" name="image" type="file" id="uploadimage"> <label class="custom-file-label" data-browse="Parcourir..." for="image"></label>
						</div><label for="image">(Formats autorisés : JPG, PNG ou GIF | max. 1 Mo)</label> <input name="MAX_FILE_SIZE" type="hidden" value="1048576">
						<hr>
						<h5><label for="last_news">Aux dernières news :</label></h5>
						<textarea class="form-control" id="last_news" name="last_news" rows="10">Aux dernières news...</textarea>
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
