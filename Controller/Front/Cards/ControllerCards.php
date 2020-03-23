<?php
require_once 'Framework/Controller.php';
require_once 'Model/Card.php';
require_once 'Model/User.php';
require_once 'Model/Calculate.php';


/**
 * Contrôleur gérant la section Cards
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerCards extends Controller
{
    private $card;
    private $user;
    private $calculate;

    public function __construct()
    {
        $this->card      = new Card();
        $this->user      = new User();
        $this->calculate = new Calculate();
    }

    // Lister les Cards :
    public function index()
    {
        if (null != $this->request->ifParameter("id")) {
            $cards_current_page = $this->request->getParameter("id");
        } else {
            $cards_current_page = 1;
        }
        $cards                 = $this->card->getCards($cards_current_page);
        $previous_page         = $cards_current_page - 1;
        $next_page             = $cards_current_page + 1;
        $number_of_cards_pages = $this->calculate->getNumberOfPagesOfCards();
        $number_of_cards       = $this->calculate->getTotalOfCards();
        $total_users_count     = $this->calculate->getTotalOfUsers();
        $this->generateView(array(
            'cards' => $cards,
            'number_of_cards' => $number_of_cards,
            'total_users_count' => $total_users_count,
            'cards_current_page' => $cards_current_page,
            'previous_page' => $previous_page,
            'next_page' => $next_page,
            'number_of_cards_pages' => $number_of_cards_pages
        ));
    }
}
