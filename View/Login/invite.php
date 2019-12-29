<?php $this->title =  WEBSITE_NAME . ' | Connexion'; ?>

<div>
<!-- Bienvenue -->
<h1 class="mt-4">Bonjour !</h1>
<hr>

<!-- Confirmation -->
<div class="container">
  <div class="row">
    <p>Vous n'êtes pas connectés. &nbsp;</p>
    <p>Pour vous connecter, <a href="login">cliquez ici</a></p>
  </div>
</div>
<hr>
</div>
<?php $this->sidebar='Le site contient :<ul><li>' . $number_of_items .' extended cards</li>
  <li>' . $total_comments_count .' commentaires</li>
  <li>' . $total_users_count .' utilisateurs</li>
</ul>'; ?>
