<?php $this->title = WEBSITE_NAME . ' | Profil de '.$this->clean($user['firstname']). ' '. $this->clean($user['name']).'' ?>
<!-- Vérification de l'existence de l'utilisateur -->
<?php if (empty($user)) { require __DIR__ . '/../errors/user_not_found.php';}
else {?>
<div class="row mb-4">
    <div class="col-md-6 col-lg-8 d-flex" data-aos-delay="200">
      <div class="row">
				<div class="col-md-12 col-lg-12 d-flex">
	         <div class="card pt-2">
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
                                <h2><?= '<h1 class="mt-4">Profil de '.$this->clean($user['firstname']). ' '. $this->clean($user['name']) ?></h2>
	                               </div>
                               </div>
							                </span>
							              </div>
							            </div>
							          </div>
							        </div>
							      </div>
                  </div>
                </div>
              </div>
            </div>
<div class="col-md-6 col-lg-4 d-none d-md-block">
  <?php if(!ISSET($_SESSION['id_user']))
          {require __DIR__ . '/../themes/front/template_module_login.php'; }
       else { require __DIR__ . '/../themes/front/template_module_logout.php';}
       require( __DIR__ . '/../themes/front/template_module_stats.php');?>
</div>
</div>
<?php };?>
