<?php
require_once 'Framework/Controller.php';
require_once 'Model/Link.php';
require_once 'Model/Calculate.php';


/**
 * Contrôleur gérant la section Cards
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerLinks extends Controller
{
    private $link;
    private $calculate;

    public function __construct()
    {
        $this->link      = new Link();
        $this->calculate = new Calculate();
    }

    // Lister les Liens :
    public function index()
    {
        if (null != $this->request->ifParameter("id")) {
            $links_current_page = $this->request->getParameter("id");
        } else {
            $links_current_page = 1;
        }
        $number_of_links_pages = $this->calculate->getNumberOfPagesOfLinks();
        $links                 = $this->link->getLinksList($links_current_page, $number_of_links_pages);
        $previous_page         = $links_current_page - 1;
        $next_page             = $links_current_page + 1;
        $number_of_items       = $this->calculate->getTotalOfItemsHome();
        $number_of_cards       = $this->calculate->getTotalOfCards();
        $number_of_links      = $this->calculate->getTotalOfLinks();
        $this->generateView(array(
            'links' => $links,
            'number_of_items' => $number_of_items,
            'number_of_cards' => $number_of_cards,
            'number_of_links' => $number_of_links,
            'links_current_page' => $links_current_page,
            'previous_page' => $previous_page,
            'next_page' => $next_page,
            'number_of_links_pages' => $number_of_links_pages
        ));
    }
}
