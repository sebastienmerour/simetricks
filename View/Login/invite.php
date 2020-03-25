<?php $this->title =  WEBSITE_NAME . ' | Connexion'; ?>
<div class="row mb-4">
    <div class="col-md-6 col-lg-8 d-flex flex-column align-items-center" data-aos-delay="200">
    <h1 class="mt-4">Bonjour !</h1>
    <p>Vous n'êtes pas connectés.<br>
    Pour vous connecter, <a href="login">cliquez ici</a></p>
    </div>
<div class="col-md-6 col-lg-4 d-none d-md-block">
  <?php if(!ISSET($_SESSION['id_user']))
          {require __DIR__ . '/../themes/front/template_module_login.php'; }
       else { require __DIR__ . '/../themes/front/template_module_logout.php';}
       require( __DIR__ . '/../themes/front/template_module_stats.php');?>
</div>
</div>
