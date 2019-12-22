<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Panneau d\'Administration'; ?>
  <!-- News -->
	<?php require __DIR__ . '/../errors/confirmation.php'; ?>

<h2 id="allcomments">Utilisateurs</h2>
<?php
if ($counter_users < 1) {
  require __DIR__ . '/../view/errors/users_not_found.php';
}

else {
require('users_pagination.php');}
?>
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
				<th>Avatar</th>
        <th>Prénom / Nom</th>
        <th>E-mail</th>
        <th>Date d'enregistrement</th>
				<th>Modification</th>
				<th>Suppression</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($user = $users->fetch())
      {
      ?>
      <tr>
				<td><div class="media mb-4">
					<a href="<?= BASE_ADMIN_URL. 'readuser/' . $this->clean($user['id_user']) ;?>"><img class="img-fluid mr-3 rounded avatar" src="<?= BASE_URL; ?>public/images/avatars/<?= $this->clean(isset($user['avatar'])) ? $this->clean($user['avatar']) : $default ;?>" alt="user"></a>
				</div>
				</td>
				<td><div class="media mb-4">
					<div class="media-body">
						<h6 class="mt-2 text-left"><a href="<?= BASE_ADMIN_URL. 'readuser/' . $this->clean($user['id_user']) ;?>"><?= $this->clean(isset($user['firstname'], $user['name']) ? $user['firstname'] . ' ' . $user['name'] : $user['author']);?></a></h6><br>
					</div>
				</div>
			  </td>
        <td><h6 class="mt-2 text-left"><a href="mailto:<?= $this->clean($user['email']); ?>"><?= $this->clean($user['email']); ?></a></h6></td>
				<td><h6 class="mt-2 text-left"><?= $this->clean($user['date_register_fr']); ?></h6></td>
        <td><a href="<?= BASE_ADMIN_URL. 'readuser/' . $this->clean($user['id_user']) ;?>" role="button" class="btn btn-sm btn-primary">Modifier</a></td>
        <td><a href="<?= BASE_ADMIN_URL. 'removeuser/' . $this->clean($user['id_user']) ;?>" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>
      </tr>
            <?php
    }
  ?>
    </tbody>
  </table>
</div>
<?php
if ($counter_users < 1) {
  require __DIR__ . '/../view/errors/users_not_found_admin.php';
}
else {
	require('users_pagination.php');}
?>
</div>
<?php
};
?>
