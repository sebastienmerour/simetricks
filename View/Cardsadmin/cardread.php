<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Modification d\'une Card'; ?>
<?php require('cards_menu.php'); ?>
<?php if (empty($card)) {
							require __DIR__ . '/../errors/card_not_found.php';
			    }
					else {
					require __DIR__ . '/../errors/errors.php'; ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="card my-4">
	<h5 class="card-header">Modification de la Card <strong><?= $this->clean($card['title']);?></strong></h5>
    <div class="card-body">
				<form role="form" class="form needs-validation" action="<?= BASE_ADMIN_URL; ?>cardsadmin/updatecard/<?= $this->clean($card['id']);?>" method="post"
	        id="cardmodification" enctype="multipart/form-data" novalidate>
					<div class="form-group">
						<div class="row">
							<div class="col-12">
								<input class="form-control font-weight-bold" id="title" name="title" type="text" placeholder="<?= $this->clean($card['title']);?>" value="<?= $this->clean($card['title']);?>"><br>
								<input class="form-control" id="slug" name="slug" type="text" placeholder="<?= $this->clean($card['slug']);?>" value="<?= $this->clean($card['slug']);?>"><br>
							</div>
						</div>
					<div class="row">
						<div class="col-12">
							<label for="cardimage"><h5>Image principale de la Card :</h5></label><br>
								<?php if (empty($card['image'])) {
								echo '<p>Il n\'y a pas d\'image pour cette Card. Ajoutez une image ci-dessous :</p>';
								} else {
									?>
							<figure class="figure">
							<img src="<?= BASE_URL; ?>public/images/card_images/<?= $this->clean($card['image']);?>" class="figure-img img-fluid rounded-right"
							alt="<?= $this->clean($card['title']); ?>" title="<?= $this->clean($card['title']);?>">
							<figcaption class="figure-caption text-right"><?= $this->clean($card['title']); ?></figcaption>
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
						<h5><label for="content">Contenu :</label></h5>
								<textarea rows="15" cols="10" class="form-control" name="content" id="content"
								placeholder="<?= $this->clean($card['content']);?>"
								title="Modifiez la Card si besoin"><?= $this->clean($card['content']);?></textarea>
				</div>
			</div>
		</div>
		<div class="form-group">
				 <div class="col-xs-12">
							<br>
							<button class="btn btn-md btn-success" name="update" type="submit">Enregistrer</button>
							<a href="#" role="button" class="btn btn-md btn-secondary" type="reset">Annuler</a>
							<a href="<?= BASE_ADMIN_URL. 'cardsadmin/removecard/' . $this->clean($card['id'])?>" role="button" class="btn btn-md btn-danger">Supprimer définitivement</a>
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
