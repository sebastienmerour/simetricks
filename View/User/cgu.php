<?php $this->title =  WEBSITE_NAME . ' | Conditions Générales d\'Utilisation'; ?>
<div class="container">
  <div class="row mb-4">
    <div class="col-md-8 col-lg-8">
      <div class="pr-lg-4">
        <?= $text ;?>
      </div>
    </div>
<div class="col-md-4 col-lg-4 d-none d-md-block">
<?php if(!ISSET($_SESSION['id_user']))
      {require __DIR__ . '/../themes/front/template_module_login.php'; }
   else { require __DIR__ . '/../themes/front/template_module_logout.php';}?>
 </div>
</div>
</div>
