<?php
	if(!ISSET($_SESSION['id_user'])){
?>
<?php $this->title =  WEBSITE_NAME . ' | Inscription'; ?>

<div class="row justify-content-center pt-3">
	<div class="col-8">
		<div class="text-center mb-4">
			<h1 class="mb-1">Rejoignez le site</h1>
			<span>Inscription gratuite</span>
		</div>
		<div class="mb-3">
			<?php require __DIR__ . '/../errors/errors.php'; ?>
		</div>
		<form class="form-signin needs-validation" method="post" action="user/createuser" novalidate>
			<div class="form-group">
				<input type="text" id="username" name="username"  placeholder="Identifiant" class="form-control" required autofocus>
			</div>
			<div class="form-group">
				<input type="password" id="pass" name="pass" placeholder="Mot de passe" class="form-control"
				pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
				title="Votre mot de passe doit contenir au moins un chiffre, un lettre Majuscule, une lettre minuscule et au minimum 8 caractères"
				data-placement="right" required>
				<small class="text-muted">| Doit contenir au moins 8 caractères</small>
			</div>
			<div class="form-group">
				<input type="password" id="passcheck" name="passcheck" placeholder="Confirmez le mot de passe" class="form-control" required>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="email" name="email" placeholder="E-mail" required><br>
			</div>
			<div class="g-recaptcha mb-3" data-sitekey="6LehvscUAAAAAH8By_5qI0kdK8aaqHqVHDFwWm5W"></div>


			<div class="form-group">
				<button class="btn btn-primary btn-block" type="submit" name="register">Envoyer</button>
			</div>
			<div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" id="signup-agree">
				<label class="custom-control-label text-small text-muted" for="signup-agree">J'accepte les <a href="#">
					Conditions Générales d'Utilisation</a>
				</label>
			</div>
			<div id="feedback" class="text-left text-small text-muted mt-3">
				<span class="text-left">Votre mot de passe doit contenir :</span><br>
			  <span id="letter" class="invalid">- au moins <b>1 minuscule</b></span><br>
			  <span id="capital" class="invalid">- au moins <b>1 majuscule</b></span><br>
			  <span id="number" class="invalid">- au moins <b>1 chiffre</b></span><br>
			  <span id="length" class="invalid">- au minimum <b>8 caractères</b></span><br>
			</div>
			<?php
				if (!empty($_SESSION['errors']['username']))
				{?>
					<div class="bg-danger text-white rounded p-3 mb-3">
		  			<?php echo $_SESSION['errors']['username'];?>
					</div>
			<?php
				}
				if (!empty($_SESSION['errors']['passdifferent']))
				{?>
					<div class="bg-danger text-white rounded p-3 mb-3">
		  			<?php echo $_SESSION['errors']['passdifferent'];?>
					</div>
			<?php }
				if (!empty($_SESSION['errors']['email']))
				{?>
					<div class="bg-danger text-white rounded p-3 mb-3">
		  			<?php echo $_SESSION['errors']['email'];?>
					</div>
			 <?php
				} ?>
		<?php unset($_SESSION['errors']); ?>
		<?php
			if (!empty($_SESSION['messages']['usercreated']))
			{?>
					<div class="bg-success text-white rounded p-3">
		  			<?php echo $_SESSION['messages']['usercreated'];
						?>
					</div>
		Pour accéder à votre compte, veuillez vous identifier :
		<a href="login">cliquez ici</a>
			<?php
			}
			?>
		<?php unset($_SESSION['messages']); ?>
			<hr>
			<div class="text-center text-small text-muted">
				<span>Vous avez déjà un compte? <a href="login/">Identifiez-vous</a>
				</span>
			</div>
		</form>
	</div>
</div>
<?php $this->sidebar= 'Le blog contient ' . $number_of_items .' articles<br>
et '. $number_of_items_pages.' pages d\'articles.<br>'; ?>

<?php
}
else
{
  header('location: ../');
};
?>
