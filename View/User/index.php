<?php
	if(!ISSET($_SESSION['id_user'])){
		header('location: '. BASE_URL. 'login/invite');
	}
	else {
?>
<?php $this->title =  WEBSITE_NAME . ' | Mon Compte'; ?>
<div class="row mb-4">
    <div class="col-md-6 col-lg-8 d-flex" data-aos-delay="200">
      <div class="row">
				<div class="col-md-12 col-lg-12 d-flex">
	      	<div class="card pt-2">
						<?php require('user-badge.php'); ?>
						<?php require('user-items.php'); ?>
						<?php require('user-tabs.php'); ?>
						<?php require('user-readonly.php'); ?>
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
<?php	};?>
