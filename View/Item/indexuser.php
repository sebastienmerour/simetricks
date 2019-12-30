<?php $this->title = WEBSITE_NAME . ' | ' .$this->clean($item['title']); ?>
<!-- Vérification de l'existence de l'item -->
  <?php if (empty($item)) { require __DIR__ . '/../errors/item_not_found.php';}
  else {?>
  <div class="pb-0 pb-1">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Accueil</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#">Catégorie</a>
                </li>
              </ol>
            </nav>
          </div>
          <h1><?= $this->clean($item['title']) ?></h1>
          <div class="d-flex align-items-center">
            <a href="<?= "user/profile/" . $this->clean($item['id_user']) ?>"><img src="<?= BASE_URL; ?>public/images/avatars/<?= $this->clean($item['avatar']);?>" alt="<?= $this->clean($item['firstname']) . '&nbsp;' . $this->clean($item['name']) ?>" class="avatar mr-2"></a>
            <div>
              <div>par <a href="<?= "user/profle/" . $this->clean($item['id_user']) ?>"><?= $this->clean($item['firstname']) . '&nbsp;' . $this->clean($item['name'])?></a>
              </div>
              <div class="text-small text-muted">publié le <?= $this->clean($item['date_creation_fr']) ?> | <?php if (isset($item['date_update']) AND $item['date_update'] > 0 ) {?>
                modifé le&nbsp;<?= $this->clean($item['date_update']) ?>
              <?php } ?><br>
                <em><a href="<?= "item/" . $this->clean($item['id']). "/1/"  ?>#comments">Commentaires (<?= $number_of_comments ;?>)</a></em><br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <section class="p-0" data-reading-position>
    <div class="container">
      <div class="row justify-content-center position-relative">
        <div class="col-lg-10 col-xl-8 pt-3">
          <img src="<?php echo BASE_URL; ?>public/images/item_images/<?= $this->clean($item['image'])?>" alt="<?= $this->clean($item['title']) ?>" class="rounded">
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-8 col-md-10">
          <article class="article">
            <p class="lead"><?= $this->cleantinymce($item['content']) ?></p>
          </article>
        </div>
      </div>
    </div>
  </section>
  <section class="has-divider">
    <div class="container pt-3">
      <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-8 col-md-10">
          <hr>
          <h5 id="comments" class="my-4"><?= $number_of_comments ;?> Commentaire(s)</h5>
          <?php
          if ($comments_current_page > $number_of_comments_pages) {
          	require __DIR__ . '/../errors/comments_not_found.php';
          }
          ?>
          <!-- Message de confirmation -->
          <?php require __DIR__ . '/../errors/confirmation.php'; ?>
          <?php require('pagination_comments.php');?>
          <hr>
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
          <?php require('comment_user_add.php');?>
        <?php };?>
        </div>
      </div>
    </div>
  </section>
