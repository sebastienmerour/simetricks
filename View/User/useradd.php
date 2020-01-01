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
			<div class="form-group custom-control custom-checkbox text-right">
				<input type="checkbox" class="custom-control-input" id="cgu" name="cgu">
				<label class="custom-control-label text-small text-muted" for="cgu">J'accepte les <a href="#">
					Conditions Générales d'Utilisation</a>
				</label>
			</div>
			<div class="g-recaptcha mb-3" data-sitekey="<?= RECAPTCHA_SITE_KEY; ?>"></div>
			<div class="form-group">
				<button class="btn btn-primary btn-block" type="submit" name="register">Envoyer</button>
			</div>
			<div id="feedback" class="text-left text-small text-muted mt-3 mb-2">
				<span class="text-left">Votre mot de passe doit contenir :</span><br>
			  <span id="letter" class="invalid">- au moins <b>1 minuscule</b></span><br>
			  <span id="capital" class="invalid">- au moins <b>1 majuscule</b></span><br>
			  <span id="number" class="invalid">- au moins <b>1 chiffre</b></span><br>
			  <span id="length" class="invalid">- au minimum <b>8 caractères</b></span><br>
			</div>
		<?php
		if (!empty($_SESSION['messages']['confirmation']))
				{
				require __DIR__ . '/../errors/confirmation.php';
				?>
				Pour accéder à votre compte, veuillez vous identifier :
				<a href="login">cliquez ici</a>
				<?php
				}
			?>
			<hr>
			<div class="text-center text-small text-muted">
				<span>Vous avez déjà un compte? <a href="login/">Identifiez-vous</a>
				</span>
			</div>
		</form>
	</div>
</div>
<?php
}
else
{
  header('location: ../');
};
?>
