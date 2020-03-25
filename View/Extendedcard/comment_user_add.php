<hr>
<div id="addcomment"></div>
<?php require __DIR__ . '/../errors/errors.php'; ?>
<h5 class="my-4">Ajoutez un commentaire :</h5>
<div class="my-4">
<form action="extendedcard/createcommentloggedin" method="post">
  <div class="row">
    <div class="col-md-12 mb-1">
      <div class="form-group">
        <div class="col-sm-7">
          <input type="hidden" id="id" name="id" value="<?= $this->clean($item['itemid']); ?>">
          <input type="hidden" id="user_id" name="user_id" value="<?= $_SESSION['id_user'];?>">
          <label for="author">| Connecté en tant que : </label>
          <input type="text" readonly class="form-control-plaintext text-left" name="author" id="author" value="<?= $this->clean($user['firstname']).' ' .$this->clean($user['name'])?>">
        </div>
      </div>
    </div>
  </div>
  <div class="form-group">
    <textarea class="form-control" name="content" rows="7" placeholder="Ecrivez ici votre commentaire"></textarea>
  </div>
  <div class="d-flex align-items-center justify-content-between">
    <div class="g-recaptcha" data-sitekey="<?= RECAPTCHA_SITE_KEY; ?>"></div>
  </div>
  <div class="d-flex align-items-center justify-content-between mt-2">
    <button class="btn btn-primary btn-block" type="submit">Envoyer</button>
  </div>
</form>
</div>
