<?php $this->title = WEBSITE_NAME . ' | ' .$this->clean($item['title']); ?>
<!-- Vérification de l'existence de l'item -->
<?php if (empty($item)) { require __DIR__ . '/../errors/item_not_found.php';}
else {?>

<!-- Title -->
<h1 class="mt-4 text-left"><?= $this->clean($item['title']) ?></h1>

<!-- Author -->
<span class="lead">publié par <a href="<?= "user/profle/" . $this->clean($item['id_user']) ?>">
  <?= $this->clean($item['firstname']) . '&nbsp;' . $this->clean($item['name'])?></a></span>
<br>

<!-- Date et Heure de Publication -->
<em>le <?= $this->clean($item['date_creation_fr']) ?></em>&nbsp;<em class="fas fa-comments">&nbsp;</em><em><a href="<?= "item/" . $this->clean($item['id']). "/1/"  ?>#comments">Commentaires (<?= $number_of_comments ;?>)</a></em><br>
<?php if (isset($item['date_update']) AND $item['date_update'] > 0 ) {?>
	<em>article modifé le&nbsp;<?= $this->clean($item['date_update']) ?></em>
	<?php } ?>
<hr>

<!-- Image du Post -->
<figure class="figure">
<img src="<?php echo BASE_URL; ?>public/images/item_images/<?= $this->clean($item['image'])?>" class="figure-img img-fluid rounded-right"
alt="<?= $this->clean($item['title']) ?>" title="<?= $this->clean($item['title']) ?>">
<figcaption class="figure-caption text-right"><?= $this->clean($item['title']) ?></figcaption>
</figure>

<hr>

<!-- Post  -->
<p class="lead"><?= $this->cleantinymce($item['content']) ?></p>

<!-- Commentaires  -->
<h2 id="comments">Commentaires</h2>
<hr>
<?php
if ($comments_current_page > $number_of_comments_pages) {
	require __DIR__ . '/../errors/comments_not_found.php';
}
?>
<!-- Message de confirmation -->
<?php require __DIR__ . '/../errors/confirmation.php'; ?>

<?php require('pagination_comments.php');?>
<h5 class="my-4"><?= $number_of_comments ;?> Commentaires</h5>
<ol class="comments">
  <?php foreach ($comments as $comment): ?>
  <li class="comment">
    <div class="d-flex align-items-center text-small">
      <img src="<?= BASE_URL; ?>public/images/avatars/<?= isset($comment['avatar_com']) ? $comment['avatar_com'] : $default ;?>" alt="user" class="avatar avatar-sm mr-2">
      <div class="text-dark mr-1"><?= $this->clean(isset($comment['firstname_com'], $comment['name_com']) ? $comment['firstname_com'] . ' ' . $comment['name_com'] : $comment['author']);?></div>
      <div class="text-muted"><?= $this->clean($comment['date_creation_fr']);?>
        <?php if (isset($comment['date_update']) AND $comment['date_update'] > 0 ) {?>
  				<em class="fas fa-history"></em>&nbsp;<em>commentaire modifé</em><br>
  				<?php }?>
      </div>
    </div>
    <div class="my-2">
      <?= $this->cleantinymce($comment['content']); ?>
    </div>
    <div>
      <em class="fas fa-flag"></em>&nbsp;<a class="text-small" href="item/reportcomment/<?= $this->clean($item['id']) ?>/<?= $this->clean($comment['id_comment']) ;?>/">signaler le commentaire</a>&nbsp;
    </div>
  </li>
  <?php endforeach; ?>
</ol>
<hr>

<?php require('pagination_comments.php');?>
<hr>
<div id="addcomment"></div>
<?php require __DIR__ . '/../errors/errors.php'; ?>

<!-- Ajout  de nouveaux commentaires : -->
<h5 class="my-4">Ajoutez un commentaire :</h5>
<div class="my-4">
<form action="item/createcomment" method="post">
  <div class="row">
    <div class="col-md-12 mb-1">
      <div class="form-group">
        <input type="hidden" id="id" name="id" value="<?= $this->clean($item['id']); ?>">
        <input type="text" class="form-control" placeholder="Prénom" name="author">
      </div>
    </div>
  </div>
  <div class="form-group">
    <textarea class="form-control" name="content" rows="7" placeholder="Ecrivez ici votre commentaire"></textarea>
  </div>
  <div class="d-flex align-items-center justify-content-between">
    <div class="g-recaptcha" data-sitekey="6LehvscUAAAAAH8By_5qI0kdK8aaqHqVHDFwWm5W"></div>
  </div>
  <div class="d-flex align-items-center justify-content-between mt-2">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Envoyer</button>
  </div>
</form>
</div>

<!-- Fin des commentaires -->
<?php };?>
<?php $this->sidebar= 'Le blog contient ' . $number_of_items .' articles<br>
et '. $number_of_items_pages.' pages d\'articles.<br>
Cette page contient ' . $number_of_comments .' commentaires et ' . $number_of_comments_pages. ' page(s) de commentaires'; ?>
