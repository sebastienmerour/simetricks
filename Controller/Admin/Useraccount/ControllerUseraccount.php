<?php
require_once 'Framework/Controller.php';
require_once 'Model/User.php';

/**
 * Contrôleur gérant la page d'accueil de l'administration du site
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerUseraccount extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user      = new User();
    }

    // Affichage du compte Admin :
    public function index()
    {
        $id_user = $_SESSION['id_user_admin'];
        $user    = $this->user->getUser($id_user);
        $this->generateadminView(array(
            'user' => $user
        ));
    }


}
