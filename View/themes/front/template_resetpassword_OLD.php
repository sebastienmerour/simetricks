<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Simetricks.com">
    <meta name="author" content="Sébastien Merour">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900" rel="stylesheet">
    <script src="https://kit.fontawesome.com/14f8a7289e.js"></script>
    <link rel="preload" as="font" href="http://www.simetricks.com/public/fonts/Inter-UI-upright.var.woff2" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" as="font" href="http://www.simetricks.com/public/fonts/Inter-UI.var.woff2" type="font/woff2" crossorigin="anonymous">
    <link href="http://www.simetricks.com/public/css/scroll-front.css" rel="stylesheet">
    <link href="http://www.simetricks.com/public/css/loaders/loader-typing.css" rel="stylesheet" media="all">
    <link type="text/css" href="http://www.simetricks.com/public/css/theme.css" rel="stylesheet" media="all">
    <link type="text/css" href="http://www.simetricks.com/public/css/simetricks.css" rel="stylesheet" media="all">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title><?= $title ?></title>
</head>
<body>
      <section data-overlay>
      	<div class="container">
          <p>Cher utilisateur,</p>
          <p>Pour ré-initialiser ton mot de passe, clique sur le lien ci-dessous :</p>
          <p><a class="btn btn-primary btn-block" href="<?= DOMAIN_NAME . 'index.php?controller=login&action=resetpassword&token=' . $token . '&email=' . $email . '&username=' . $username ;?>" target="_blank">
          Choisir un nouveau mot de passe</a></p>
          <p>Ce lien expire au bout de 24H pour des raisons de sécurité.</p>
          <p>Si tu n'es pas à  l'origine de la réception de cet e-mail, n'en tiens
          pas compte. Ton mot de passe ne sera pas ré-initialisé.
          Cependant, nous te conseillons de te connecter à ton compte et
          de modifier ton mot de passe, car il se peut que quelqu'un tente
          de deviner ton mot de passe.</p>
      		<?= $content ?>
      	</div>
      	</section>
  <footer class="pb-5 mt-5 bg-primary-alt">
    <div class="container">
      <div class="row mb-4 justify-content-center">
        <div class="col-auto">
          <a href="http://www.simetricks.com">
            <img width="150px" src="http://www.simetricks.com/public/images/logos/logo-xl.png" alt="<?= WEBSITE_NAME; ?>" title="<?= WEBSITE_NAME; ?>" class="icon icon-lg">
          </a>
        </div>
      </div>
      <div class="row mb-4">
        <div class="col">
          <ul class="nav justify-content-center">
            <li class="nav-item"><a href="#" class="nav-link">Cards</a>
            </li>
            <li class="nav-item"><a href="#" class="nav-link">Extended Cards</a>
            </li>
            <li class="nav-item"><a href="#" class="nav-link">2.0</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="row justify-content-center text-center">
        <div class="col-xl-10">
          <small class="text-muted">&copy; <?= COPYRIGHT_YEAR. ' Tous droits réservés.' ;?></small>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="http://www.simetricks.com/public/js/scroll.js"></script>
  <script src="http://www.simetricks.com/public/js/tab.js"></script>
  <script type="text/javascript" src="http://www.simetricks.com/public/js/password_policy.js"></script>
  <script type="text/javascript">
    window.addEventListener("load", function () {    document.querySelector('body').classList.add('loaded');  });
  </script>
  <script>
      $('#uploadimage').on('change',function(){
          //get the file name
          var fileName = $(this).val();
          fileName = fileName.substring(fileName.lastIndexOf("\\") + 1, fileName.length);
          //replace the "Choose a file" label
          $(this).next('.custom-file-label').html(fileName);
      })
  </script>
  </body>
  </html>
