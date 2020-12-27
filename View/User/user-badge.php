<div class="container">
  <div class="row justify-content-center">
    <div class="col">
      <div class="row">
        <div class="col">
        <span class="card card-article-wide flex-md-row no-gutters hover-shadow-3d">
        <div class="col-md-5 col-lg-3">
        <?php
        if (empty($user['avatar'])) {
        echo '<img src="'.BASE_URL.'public/images/avatars/default.png" alt="'.$this->clean($user['firstname']).'" title="'.$this->clean($user['firstname']).'" class="card-img-top">';} else {
        echo '<img src="'.BASE_URL.'public/images/avatars/'.$this->clean($user['avatar']).'" alt="'.$this->clean($user['firstname']).'" title="'.$this->clean($user['firstname']).'" class="card-img-top">'
        ;};
        ?>
      </div>
      <div class="card-body d-flex flex-column justify-content-between col-auto p-4 p-lg-5">
        <div>
          <?php require __DIR__ . '/../errors/errors.php'; ?>
          <?php require __DIR__ . '/../errors/confirmation.php'; ?>
          <h2><?= '<h1 class="mt-4">Bienvenue ' .$this->clean($user['firstname']). ' !</h1>';	?></h2>
          <div class="h6">Tu peux modifier ta photo de profil :</div>
        </div>
        <form action="<?= BASE_URL; ?>user/updateavatar" method="post" enctype="multipart/form-data">
          <div class="custom-file">
            <input type="file" name="avatar" class="custom-file-input" id="uploadimage">
            <label class="custom-file-label" data-browse="Parcourir..." for="avatar"></label>
          </div>
          <label for="avatar" class="text-muted text-small">(Formats autorisés : JPG, PNG ou GIF | max. 1 Mo)</label>
          <input type="hidden" name="MAX_FILE_SIZE" value="1048576">
          <br>
          <input type="submit" class="btn btn-md btn-success" name="update" value="Envoyer">
          <a href="<?= BASE_URL. 'user/profile/' .$this->clean($user['id_user']);?>"><span class="btn btn-md btn-info">Voir mon profil public</span></a>
        </form>
      </div>
    </span>
  </div>
</div>
</div>
</div>
</div>
