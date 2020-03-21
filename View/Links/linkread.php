<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Modification d\'un lien'; ?>
<?php require('links_menu.php'); ?>
<?php if (empty($link)) {
							require __DIR__ . '/../errors/link_not_found.php';
			    }
					else {
					require __DIR__ . '/../errors/errors.php'; ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="card my-4">
	<h5 class="card-header">Modification du Lien <strong><?= $this->clean($link['name']);?></strong></h5>
    <div class="card-body">
				<form role="form" class="form needs-validation" action="<?= BASE_ADMIN_URL; ?>links/updatelink/<?= $this->clean($link['id']);?>" method="post"
	        id="linkmodification" novalidate>
				<div class="form-group">
					<div class="row">
					<div class="col-12">
						<input class="form-control" id="id_item" name="id_item" type="text" value="<?= $this->clean($link['id_item']);?>">
						<small id="id_item" class="form-text text-muted">
						  &nbsp;<strong>Attention : </strong>renseigner l'ID d'une Extended Card déjà publiée. Ne rentrer qu'une valeur numérique uniquement.
						</small><br>
					</div>
					</div>
						<div class="row">
						<div class="col-12">
							<input class="form-control" id="name" name="name" type="text" value="<?= $this->clean($link['name']);?>"><br>
						</div>
					</div>
				</div>
				<div class="row">
				<div class="col-12">
					<input type="url" class="form-control" name="url" id="url" value="<?= $this->clean($link['url']);?>"
					title="Modifiez le lien si besoin"><br>
				</div>
			</div>
		<div class="form-group">
				 <div class="col-xs-12">
							<br>
							<button class="btn btn-md btn-success" name="update" type="submit">Enregistrer</button>
							<a href="#" role="button" class="btn btn-md btn-secondary" type="reset">Annuler</a>
							<a href="<?= BASE_ADMIN_URL. 'links/removelink/' . $this->clean($link['id'])?>" role="button" class="btn btn-md btn-danger">Supprimer définitivement</a>
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
