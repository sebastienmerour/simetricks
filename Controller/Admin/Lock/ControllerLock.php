<?php
require_once 'Framework/Controller.php';
require_once 'Model/Login.php';
require_once 'Model/User.php';

/**
 * Contrôleur gérant l'authentification sur l'administration du site
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerLock extends Controller
{
    private $login;
    private $user;

    public function __construct()
    {
        $this->login = new Login();
        $this->user  = new User();
    }


    // Affichage de la page index :
    public function index()
    {
        $this->generateadminView();
    }

    // Processus de Connexion d'un user sur l'interdace d'admin :
    public function lock()
    {
        if ($this->request->ifParameter("username") && $this->request->ifParameter("pass")) {
            $username        = $this->request->getParameter("username");
            $passwordAttempt = $this->request->getParameter("pass");
            $this->login->logInUserAdmin($username, $passwordAttempt);
        } else
            throw new Exception("Action impossible : identifiant ou mot de passe non défini");
    }

    // Appui sur le bouton Deconnexion d'un user admin :
    public function logoutadmin()
    {
        if (ISSET($_SESSION['id_user_admin'])) {
            $this->request->getSession()->destroy();
            // Suppression des cookies de connexion automatique
            setcookie('username', '');
            setcookie('pass', '');
            $this->redirect("admintricks/lock/adminended");
        } else {
            $this->redirect("admintricks/lock/admininvite");
        }
    }

    // Fin de sessionn d'un admin :
    public function adminended()
    {
        $this->generateadminView();
    }

    // On invite un admin non connecté à se connecter :
    public function admininvite()
    {
        $this->generateadminView();
    }


}
