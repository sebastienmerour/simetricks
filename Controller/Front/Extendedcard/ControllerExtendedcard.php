<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Link.php';
require_once 'Model/Category.php';
require_once 'Model/Comment.php';
require_once 'Model/User.php';
require_once 'Model/Calculate.php';

/**
 * Contrôleur des actions liées aux Extended Cards
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerExtendedcard extends Controller
{
    private $item;
    private $link;
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
        $this->link      = new Link();
        $this->category  = new Category();
        $this->comment   = new Comment();
        $this->user      = new User();
        $this->calculate = new Calculate();
    }

    // ITEMS
    // Read

    // Affichage d'un seul item avec ses commentaires - pour user inconnu :
    public function index()
    {
        $id_item                  = $this->request->getParameter("id");
        $item                     = $this->item->getItem($id_item);
        $id_category              = $item['category'];
        $category                 = $this->category->getCategory($id_category);
        $number_of_items          = $this->calculate->getTotalOfItemsFront();
        $number_of_cards          = $this->calculate->getTotalOfCards();
        $number_of_links          = $this->calculate->getTotalOfLinks();
        $number_of_links          = $this->calculate->getTotalOfLinks();
        $number_of_items_pages    = $this->calculate->getNumberOfPagesOfExtFront();
        $page_view                = $this->calculate->pageviewItemId($id_item);
        $number_of_comments       = $this->calculate->countComments($id_item);
        $comments_current_page    = $this->calculate->getCommentsCurrentPage();
        $page_previous_comments   = $comments_current_page - 1;
        $page_next_comments       = $comments_current_page + 1;
        $comments                 = $this->comment->getPaginationComments($id_item, $comments_current_page);
        $total_comments_count     = $this->calculate->getTotalOfComments();
        $total_users_count        = $this->calculate->getTotalOfUsers();
        $links                    = $this->link->getLinks($id_item);
        $default                  = "default.png";
        $number_of_comments_pages = $this->calculate->getNumberOfCommentsPagesFromItem($id_item);
        $this->generateView(array(
            'item' => $item,
            'category' => $category,
            'number_of_items' => $number_of_items,
            'number_of_cards' => $number_of_cards,
            'number_of_links' => $number_of_links,
            'number_of_items_pages' => $number_of_items_pages,
            'comments' => $comments,
            'links' => $links,
            'total_comments_count' => $total_comments_count,
            'total_users_count' => $total_users_count,
            'default' => $default,
            'comments_current_page' => $comments_current_page,
            'page_previous_comments' => $page_previous_comments,
            'page_next_comments' => $page_next_comments,
            'number_of_comments' => $number_of_comments,
            'number_of_comments_pages' => $number_of_comments_pages
        ));
    }

    // Affichage d'un seul item avec ses commentaires - pour user connecté :
    public function indexuser()
    {
        $id_item                  = $this->request->getParameter("id");
        $item                     = $this->item->getItem($id_item);
        $id_category              = $item['category'];
        $category                 = $this->category->getCategory($id_category);
        $user                     = $this->user->getUser($_SESSION['id_user']);
        $number_of_items          = $this->calculate->getTotalOfItemsFront();
        $number_of_cards          = $this->calculate->getTotalOfCards();
        $number_of_links          = $this->calculate->getTotalOfLinks();
        $total_comments_count     = $this->calculate->getTotalOfComments();
        $total_users_count        = $this->calculate->getTotalOfUsers();
        $links                    = $this->link->getLinks($id_item);
        $number_of_comments       = $this->calculate->countComments($id_item);
        $comments_current_page    = $this->calculate->getCommentsCurrentPageUser();
        $page_previous_comments   = $comments_current_page - 1;
        $page_next_comments       = $comments_current_page + 1;
        $comments                 = $this->comment->getPaginationComments($id_item, $comments_current_page);
        $default                  = "default.png";
        $number_of_comments_pages = $this->calculate->getNumberOfCommentsPagesFromItem($id_item);
        $this->generateView(array(
            'item' => $item,
            'category' => $category,
            'number_of_items' => $number_of_items,
            'number_of_cards' => $number_of_cards,
            'number_of_links' => $number_of_links,
            'total_comments_count' => $total_comments_count,
            'total_users_count' => $total_users_count,
            'user' => $user,
            'comments' => $comments,
            'links' => $links,
            'default' => $default,
            'comments_current_page' => $comments_current_page,
            'page_previous_comments' => $page_previous_comments,
            'page_next_comments' => $page_next_comments,
            'number_of_comments' => $number_of_comments,
            'number_of_comments_pages' => $number_of_comments_pages
        ));
    }


    // COMMENTS //
    // Create

    // Ajout d'un nouveau commentaire - pour user inconnu :
    public function createcomment()
    {
        $id_item = $this->request->getParameter("id");
        if (!empty($_POST['content']) && !empty($_POST['author'])) {

            if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
                $secretKey      = RECAPTCHA_SECRET_KEY;
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
                $responseData   = json_decode($verifyResponse);
                $author         = $this->request->getParameter("author");
                $content        = $this->request->getParameter("content");

                if ($responseData->success) {
                    $this->comment->insertComment($id_item, $author, $content);
                } else {
                    $errors['errors'] = 'La vérification a échoué. Merci de re-essayer plus tard.';
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header('Location: ' . BASE_URL . 'extendedcard/' . $id_item . '/1/#addcomment');
                        exit;
                    }
                }
            } else {
                $errors['errors']   = 'Merci de cocher la case reCAPTCHA.';
                $_SESSION['errors'] = $errors;
                header('Location: ' . BASE_URL . 'extendedcard/' . $id_item . '/1/#addcomment');
                exit;
            }
        } else {
            $errors['errors']   = 'Merci de renseigner tous les champs';
            $_SESSION['errors'] = $errors;
            header('Location: ' . BASE_URL . 'extendedcard/' . $id_item . '/1/#addcomment');
            exit;
        }
    }

    // Ajout d'un nouveau commentaire - pour user connecté :
    public function createcommentloggedin()
    {
        $id_item = $this->request->getParameter("id");

        if (!empty($_POST['content'])) {

            if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

                $secretKey      = RECAPTCHA_SECRET_KEY;
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
                $responseData   = json_decode($verifyResponse);
                $id_user        = $_SESSION['id_user'];
                $author         = $this->request->getParameter("author");
                $content        = $this->request->getParameter("content");

                if ($responseData->success) {
                    $this->comment->insertCommentLoggedIn($id_item, $id_user, $author, $content);
                } else {
                    $errors['errors'] = 'La vérification a échoué. Merci de re-essayer plus tard.';
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header('Location: ' . BASE_URL . 'extendedcard/indexuser/' . $id_item . '/1/#addcomment');
                        exit;
                    }
                }
            } else {
                $errors['errors']   = 'Merci de cocher la case reCAPTCHA.';
                $_SESSION['errors'] = $errors;
                header('Location: ' . BASE_URL . 'extendedcard/indexuser/' . $id_item . '/1/#addcomment');
                exit;
            }
        } else {
            $errors['errors']   = 'Merci de renseigner tous les champs';
            $_SESSION['errors'] = $errors;
            header('Location: ' . BASE_URL . 'extendedcard/indexuser/' . $id_item . '/1/#addcomment');
            exit;
        }
    }

    // Read

    // Affichage d'un commentaire :
    public function commentread()
    {

        $id_item                  = $this->calculate->getItemId();
        $item                     = $this->item->getItem($id_item);
        $number_of_items          = $this->calculate->getTotalOfItemsFront();
        $number_of_cards          = $this->calculate->getTotalOfCards();
        $number_of_links          = $this->calculate->getTotalOfLinks();
        $total_comments_count     = $this->calculate->getTotalOfComments();
        $total_users_count        = $this->calculate->getTotalOfUsers();
        $number_of_comments       = $this->calculate->countComments($id_item);
        $comments_current_page    = 1;
        $page_previous_comments   = $comments_current_page - 1;
        $page_next_comments       = $comments_current_page + 1;
        $user                     = $this->user->getUser($_SESSION['id_user']);
        $comments                 = $this->comment->getPaginationComments($id_item, $comments_current_page);
        $id_comment               = $this->calculate->getCommentId();
        $comment                  = $this->comment->getComment($id_comment);
        $number_of_comments_pages = $this->calculate->getNumberOfCommentsPagesFromItem($id_item);
        $default                  = "default.png";
        $this->generateView(array(
            'comment' => $comment,
            'item' => $item,
            'number_of_items' => $number_of_items,
            'number_of_cards' => $number_of_cards,
            'number_of_links' => $number_of_links,
            'total_comments_count' => $total_comments_count,
            'total_users_count' => $total_users_count,
            'comments_current_page' => $comments_current_page,
            'comments' => $comments,
            'user' => $user,
            'default' => $default,
            'page_previous_comments' => $page_previous_comments,
            'page_next_comments' => $page_next_comments,
            'number_of_comments' => $number_of_comments,
            'number_of_comments_pages' => $number_of_comments_pages
        ));
    }


    // Update

    // Modification d'un commentaire :
    public function updatecomment()
    {
        $id_comment = $this->calculate->getCommentId();
        $comment    = $this->comment->getComment($id_comment);
        $content    = $comment['content'];
        $this->comment->changeComment($content);
    }

    // Signaler un commentaire :
    public function reportcomment()
    {
        $id_item                  = $this->calculate->getItemId();
        $item                     = $this->item->getItem($id_item);
        $number_of_items          = $this->calculate->getTotalOfItemsFront();
        $number_of_items_pages    = $this->calculate->getNumberOfPagesOfExtFront();
        $number_of_comments       = $this->calculate->countComments($id_item);
        $comments_current_page    = 1;
        $page_previous_comments   = $comments_current_page - 1;
        $page_next_comments       = $comments_current_page + 1;
        $comments                 = $this->comment->getPaginationComments($id_item, $comments_current_page);
        $id_comment               = $this->calculate->getCommentId();
        $comment                  = $this->comment->getComment($id_comment);
        $number_of_comments_pages = $this->calculate->getNumberOfCommentsPagesFromItem($id_item);
        $this->comment->reportBadComment($id_comment);
        $default = "default.png";
        $this->generateView(array(
            'comment' => $comment,
            'item' => $item,
            'number_of_items' => $number_of_items,
            'number_of_items_pages' => $number_of_items_pages,
            'comments_current_page' => $comments_current_page,
            'comments' => $comments,
            'default' => $default,
            'page_previous_comments' => $page_previous_comments,
            'page_next_comments' => $page_next_comments,
            'number_of_comments' => $number_of_comments,
            'number_of_comments_pages' => $number_of_comments_pages
        ));
    }

}
