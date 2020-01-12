<?php
define("BASE_URL", "/");
define("BASE_ADMIN_URL", "/admintricks/");
define("ROOT_SERVER", $_SERVER["DOCUMENT_ROOT"] . "/");
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/");
define("WEBSITE_NAME", "Simetricks");
define("COPYRIGHT_YEAR", "2020");

// Contrôleur frontal : instancie un routeur pour traiter la requête entrante
require '../Framework/Router.php';

$router = new Router();
$router->rootRequest();
