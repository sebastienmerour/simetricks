<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Category.php';
require_once 'Model/Link.php';
require_once 'Model/Comment.php';
require_once 'Model/User.php';
require_once 'Model/Calculate.php';

/**
 * Contrôleur gérant la page d'accueil de l'administration du site
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerUseraccount extends Controller
{
    private $user;
    private $item;
    private $category;
    private $link;
    private $comment;
    private $calculate;

    public function __construct()
    {
        $this->user      = new User();
        $this->item      = new Item();
        $this->category  = new Category();
        $this->link      = new Link();
        $this->comment   = new Comment();
        $this->calculate = new Calculate();
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
