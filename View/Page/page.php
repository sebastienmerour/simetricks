<h1 class="ml-3"><?= $this->clean($page['title']) ?></h1>
<div class="d-flex align-items-center ml-3"><!-- Entête de la page  -->
  <a href="<?= "user/profile/" . $this->clean($page['id_user']) ?>"><img src="<?= BASE_URL; ?>public/images/avatars/<?= $this->clean($page['avatar']);?>" alt="<?= $this->clean($page['firstname']) . '&nbsp;' . $this->clean($page['name']) ?>" class="avatar mr-2"></a>
  <div>
    <div>par <a href="<?= "user/profile/" . $this->clean($page['id_user']) ?>"><?= $this->clean($page['firstname']) . '&nbsp;' . $this->clean($page['name'])?></a>
    </div>
    <div class="text-small text-muted">publié le <?= $this->clean($page['date_creation_fr']) ?> | <?php if (isset($page['date_update']) AND $page['date_update'] > 0 ) {?>
      modifé le&nbsp;<?= $this->clean($page['date_update']) ?>
    <?php } ?><br>
    </div>
  </div>
</div>
<!-- Fin de l'Entête de la page  -->
<div class="container"><!-- Contenu de la page  -->
  <div class="row justify-content-left ml-3">
    <div class="mt-3">
      <article class="article">
          <?php if (!empty($this->cleantinymce($page['content']))) {?>
          <?= $this->cleantinymce($page['content']);?><?php };?>
      </article>
    </div>
    <div class="row justify-content-left position-relative">
      <div class="pt-3 ml-3">
      </div>
    </div>
  </div><!-- Fin du Contenu de la page  -->
