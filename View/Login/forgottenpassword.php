<?php $this->title =  WEBSITE_NAME . ' | Mot de passe oublié'; ?>
<div class="row mb-4">
  <div class="col-md-6 col-lg-8 d-flex flex-column align-items-center" data-aos-delay="200">
    <h1 class="mb-1">Mot de passe oublié</h1>
    <span class="mb-3">Entrez votre identifiant ci-dessous ré-initialiser votre mot de passe : </span>
    <?php
    if (!empty($_SESSION['messages']['confirmation']))
        { require __DIR__ . '/../errors/confirmation.php';};
      ?>
    <?php require __DIR__ . '/../errors/errors.php'; ?>
  <form method="post" action="login/generatepassword">
    <div class="form-group">
      <input type="text" name="username" placeholder="Identifiant" class="form-control" value="<?php if(ISSET($_COOKIE['username'])){echo $_COOKIE['username'];}?>" required autofocus>
    </div>
    <div class="form-group">
      <button class="btn-block btn btn-primary" name="login" type="submit">Ré-initialiser</button>
    </div>
    <hr>
    <div class="text-center text-small text-muted">
      <span>Pas encore de compte? <a href="<?= BASE_URL; ?>user/useradd">Créer un compte</a>
      </span>
    </div>
  </form>
</div>
<div class="col-md-6 col-lg-4 d-none d-md-block">
  <?php if(!ISSET($_SESSION['id_user']))
          {require __DIR__ . '/../themes/front/template_module_login.php'; }
       else { require __DIR__ . '/../themes/front/template_module_logout.php';}
       require( __DIR__ . '/../themes/front/template_module_stats.php');?>
</div>
</div>
