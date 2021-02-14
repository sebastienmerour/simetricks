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
				<th>Article</th>
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
					<div class="media-body">
            <h6 class="mt-2 text-left"><?= $this->clean(isset($comment['firstname_com'], $comment['name_com']) ? $comment['firstname_com'] . ' ' . $comment['name_com'] : $comment['author']);?></h6><br>
          </div>
				</div></td>
        <td><h6 class="mt-2 text-left"><?= $content; ?> ...</h6></td>
				<td><a href="<?= BASE_URL; ?><?= !ISSET($_SESSION['id_user']) ? "extendedcard/" . $this->clean($comment['extended_card_id'])  . "/1/". $this->clean($comment['extended_card_slug'])
				 : "extendedcard/indexuser/" . $this->clean($comment['extended_card_id']). "/1/" .$this->clean($comment['extended_card_slug']);?>" target="_blank"><h6 class="mt-2 text-left"><?= $this->clean($comment['extended_card_title']); ?></h6></a></td>
        <td><a href="<?= BASE_ADMIN_URL. 'comments/commentread/' . $this->clean($comment['id']) ;?>" role="button" class="btn btn-sm btn-primary">Consulter</a></td>
				<td><a href="<?= BASE_ADMIN_URL. 'comments/restorethiscomment/' . $this->clean($comment['id'])?>" role="button" class="btn btn-sm btn-success">Restaurer</a></td>
				<td><a href="<?= BASE_ADMIN_URL. 'comments/removecomment/' . $this->clean($comment['id']) ;?>" role="button" class="btn btn-sm btn-danger">Supprimer dédinitivement</a></td>
      </tr>
            <?php
    }
  ?>
    </tbody>
  </table>
	<?php require('commentsbin_pagination.php');?>
	<div class="d-flex flex-row-reverse btn-toolbar mb-3 mb-md-0">
		<div class="btn-group mr-2">
			<a href="<?= BASE_ADMIN_URL; ?>comments/emptycomments" role="button" class="float-right btn btn-sm btn-dark">Vider la Corbeille</a>
		</div>
	</div>
</div>
<?php };  ?>
<?php };  ?>
