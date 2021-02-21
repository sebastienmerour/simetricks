<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' | Ajout d\'un nouvel article'; ?>
<?php require('cards_menu.php'); ?>
<?php require __DIR__ . '/../errors/errors.php'; ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="card my-4">
	<h5 class="card-header"><em class="far fa-plus-square mr-1"></em>Ajout d'une <strong>Card</strong></h5>
	<div class="card-body">
		<form id="repeater_form" action="<?= BASE_ADMIN_URL; ?>cardsadmin/createcard" enctype="multipart/form-data" method="post">
			<div class="form-group">
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
						<label for="style">Style :</label><br>
							<?php
							foreach ($styles as $style):?>
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="style" value="<?= $this->clean($style['id']);?>" id="<?= $this->clean($style['id']);?>">
							  <label class="form-check-label btn-sm rounded text-white" style="background-color:<?= $this->clean($style['hexadecimal']); ?>" for="<?= $this->clean($style['id']);?>">
							    <?= $this->clean($style['description']); ?>
							  </label>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<hr>
						<label for="cardimage"></label>
						<h5><label for="cardimage">Image principale de l'article :</label></h5>
						<div class="custom-file">
							<input class="custom-file-input" name="image" type="file" id="uploadimage"> <label class="custom-file-label" data-browse="Parcourir..." for="image"></label>
						</div><label for="image">(Formats autorisés : JPG, PNG ou GIF | max. 1 Mo)</label> <input name="MAX_FILE_SIZE" type="hidden" value="1048576">
						<hr>
						<label for="definition"><h5>Définition :</h5></label><br>
						<input class="form-control" id="definition" name="definition" type="text"><br>
						<h5><label for="content">Contenu :</label></h5>
						<textarea class="form-control" id="content" name="content" rows="10">Aux dernières news...</textarea>
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
