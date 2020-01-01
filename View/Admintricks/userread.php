<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' | Modification d\'un utilisateur'; ?>
<?php require('users_menu.php'); ?>
<?php if (empty($user)) {
							require __DIR__ . '/../errors/user_not_found.php';
			    }
					else {
					require __DIR__ . '/../errors/errors.php'; ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<div class="card my-4">
  <h5 class="card-header">Modification de l'utilisateur <strong><?= $this->clean($user['firstname']);?> <?= $this->clean($user['name']);?></strong></h5>
    <div class="card-body">
				<form role="form" class="form needs-validation" action="<?= BASE_ADMIN_URL; ?>updateuser/<?= $this->clean($user['id_user']);?>" method="post"
	        id="itemmodification" enctype="multipart/form-data" novalidate>
					<div class="form-group">
							<div class="row">
	            <div class="col-6">
								<input class="form-control" readonly id="username" name="username" type="text" placeholder="<?= $this->clean($user['username']);?>" value="<?= $this->clean($user['username']);?>"><br>
								<input class="form-control" id="email" name="email" type="email" placeholder="<?= $this->clean($user['email']);?>" value="<?= $this->clean($user['email']);?>"><br>
								<label for="status">Statut :</label><br>
								<select class="form-control form-control-sm custom-select" id="status" name="status">
									<option selected value="<?= $this->clean($user['status']);?>">
										<?php if ($this->clean($user['status'] === 0)) {; ?>Utilisateur<?php }
											else {;?>Administrateur<?php }; ?>
									</option>
									<option value="5">
										Administrateur
									</option>
									<option value="0">
										Utilisateur
									</option>
								</select><br>
								<br>
								<hr>
						 		<label for="avatar">Avatar :</label><br>
								<?php if (empty($user['avatar'])) {
									echo '<p>Il n\'y a pas d\'avatar pour cet utilisateur. Ajoutez une image ci-dessous :</p>';
							} else {
								?>
								<figure class="figure">
								<img src="<?= BASE_URL; ?>public/images/avatars/<?= $this->clean($user['avatar']);?>" class="figure-img img-fluid rounded-right"
								alt="<?= $this->clean($user['avatar']); ?>" title="<?= $this->clean($user['avatar']);?>">
								<figcaption class="figure-caption text-right"><?= $this->clean($user['avatar']); ?></figcaption>
								</figure>
								<?php
								};
								?>
								<div class="custom-file">
								<input type="file" name="avatar" class="custom-file-input" id="uploadimage">
								<label class="custom-file-label" data-browse="Parcourir..." for="avatar"></label>
								</div>
								<label for="image" class="text-muted text-small">(Formats autorisés : JPG, PNG ou GIF | max. 1 Mo)</label>
								<input type="hidden" name="MAX_FILE_SIZE" value="1048576">
	            </div>

							<div class="col-6">
								<input class="form-control" id="firstname" name="firstname" type="text" placeholder="<?= $this->clean($user['firstname']);?>" value="<?= $this->clean($user['firstname']);?>"><br>
								<input class="form-control" id="name" name="name" type="text" placeholder="<?= $this->clean($user['name']);?>" value="<?= $this->clean($user['name']);?>"><br>
								<label for="date_birth">Date de naissance :</label><br>
								<input type="date" class="form-control" name="date_birth" id="date_birth" value="<?= strftime('%Y-%m-%d', strtotime($user['date_birth'])); ?>" title="Modifiez la date de naissance si besoin"><br>
								<label for="date_register">Date d'enregistrement :</label><br>
								<input type="text" readonly class="form-control" name="date_register" id="date_register" value="<?= $this->clean($user['date_register']); ?>" title="Date d'enregistrement"><br>
								<label for="date_register">Dernière mise à jour :</label><br>
								<input type="text" readonly class="form-control" name="date_update" id="date_update" value="<?= $this->clean($user['date_update']); ?>" title="Dernière mise à jour"><br>
								<hr>
								<br><br>
	            </div>
						</div>
	        </div>
	        <div class="form-group">
	             <div class="col-xs-12">
	                  <br>
	                  <button class="btn btn-md btn-success" name="modify" type="submit">Enregistrer</button>
										<a href="<?= BASE_ADMIN_URL. 'removeuser/' . $this->clean($user['id_user']) ;?>" role="button" class="btn btn-danger">Supprimer définitivement</a>
										<a href="#" role="button" class="btn btn-md btn-secondary" type="reset">Annuler</a>
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
