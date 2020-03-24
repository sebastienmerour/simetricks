<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Comment.php';
require_once 'Model/User.php';
require_once 'Model/Calculate.php';

/**
 * Contrôleur gérant la page d'accueil de l'administration du site
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerDashboard extends Controller
{
    private $user;
    private $item;
    private $comment;
    private $calculate;

    public function __construct()
    {
        $this->user      = new User();
        $this->item      = new Item();
        $this->comment   = new Comment();
        $this->calculate = new Calculate();
    }


    // Affichage de la page d'accueil après connexion :
    public function index()
    {
        $default               = "default.png";
        $items_current_page    = 1;
        $comments_current_page = 1;
        $users_current_page    = 1;
        $items                 = $this->item->getItemsAdmin($items_current_page);
        $comments              = $this->comment->selectComments($comments_current_page);
        $users                 = $this->user->selectUsers($users_current_page);
        $this->generateadminView(array(
            'default' => $default,
            'items' => $items,
            'comments' => $comments,
            'users' => $users
        ));
    }
}
