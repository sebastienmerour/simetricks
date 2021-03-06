<?php
require_once 'Framework/Controller.php';
require_once 'Model/Category.php';
require_once 'Model/Calculate.php';
require_once 'Model/Message.php';

/**
 * Contrôleur gérant les Catégories depuis l'administration du site
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerCategories extends Controller
{
    private $category;
    private $calculate;
    private $message;

    public function __construct()
    {
        $this->category  = new Category();
        $this->calculate = new Calculate();
        $this->message = new Message();
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
            $name         = $_POST['name'];
            $description  = $_POST['description'];
            $delimiter    = '-';
            $slugcategory = $this->slugify($name, $delimiter);

            if (empty($name) || empty($description)) {
                $errors['errors'] = 'Veuillez remplir tous les champs !';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . BASE_ADMIN_URL . 'categories/categoryadd');
                    exit;
                }
            }
            else {
            $this->category->insertCategory($name, $slugcategory, $description);
            $this->message->categoryCreated();
          }
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
            $id_category  = $this->request->getParameter("id");
            $name         = $this->request->getParameter("name");
            $slugcategory = $this->request->getParameter("slugcategory");
            $description  = $this->request->getParameter("description");
            $this->category->changeCategory($id_category, $name, $slugcategory, $description);
            $this->message->categoryUpdated($id_category);
        }
    }

    // Restaurer une Catégorie depuis la Corbeille :
    public function restorethiscategory()
    {
        $id_category = $this->request->getParameter("id");
        $this->category->restoreCategory($id_category);
        $this->message->categoryRestored();
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

    // Déplacer une catégorie vers la Corbeille :
    public function movecategorytobin()
    {
        $id_category = $this->request->getParameter("id");
        $this->category->moveCategory($id_category);
        $this->message->categoryMoveTobBin();
    }

    // Suppression définitive d'une Catégorie :
    public function removecategory()
    {
        $id_category = $this->request->getParameter("id");
        $this->category->eraseCategory($id_category);
        $this->message->categoryErased();
    }

    // Vider la Corbeille Catégorie :
    public function emptycategories()
    {
        $this->category->emptybin();
        $this->message->categoryEmptyBin();

    }

    public function slugify($name, $delimiter) {
    	$oldLocale = setlocale(LC_ALL, '0');
    	setlocale(LC_ALL, 'en_US.UTF-8');
    	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
      $clean = str_replace('\'', ' ', $clean);
    	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    	$clean = strtolower($clean);
    	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    	$clean = trim($clean, $delimiter);
    	setlocale(LC_ALL, $oldLocale);
    	return $clean;
    }


}
