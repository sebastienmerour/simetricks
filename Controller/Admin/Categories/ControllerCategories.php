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

class ControllerCategories extends Controller
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


    // CREATE

    // Affichage du formulaire de création d'une catégorie :
    public function categoryadd()
    {
        $this->generateadminView();
    }

    // Processus de création d'une catégorie :
    public function createcategory()
    {
        if (isset($_POST["create"])) {
            $name        = $_POST['name'];
            $description = $_POST['description'];
            $this->category->insertCategory($name, $description);
        }
    }

    // READ

    // Affichage de la page Catégories : :
    public function index()
    {
        $number_of_categories = $this->calculate->getTotalOfCategories();
        $categories           = $this->category->getCategories();
        $this->generateadminView(array(
            'categories' => $categories,
            'number_of_categories' => $number_of_categories
        ));
    }

    // Affichage d'une catégorie seule :
    public function categoryread()
    {

        $id_category = $this->request->getParameter("id");
        $category    = $this->category->getCategory($id_category);
        $this->generateadminView(array(
            'category' => $category
        ));
    }


    // UPDATE

    // Modification d'une catégorie :
    public function updatecategory()
    {
        if (isset($_POST["update"])) {
            $id_category = $this->request->getParameter("id");
            $name        = $this->request->getParameter("name");
            $description = $this->request->getParameter("description");
            $this->category->changeCategory($id_category, $name, $description);
        }
    }

    // Restaurer une Catégorie depuis la Corbeille :
    public function restorethiscategory()
    {
        $id_category = $this->request->getParameter("id");
        $this->category->restoreCategory($id_category);
    }


    // DELETE

    // Affichage de la Corbeille Catégories :
    public function categoriesbin()
    {
        $number_of_categories_deleted = $this->calculate->getTotalOfCategoriesDeleted();
        $categories_deleted           = $this->category->getCategoriesDeleted();
        $this->generateadminView(array(
            'categories_deleted' => $categories_deleted,
            'number_of_categories_deleted' => $number_of_categories_deleted
        ));
    }


    // Déplacer un catégorie vers la Corbeille :
    public function movecategorytobin()
    {
        $id_category = $this->request->getParameter("id");
        $this->category->moveCategory($id_category);
    }

    // Suppression définitive d'une Catégorie :
    public function removecategory()
    {
        $id_category = $this->request->getParameter("id");
        $this->category->eraseCategory($id_category);
        if ($id_category === false) {
            throw new Exception('Impossible de supprimer la catégorie !');
        } else {
            $messages['confirmation'] = 'La Catégorie a bien été supprimée !';
            $this->generateadminView();
        }
    }

    // Vider la Corbeille Catégorie :
    public function emptycategories()
    {
        $this->category->emptybin();
    }


}
