<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' | Modification d\'un commentaire'; ?>
<?php require('comments_menu.php'); ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<!-- Modification d'un commentaire -->
<div class="media mb-4">
	<img class="img-fluid mr-3 rounded avatar" src="<?= BASE_URL; ?>public/images/avatars/<?= $this->clean(isset($comment['avatar_com']) ? $comment['avatar_com'] : $default );?>" alt="user">
  <div class="media-body">
      <form role="form" class="form needs-validation" action="<?= BASE_ADMIN_URL; ?>comments/updatecomment/<?= $this->clean($comment['id']);?>" method="post" id="commentmodification" novalidate>
        <div class="form-group">
            <div class="col-xs-6">
							<h6 class="mt-0"><?= $this->clean(isset($comment['firstname_com'], $comment['name_com']) ? $comment['firstname_com'] . ' ' . $comment['name_com'] : $comment['author']);?></h6>
							<em>le <?= $this->clean($comment['date_creation_fr']); ?></em>
                <p>&nbsp;</p>
                <textarea class="form-control" name="content" id="content"
                placeholder="<?= $this->clean($comment['content']);?>"
                title="Modifiez le commentaire si besoin"><?= $this->clean($comment['content']);?></textarea>
            </div>
        </div>
        <div class="form-group">

             <div class="col-xs-12">
                  <br>
									<button class="btn btn-md btn-success" name="modify" type="submit">Modifier</button>
									<a href="<?= BASE_ADMIN_URL. 'comments/removecomment/' . $this->clean($comment['id']) ;?>" role="button" class="btn btn-danger">Supprimer définitivement</a>
								  <a href="#"><button class="btn btn-md btn-secondary" type="reset">Annuler</button></a>
                  <a href="<?= $_SERVER['HTTP_REFERER']; ?>"><button class="btn btn-md btn-primary" type="button">Retour</button></a>
              </div>
        </div>
      </form>
  </div>
</div>

<?php
};

?>
