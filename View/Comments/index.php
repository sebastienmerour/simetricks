<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Panneau d\'Administration'; ?>
<?php require('comments_menu.php'); ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<h2 id="comments">&nbsp;</h2>
<?php
if ($counter_comments < 1) {
  require __DIR__ . '/../errors/comments_not_found_admin.php';
}
else {?>
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Date</th>
        <th>Utilisateur</th>
        <th>Commentaire</th>
				<th>Article</th>
        <th>Consultation</th>
        <th>Suppression</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($comment = $comments->fetch())
      {
				        $intro = strip_tags($comment['content']);
				        if (strlen($intro) > 40) {
				            // truncate string
				            $stringCut = substr($intro, 0, 40);
				            $endPoint = strrpos($stringCut, ' ');
				            //if the string doesn't contain any space then it will cut without word basis.
				            $intro = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
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
        <td><h6 class="mt-2 text-left"><?= $intro; ?> ...</h6></td>
				<td><a href="<?= BASE_URL; ?><?= !ISSET($_SESSION['id_user']) ? "extendedcard/" . $this->clean($comment['extended_card_id'])  . "/1/". $this->clean($comment['extended_card_slug'])
				 : "extendedcard/indexuser/" . $this->clean($comment['extended_card_id']). "/1/" .$this->clean($comment['extended_card_slug']);?>" target="_blank"><h6 class="mt-2 text-left"><?= $this->clean($comment['extended_card_title']); ?></h6></a></td>
        <td><a href="<?= BASE_ADMIN_URL. 'comments/commentread/' . $this->clean($comment['id']) ;?>" role="button" class="btn btn-sm btn-primary">Consulter</a></td>
        <td><a href="<?= BASE_ADMIN_URL. 'comments/movecommenttobin/' . $this->clean($comment['id']) ;?>" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>
      </tr>
            <?php
    }
  ?>
    </tbody>
  </table>
</div>
<?php
	require __DIR__ . '/../Comments/comments_pagination.php';
}
?>
</div>
<?php
};
?>
