<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('Location:' . BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Panneau d\'Administration'; ?>
<?php require('users_menu.php'); ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>
  <h2 id="usersbin">Corbeille</h2>
	<?php
	if ($counter_users_deleted < 1) {
		require __DIR__ . '/../errors/empty_bin.php';
	}
	else {?>
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
				<th>Avatar</th>
        <th>Prénom / Nom</th>
        <th>E-mail</th>
				<th>Consultation</th>
				<th>Restauration</th>
				<th>Suppression</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($user = $users_deleted->fetch())
      {
      ?>
      <tr>
				<td><div class="media">
					<a href="<?= BASE_ADMIN_URL. 'userread/' . $this->clean($user['id_user']) ;?>"><img class="img-fluid mr-3 rounded avatar" src="<?= BASE_URL; ?>public/images/avatars/<?= $this->clean(isset($user['avatar'])) ? $this->clean($user['avatar']) : $default ;?>" alt="user"></a>
				</div>
				</td>
				<td><div class="media">
					<div class="media-body">
						<h6 class="mt-2 text-left"><a href="<?= BASE_ADMIN_URL. 'userread/' . $this->clean($user['id_user']) ;?>"><?= $this->clean(isset($user['firstname'], $user['name']) ? $user['firstname'] . ' ' . $user['name'] : $user['author']);?></a></h6><br>
					</div>
				</div>
			  </td>
        <td><h6 class="mt-2 text-left"><a href="mailto:<?= $this->clean($user['email']); ?>"><?= $this->clean($user['email']); ?></a></h6></td>
        <td><a href="<?= BASE_ADMIN_URL. 'userread/' . $this->clean($user['id_user']) ;?>" role="button" class="btn btn-sm btn-primary">Consulter</a></td>
				<td><a href="<?= BASE_ADMIN_URL. 'restorethisuser/' . $this->clean($user['id_user'])?>" role="button" class="btn btn-sm btn-success">Restaurer</a></td>
			  <td><a href="<?= BASE_ADMIN_URL. 'removeuser/' . $this->clean($user['id_user']) ;?>" role="button" class="btn btn-sm btn-danger">Supprimer définitivement</a></td>
      </tr>

            <?php
    }
  ?>
    </tbody>
  </table>
	<?php require('usersbin_pagination.php');?>
	<div class="d-flex flex-row-reverse btn-toolbar mb-3 mb-md-0">
		<div class="btn-group mr-2">
			<a href="<?= BASE_ADMIN_URL; ?>emptyusers" role="button" class="float-right btn btn-sm btn-dark">Vider la Corbeille</a>
		</div>
	</div>
</div>
<?php };  ?>
<?php };  ?>
