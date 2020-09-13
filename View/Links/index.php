<?php $this->title = WEBSITE_NAME; ?>
<div class="row mb-4">
    <div class="col-md-6 col-lg-8" data-aos-delay="200">
      <div class="pr-lg-4">
   <div class="row card card-body justify-content-between bg-primary text-light">
     <div class="d-flex justify-content-between">
       <div class="text-small d-flex">
         <div class="mr-2">
           <h1>Liens utiles</h1>
         </div>
       </div>
     </div>
   </div>
 </div>
 <div class="pr-lg-4">
  <div class="row">
<?php foreach ($links as $link):?>

  <a href="<?= $this->clean($link['url']) ?>" target="_blank" class="card card-body flex-row align-items-center hover-shadow-sm">
                <div class="icon-round icon-round-lg bg-primary mx-md-4">
                  <img class="icon bg-primary" src="assets/img/icons/theme/general/thunder-move.svg" alt="icon" data-inject-svg />
                </div>
                <div class="pl-4">
                  <h3 class="mb-1"><?= $this->clean($link['name']) ?></h3>
                  <span><?= $this->clean($link['description']) ?></span>
                </div>
              </a>

<?php endforeach; ?>
  </div>
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
    if ($links_current_page > $number_of_links_pages) {
      require __DIR__ . '/../errors/cards_not_found.php';
    }
    else {
    require __DIR__ . '/../Links/index_pagination.php';
    }
    ?>
