<?php
define("BASE_URL", "/simetricks/");
define("ROOT_SERVER", $_SERVER["DOCUMENT_ROOT"] . "/");
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/simetricks/");

// Contrôleur frontal : instancie un routeur pour traiter la requête entrante
require 'Framework/Router.php';

$router = new Router();
$router->rootRequest();
