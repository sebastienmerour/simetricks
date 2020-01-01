<?php
require_once 'Framework/Controller.php';
require_once 'Model/User.php';
require_once 'Model/Item.php';
require_once 'Model/Calculate.php';

/**
 * Contrôleur gérant la connexion au site
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerLogin extends Controller
{
    private $user;
    private $item;
    private $calculate;

    public function __construct()
    {
        $this->user = new User();
        $this->item = new Item();
        $this->calculate = new Calculate();
    }

    // Affichage de la page de connexion :
    public function index()
    {
        $number_of_items       = $this->calculate->getTotalOfItems();
        $total_comments_count     = $this->calculate->getTotalOfComments();
        $total_users_count        = $this->calculate->getTotalOfUsers();
        $number_of_items_pages = $this->calculate->getNumberOfPages();
        $this->generateView(array(
            'number_of_items' => $number_of_items,
            'total_comments_count' => $total_comments_count,
            'total_users_count' => $total_users_count,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }

    // Processus de Connexion d'un user :
    public function login()
    {
        if ($this->request->ifParameter("username") && $this->request->ifParameter("pass")) {
            $username        = $this->request->getParameter("username");
            $passwordAttempt = $this->request->getParameter("pass");
            $this->user->logInUser($username, $passwordAttempt);
        } else
            throw new Exception("Action impossible : identifiant ou mot de passe non défini");
    }

    // Processus de Connexion d'un user sur l'interdace d'admin :
    public function loginadmin()
    {
        if ($this->request->ifParameter("username") && $this->request->ifParameter("pass")) {
            $username        = $this->request->getParameter("username");
            $passwordAttempt = $this->request->getParameter("pass");
            $this->user->logInUserAdmin($username, $passwordAttempt);
        } else
            throw new Exception("Action impossible : identifiant ou mot de passe non défini");
    }

    // Appui sur le bouton Deconnexion d'un user :
    public function logout()
    {
        $number_of_items       = $this->calculate->getTotalOfItems();
        $total_comments_count     = $this->calculate->getTotalOfComments();
        $total_users_count        = $this->calculate->getTotalOfUsers();
        if (ISSET($_SESSION['id_user'])) {
            $this->request->getSession()->destroy();
            // Suppression des cookies de connexion automatique
            setcookie('username', '');
            setcookie('pass', '');
            $this->generateView(array(
                'number_of_items' => $number_of_items,
                'total_comments_count' => $total_comments_count,
                'total_users_count' => $total_users_count
            ));
        } else {
            $this->redirect("login/invite");
        }
    }

    // Appui sur le bouton Deconnexion d'un user admin :
    public function logoutadmin()
    {
        if (ISSET($_SESSION['id_user_admin'])) {
            $this->request->getSession()->destroy();
            // Suppression des cookies de connexion automatique
            setcookie('username', '');
            setcookie('pass', '');
            $this->redirect("login/adminended");
        } else {
            $this->redirect("login/admininvite");
        }
    }

    // On invite un utilisateur non connecté à se connecter :
    public function invite()
    {
        $number_of_items       = $this->calculate->getTotalOfItems();
        $total_comments_count     = $this->calculate->getTotalOfComments();
        $total_users_count        = $this->calculate->getTotalOfUsers();
        $this->generateView(array(
            'number_of_items' => $number_of_items,
            'total_comments_count' => $total_comments_count,
            'total_users_count' => $total_users_count
        ));
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
