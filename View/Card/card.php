<h1 class="ml-3"><?= $this->clean($card['title']) ?></h1>
<div class="container"><!-- Contenu de la Card  -->
  <div class="row justify-content-left position-relative">
    <div class="pt-3 ml-3">
      <img src="<?php echo BASE_URL; ?>public/images/card_images/<?= $this->clean($card['image'])?>" alt="<?= $this->clean($card['title']) ?>" class="w-85 rounded">
    </div>
  </div>
  <div class="row justify-content-left ml-3">
    <div class="mt-3">
      <article class="article">
        <dl class="row">
          <dt class="col-sm-4"><h6>Définition</h6></dt>
          <dd class="col-sm-8"><?= $this->cleantinymce($card['content']); ?></dd>
        </dl>
      </article>
    </div>
  </div>
</div>
<div class="pr-lg-4 ml-3"><!-- Commentaires  -->
