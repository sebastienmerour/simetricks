<?php require('template_header.php'); ?>
<?php require('template_nav.php'); ?>
<div class="container-fluid">
  <div class="row">
    <?php if(ISSET($_SESSION['id_user_admin']))
              {
         require('template_sidebar_login.php'); }
         else {
         }?>
<div class="main container">
  <div class="row container">
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="row text-center py-6">
        <div class="col layer-2">
          <h1 class="display-3 mb-0">Erreur</h1>
          <h2 class="h1"><?= $content ?></h2>
        </div>
      </div>
    </main>
  </div>
</div>
</div>
</div>
<?php require('template_footer.php'); ?>
