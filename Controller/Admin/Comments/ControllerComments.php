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

class ControllerComments extends Controller
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


    // COMMENTS

    // Affichage des commentaires à modérer :
    public function commentsreported()
    {
        if (null != $this->request->ifParameter("id")) {
            $comments_reported_current_page = $this->request->getParameter("id");
        } else {
            $comments_reported_current_page = 1;
        }
        $comments_reported_previous_page   = $comments_reported_current_page - 1;
        $comments_reported_next_page       = $comments_reported_current_page + 1;
        $comments_reported                 = $this->comment->selectCommentsReported($comments_reported_current_page);
        $default                           = "default.png";
        $number_of_comments_reported_pages = $this->calculate->getNumberOfCommentsReportedPagesFromAdmin();
        $counter_comments_reported         = $this->calculate->getTotalOfCommentsReported();
        $this->generateadminView(array(
            'comments_reported' => $comments_reported,
            'default' => $default,
            'comments_reported_current_page' => $comments_reported_current_page,
            'comments_reported_previous_page' => $comments_reported_previous_page,
            'comments_reported_next_page' => $comments_reported_next_page,
            'number_of_comments_reported_pages' => $number_of_comments_reported_pages,
            'counter_comments_reported' => $counter_comments_reported
        ));
    }

    // Affichage de l'ensemble des commentaires :
    public function index()
    {
        if (null != $this->request->ifParameter("id")) {
            $comments_current_page = $this->request->getParameter("id");
        } else {
            $comments_current_page = 1;
        }
        $comments_previous_page   = $comments_current_page - 1;
        $comments_next_page       = $comments_current_page + 1;
        $comments                 = $this->comment->selectComments($comments_current_page);
        $default                  = "default.png";
        $number_of_comments_pages = $this->calculate->getNumberOfCommentsPagesFromAdmin();
        $counter_comments         = $this->calculate->getTotalOfComments();
        $this->generateadminView(array(
            'comments' => $comments,
            'default' => $default,
            'comments_current_page' => $comments_current_page,
            'comments_previous_page' => $comments_previous_page,
            'comments_next_page' => $comments_next_page,
            'number_of_comments_pages' => $number_of_comments_pages,
            'counter_comments' => $counter_comments
        ));
    }

    // Affichage d'un commentaire
    public function commentread()
    {
        $id_comment = $this->request->getParameter("id");
        $comment    = $this->comment->getComment($id_comment);
        $default    = "default.png";
        $this->generateadminView(array(
            'comment' => $comment,
            'default' => $default
        ));
    }

    // Affichage d'un commentaire signalé :
    public function commentreportedread()
    {
        $id_comment = $this->request->getParameter("id");
        $comment    = $this->comment->getComment($id_comment);
        $default    = "default.png";
        $this->generateadminView(array(
            'comment' => $comment,
            'default' => $default
        ));
    }


    // UPDATE

    // Modification d'un commentaire :
    public function updatecomment()
    {
        $id_comment = $this->request->getParameter("id");
        $comment    = $this->comment->getComment($id_comment);
        $content    = $comment['content'];
        $this->comment->changeCommentAdmin($content);
    }

    // Modification d'un commentaire :
    public function updatecommentreported()
    {
        $id_comment = $this->request->getParameter("id");
        $comment    = $this->comment->getComment($id_comment);
        $content    = $comment['content'];
        $this->comment->changeCommentReportedAdmin($content);
    }

    // Approuver un commentaire signalé :
    public function approve()
    {
        $id_comment = $this->request->getParameter("id");
        $this->comment->approveComment($id_comment);
    }


    // DELETE

    // Affichage de la Corbeille des commentaires :
    public function commentsbin()
    {
        if (null != $this->request->ifParameter("id")) {
            $comments_deleted_current_page = $this->request->getParameter("id");
        } else {
            $comments_deleted_current_page = 1;
        }
        $comments_deleted_previous_page   = $comments_deleted_current_page - 1;
        $comments_deleted_next_page       = $comments_deleted_current_page + 1;
        $comments_deleted                 = $this->comment->selectCommentsDeleted($comments_deleted_current_page);
        $default                          = "default.png";
        $number_of_comments_deleted_pages = $this->calculate->getNumberOfCommentsDeletedPagesFromAdmin();
        $counter_comments_deleted         = $this->calculate->getTotalOfCommentsDeleted();
        $this->generateadminView(array(
            'comments_deleted' => $comments_deleted,
            'default' => $default,
            'comments_deleted_current_page' => $comments_deleted_current_page,
            'comments_deleted_previous_page' => $comments_deleted_previous_page,
            'comments_deleted_next_page' => $comments_deleted_next_page,
            'number_of_comments_deleted_pages' => $number_of_comments_deleted_pages,
            'counter_comments_deleted' => $counter_comments_deleted
        ));
    }

    // Déplacer un commentaire vers la Corbeille :
    public function movecommenttobin()
    {
        $id_comment = $this->request->getParameter("id");
        $this->comment->moveComment($id_comment);
    }

    // Restaurer un commentaire depuis la Corbeille :
    public function restorethiscomment()
    {
        $id_comment = $this->request->getParameter("id");
        $this->comment->restoreComment($id_comment);
    }

    // Vider la Corbeille Commentaires
    public function emptycomments()
    {
        $this->comment->emptycommentsbin();
    }

    // Suppression d'un commentaire définitivement :
    public function removecomment()
    {
        $id_comment = $this->request->getParameter("id");
        $this->comment->eraseComment($id_comment);
        $messages['confirmation'] = 'Merci ! Le commentaire a bien été supprimé définitivement!';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'comments');
            exit;
        }
    }

    // Suppression d'un commentaire signalé :
    public function removecommentreported()
    {
        $id_comment = $this->request->getParameter("id");
        $this->comment->eraseComment($id_comment);
        $messages['confirmation'] = 'Merci ! Le commentaire a bien été supprimé !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'commentsreported');
            exit;
        }
    }
        

}
