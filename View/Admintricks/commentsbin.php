<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Panneau d\'Administration'; ?>
<?php require('comments_menu.php'); ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
  <h2 id="commentsbin">Corbeille</h2>
	<?php
	if ($counter_comments_deleted < 1) {
		require __DIR__ . '/../errors/empty_bin.php';
	}
	else {?>
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Date</th>
        <th>Avatar</th>
				<th>Commentaire</th>
        <th>Consultation</th>
				<th>Restauration</th>
        <th>Suppression</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($comment = $comments_deleted->fetch())
      {
					$content = $this->cleantinymce($comment['content']);
					$maxlen = 50;
					if ( strlen($content) > $maxlen ){
				    $content = substr($content,0,strrpos($content,". ",$maxlen-strlen($content))+50);
					}

      ?>
      <tr>
        <td><h6 class="mt-2 text-left"><?= $this->clean($comment['date_creation_fr']); ?></h6></td>
        <td><div class="media">
          <img class="img-fluid mr-3 rounded avatar" src="<?= BASE_URL; ?>public/images/avatars/<?= $this->clean(isset($comment['avatar_com'])) ? $this->clean($comment['avatar_com']) : $default ;?>" alt="user">
        </div></td>
        <td><h6 class="mt-2 text-left"><?= $content; ?> ...</h6></td>
        <td><a href="<?= BASE_ADMIN_URL. 'commentread/' . $this->clean($comment['id']) ;?>" role="button" class="btn btn-sm btn-primary">Consulter</a></td>
				<td><a href="<?= BASE_ADMIN_URL. 'restorethiscomment/' . $this->clean($comment['id'])?>" role="button" class="btn btn-sm btn-success">Restaurer</a></td>
				<td><a href="<?= BASE_ADMIN_URL. 'removecomment/' . $this->clean($comment['id']) ;?>" role="button" class="btn btn-sm btn-danger">Supprimer dédinitivement</a></td>
      </tr>
            <?php
    }
  ?>
    </tbody>
  </table>
	<?php require('commentsbin_pagination.php');?>
	<div class="d-flex flex-row-reverse btn-toolbar mb-3 mb-md-0">
		<div class="btn-group mr-2">
			<a href="<?= BASE_ADMIN_URL; ?>emptycomments" role="button" class="float-right btn btn-sm btn-dark">Vider la Corbeille</a>
		</div>
	</div>
</div>
<?php };  ?>
<?php };  ?>
