<hr>
<div id="addcomment"></div>
<?php require __DIR__ . '/../errors/errors.php'; ?>
<h5 class="my-4">Ajoutez un commentaire :</h5>
<div class="my-4">
<form action="item/createcomment" method="post">
  <div class="row">
    <div class="col-md-12 mb-1">
      <div class="form-group">
        <input type="hidden" id="id" name="id" value="<?= $this->clean($item['itemid']); ?>">
        <input type="text" class="form-control" placeholder="Prénom" name="author">
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
