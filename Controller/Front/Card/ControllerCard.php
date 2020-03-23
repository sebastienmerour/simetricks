<?php
require_once 'Framework/Controller.php';
require_once 'Model/Card.php';
require_once 'Model/User.php';
require_once 'Model/Calculate.php';

/**
 * Contrôleur des actions liées aux Cards
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerCard extends Controller
{
    private $card;
    private $user;
    private $calculate;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->card      = new Card();
        $this->user      = new User();
        $this->calculate = new Calculate();
    }

    // CARDS
    // Create

    // Affichage d'une seule Card :
    public function index()
    {
        $id_card                  = $this->request->getParameter("id");
        $card                     = $this->card->getCard($id_card);
        $number_of_cards          = $this->calculate->getTotalOfCards();
        $number_of_cards_pages    = $this->calculate->getNumberOfPagesOfCards();
        $default                  = "default.png";
        $this->generateView(array(
            'card' => $card,
            'number_of_cards' => $number_of_cards,
            'number_of_cards_pages' => $number_of_cards_pages,
            'default' => $default
        ));
    }


}
