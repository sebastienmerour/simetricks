<?php
define("BASE_URL", "/simetricks/");
define("BASE_ADMIN_URL", "/simetricks/admintricks/");
define("ROOT_SERVER", $_SERVER["DOCUMENT_ROOT"] . "/");
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/simetricks/");
define("WEBSITE_NAME", "Simetricks");
define("COPYRIGHT_YEAR", "2020");
define("RECAPTCHA_SITE_KEY", "6LehvscUAAAAAH8By_5qI0kdK8aaqHqVHDFwWm5W");
define("RECAPTCHA_SECRET_KEY", "6LehvscUAAAAAKqwsNh3itC2eIpvnSe64ltCXxr3");

// Contrôleur frontal : instancie un routeur pour traiter la requête entrante
require 'Framework/Router.php';

$router = new Router();
$router->rootRequest();