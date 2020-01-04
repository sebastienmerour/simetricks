<div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active p-2" id="infos" role="tabpanel" aria-labelledby="pills-home-tab">
        <form role="form" class="form needs-validation" action="user/updateuser" method="post" id="usermodification" novalidate>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <div class="col-xs-6">
                  <label class="pl-1" for="password">Mot de passe :</label>
                  <input type="password" class="form-control" name="pass" id="pass" placeholder="Mot de passe"
                  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                  title="Votre mot de passe doit contenir au moins un chiffre, un lettre Majuscule, une lettre minuscule et au minimum 8 caractères"
                  data-placement="left">
                  <small id="input-group-help" class="form-text text-muted">| doit contenir au moins un chiffre, un lettre Majuscule, une lettre minuscule et au minimum 8 caractères</small><br>
                  <input type="password" class="form-control" name="passcheck" id="pass2" placeholder="Confirmez le mot de passe" data-placement="left">
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-6">
                  <label class="pl-1" for="email">E-Mail :</label>
                  <input type="email" class="form-control" name="email" id="email" value="<?php echo $user['email']?>" title="Modifiez votre email si besoin">
                </div>
              </div>
            </div>
            <div class="col-6">
            <div class="form-group">
                <div class="col-xs-6">
                    <label class="pl-1" for="firstname">Prénom :</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $user['firstname']?>" title="Modifiez votre prénom si besoin">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-6">
                  <label class="pl-1" for="name">Nom :</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?php echo $user['name'] ?>" title="Modifiez votre nom si besoin">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-6">
                    <label class="pl-1" for="date_birth">Date de naissance :</label>
                    <input type="date" class="form-control" name="date_birth" id="date_birth" value="<?= strftime('%Y-%m-%d', strtotime($user['date_birth'])); ?>" title="Modifiez votre date de naissance si besoin">
                </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
            <button class="btn btn-md btn-success" name="useredit" type="submit">Enregistrer</button>
            <a href="#" class="btn btn-md btn-secondary" type="reset">Annuler</a>
            <a href="<?= $_SERVER['HTTP_REFERER']; ?>" class="btn btn-md btn-primary" role="button">Retour</a>
          </div>
        </div>
        <div id="feedback" class="text-left">
          <span class="text-left">Votre mot de passe doit contenir :</span><br>
          <span id="letter" class="invalid">- au moins <b>1 minuscule</b></span><br>
          <span id="capital" class="invalid">- au moins <b>1 majuscule</b></span><br>
          <span id="number" class="invalid">- au moins <b>1 chiffre</b></span><br>
          <span id="length" class="invalid">- au minimum <b>8 caractères</b></span><br>
        </div>
      </form>
</div>
<div class="tab-pane fade p-2" id="username" role="tabpanel" aria-labelledby="pills-profile-tab">
<form role="form" class="form needs-validation" action="user/updateusername" method="post" id="usermodification" novalidate>
  <div class="form-group">
      <div class="col-xs-6">
          <label class="pl-1" for="username">Identifiant :</label>
          <input type="text" class="form-control" name="username" id="username" value="<?php echo $user['username']?>" title="Modifiez votre identifiant si besoin">
      </div>
  </div>
  <div class="form-group">
    <div class="col-xs-12">
      <button class="btn btn-md btn-success" name="editusername" type="submit">Enregistrer</button>
      <a href="#"><button class="btn btn-md btn-secondary" type="reset">Annuler</button></a>
      <a href="<?= $_SERVER['HTTP_REFERER']; ?>"><button class="btn btn-md btn-primary" type="button">Retour</button></a>
    </div>
    </div>
  </form>
</div>
</div>
