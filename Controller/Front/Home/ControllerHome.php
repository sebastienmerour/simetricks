<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Calculate.php';


/**
 * Contrôleur gérant la page d'accueil
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerHome extends Controller
{
    private $item;
    private $calculate;

    public function __construct()
    {
        $this->item      = new Item();
        $this->calculate = new Calculate();
    }

    // Lister les articles en page d'accueil :
    public function index()
    {
        if (null != $this->request->ifParameter("id")) {
            $items_current_page = $this->request->getParameter("id");
        } else {
            $items_current_page = 1;
        }
        $items                 = $this->item->getItemsFront($items_current_page);
        $previous_page         = $items_current_page - 1;
        $next_page             = $items_current_page + 1;
        $number_of_items_pages = $this->calculate->getNumberOfPagesOfExtHome();
        $number_of_items       = $this->calculate->getTotalOfItemsHome();
        $number_of_cards       = $this->calculate->getTotalOfCards();
        $this->generateView(array(
            'items' => $items,
            'number_of_items' => $number_of_items,
            'number_of_cards' => $number_of_cards,
            'items_current_page' => $items_current_page,
            'previous_page' => $previous_page,
            'next_page' => $next_page,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }
}
