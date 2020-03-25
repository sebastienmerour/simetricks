<?php $this->title =  WEBSITE_NAME . ' | Modification de commentaire'; ?>
<?php
if (empty($comment)) {
							require __DIR__ . '/../errors/comment_not_found.php';
			    } else {
 ?>
 <div class="container">
	 <div class="row mb-4">
		 <div class="col-md-8 col-lg-8">
			 <div class="pr-lg-4">
				 <?php require __DIR__ . '/../errors/confirmation.php';	?>
				 <div class="card card-body justify-content-between bg-light">
					 <div class="d-flex justify-content-between mb-3">
						 <div class="text-small d-flex">
							 <div class="mr-2">
								 <em class="fas fa-edit"></em>
							 </div>
							 <span class="opacity-90">Modifier le Commentaire :</span>
						 </div>
					 </div>
					 <div>
						 <form role="form" class="form needs-validation" action="<?php echo BASE_URL; ?>extendedcard/updatecomment/<?= $this->clean($item['itemid']) ?>/<?= $this->clean($comment['id']) ;?>/" method="post" id="commentmodification" novalidate>
							 <div class="form-group">
									 <div class="col-xs-6 p-2 d-flex justify-content-start">
										 <img src="<?php echo BASE_URL; ?>public/images/avatars/<?= $this->clean(isset($comment['avatar_com']) ? $comment['avatar_com'] : $default );?>" alt="user" class="avatar avatar-lg">
										 	<div class="row">
												<div class="d-flex pl-4 flex-column">
													<h6 class="mt-0"><?= $this->clean(isset($comment['firstname_com'], $comment['name_com']) ? $comment['firstname_com'] . ' ' . $comment['name_com'] : $comment['author']);?></h6><br>
	 											<em>le <?= $this->clean($comment['date_creation_fr']); ?></em>
											</div>
					 				</div>
								</div>
					 		<textarea class="form-control" name="content" id="content"
							placeholder="<?= $this->clean($comment['content']);?>"
							title="Modifiez le commentaire si besoin"><?= $this->clean($comment['content']);?></textarea>
			 		</div>
					<div class="form-group">
						<div class="col-xs-12">
				 		<br>
						<button class="btn btn-md btn-success" name="modify" type="submit">Enregistrer</button>
						<a href="#"><button class="btn btn-md btn-secondary" type="reset">Annuler</button></a>
				 		<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><button class="btn btn-md btn-primary" type="button">Retour</button></a>
					</div>
				</div>
	 	</form>
	 	</div>
 	</div>
</div>
<?php } ;?>
<?php require('comments.php'); ?>
<?php require('comments_pagination.php');?>
<?php require('comment_user_add.php');?>
</div>
</div>

<div class="col-md-4 col-lg-4 d-none d-md-block">
	<div class="mb-4">
		<?php if(!ISSET($_SESSION['id_user']))
	          {require __DIR__ . '/../themes/front/template_module_login.php'; }
	       else { require __DIR__ . '/../themes/front/template_module_logout.php';}
	       require( __DIR__ . '/../themes/front/template_module_stats.php');?>
</div>
</div>
