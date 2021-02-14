<?php
require_once 'Framework/Controller.php';
require_once 'Model/Page.php';
require_once 'Model/Calculate.php';

/**
 * Contrôleur des actions liées aux Pages
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerPage extends Controller
{
    private $page;
    private $calculate;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->page      = new Page();
        $this->calculate = new Calculate();
    }

    // PAGES
    // Create

    // Affichage d'une seule Page :
    public function index()
    {
        $id_page                  = $this->request->getParameter("id");
        $page                    = $this->page->getPage($id_page);
        $number_of_links          = $this->calculate->getTotalOfLinks();
        $number_of_items          = $this->calculate->getTotalOfItemsHome();
        $number_of_cards          = $this->calculate->getTotalOfCards();
        $default                  = "default.png";
        $this->generateView(array(
            'page' => $page,
            'number_of_links' => $number_of_links,
            'number_of_items' => $number_of_items,
            'number_of_cards' => $number_of_cards,
            'default' => $default
        ));
    }


}
