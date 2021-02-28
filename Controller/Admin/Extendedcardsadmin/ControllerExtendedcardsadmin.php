<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Category.php';
require_once 'Model/Link.php';
require_once 'Model/User.php';
require_once 'Model/Calculate.php';
require_once 'Model/Message.php';

/**
 * Contrôleur gérant les Items de type ExtendedCards
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerExtendedcardsadmin extends Controller
{
    private $user;
    private $item;
    private $category;
    private $link;
    private $calculate;
    private $message;

    public function __construct()
    {
        $this->user      = new User();
        $this->item      = new Item();
        $this->category  = new Category();
        $this->link      = new Link();
        $this->calculate = new Calculate();
        $this->message   = new Message();
    }

    // CREATE

    // Affichage du formulaire de création d'une Extended Card :
    public function extendedcardadditem()
    {
        $links_current_page = 1;
        $categories         = $this->category->getCategories();
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
            $draft                 = "yes";
            $id_user               = $_SESSION['id_user_admin'];
            $id_category           = $_POST['category'];
            $title                 = $_POST['title'];
            $content               = $_POST['content'];
            $owner                 = $_POST['owner'];
            $date_native           = $_POST['date_native'];
            $year_native           = $_POST['year_native'];
            $licence               = $_POST['licence'];
            $sgbdr                 = $_POST['sgbdr'];
            $number_of_users       = $_POST['number_of_users'];
            $pdm                   = $_POST['pdm'];
            $os_supported          = $_POST['os_supported'];
            $langage               = $_POST['langage'];
            $features              = $_POST['features'];
            $last_news             = $_POST['last_news'];
            $version               = $_POST['version'];
            $delimiter             = '-';
            $slug                  = $this->slugify($title, $delimiter);
            $extensions_authorized = array(
                "gif",
                "png",
                "jpg",
                "jpeg"
            );
            $extension_upload      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            if (isset($_POST['draft'])) {
                $draft = "no";
            }
            if (empty($title) || empty($content)) {
                $errors['errors'] = 'Veuillez remplir les champs <strong>Titre et Description</strong>';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . BASE_ADMIN_URL . 'extendedcardsadmin/extendedcardadditem');
                    exit;
                }
            }
            if (!empty($_FILES['image']['tmp_name']) && file_exists($_FILES['image']['tmp_name'])) {
                $fileinfo      = @getimagesize($_FILES["image"]["tmp_name"]);
                $width         = $fileinfo[0];
                $height        = $fileinfo[1];
                $time          = date("Y-m-d-H-i-s") . "-";
                $width         = $fileinfo[0];
                $height        = $fileinfo[1];
                $time          = date("Y-m-d-H-i-s") . "-";
                $itemimagename = str_replace(' ', '-', strtolower($_FILES['image']['name']));
                $itemimagename = preg_replace("/\.[^.\s]{3,4}$/", "", $itemimagename);
                $itemimagename = "{$time}$slug.{$extension_upload}";
                $destination   = ROOT_PATH . 'public/images/extendedcard_images';
                if (!in_array($extension_upload, $extensions_authorized)) {
                    $errors['errors'] = 'L\'extension du fichier n\'est pas autorisée.';
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header('Location: ' . BASE_ADMIN_URL . 'extendedcardsadmin/extendedcardadditem');
                        exit;
                    }
                } else if (($_FILES["image"]["size"] > 1000000)) {
                    $errors['errors'] = 'Le fichier est trop lourd.';
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header('Location: ' . BASE_ADMIN_URL . 'extendedcardsadmin/extendedcardadditem');
                        exit;
                    }
                } else if ($width < "800" && $height < "600") {
                    $errors['errors'] = 'Les dimensions sont trop petites. <br>Minimum : 800 X 600 px';
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header('Location: ' . BASE_ADMIN_URL . 'extendedcardsadmin/extendedcardadditem');
                        exit;
                    }
                } else {
                    move_uploaded_file($_FILES['image']['tmp_name'], $destination . "/" . $itemimagename);
                    $this->item->insertItemImage($id_user, $id_category, $title, $slug, $content, $itemimagename, $owner, $date_native, $year_native, $licence, $os_supported, $sgbdr, $number_of_users, $pdm, $langage, $features, $last_news, $version, $draft);
                    $this->message->extendedCardCreated();

                }
            } else {
                $this->item->insertItem($id_user, $id_category, $title, $slug, $content, $owner, $date_native, $year_native, $licence, $os_supported, $sgbdr, $number_of_users, $pdm, $langage, $features, $last_news, $version, $draft);
                $this->message->extendedCardCreated();
            }
        }
    }

    // READ


    // Affichage de la page Extended Cards en Admnin :
    public function index()
    {
        $number_of_items = $this->calculate->getTotalOfItemsAdmin();
        if (null != $this->request->ifParameter("id")) {
            $items_current_page = $this->request->getParameter("id");
        } else {
            $items_current_page = 1;
        }
        $items                 = $this->item->getItemsForAdmin($items_current_page);
        $page_previous_items   = $items_current_page - 1;
        $page_next_items       = $items_current_page + 1;
        $number_of_items_pages = $this->calculate->getNumberOfPagesOfExtAdmin();
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
        $item        = $this->item->getItem($id_item);
        $categories  = $this->category->getCategories();
        $id_category = $item['catid'];
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
            $id_item         = $this->request->getParameter("id");
            $id_category     = $_POST['catid'];
            $draft           = "yes";
            $title           = $this->request->getParameter("title");
            $slug            = $_POST['slug'];
            $content         = $this->request->getParameter("content");
            $owner           = $_POST['owner'];
            $date_native     = $_POST['date_native'];
            $year_native     = $_POST['year_native'];
            $licence         = $_POST['licence'];
            $os_supported    = $_POST['os_supported'];
            $sgbdr           = $_POST['sgbdr'];
            $number_of_users = $_POST['number_of_users'];
            $pdm             = $_POST['pdm'];
            $langage         = $_POST['langage'];
            $features        = $_POST['features'];
            $last_news       = $_POST['last_news'];
            $version         = $_POST['version'];
            $delimiter       = '-';
            $slug            = $this->slugify($title, $delimiter);
            if (isset($_POST['draft'])) {
                $draft = "no";
            }
            $extensions_authorized = array(
                "gif",
                "png",
                "jpg",
                "jpeg"
            );
            $extension_upload      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            if (!empty($_FILES['image']['tmp_name']) && file_exists($_FILES['image']['tmp_name'])) {
                $fileinfo      = @getimagesize($_FILES["image"]["tmp_name"]);
                $width         = $fileinfo[0];
                $height        = $fileinfo[1];
                $time          = date("Y-m-d-H-i-s") . "-";
                $itemimagename = str_replace(' ', '-', strtolower($_FILES['image']['name']));
                $itemimagename = preg_replace("/\.[^.\s]{3,4}$/", "", $itemimagename);
                $itemimagename = "{$time}$slug.{$extension_upload}";
                $destination   = ROOT_PATH . 'public/images/extendedcard_images';
                if (!in_array($extension_upload, $extensions_authorized)) {
                    $errors['errors'] = 'L\'extension du fichier n\'est pas autorisée.';
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header('Location: ' . BASE_ADMIN_URL . 'extendedcardsadmin/extendedcardread/' . $id_item);
                        exit;
                    }
                } else if (($_FILES["image"]["size"] > 1000000)) {
                    $errors['errors'] = 'Le fichier est trop lourd.';
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header('Location: ' . BASE_ADMIN_URL . 'extendedcardsadmin/extendedcardread/' . $id_item);
                        exit;
                    }
                } else if ($width < "800" && $height < "600") {
                    $errors['errors'] = 'Les dimensions sont trop petites. <br>Minimum : 800 X 600 px';
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header('Location: ' . BASE_ADMIN_URL . 'extendedcardsadmin/extendedcardread/' . $id_item);
                        exit;
                    }
                } else {
                    move_uploaded_file($_FILES['image']['tmp_name'], $destination . "/" . $itemimagename);
                    $this->item->changeItemImage($id_category, $title, $slug, $content, $itemimagename, $owner, $date_native, $year_native, $licence, $os_supported, $sgbdr, $number_of_users, $pdm, $langage, $features, $last_news, $version, $draft, $id_item);
                    $this->message->extendedCardUpdated($id_item);
                }
            } else {
                $messages = array();
                $this->item->changeItem($id_category, $title, $slug, $content, $owner, $date_native, $year_native, $licence, $os_supported, $sgbdr, $number_of_users, $pdm, $langage, $features, $last_news, $version, $draft, $id_item);
                $this->message->extendedCardUpdated($id_item);
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
        $this->message->extendedCardMoveToBin();

    }

    // Suppression définitive d'une Extended Card :
    public function removeitem()
    {
        $id_item = $this->request->getParameter("id");
        $this->item->eraseItem($id_item);
        $this->message->extendedCardErased();
    }

    // Vider la Corbeille Extended Cards :
    public function emptyextendedcards()
    {
        $this->item->emptybin();
        $this->message->extendedCardEmptyBin();
    }

    // Restaurer un item depuis la Corbeille :
    public function restorethisitem()
    {
        $id_item = $this->request->getParameter("id");
        $this->item->restoreItem($id_item);
        $this->message->extendedCardRestored();
    }

    // AUTRES FONCTIONS
    public function slugify($title, $delimiter)
    {
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
