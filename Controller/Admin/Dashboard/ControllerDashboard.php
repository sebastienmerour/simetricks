<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Card.php';
require_once 'Model/User.php';

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
    private $card;

    public function __construct()
    {
        $this->user      = new User();
        $this->item      = new Item();
        $this->card      = new Card();
    }


    // Affichage de la page d'accueil après connexion :
    public function index()
    {
        $default               = "default.png";
        $items_current_page    = 1;
        $cards_current_page = 1;
        $users_current_page    = 1;
        $number_of_cards_pages = 1;
        $items                 = $this->item->getItemsAdmin($items_current_page);
        $cards                 = $this->card->getCards($cards_current_page, $number_of_cards_pages);
        $users                 = $this->user->selectUsers($users_current_page);
        $this->generateadminView(array(
            'default' => $default,
            'items' => $items,
            'cards' => $cards,
            'users' => $users
        ));
    }
}
