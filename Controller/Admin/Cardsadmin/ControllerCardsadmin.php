<?php
require_once 'Framework/Controller.php';
require_once 'Model/Card.php';
require_once 'Model/Category.php';
require_once 'Model/Style.php';
require_once 'Model/User.php';
require_once 'Model/Calculate.php';
require_once 'Model/Message.php';

/**
 * Contrôleur gérant les Items de type Cards depuis l'administration du site
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerCardsadmin extends Controller
{
    private $user;
    private $card;
    private $category;
    private $style;
    private $calculate;
    private $message;

    public function __construct()
    {
        $this->user      = new User();
        $this->card      = new Card();
        $this->category  = new Category();
        $this->style     = new Style();
        $this->calculate = new Calculate();
        $this->message = new Message();
    }


    // CREATE

    // Affichage du formulaire de création d'une card :
    public function cardaddcard()
    {
        $categories              = $this->category->getCategories();
        $styles                  = $this->style->getStyles();
        $this->generateadminView(array(
            'categories' => $categories,
            'styles' => $styles
        ));
    }

    // Processus de création d'une Card :
    public function createcard()
    {
        if (isset($_POST["create"])) {
            $errors                = array();
            $messages              = array();
            $id_user               = $_SESSION['id_user_admin'];
            $id_category           = $_POST['category'];
            $id_style              = $_POST['style'];
            $title                 = $_POST['title'];
            $definition            = $_POST['definition'];
            $content               = $_POST['content'];
            $delimiter             = '-';
            $slugcard              = $this->slugify($title, $delimiter);
            if (empty($title) || empty($content)) {
                $errors['errors'] = 'Veuillez remplir les champs <strong>Titre et Contenu</strong>';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . BASE_ADMIN_URL . 'cardsadmin/cardaddcard');
                    exit;
                }
            }
            if(!empty($_FILES['image']['tmp_name'])
                 && file_exists($_FILES['image']['tmp_name'])) {
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
                   $cardimagename         = str_replace(' ', '-', strtolower($_FILES['image']['name']));
                   $cardimagename         = preg_replace("/\.[^.\s]{3,4}$/", "", $cardimagename);
                   $cardimagename         = "{$time}$slugcard.{$extension_upload}";
                   $destination           = ROOT_PATH . 'public/images/card_images';
                   if (!in_array($extension_upload, $extensions_authorized)) {
                       $errors['errors'] = 'L\'extension du fichier n\'est pas autorisée.';
                       if (!empty($errors)) {
                           $_SESSION['errors'] = $errors;
                           header('Location: ' . BASE_ADMIN_URL . 'cardsadmin/cardaddcard');
                           exit;
                       }
                   } else if (($_FILES["image"]["size"] > 1000000)) {
                       $errors['errors'] = 'Le fichier est trop lourd.';
                       if (!empty($errors)) {
                           $_SESSION['errors'] = $errors;
                           header('Location: ' . BASE_ADMIN_URL . 'cardsadmin/cardaddcard');
                           exit;
                       }
                   } else if ($width < "250" && $height < "250") {
                       $errors['errors'] = 'Les dimensions sont trop petites. <br>Minimum : 250 X 250 px';
                       if (!empty($errors)) {
                           $_SESSION['errors'] = $errors;
                           header('Location: ' . BASE_ADMIN_URL . 'cardsadmin/cardaddcard');
                           exit;
                       }
                   }
                   else {
                     move_uploaded_file($_FILES['image']['tmp_name'], $destination . "/" . $cardimagename);
                     $this->card->insertCardImage($id_user, $id_category, $id_style, $title, $slugcard, $cardimagename, $definition, $content);
                     $this->message->cardCreated();
                   }
                 }
            else {
                $this->card->insertCard($id_user, $id_category, $id_style, $title, $slugcard, $definition, $content);
                $this->message->cardCreated();
            }
        }
    }


    // READ

    // Affichage de la page Cards :
    public function index()
    {
        $number_of_cards = $this->calculate->getTotalOfCards();
        if (null != $this->request->ifParameter("id")) {
            $cards_current_page = $this->request->getParameter("id");
        } else {
            $cards_current_page = 1;
        }
        $number_of_cards_pages = $this->calculate->getNumberOfPagesOfCards();
        $cards                 = $this->card->getCards($cards_current_page, $number_of_cards_pages);
        $page_previous_cards   = $cards_current_page - 1;
        $page_next_cards       = $cards_current_page + 1;
        $this->generateadminView(array(
            'cards' => $cards,
            'number_of_cards' => $number_of_cards,
            'cards_current_page' => $cards_current_page,
            'page_previous_cards' => $page_previous_cards,
            'page_next_cards' => $page_next_cards,
            'number_of_cards_pages' => $number_of_cards_pages
        ));
    }

    // Affichage d'une seule Card :
    public function cardread()
    {
        $id_card     = $this->request->getParameter("id");
        $card        = $this->card->getCard($id_card);
        $categories  = $this->category->getCategories();
        $id_category = $card['category'];
        $category    = $this->category->getCategory($id_category);
        $styles      = $this->style->getStyles();
        $id_style    = $card['style'];
        $style       = $this->style->getStyle($id_style);
        $this->generateadminView(array(
            'card'        => $card,
            'category'    => $category,
            'categories'  => $categories,
            'style'       => $style,
            'styles'      => $styles
        ));
    }


    // UPDATE

    // Modification d'une Card :
    public function updatecard()
    {
        if (isset($_POST["update"])) {
            $id_card               = $this->request->getParameter("id");
            $id_category           = $_POST['category'];
            $id_style              = $_POST['style'];
            $title                 = $this->request->getParameter("title");
            $slugcard              = $_POST['slug'];
            $definition            = $_POST['definition'];
            $content               = $_POST['content'];
            $delimiter             = '-';
            $slugcard              = $this->slugify($title, $delimiter);


            if(!empty($_FILES['image']['tmp_name'])
                 && file_exists($_FILES['image']['tmp_name'])) {
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
                   $cardimagename         = str_replace(' ', '-', strtolower($_FILES['image']['name']));
                   $cardimagename         = preg_replace("/\.[^.\s]{3,4}$/", "", $cardimagename);
                   $cardimagename         = "{$time}$slugcard.{$extension_upload}";
                   $destination           = ROOT_PATH . 'public/images/card_images';
                   if (!in_array($extension_upload, $extensions_authorized)) {
                       $errors['errors'] = 'L\'extension du fichier n\'est pas autorisée.';
                       if (!empty($errors)) {
                           $_SESSION['errors'] = $errors;
                           header('Location: ' . BASE_ADMIN_URL . 'cardsadmin/cardread/' . $id_card);
                           exit;
                       }
                   } else if (($_FILES["image"]["size"] > 1000000)) {
                       $errors['errors'] = 'Le fichier est trop lourd.';
                       if (!empty($errors)) {
                           $_SESSION['errors'] = $errors;
                           header('Location: ' . BASE_ADMIN_URL . 'cardsadmin/cardread/' . $id_card);
                           exit;
                       }
                   } else if ($width < "250" && $height < "250") {
                       $errors['errors'] = 'Les dimensions sont trop petites. <br>Minimum : 250 X 250 px';
                       if (!empty($errors)) {
                           $_SESSION['errors'] = $errors;
                           header('Location: ' . BASE_ADMIN_URL . 'cardsadmin/cardread/' . $id_card);
                           exit;
                       }
                 }
                 move_uploaded_file($_FILES['image']['tmp_name'], $destination . "/" . $cardimagename);
                 $this->card->changeCardImage($id_category, $id_style, $title, $slugcard, $cardimagename, $definition, $content, $id_card);
                 $this->message->cardUpdated($id_card);
}
                 else {
                   $messages    = array();
                   $this->card->changeCard($id_category, $id_style, $title, $slugcard, $definition, $content, $id_card);
                   $this->message->cardUpdated($id_card);
                 }
            }
        }


    // DELETE

    // Affichage de la Corbeille :
    public function cardsbin()
    {
        $number_of_cards_deleted = $this->calculate->getTotalOfCardsDeleted();
        if (null != $this->request->ifParameter("id")) {
            $cards_deleted_current_page = $this->request->getParameter("id");
        } else {
            $cards_deleted_current_page = 1;
        }
        $cards_deleted                 = $this->card->getCardsDeleted($cards_deleted_current_page);
        $page_previous_cards_deleted   = $cards_deleted_current_page - 1;
        $page_next_cards_deleted       = $cards_deleted_current_page + 1;
        $number_of_cards_deleted_pages = $this->calculate->getNumberOfPagesOfCardsDeleted();
        $this->generateadminView(array(
            'cards_deleted' => $cards_deleted,
            'number_of_cards_deleted' => $number_of_cards_deleted,
            'cards_deleted_current_page' => $cards_deleted_current_page,
            'page_previous_cards_deleted' => $page_previous_cards_deleted,
            'page_next_cards_deleted' => $page_next_cards_deleted,
            'number_of_cards_deleted_pages' => $number_of_cards_deleted_pages
        ));
    }

    // Déplacer une card vers la Corbeille :
    public function movecardtobin()
    {
        $id_card = $this->request->getParameter("id");
        $this->card->moveCard($id_card);
        $this->message->cardMoveTobBin();
    }

    // Suppression définitive d'une Card :
    public function removecard()
    {
        $id_card = $this->request->getParameter("id");
        $this->card->eraseCard($id_card);
        $this->message->cardErased();
    }


    // Vider la Corbeille Cards :
    public function emptycards()
    {
        $this->card->emptybin();
        $this->message->cardEmptyBin();
    }

    // Restaurer une Card depuis la Corbeille :
    public function restorethiscard()
    {
        $id_card = $this->request->getParameter("id");
        $this->card->restoreCard($id_card);
        $this->message->cardRestored();
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
