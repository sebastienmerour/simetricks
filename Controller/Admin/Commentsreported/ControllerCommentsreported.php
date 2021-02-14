<?php
require_once 'Framework/Controller.php';
require_once 'Model/Comment.php';
require_once 'Model/Calculate.php';
require_once 'Model/Message.php';

/**
 * Contrôleur gérant l'administration des commentaires signalés
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerCommentsreported extends Controller
{
    private $comment;
    private $calculate;
    private $message;

    public function __construct()
    {
        $this->comment   = new Comment();
        $this->calculate = new Calculate();
        $this->message = new Message();
    }


    // READ

    // Affichage des commentaires à modérer :
    public function index()
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
    public function updatecommentreported()
    {
        $id_comment = $this->request->getParameter("id");
        $comment    = $this->comment->getComment($id_comment);
        $content    = $comment['content'];
        $this->comment->changeCommentReportedAdmin($content);
        $this->message->commentUpdated($id_comment);
    }

    // Approuver un commentaire signalé :
    public function approve()
    {
        $id_comment = $this->request->getParameter("id");
        $this->comment->approveComment($id_comment);
        $this->message->commentApprovedAdmin($id_comment);
    }


    // DELETE

    // Affichage de la Corbeille des commentaires signalés :
    public function commentsreportedbin()
    {
        if (null != $this->request->ifParameter("id")) {
            $comments_reported_deleted_current_page = $this->request->getParameter("id");
        } else {
            $comments_reported_deleted_current_page = 1;
        }
        $comments_reported_deleted_previous_page   = $comments_reported_deleted_current_page - 1;
        $comments_reported_deleted_next_page       = $comments_reported_deleted_current_page + 1;
        $comments_reported_deleted                 = $this->comment->selectCommentsReportedDeleted($comments_reported_deleted_current_page);
        $default                                   = "default.png";
        $number_of_comments_reported_deleted_pages = $this->calculate->getNumberOfCommentsReportedDeletedPagesFromAdmin();
        $counter_comments_reported_deleted         = $this->calculate->getTotalOfCommentsReportedDeleted();
        $this->generateadminView(array(
            'comments_reported_deleted' => $comments_reported_deleted,
            'default' => $default,
            'comments_reported_deleted_current_page' => $comments_reported_deleted_current_page,
            'comments_reported_deleted_previous_page' => $comments_reported_deleted_previous_page,
            'comments_reported_deleted_next_page' => $comments_reported_deleted_next_page,
            'number_of_comments_reported_deleted_pages' => $number_of_comments_reported_deleted_pages,
            'counter_comments_reported_deleted' => $counter_comments_reported_deleted
        ));
    }

    // Déplacer un commentaire signalé vers la Corbeille :
    public function movecommentreportedtobin()
    {
        $id_comment = $this->request->getParameter("id");
        $this->comment->moveCommentReported($id_comment);
        $this->message->commentReportedMovedToBin();
    }


    // Restaurer un commentaire signalé depuis la Corbeille :
    public function restorethiscommentreported()
    {
        $id_comment = $this->request->getParameter("id");
        $this->comment->restoreCommentReported($id_comment);
        $this->message->commentReportedRestored();
    }

    // Vider la Corbeille Commentaires Signalés
    public function emptycommentsreported()
    {
        $this->comment->emptycommentsreportedbin();
        $this->message->commentReportedEmptyBin();
    }


    // Suppression d'un commentaire signalé :
    public function removecommentreported()
    {
        $id_comment = $this->request->getParameter("id");
        $this->comment->eraseCommentReported($id_comment);
        $this->message->commentReportedErased();
    }


}
