<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Modification d\'une style'; ?>
<?php require('styles_menu.php'); ?>
<?php if (empty($style)) {
							require __DIR__ . '/../errors/style_not_found.php';
			    }
					else {
					require __DIR__ . '/../errors/errors.php'; ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="card my-4">
	<h5 class="card-header">Modification du Style <strong><?= $this->clean($style['name']);?></strong></h5>
    <div class="card-body">
			<form role="form" class="form needs-validation" action="<?= BASE_ADMIN_URL; ?>styles/updatestyle/<?= $this->clean($style['id']);?>" method="post"
	        id="stylemodification" novalidate>
				<div class="form-group">
					<div class="row">
						<div class="col-12">
							<input class="form-control" id="name" name="name" type="text" placeholder="<?= $this->clean($style['name']);?>" value="<?= $this->clean($style['name']);?>"><br>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<input class="form-control" id="description" name="description" type="text" placeholder="<?= $this->clean($style['description']);?>" value="<?= $this->clean($style['description']);?>"><br>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<input class="form-control" id="hexadecimal" name="hexadecimal" type="text" placeholder="<?= $this->clean($style['hexadecimal']);?>" value="<?= $this->clean($style['hexadecimal']);?>"><br>
					</div>
				</div>
				<div class="form-group">
				 	<div class="col-xs-12">
							<br>
							<button class="btn btn-md btn-success" name="update" type="submit">Enregistrer</button>
							<a href="#" role="button" class="btn btn-md btn-secondary" type="reset">Annuler</a>
							<a href="<?= BASE_ADMIN_URL. 'styles/removestyle/' . $this->clean($style['id'])?>" role="button" class="btn btn-md btn-danger">Supprimer définitivement</a>
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
