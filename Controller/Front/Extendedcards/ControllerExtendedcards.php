<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Category.php';
require_once 'Model/User.php';
require_once 'Model/Calculate.php';


/**
 * Contrôleur gérant la section Extended Cards
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerExtendedcards extends Controller
{
    private $item;
    private $category;
    private $user;
    private $calculate;

    public function __construct()
    {
        $this->item      = new Item();
        $this->category  = new Category();
        $this->user      = new User();
        $this->calculate = new Calculate();
    }

    // Lister les Extended Cards :
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
        $number_of_items_pages = $this->calculate->getNumberOfPagesOfExtFront();
        $number_of_items       = $this->calculate->getTotalOfItemsFront();
        $total_comments_count  = $this->calculate->getTotalOfComments();
        $total_users_count     = $this->calculate->getTotalOfUsers();
        $this->generateView(array(
            'items' => $items,
            'number_of_items' => $number_of_items,
            'total_comments_count' => $total_comments_count,
            'total_users_count' => $total_users_count,
            'items_current_page' => $items_current_page,
            'previous_page' => $previous_page,
            'next_page' => $next_page,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }
}