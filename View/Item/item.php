<h1 class="ml-3"><?= $this->clean($item['title']) ?></h1>
<div class="d-flex align-items-center ml-3">
  <a href="<?= "user/profile/" . $this->clean($item['id_user']) ?>"><img src="<?= BASE_URL; ?>public/images/avatars/<?= $this->clean($item['avatar']);?>" alt="<?= $this->clean($item['firstname']) . '&nbsp;' . $this->clean($item['name']) ?>" class="avatar mr-2"></a>
<div>
    <div>par <a href="<?= "user/profle/" . $this->clean($item['id_user']) ?>"><?= $this->clean($item['firstname']) . '&nbsp;' . $this->clean($item['name'])?></a>
    </div>
    <div class="text-small text-muted">publié le <?= $this->clean($item['date_creation_fr']) ?> | <?php if (isset($item['date_update']) AND $item['date_update'] > 0 ) {?>
      modifé le&nbsp;<?= $this->clean($item['date_update']) ?>
    <?php } ?><br>
    Catégorie : <a href="#"><?= $category['name']; ?></a> |&nbsp;<a data-smooth-scroll href="<?= "item/" . $this->clean($item['id']). "/1"  ?>/#comments">Commentaires (<?= $number_of_comments ;?>)</a><br>
    </div>
  </div>
</div>
</div>
<div class="pr-lg-4">
<div class="container">
  <div class="row justify-content-left position-relative">
    <div class="pt-3 ml-3">
      <img src="<?php echo BASE_URL; ?>public/images/item_images/<?= $this->clean($item['image'])?>" alt="<?= $this->clean($item['title']) ?>" class="w-85 rounded">
    </div>
  </div>
  <div class="row justify-content-left ml-3">
    <div class="mt-3">
      <article class="article">
        <dl class="row">
          <dt class="col-sm-3"><h6>Date de création</h6></dt>
          <dd class="col-sm-9"><?= strftime('%d/%m/%Y', strtotime($item['date_native'])); ?></dd>
          <dt class="col-sm-3"><h6>Licence</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['licence']); ?></dd>
          <dt class="col-sm-3"><h6>SGBDR</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['sgbdr']); ?></dd>
          <dt class="col-sm-3"><h6>Part de Marché</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['pdm']); ?></dd>
          <dt class="col-sm-3"><h6>Langage</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['langage']); ?></dd>
          <dt class="col-sm-3"><h6>Fonctionnalités</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['features']); ?></dd>
          <dt class="col-sm-3"><h6>Liens</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['links']); ?></dd>
          <dt class="col-sm-3"><h6>Aux dernières nouvelles</h6></dt>
          <dd class="col-sm-9"><?= $this->cleantinymce($item['content']); ?></dd>
        </dl>
      </article>
    </div>
  </div>
</div>
