<?php $this->title = WEBSITE_NAME; ?>
<div class="row mb-4">
    <div class="col-md-6 col-lg-8 d-flex" data-aos-delay="200">
      <div class="row">

<?php foreach ($cards as $card):?>
  <?php
          $intro = strip_tags($card['content']);
          if (strlen($intro) > 75) {
              $stringCut = substr($intro, 0, 75);
              $endPoint = strrpos($stringCut, ' ');
              $intro = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
          }
  ?>
<div id="onecard" class="col-md-12 col-lg-4 d-flex">
    <div class="card card-body <?= $this->clean($card['stylename']) ?> text-light hover-shadow-3d rotate-left">
      <div class="d-flex justify-content-between">
        <div class="text-small d-flex">
          <div class="mr-2">
            <h3><a href="card/<?= $this->clean($card['id'])  . '/1/'. $this->clean($card['slug']);?>"><?= $this->clean($card['title']) ?></a></h3>
            <span class="h5 opacity-70">//&nbsp;<?= $this->clean($card['definition']); ?></span>
          </div>
        </div>
      </div>
      <div>
        <a href="card/<?= $this->clean($card['id'])  . '/1/'. $this->clean($card['slug']);?>"><h2><?= $this->cleantinymce($intro); ?>...</h2></a>
        <span class="opacity-70">[&nbsp;<a href="card/<?= $this->clean($card['id']) . '/1/'. $this->clean($card['slug']);?>">lire la suite</a>&nbsp;]</span></p>
        <span class="opacity-70">|&nbsp;<?= $this->clean($card['date_creation_fr']) ?>&nbsp;</span>
      </div>
    </div>
</div>
<?php endforeach; ?>
    </div>
  </div>
<div class="col-md-6 col-lg-4 d-none d-md-block">
  <?php if(!ISSET($_SESSION['id_user']))
          {require __DIR__ . '/../themes/front/template_module_login.php'; }
       else { require __DIR__ . '/../themes/front/template_module_logout.php';}
       require( __DIR__ . '/../themes/front/template_module_stats.php');?>
</div>
</div>
    <?php
    if ($cards_current_page > $number_of_cards_pages) {
      require __DIR__ . '/../errors/cards_not_found.php';
    }
    else {
    require __DIR__ . '/../Cards/index_pagination.php';
    }
    ?>
