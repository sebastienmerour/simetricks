<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Modification d\'une Extended Card'; ?>
<?php require('extendedcards_menu.php'); ?>
<?php if (empty($item)) {
							require __DIR__ . '/../errors/item_not_found.php';
			    }
					else {
					require __DIR__ . '/../errors/errors.php'; ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="card my-4">
	<h5 class="card-header">Modification de l'Extended Card <strong><?= $this->clean($item['title']);?></strong></h5>
    <div class="card-body">
				<form role="form" class="form needs-validation" action="<?= BASE_ADMIN_URL; ?>extendedcardsadmin/updateitem/<?= $this->clean($item['itemid']);?>" method="post"
	        id="itemmodification" enctype="multipart/form-data" novalidate>
						<div class="form-group">
							<div class="row">
								<div class="col-12 text-right">
									<h4><label for="draft">Pubication :</label></h4>
									<div class="custom-control custom-switch">
										<input type="checkbox" class="custom-control-input" name="draft" id="draft" <?php if ($this->clean($item['draft']== "no")) {?> checked value="no"<?php } else { ?>value="yes"<?php }; ?>>
										<label class="custom-control-label" for="draft">Activer pour Publier</label>
									</div>
									<br>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<label for="category">Catégorie :</label>
							<select class="form-control" name="category">
								<option selected value="<?= $this->clean($item['category']); ?>" id="<?= $this->clean($item['category']); ?>"><?= $this->clean($item['categoryname']); ?></option>
								<?php
								foreach ($categories as $category):?>
								<option value="<?= $this->clean($category['id']);?>" id="<?= $this->clean($category['id']);?>"><?= $this->clean($category['name']); ?></option>
							<?php endforeach; ?>
						</select><br>
						</div>
					</div>
						<div class="row">
						<div class="col-12">
							<input class="form-control font-weight-bold" id="title" name="title" type="text" placeholder="<?= $this->clean($item['title']);?>" value="<?= $this->clean($item['title']);?>"><br>
							<input class="form-control" id="slug" name="slug" type="text" placeholder="<?= $this->clean($item['slug']);?>" value="<?= $this->clean($item['slug']);?>"><br>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<label for="content">Description :</label><br>
							<textarea rows="5" cols="10" class="form-control" name="content" id="content"
							placeholder="<?= $this->clean($item['content']);?>"
							title="Modifiez la description si besoin"><?= $this->clean($item['content']);?></textarea><br>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<label for="features">Fonctionnalités :</label><br>
							<textarea rows="5" cols="10" class="form-control" name="features" id="features"
							placeholder="<?= $this->clean($item['features']);?>"
							title="Modifiez les fonctionnalités si besoin"><?= $this->clean($item['features']);?></textarea><br>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
					<label for="date_native">Date de création :</label><br>
          <input class="form-control" id="date_native" name="date_native" type="date" value="<?= $this->clean($item['date_native']); ?>"><br>
						</div>
						<div class="col-6">
					<label for="year_native">Année de création :</label><br>
					<input class="form-control" id="year_native" name="year_native" type="text" placeholder="<?= $this->clean($item['year_native']);?>" value="<?= $this->clean($item['year_native']);?>"><br>
						</div>
				</div>
				<div class="row">
					<div class="col-6">
						<label for="owner">Créateur :</label><br>
						<input class="form-control" id="owner" name="owner" type="text" placeholder="<?= $this->clean($item['owner']);?>" value="<?= $this->clean($item['owner']);?>"><br>
					</div>
					<div class="col-6">
						<label for="os_supported">OS supportés :</label><br>
						<input class="form-control" id="os_supported" name="os_supported" type="text" placeholder="<?= $this->clean($item['os_supported']);?>" value="<?= $this->clean($item['os_supported']);?>"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<label for="version">Version :</label><br>
						<input class="form-control" id="version" name="version" type="text" placeholder="<?= $this->clean($item['version']);?>" value="<?= $this->clean($item['version']);?>"><br>
					</div>
					<div class="col-6">
						<label for="licence">Licence :</label><br>
						<input class="form-control" id="licence" name="licence" type="text" placeholder="<?= $this->clean($item['licence']);?>" value="<?= $this->clean($item['licence']);?>"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<label for="sgbdr">Langage :</label><br>
						<input class="form-control" id="langage" name="langage" type="text" placeholder="<?= $this->clean($item['langage']);?>" value="<?= $this->clean($item['langage']);?>"><br>
					</div>
					<div class="col-6">
						<label for="sgbdr">SGBDR :</label><br>
						<input class="form-control" id="sgbdr" name="sgbdr" placeholder="<?= $this->clean($item['sgbdr']);?>" value="<?= $this->clean($item['sgbdr']);?>" type="text"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<label for="number_of_users">Nombre d'utilisateurs :</label><br>
						<input class="form-control" id="number_of_users" name="number_of_users" placeholder="<?= $this->clean($item['number_of_users']);?>" value="<?= $this->clean($item['number_of_users']);?>" type="text"><br>
					</div>
					<div class="col-6">
						<label for="pdm">Part de Marché :</label><br>
						<input class="form-control" id="pdm" name="pdm" placeholder="<?= $this->clean($item['pdm']);?>" value="<?= $this->clean($item['pdm']);?>" type="text"><br>
					</div>
				</div>
				<div class="row">
				<div class="col-12">
					<label for="links">Liens :</label><br>
					<div class="wrapper">
						<?php foreach ($links as $link): ?>
					<div class="row">
						<div class="col-6">
							<label for="linkname">Nom du site :</label><br>
							<input class="form-control" id="linkname" name="linkname[]" placeholder="<?= $this->clean($link['name']);?>" type="text"><br>
						</div>
						<div class="col-6">
							<label for="linkurl">URL</label><br>
							<input class="form-control" id="linkurl" name="linkurl[]" placeholder="<?= $this->clean($link['url']);?>" type="url"><br>
						</div>
					</div>
				<?php endforeach; ?>
				</div>
						<hr>
						<label for="itemimage"><h5>Image principale de l'Extended Card :</h5></label><br>
						<?php if (empty($item['image'])) {
								echo '<p>Il n\'y a pas d\'image pour cette Extended Card. Ajoutez une image ci-dessous :</p>';
						} else {
							?>
							<figure class="figure">
							<img src="<?= BASE_URL; ?>public/images/extendedcard_images/<?= $this->clean($item['image']);?>" class="figure-img img-fluid rounded-right"
							alt="<?= $this->clean($item['title']); ?>" title="<?= $this->clean($item['title']);?>">
							<figcaption class="figure-caption text-right"><?= $this->clean($item['title']); ?></figcaption>
							</figure>
							<?php
							};
							?>
						<div class="custom-file">
						<input type="file" name="image" class="custom-file-input" id="uploadimage">
						<label class="custom-file-label" data-browse="Parcourir..." for="image"></label>
						</div>
						<label for="image">(Formats autorisés : JPG, PNG ou GIF | max. 1 Mo)</label>
						<input type="hidden" name="MAX_FILE_SIZE" value="1048576">
						<hr>
						<h5><label for="last_news">Aux dernières news :</label></h5>
						<textarea rows="15" cols="10" class="form-control" name="last_news" id="last_news"
						placeholder="<?= $this->clean($item['last_news']);?>"
						title="Modifiez l'extended card si besoin"><?= $this->clean($item['last_news']);?></textarea>
				</div>
			</div>
		</div>
		<div class="form-group">
				 <div class="col-xs-12">
							<br>
							<button class="btn btn-md btn-success" name="update" type="submit">Enregistrer</button>
							<a href="#" role="button" class="btn btn-md btn-secondary" type="reset">Annuler</a>
							<a href="<?= BASE_ADMIN_URL. 'extendedcardsadmin/removeitem/' . $this->clean($item['itemid'])?>" role="button" class="btn btn-md btn-danger">Supprimer définitivement</a>
							<a href="<?= $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-md btn-primary" type="button">Retour</a>
						</div>
			</div>
		</form>
	</div>
</div>

<?php
};
};
?>
