<?php $this->title = WEBSITE_NAME; ?>

<!-- Pour chaque post on met un foreach : -->
<div class="row mb-4">
<?php foreach ($items as $item):?>
<?php
      $content = $this->clean($item['content']);
      $maxlen = 75;
      if ( strlen($content) > $maxlen ){
        $content = substr($content,0,strrpos($content,". ",$maxlen-strlen($content))+75);}
?>
  <div class="col-md-6 col-lg-4 d-flex" data-aos-delay="200">
      <div class="card">
        <a href="<?= !ISSET($_SESSION['id_user']) ? "item/" . $this->clean($item['id'])  . "/1/" : "item/indexuser/" . $this->clean($item['id']). "/1/" ?>">
          <img src="<?php echo BASE_URL; ?>public/images/item_images/<?= $this->clean($item['image'])?>" alt="<?= $this->clean($item['title']) ?>" class="card-img-top">
        </a>
        <div class="card-body d-flex flex-column">
          <div class="d-flex justify-content-between mb-3">
            <div class="text-small d-flex">
              <div class="mr-2">
                <a href="#">Business</a>
              </div>
              <span class="text-muted">Le <?= $this->clean($item['date_creation_fr']) ?></span>
            </div>
          </div>
          <a href="<?= !ISSET($_SESSION['id_user']) ? "item/" . $this->clean($item['id']) . "/1/" : "item/indexuser/" . $this->clean($item['id']) . "/1/" ?>">
            <h4><?= $this->clean($item['title']) ?></h4>
          </a>
          <p class="flex-grow-1">
            <?= $content; ?> ...[<a href="<?= !ISSET($_SESSION['id_user']) ? "item/" . $this->clean($item['id']) . "/1/" : "item/indexuser/" . $this->clean($item['id']) . "/1/" ?>">lire la suite</a>]
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


    <?php
    if ($items_current_page > $number_of_items_pages) {
      require __DIR__ . '/../errors/items_not_found.php';
    }
    else {
    require __DIR__ . '/../Home/pagination_index.php';
    }
    ?>



<?php $this->sidebar='Le site contient :<ul><li>' . $number_of_items .' extended cards</li>
  <li>' . $total_comments_count .' commentaires</li>
  <li>' . $total_users_count .' utilisateurs</li>
</ul>'; ?>
