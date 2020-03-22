<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Modification d\'une catégorie'; ?>
<?php require('categories_menu.php'); ?>
<?php if (empty($category)) {
							require __DIR__ . '/../errors/category_not_found.php';
			    }
					else {
					require __DIR__ . '/../errors/errors.php'; ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="card my-4">
	<h5 class="card-header">Modification de la Catégorie <strong><?= $this->clean($category['name']);?></strong></h5>
    <div class="card-body">
				<form role="form" class="form needs-validation" action="<?= BASE_ADMIN_URL; ?>categories/updatecategory/<?= $this->clean($category['id']);?>" method="post"
	        id="categorymodification" novalidate>
				<div class="form-group">
						<div class="row">
						<div class="col-12">
							<input class="form-control" id="name" name="name" type="text" placeholder="<?= $this->clean($category['name']);?>" value="<?= $this->clean($category['name']);?>"><br>
						</div>
					</div>
					<div class="row">
					<div class="col-12">
						<input class="form-control" id="slugcategory" name="slugcategory" type="text" placeholder="<?= $this->clean($category['slug']);?>" value="<?= $this->clean($category['slug']);?>"><br>
					</div>
				</div>
				</div>
				<div class="row">
				<div class="col-12">
					<textarea rows="5" cols="10" class="form-control" name="description" id="description"
					placeholder="<?= $this->clean($category['description']);?>"
					title="Modifiez la catégorie si besoin"><?= $this->clean($category['description']);?></textarea>
				</div>
			</div>
		<div class="form-group">
				 <div class="col-xs-12">
							<br>
							<button class="btn btn-md btn-success" name="update" type="submit">Enregistrer</button>
							<a href="#" role="button" class="btn btn-md btn-secondary" type="reset">Annuler</a>
							<a href="<?= BASE_ADMIN_URL. 'categories/removecategory/' . $this->clean($category['id'])?>" role="button" class="btn btn-md btn-danger">Supprimer définitivement</a>
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
