<?php
require_once 'Controller.php';
require_once 'Request.php';
require_once 'View.php';

/**
 * Classe pour le Routeur
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class Router
{

    // Route une requête entrante : exécute l'action associée
    public function rootRequest()
    {
        try {
            // Fusion des paramètres GET et POST de la requête
            $request    = new Request(array_merge($_GET, $_POST));
            $controller = $this->createController($request);
            $action     = $this->createAction($request);
            $controller->executeAction($action);
        }
        catch (Exception $e) {
            $this->manageError($e);
        }
    }

    // Crée le contrôleur approprié en fonction de la requête reçue
    private function createController(Request $request)
    {
        $q          = explode("/", $_SERVER['REQUEST_URI']);
        $folder     = "Front"; // Dossier par défaut
        $subfolder  = "Home"; // Sous-Dossier par défaut
        $controller = $subfolder;

        if ($request->ifParameter('controller')) {
        $controller = $request->getParameter('controller');
        // Première lettre en majuscule
        $controller = ucfirst(strtolower($controller));
        }


        if ($q[1] != "admintricks" AND $q[1] == false) {
            $subfolder  = "Home"; // Sous-Dossier par défaut
            $controller = $subfolder;
        }

        else if ($q[1] != "admintricks") {
            $subfolder = ucfirst($q[1]); // Sous-Dossier par défaut
            $controller = ucfirst($q[1]); // Sous-Dossier par défaut
        }

        else if ($q[1] != "admintricks" AND $request->ifParameter('token')) {
            $subfolder = "Login";
            $controller = "Login";
        }

        else if ($q[1] == "admintricks" AND $q[2] == false) {
            $folder     = "Admin"; // Dossier par défaut
            $subfolder  = "Lock"; // Sous-Dossier par défaut
            $controller = "Lock";
        }

        else if ($q[1] == "admintricks") {
            $folder     = "Admin"; // Dossier par défaut
            $subfolder  = ucfirst($q[2]); // Sous-Dossier par défaut
            $controller = ucfirst($q[2]);
        }

        // Création du nom du fichier du contrôleur
        $folderController    = $folder;
        $subFolderController = $subfolder;
        $classController     = "Controller" . $controller;
        $fileController      = "Controller/" . $folderController . "/" . $subFolderController . "/" . $classController . ".php";

        if ($q[1] != "admintricks"  AND $request->ifParameter('token'))  {
            $subfolder = "Login";
            $controller = "Login";
            $classController     = "Controller" . $controller;
            $fileController      = "Controller/Front/Login/ControllerLogin.php";
        }

        if (file_exists($fileController)) {
            // Instanciation du contrôleur adapté à la requête
            require($fileController);
            $controller = new $classController();
            $controller->setRequest($request);
            return $controller;
        } else
            throw new Exception("Fichier '$fileController' introuvable");
    }

    // Détermine l'action à exécuter en fonction de la requête reçue
    private function createAction(Request $request)
    {
        $q      = explode("/", $_SERVER['REQUEST_URI']);
        $action = "index"; // Action par défaut
        if ($request->ifParameter('action')) {
            $action = $request->getParameter('action');
        }
        return $action;
    }

    // Gère une erreur d'exécution (exception)
    private function manageError(Exception $exception)
    {
        $view = new View('error');
        $view->generateError(array(
            'generalerror' => $exception->getMessage()
        ));
    }
}
