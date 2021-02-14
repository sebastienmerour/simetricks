<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Modification d\'une Page'; ?>
<?php require('pages_menu.php'); ?>
<?php require __DIR__ . '/../errors/errors.php'; ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="card my-4">
	<h5 class="card-header">Modification de la Page <strong><?= $this->clean($page['title']);?></strong></h5>
    <div class="card-body">
				<form role="form" class="form needs-validation" action="<?= BASE_ADMIN_URL; ?>pagesadmin/updatepage/<?= $this->clean($page['pageid']);?>" method="post"
	        id="pagemodification" enctype="multipart/form-data" novalidate>
						<div class="form-group">
							<div class="row">
								<div class="col-12 text-right">
									<h4><label for="draft">Pubication :</label></h4>
									<div class="custom-control custom-switch">
										<input type="checkbox" class="custom-control-input" name="draft" id="draft" <?php if ($this->clean($page['draft']== "no")) {?> checked value="no"<?php } else { ?>value="yes"<?php }; ?>>
										<label class="custom-control-label" for="draft">Activer pour Publier</label>
									</div>
									<br>
						</div>
					</div>
						<div class="row">
						<div class="col-12">
							<input class="form-control font-weight-bold" id="title" name="title" type="text" placeholder="<?= $this->clean($page['title']);?>" value="<?= $this->clean($page['title']);?>"><br>
							<input class="form-control" id="slug" name="slug" type="text" placeholder="<?= $this->clean($page['slug']);?>" value="<?= $this->clean($page['slug']);?>"><br>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<label for="content">Description :</label><br>
							<textarea rows="5" cols="10" class="form-control" name="content" id="content"
							placeholder="<?= $this->clean($page['content']);?>"
							title="Modifiez la description si besoin"><?= $this->clean($page['content']);?></textarea><br>
						</div>
					</div>
		</div>
		<div class="form-group">
				 <div class="col-xs-12">
							<br>
							<button class="btn btn-md btn-success" name="update" type="submit">Enregistrer</button>
							<a href="#" role="button" class="btn btn-md btn-secondary" type="reset">Annuler</a>
							<a href="<?= BASE_ADMIN_URL. 'pagesadmin/removepage/' . $this->clean($page['pageid'])?>" role="button" class="btn btn-md btn-danger">Supprimer définitivement</a>
							<a href="<?= $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-md btn-primary" type="button">Retour</a>
						</div>
			</div>
		</form>
	</div>
</div>

<?php
};
?>
