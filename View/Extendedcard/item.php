<h1 class="ml-3"><?= $this->clean($item['title']) ?></h1>
<div class="d-flex align-items-center ml-3"><!-- Entête de l'item  -->
  <a href="<?= "user/profile/" . $this->clean($item['id_user']) ?>"><img src="<?= BASE_URL; ?>public/images/avatars/<?= $this->clean($item['avatar']);?>" alt="<?= $this->clean($item['firstname']) . '&nbsp;' . $this->clean($item['name']) ?>" class="avatar mr-2"></a>
  <div>
    <div>par <a href="<?= "user/profile/" . $this->clean($item['id_user']) ?>"><?= $this->clean($item['firstname']) . '&nbsp;' . $this->clean($item['name'])?></a>
    </div>
    <div class="text-small text-muted">publié le <?= $this->clean($item['date_creation_fr']) ?> | <?php if (isset($item['date_update']) AND $item['date_update'] > 0 ) {?>
      modifé le&nbsp;<?= $this->clean($item['date_update']) ?>
    <?php } ?><br>
    Catégorie : <a href="category/<?= $this->clean($category['id']). '/1/' . $this->clean($category['slug']);?>"><?= $this->clean($category['name']); ?></a> |&nbsp;<a href="<?= !ISSET($_SESSION['id_user']) ? "extendedcard/" . $this->clean($item['itemid'])  . "/1/" .$this->clean($item['slug']). "#comments" : "extendedcard/indexuser/" . $this->clean($item['itemid']). "/1/" .$this->clean($item['slug']). "#comments" ?>">Commentaires (<?= $number_of_comments ;?>)</a><br>
    </div>
  </div>
</div><!-- Fin de l'Entête de l'item  -->
<div class="container"><!-- Contenu de l'item  -->
  <div class="row justify-content-left position-relative">
    <div class="pt-3 ml-3">
      <img src="<?php echo BASE_URL; ?>public/images/extendedcard_images/<?= $this->clean($item['image'])?>" alt="<?= $this->clean($item['title']) ?>" class="w-85 rounded">
    </div>
  </div>
  <div class="row justify-content-left ml-3">
    <div class="mt-3">
      <article class="article">
        <dl class="row">
          <?php if (!empty($this->cleantinymce($item['content']))) {?><dt class="col-sm-3"><h6>Description</h6></dt>
          <dd class="col-sm-9"><?= $this->cleantinymce($item['content']);?></dd><?php };?>
          <?php if (!empty($this->clean($item['features']))) {?><dt class="col-sm-3"><h6>Fonctionnalités</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['features']);?></dd><?php };?>
          <?php if(strtotime($item['date_native']) > 0) {?><dt class="col-sm-3"><h6>Date de création</h6></dt>
          <dd class="col-sm-9"><?= strftime('%d/%m/%Y', strtotime($item['date_native']));?></dd><?php };?>
          <?php if (!empty($this->clean($item['year_native']))) {?><dt class="col-sm-3"><h6>Année de création</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['year_native']);?></dd><?php };?>
          <?php if (!empty($this->clean($item['owner']))) {?><dt class="col-sm-3"><h6>Créateur</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['owner']);?></dd><?php };?>
          <?php if (!empty($this->clean($item['os_supported']))) {?><dt class="col-sm-3"><h6>OS supportés</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['os_supported']);?></dd><?php };?>
          <?php if (!empty($this->clean($item['version']))) {?><dt class="col-sm-3"><h6>Dernière version</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['version']);?></dd><?php };?>
          <?php if (!empty($this->clean($item['licence']))) {?><dt class="col-sm-3"><h6>Licence</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['licence']);?></dd><?php };?>
          <?php if (!empty($this->clean($item['langage']))) {?><dt class="col-sm-3"><h6>Langage</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['langage']);?></dd><?php };?>
          <?php if (!empty($this->clean($item['sgbdr']))) {?><dt class="col-sm-3"><h6>SGBDR</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['sgbdr']);?></dd><?php };?>
          <?php if (!empty($this->clean($item['number_of_users']))) {?><dt class="col-sm-3"><h6>Nombre d'utilisateurs</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['number_of_users']);?></dd><?php };?>
          <?php if (!empty($this->clean($item['pdm']))) {?><dt class="col-sm-3"><h6>Part de Marché</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['pdm']);?></dd><?php };?>
          <dt class="col-sm-3"><h6>Liens</h6></dt>
          <dd class="col-sm-9">
            <div class="">
              <?php foreach ($links as $link): ?>
                <a href="<?= $this->clean($link['url']) ;?>" target="_blank" type="button" class="btn btn-success btn-sm p-1"><?= $this->clean($link['name']) ;?></a>
              <?php endforeach; ?>
            </div>
          </dd>
          <?php if (!empty($this->clean($item['last_news']))) {?><dt class="col-sm-3"><h6>Aux dernières nouvelles</h6></dt>
          <dd class="col-sm-9"><?= $this->clean($item['last_news']);?></dd><?php };?>
        </dl>
      </article>
    </div>
  </div>
</div><!-- Fin du Contenu de l'item  -->
