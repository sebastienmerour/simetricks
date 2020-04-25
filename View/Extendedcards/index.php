<?php $this->title = WEBSITE_NAME; ?>
<div class="row mb-4">
    <div class="col-md-6 col-lg-8 d-flex" data-aos-delay="200">
      <div class="row">
<?php foreach ($items as $item):?>
<?php
        $intro = strip_tags($item['last_news']);
        if (strlen($intro) > 75) {
            $stringCut = substr($intro, 0, 75);
            $endPoint = strrpos($stringCut, ' ');
            $intro = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
        }
?>
      <div class="col-md-12 col-lg-6 d-flex">
      <div class="card hover-shadow-3d rotate-left">
        <a href="<?= !ISSET($_SESSION['id_user']) ? "extendedcard/" . $this->clean($item['itemid'])  . "/1/". $this->clean($item['slug']) : "extendedcard/indexuser/" . $this->clean($item['itemid']). "/1/" .$this->clean($item['slug']);?>">
          <img src="<?php echo BASE_URL; ?>public/images/extendedcard_images/<?= $this->clean($item['image'])?>" alt="<?= $this->clean($item['title']) ?>" class="card-img-top">
        </a>
        <div class="card-body d-flex flex-column">
          <div class="d-flex justify-content-between mb-3">
            <div class="text-small d-flex">
              <div class="mr-2">
                <a href="category/<?= $this->clean($item['categoryid']).'/1/' . $this->clean($item['categoryslug']) ;?>"><?= $this->clean($item['categoryname']) ;?></a>
              </div>
              <span class="text-muted">Le <?= $this->clean($item['date_creation_fr']) ?></span>
            </div>
          </div>
          <a href="<?= !ISSET($_SESSION['id_user']) ? "extendedcard/" . $this->clean($item['itemid']) . "/1/". $this->clean($item['slug']) : "extendedcard/indexuser/" . $this->clean($item['itemid']) . "/1/" .$this->clean($item['slug']);?>">
            <h4><?= $this->clean($item['title']) ?></h4>
          </a>
          <p class="flex-grow-1">
            <?= $this->clean($intro); ?> ...[<a href="<?= !ISSET($_SESSION['id_user']) ? "extendedcard/" . $this->clean($item['itemid']) . "/1/". $this->clean($item['slug']) : "extendedcard/indexuser/" . $this->clean($item['itemid']) . "/1/" .$this->clean($item['slug']);?>">lire la suite</a>]
          </p>
          <div class="d-flex align-items-center mt-3">
            <a href="<?= "user/profile/" . $this->clean($item['id_user']) ?>"><img src="<?= BASE_URL; ?>public/images/avatars/<?= $this->clean($item['avatar']);?>" alt="<?= $this->clean($item['firstname']) . '&nbsp;' . $this->clean($item['name']) ?>" class="avatar avatar-sm"></a>
            <div class="ml-1">
              <span class="text-small text-muted">Par</span>
              <span class="text-small"><a href="<?= "user/profile/" . $this->clean($item['id_user']) ?>">
                  <?= $this->clean($item['firstname']) . '&nbsp;' . $this->clean($item['name']) ?></a></span>
            </div>
          </div>
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
    if ($items_current_page > $number_of_items_pages) {
      require __DIR__ . '/../errors/items_not_found.php';
    }
    else {
    require __DIR__ . '/../Extendedcards/index_pagination.php';
    }
    ?>
