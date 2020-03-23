<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Category.php';
require_once 'Model/Link.php';
require_once 'Model/Comment.php';
require_once 'Model/User.php';
require_once 'Model/Calculate.php';

/**
 * Contrôleur gérant les Items de type ExtendedCards
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerExtendedcards extends Controller
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

    // Affichage du formulaire de création d'une Extended Card :
    public function extendedcardadditem()
    {
        $categories_current_page = 1;
        $links_current_page      = 1;
        $categories              = $this->category->getCategories($categories_current_page);
        $this->generateadminView(array(
            'categories' => $categories
        ));
    }

    // Processus de création d'une Extended Card :
    public function createitem()
    {
        if (isset($_POST["create"])) {
            $errors                = array();
            $messages              = array();
            $id_user               = $_SESSION['id_user_admin'];
            $id_category           = $_POST['category'];
            $title                 = $_POST['title'];
            $date_native           = $_POST['date_native'];
            $licence               = $_POST['licence'];
            $sgbdr                 = $_POST['sgbdr'];
            $pdm                   = $_POST['pdm'];
            $langage               = $_POST['langage'];
            $features              = $_POST['features'];
            $content               = $_POST['content'];
            $fileinfo              = @getimagesize($_FILES["image"]["tmp_name"]);
            $width                 = $fileinfo[0];
            $height                = $fileinfo[1];
            $extensions_authorized = array(
                "gif",
                "png",
                "jpg",
                "jpeg"
            );
            $extension_upload      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $time                  = date("Y-m-d-H-i-s") . "-";
            $delimiter             = '-';
            $slug                  = $this->slugify($title, $delimiter);
            $itemimagename         = str_replace(' ', '-', strtolower($_FILES['image']['name']));
            $itemimagename         = preg_replace("/\.[^.\s]{3,4}$/", "", $itemimagename);
            $itemimagename         = "{$time}$slug.{$extension_upload}";
            $destination           = ROOT_PATH . 'public/images/item_images';

            if (empty($title) || empty($content)) {
                $errors['errors'] = 'Veuillez remplir les champs <strong>Titre et Contenu</strong>';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . BASE_ADMIN_URL . 'extendedcards/extendedcardadditem');
                    exit;
                }
            }

            else if (!file_exists($_FILES["image"]["tmp_name"])) {
                $this->item->insertItem($id_user, $id_category, $title, $slug, $date_native, $licence, $sgbdr, $pdm, $langage, $features, $content);
            }

            else if (!in_array($extension_upload, $extensions_authorized)) {
                $errors['errors'] = 'L\'extension du fichier n\'est pas autorisée.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . BASE_ADMIN_URL . 'extendedcards/extendedcardadditem');
                    exit;
                }
            } else if (($_FILES["image"]["size"] > 1000000)) {
                $errors['errors'] = 'Le fichier est trop lourd.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . BASE_ADMIN_URL . 'extendedcards/extendedcardadditem');
                    exit;
                }
            } else if ($width < "800" && $height < "600") {
                $errors['errors'] = 'Les dimensions sont trop petites. <br>Minimum : 800 X 600 px';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . BASE_ADMIN_URL . 'extendedcards/extendedcardadditem');
                    exit;
                }
            }

            else {
                move_uploaded_file($_FILES['image']['tmp_name'], $destination . "/" . $itemimagename);
                $this->item->insertItemImage($id_user, $id_category, $title, $slug, $itemimagename, $date_native, $licence, $sgbdr, $pdm, $langage, $features, $content);

            }
        }
    }


    // READ

    // Affichage de la page Extended Cards :
    public function index()
    {
        $number_of_items = $this->calculate->getTotalOfItems();
        if (null != $this->request->ifParameter("id")) {
            $items_current_page = $this->request->getParameter("id");
        } else {
            $items_current_page = 1;
        }
        $items                 = $this->item->getItems($items_current_page);
        $page_previous_items   = $items_current_page - 1;
        $page_next_items       = $items_current_page + 1;
        $number_of_items_pages = $this->calculate->getNumberOfPagesOfExt();
        $this->generateadminView(array(
            'items' => $items,
            'number_of_items' => $number_of_items,
            'items_current_page' => $items_current_page,
            'page_previous_items' => $page_previous_items,
            'page_next_items' => $page_next_items,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }

    // Affichage d'une seule Extended Card :
    public function extendedcardread()
    {
        $id_item     = $this->request->getParameter("id");
        $categories  = $this->category->getCategories();
        $item        = $this->item->getItem($id_item);
        $id_category = $item['category'];
        $category    = $this->category->getCategory($id_category);
        $links       = $this->link->getLinks($id_item);
        $this->generateadminView(array(
            'item' => $item,
            'category' => $category,
            'categories' => $categories,
            'links' => $links
        ));
    }

    // UPDATE

    // Modification d'une Extended Card :
    public function updateitem()
    {
        if (isset($_POST["update"])) {
            $id_item               = $this->request->getParameter("id");
            $id_category           = $_POST['category'];
            $title                 = $this->request->getParameter("title");
            $slug                  = $_POST['slug'];
            $date_native           = $_POST['date_native'];
            $licence               = $_POST['licence'];
            $sgbdr                 = $_POST['sgbdr'];
            $pdm                   = $_POST['pdm'];
            $langage               = $_POST['langage'];
            $features              = $_POST['features'];
            $content               = $this->request->getParameter("content");
            $fileinfo              = @getimagesize($_FILES["image"]["tmp_name"]);
            $width                 = $fileinfo[0];
            $height                = $fileinfo[1];
            $extensions_authorized = array(
                "gif",
                "png",
                "jpg",
                "jpeg"
            );
            $extension_upload      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $time                  = date("Y-m-d-H-i-s") . "-";
            $delimiter             = '-';
            $slug                  = $this->slugify($title, $delimiter);
            $itemimagename         = str_replace(' ', '-', strtolower($_FILES['image']['name']));
            $itemimagename         = preg_replace("/\.[^.\s]{3,4}$/", "", $itemimagename);
            $itemimagename         = "{$time}$slug.{$extension_upload}";
            $destination           = ROOT_PATH . 'public/images/item_images';

            if (!file_exists($_FILES["image"]["tmp_name"])) {
                $messages    = array();
                $this->item->changeItem($id_category, $title, $slug, $date_native, $licence, $sgbdr, $pdm, $langage, $features, $content, $id_item);
            } else if (!in_array($extension_upload, $extensions_authorized)) {
                $errors['errors'] = 'L\'extension du fichier n\'est pas autorisée.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . BASE_ADMIN_URL . 'extendedcards/extendedcardread/' . $id_item);
                    exit;
                }
            } else if (($_FILES["image"]["size"] > 1000000)) {
                $errors['errors'] = 'Le fichier est trop lourd.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . BASE_ADMIN_URL . 'extendedcards/extendedcardread/' . $id_item);
                    exit;
                }
            } else if ($width < "800" && $height < "600") {
                $errors['errors'] = 'Les dimensions sont trop petites. <br>Minimum : 800 X 600 px';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . BASE_ADMIN_URL . 'extendedcards/extendedcardread/' . $id_item);
                    exit;
                }
            } else {
                move_uploaded_file($_FILES['image']['tmp_name'], $destination . "/" . $itemimagename);
                $this->item->changeItemImage($id_category, $title, $slug, $itemimagename, $date_native, $licence, $sgbdr, $pdm, $langage, $features, $content, $id_item);
            }
        }
    }

    // DELETE

    // Affichage de la Corbeille :
    public function extendedcardsbin()
    {
        $number_of_items_deleted = $this->calculate->getTotalOfItemsDeleted();
        if (null != $this->request->ifParameter("id")) {
            $items_deleted_current_page = $this->request->getParameter("id");
        } else {
            $items_deleted_current_page = 1;
        }
        $items_deleted                 = $this->item->getItemsDeleted($items_deleted_current_page);
        $page_previous_items_deleted   = $items_deleted_current_page - 1;
        $page_next_items_deleted       = $items_deleted_current_page + 1;
        $number_of_items_deleted_pages = $this->calculate->getNumberOfPagesOfExtDeleted();
        $this->generateadminView(array(
            'items_deleted' => $items_deleted,
            'number_of_items_deleted' => $number_of_items_deleted,
            'items_deleted_current_page' => $items_deleted_current_page,
            'page_previous_items_deleted' => $page_previous_items_deleted,
            'page_next_items_deleted' => $page_next_items_deleted,
            'number_of_items_deleted_pages' => $number_of_items_deleted_pages
        ));
    }

    // Déplacer un item vers la Corbeille :
    public function moveitemtobin()
    {
        $id_item = $this->request->getParameter("id");
        $this->item->moveItem($id_item);
    }

    // Suppression définitive d'une Extended Card :
    public function removeitem()
    {
        $id_item = $this->request->getParameter("id");
        $this->item->eraseItem($id_item);
        if ($id_item === false) {
            throw new Exception('Impossible de supprimer l\' Extended Card !');
        } else {
            $messages['confirmation'] = 'L\'Extended Card a bien été supprimée !';
            $this->generateadminView();
        }
    }

    // Vider la Corbeille Extended Cards :
    public function emptyextendedcards()
    {
        $this->item->emptybin();
    }

    // Restaurer un item depuis la Corbeille :
    public function restorethisitem()
    {
        $id_item = $this->request->getParameter("id");
        $this->item->restoreItem($id_item);
    }

    public function slugify($title, $delimiter) {
    	$oldLocale = setlocale(LC_ALL, '0');
    	setlocale(LC_ALL, 'en_US.UTF-8');
    	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $title);
      $clean = str_replace('\'', ' ', $clean);
    	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    	$clean = strtolower($clean);
    	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    	$clean = trim($clean, $delimiter);
    	setlocale(LC_ALL, $oldLocale);
    	return $clean;
    }


}
