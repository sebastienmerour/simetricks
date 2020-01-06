<?php
define("BASE_URL", "/simetricks/");
define("DOMAIN_NAME", "http://p4547.phpnet.org/simetricks/");
define("BASE_ADMIN_URL", "/simetricks/admintricks/");
define("ID_ADMIN", "18");
define("ROOT_SERVER", $_SERVER["DOCUMENT_ROOT"] . "/");
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/simetricks/");
define("WEBSITE_NAME", "Simetricks");
define("WEBMASTER_EMAIL", "contact@simetricks.com");
define("COPYRIGHT_YEAR", "2020");
define("RECAPTCHA_SITE_KEY", "6LehvscUAAAAAH8By_5qI0kdK8aaqHqVHDFwWm5W");
define("RECAPTCHA_SECRET_KEY", "6LehvscUAAAAAKqwsNh3itC2eIpvnSe64ltCXxr3");

// Contrôleur frontal : instancie un routeur pour traiter la requête entrante
require 'Framework/Router.php';

$router = new Router();
$router->rootRequest();
