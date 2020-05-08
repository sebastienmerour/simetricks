<div class="pr-lg-4 ml-3"><!-- Commentaires  -->
  <hr>
  <h5 id="comments" class="my-4"><?= $number_of_comments ;?> Commentaire(s)</h5>
<?php
if ($comments_current_page > $number_of_comments_pages) {
  require __DIR__ . '/../errors/comments_not_found.php';
}
?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
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
      <em class="fas fa-flag"></em>&nbsp;<a class="text-small" href="extendedcard/reportcomment/<?= $this->clean($item['itemid']) ?>/<?= $this->clean($comment['id_comment']) ;?>/">signaler le commentaire</a>&nbsp;
      <?php if(ISSET($_SESSION['id_user']) AND  $_SESSION['id_user'] == $comment['user_com'])  {
      ?>
      |&nbsp;<em class="fas fa-edit"></em>&nbsp;<a href="extendedcard/commentread/<?= $this->clean($item['itemid']) ?>/<?= $this->clean($comment['id_comment']) ;?>/">modifier</a>
        <?php };?>
    </div>
  </li>
  <hr>
  <?php endforeach; ?>
</ol>
