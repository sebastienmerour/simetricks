<?php $this->title =  WEBSITE_NAME . ' | Connexion'; ?>
<div class="row mb-4">
    <div class="col-md-6 col-lg-8 d-flex flex-column align-items-center" data-aos-delay="200">
      <h1 class="mb-1">Connexion</h1>
      <span class="mb-3">Entrez votre identifiant et votre mot de passe ci-dessous :</span>
    <?php require __DIR__ . '/../errors/errors.php'; ?>
    <form method="post" action="login/login">
      <div class="form-group">
        <input type="text" name="username" placeholder="Identifiant" class="form-control" value="<?php if(ISSET($_COOKIE['username'])){echo $_COOKIE['username'];}?>" required autofocus>
      </div>
      <div class="form-group">
        <input type="password" id="pass" name="pass" placeholder="Mot de passe" class="form-control" value = "<?php if(ISSET($_COOKIE['pass'])){echo $_COOKIE['pass'];}?>" required>
        <small><a href="#">Mot de passe oublié?</a>
        </small>
      </div>
      <div class="form-group">
        <button class="btn-block btn btn-primary" name="login" type="submit">Se Connecter</button>
      </div>
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="rememberme" name="rememberme" <?php if(ISSET($_COOKIE['username'])){echo 'checked';}?>>
        <label class="custom-control-label text-small text-muted" for="rememberme">Connexion Automatique</label>
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
   else { require __DIR__ . '/../themes/front/template_module_logout.php';}?>
</div>
</div>
