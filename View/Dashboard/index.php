<?php
	if(!ISSET($_SESSION['id_user_admin'])){
		header('location: '. BASE_ADMIN_URL);
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' |  Panneau d\'Administration'; ?>
<?php require __DIR__ . '/../errors/confirmation.php'; ?>

<h2 id="lastitems">Dernières Extended Cards</h2>
<div class="table-responsive">
	<table class="table table-striped table-sm">
		<thead>
			<tr>
				<th>Date</th>
				<th>Auteur</th>
				<th>Image</th>
				<th>Titre</th>
				<th>Brouillon</th>
				<th>Modification</th>
				<th>Suppression</th>
			</tr>
		</thead>
		<tbody>

      <?php
      while ($item = $items->fetch()) {
      ?>
      <tr>
				<td><h6 class="mt-2 text-left"><?= $this->clean($item['date_creation_fr']); ?></h6></td>
        <td><h6 class="mt-2 text-left"><a target="_blank" href="<?= BASE_ADMIN_URL.'users/userread/' . $this->clean($item['id_user']) ?>">
        <?= $this->clean($item['firstname']); ?>&nbsp;<?= $this->clean($item['name']);?></a></span></td>
				<td><a href="<?= BASE_ADMIN_URL.'extendedcardsadmin/extendedcardread/' . $this->clean($item['itemid'])?>">
				<img width="125px" src="<?= BASE_URL. 'public/images/extendedcard_images/' .$this->clean($item['image'])?>" class="figure-img img-fluid rounded-right"
				alt="<?= $this->clean($item['title']) ?>" title="<?= $this->clean($item['title']) ?>"></a></td>
        <td><span class="text-body newstitle"><a href="<?= BASE_ADMIN_URL.'extendedcardsadmin/extendedcardread/' . $this->clean($item['itemid'])?>">
				<h6 class="mt-2 text-left"><?= $this->clean($item['title']); ?></h6></a></span></td>
				<td><?php if ($this->clean($item['draft']) == "yes"){ ?><span class="badge badge-warning">Br.</span><?php };?></td>
        <td><a href="<?= BASE_ADMIN_URL. 'extendedcardsadmin/extendedcardread/' . $this->clean($item['itemid'])?>/" role="button" class="btn btn-sm btn-primary">Modifier</a></td>
        <td><a href="<?= BASE_ADMIN_URL. 'extendedcardsadmin/moveitemtobin/' . $this->clean($item['itemid'])?>" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>
		  </tr>
      <?php
        }
      ?>
    </tbody>
  </table>
		<div class="d-flex flex-row-reverse btn-toolbar mb-3 mb-md-0">
			<div class="btn-group mr-2">
				<a href="<?= BASE_ADMIN_URL; ?>extendedcardsadmin" role="button" class="float-right btn btn-sm btn-info"><em class="far fa-folder-open mr-1"></em>Toutes les Extended Cards</a>
			</div>
		</div>

		<h2 id="lastcards">Dernières Cards</h2>
		<div class="table-responsive">
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th>Date</th>
						<th>Titre</th>
						<th>Style</th>
						<th>Image</th>
		        <th>Modification</th>
		        <th>Suppression</th>
					</tr>
				</thead>
				<tbody>
					<?php
		      while ($card = $cards->fetch()) {
		      ?>
		      <tr>
		        <td><h6 class="mt-2 text-left"><?= $this->clean($card['date_creation_fr']); ?></h6></td>
						<td><span class="text-body newstitle"><a href="<?= BASE_ADMIN_URL.'cardsadmin/cardread/' . $this->clean($card['id'])?>">
						<h6 class="mt-2 text-left"><?= $this->clean($card['title']); ?></h6></a></span></td>
						<td><h6 class="mt-2 mr-3 btn-sm rounded text-white" style="background-color:<?= $this->clean($card['stylehexadecimal']); ?>"><?= $this->clean($card['styledescription']); ?>&nbsp;</h6></td>
						<td><a href="<?= BASE_ADMIN_URL.'cardsadmin/cardread/' . $this->clean($card['id'])?>">
						<img width="125px" src="<?= BASE_URL. 'public/images/card_images/' .$this->clean($card['image'])?>" class="figure-img img-fluid rounded-right"
						alt="<?= $this->clean($card['title']) ?>" title="<?= $this->clean($card['title']) ?>"></a></td>
		        <td><a href="<?= BASE_ADMIN_URL. 'cardsadmin/cardread/' . $this->clean($card['id'])?>" role="button" class="btn btn-sm btn-primary">Modifier</a></td>
		        <td><a href="<?= BASE_ADMIN_URL. 'cardsadmin/movecardtobin/' . $this->clean($card['id'])?>" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>
		      </tr>
		      <?php
		        }
		      ?>
		    </tbody>
		  </table>
		</div>
			<div class="d-flex flex-row-reverse btn-toolbar mb-3 mb-md-0">
				<div class="btn-group mr-2">
					<a href="<?= BASE_ADMIN_URL; ?>cardsadmin" role="button" class="float-right btn btn-sm btn-info"><em class="far fa-folder-open mr-1"></em>Toutes les Cards</a>
				</div>
			</div>

			<h2 id="lastusers">Nouveaux Utilisateurs</h2>
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
							<td><h6 class="mt-2 text-left"><?= $this->clean($user['date_register_fr']); ?></h6></td>
			        <td><a href="<?= BASE_ADMIN_URL. 'users/userread/' . $this->clean($user['id_user']) ;?>" role="button" class="btn btn-sm btn-primary">Modifier</a></td>
			        <td><a href="<?= BASE_ADMIN_URL. 'users/moveusertobin/' . $this->clean($user['id_user']) ;?>" role="button" class="btn btn-sm btn-danger">Supprimer</a></td>
			      </tr>
					<?php }	?>
			    </tbody>
			  </table>
			</div>
			<div class="d-flex flex-row-reverse btn-toolbar mb-3 mb-md-0">
				<div class="btn-group mr-2">
					<a href="<?= BASE_ADMIN_URL; ?>users" role="button" class="float-right btn btn-sm btn-info"><em class="far fa-folder-open mr-1"></em>Tous les Utilisateurs</a>
				</div>
			</div>

</div>
<?php
};
?>
