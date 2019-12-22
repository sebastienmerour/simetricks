<?php $this->title =  WEBSITE_NAME . ' | Connexion'; ?>

<div class="row justify-content-center pt-3">
  <div class="col-8">
    <div class="text-center mb-4">
      <h1 class="mb-1">Connexion</h1>
      <span>Entrez votre identifiant et votre mot de passe ci-dessous :</span>
    </div>
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
        <span>Pas encore de compte? <a href="<?= BASE_URL; ?>user/adduser">Créer un compte</a>
        </span>
      </div>
    </form>
  </div>
</div>

<?php $this->sidebar= 'Le site contient ' . $number_of_items .' articles<br>
et '. $number_of_items_pages.' pages d\'articles.<br>'; ?>
