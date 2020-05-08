<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Category.php';
require_once 'Model/Comment.php';
require_once 'Model/User.php';
require_once 'Model/Calculate.php';

/**
 * Contrôleur des actions liées aux catégories
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerCategory extends Controller
{
    private $item;
    private $category;
    private $comment;
    private $user;
    private $calculate;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->item      = new Item();
        $this->category  = new Category();
        $this->comment   = new Comment();
        $this->user      = new User();
        $this->calculate = new Calculate();
    }
    // Lister les items liées à une Catégorie en Front :
    public function index()
    {
          $q                      = explode("/", $_SERVER['REQUEST_URI']);
          $cat                    = $q[2];
          $page                   = $q[3];
          $id_category            = (int) $cat;
          $category               = $this->category->getCategory($id_category);
          $items_current_page     = (int) $page;
          $items                  = $this->item->getItemsFromCategoryFront($cat, $items_current_page);
          $previous_page          = $items_current_page - 1;
          $next_page              = $items_current_page + 1;
          $number_of_items_pages  = $this->calculate->getNumberOfCatPagesFront($id_category);
          $number_of_itemsFromCat = $this->calculate->getTotalOfItemsFromCatFront($id_category);
          $number_of_items       = $this->calculate->getTotalOfItemsHome();
          $number_of_cards        = $this->calculate->getTotalOfCards();
          $total_comments_count   = $this->calculate->getTotalOfComments();
          $total_users_count      = $this->calculate->getTotalOfUsers();
          $this->generateView(array(
              'items' => $items,
              'number_of_items_FromCat' => $number_of_itemsFromCat,
              'number_of_items' => $number_of_items,
              'number_of_cards' => $number_of_cards,
              'total_comments_count' => $total_comments_count,
              'total_users_count' => $total_users_count,
              'items_current_page' => $items_current_page,
              'id_category' => $id_category,
              'category' => $category,
              'previous_page' => $previous_page,
              'next_page' => $next_page,
              'number_of_items_pages' => $number_of_items_pages
          ));
    }
  }
