<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' | Panneau d\'Administration'; ?>
<?php require('commentsreported_menu.php'); ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
<h2 id="commentsreported">&nbsp;</h2>
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
	      while ($comment_reported = $comments_reported->fetch())
				{
					        $intro = strip_tags($comment_reported['content']);
					        if (strlen($intro) > 40) {
					            // truncate string
					            $stringCut = substr($intro, 0, 40);
					            $endPoint = strrpos($stringCut, ' ');
					            //if the string doesn't contain any space then it will cut without word basis.
					            $intro = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
					        }
	      ?>
	      <tr>
	        <td><h6 class="mt-2 text-left"><?= $this->clean($comment_reported['date_creation_fr']); ?></h6></td>
	        <td><div class="media mb-4">
	          <img class="img-fluid mr-3 rounded avatar" src="<?php echo BASE_URL; ?>public/images/avatars/<?= $this->clean(isset($comment_reported['avatar_com'])) ? $this->clean($comment_reported['avatar_com']) : $default ;?>" alt="user">
	          <div class="media-body">
	            <h6 class="mt-2 text-left"><?= $this->clean(isset($comment_reported['firstname_com'], $comment['name_com']) ? $comment_reported['firstname_com'] . ' ' . $comment_reported['name_com'] : $comment_reported['author']);?></h6><br>
	          </div>
	        </div></td>
	        <td><h6 id="commentcontent" class="mt-2 text-left"><?= $intro; ?> ...</h6></td>
					<td><a href="<?= BASE_URL; ?><?= !ISSET($_SESSION['id_user']) ? "extendedcard/" . $this->clean($comment_reported['extended_card_id'])  . "/1/". $this->clean($comment_reported['extended_card_slug'])
					 : "extendedcard/indexuser/" . $this->clean($comment_reported['extended_card_id']). "/1/" .$this->clean($comment_reported['extended_card_slug']);?>" target="_blank"><h6 class="mt-2 text-left"><?= $this->clean($comment_reported['extended_card_title']); ?></h6></a></td>
	        <td><a href="<?= BASE_ADMIN_URL. 'commentsreported/commentreportedread/' . $this->clean($comment_reported['id']) ;?>" role="button" class="btn btn-sm btn-primary">Consulter</a></td>
					<td><a href="<?= BASE_ADMIN_URL. 'commentsreported/movecommentreportedtobin/' . $this->clean($comment_reported['id']) ;?>" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>
	      </tr>

	            <?php
	    }
	  ?>
	    </tbody>
	  </table>
	</div>
	<?php
	if ($counter_comments_reported  < 1) {
	  require __DIR__ . '/../errors/comments_reported_not_found_admin.php';
	}
	else {
	require('commentsreported_pagination.php');}
	?>
</div>
<?php
};
?>
