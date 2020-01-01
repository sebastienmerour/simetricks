<?php require('template_header.php'); ?>

<?php require('template_nav.php'); ?>
<!-- Page Content -->
<div class="container-fluid">
  <div class="row">
    <?php if(ISSET($_SESSION['id_user_admin']))
              {
         require('template_sidebar_login.php'); }
         else {
         }?>

<div class="main container">
  <div class="row container">
    <main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-4">
        	<?= $content; ?>
    </main>
  </div>
</div>
</div>
</div>

<?php require('template_footer.php'); ?>
