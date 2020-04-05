<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active p-2" id="infos" role="tabpanel" aria-labelledby="pills-home-tab">
    <table class="table table-striped">
    <tbody>
      <tr>
        <th scope="row">E-Mail</th>
        <td><?= $user['email'] ?></td>
      </tr>
    <tr>
      <th scope="row">Prénom</th>
      <td><?= $user['firstname'] ?></td>
    </tr>
    <tr>
      <th scope="row">Nom</th>
      <td><?= $user['name'] ?></td>
    </tr>
    <tr>
      <th scope="row">Date de naissance</th>
      <td><?= strftime('%d/%m/%Y', strtotime($user['date_birth'])); ?></td>
    </tr>
    <tr>
      <th scope="row">Ville</th>
      <td><?= $user['city'] ?></td>
    </tr>
    <tr>
      <th scope="row">Linkedin</th>
      <td><?= $user['linkedin'] ?></td>
    </tr>
    <tr>
      <th scope="row">Github</th>
      <td><?= $user['github'] ?></td>
    </tr>
    <tr>
      <th scope="row">Twitter</th>
      <td><?= $user['twitter'] ?></td>
    </tr>
    <tr>
      <th scope="row">Site Web</th>
      <td><?= $user['website'] ?></td>
    </tr>
  </tbody>
</table>
<a href="user/useredit" class="btn btn-success" role="button">Modifier</a>
</div>
<div class="tab-pane fade p-2" id="username" role="tabpanel" aria-labelledby="pills-profile-tab">
<table class="table table-striped">
  <tbody>
    <tr>
      <th scope="row">Identifiant</th>
      <td><?php echo $user['username']?></td>
    </tr>
  </tbody>
</table>
<a href="user/useredit#username"><button class="btn btn-success" role="button">Modifier</button></a>
</div>
<div class="tab-pane fade p-2" id="password" role="tabpanel" aria-labelledby="pills-profile-tab">
<table class="table table-striped">
  <tbody>
    <tr>
      <th scope="row">Mot de passe</th>
      <td>********</td>
    </tr>
  </tbody>
</table>
<a href="user/useredit#password"><button class="btn btn-success" role="button">Modifier</button></a>
</div>
</div>
