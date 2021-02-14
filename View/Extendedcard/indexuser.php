<?php $this->title = WEBSITE_NAME . ' | ' .$this->clean($item['title']); ?>
<div class="">
  <div class="row mb-4">
    <div class="col-md-8 col-lg-8">
      <div class="pr-lg-4">
          <?php require('breadcrumb.php'); ?>
          <?php require('item.php'); ?>
          <?php require('comments.php'); ?>
          <?php require('comments_pagination.php');?>
          <?php require('comment_user_add.php');?>
      </div>
    </div>
  </div>
<div class="col-md-4 col-lg-4 d-none d-md-block">
  <?php if(!ISSET($_SESSION['id_user']))
          {require __DIR__ . '/../themes/front/template_module_login.php'; }
       else { require __DIR__ . '/../themes/front/template_module_logout.php';}
       require( __DIR__ . '/../themes/front/template_module_stats.php');?>
 </div><!-- Fin de la Sidebar  -->
</div><!-- Fin du Container Global  -->
