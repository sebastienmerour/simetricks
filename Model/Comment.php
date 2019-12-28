<?php
require_once 'Framework/Model.php';

/**
 * Fournit les fonctions liées aux commentaires
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class Comment extends Model
{
    public $number_of_comments, $comments_current_page, $number_of_comments_by_page = 5, $number_of_comments_reported_by_page = 5;

    // CREATE
    // Création d'un commentaire :
    public function insertComment($item_id, $author, $content)
    {
        $item_id;
        $sql     = 'INSERT INTO comments(id_item, author, content, date_creation) VALUES(?, ?, ?, NOW())';
        $comment = $this->dbConnect($sql, array(
            $item_id,
            $author,
            $content
        ));

        $messages['confirmation'] = 'Votre commentaire a bien été ajouté !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../item/' . $item_id . '/1/#comments');
            exit;
        }
    }

    // Création d'un commentaire d'un utilisateur connecté :
    public function insertCommentLoggedIn($item_id, $user_id, $author, $content)
    {
        $item_id;
        $user_id                  = $_SESSION['id_user'];
        $sql                      = 'INSERT INTO comments(id_item, id_user, author, content, date_creation) VALUES(?, ?, ?, ?, NOW())';
        $comment                  = $this->dbConnect($sql, array(
            $item_id,
            $user_id,
            $author,
            $content
        ));
        $messages['confirmation'] = 'Votre commentaire a bien été ajouté !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../item/indexuser/' . $item_id . '/1/#comments');
            exit;
        }
    }

    // READ
    // FRONT

    // Afficher la liste des commentaires d'un Article :
    public function getComments($item_id)
    {
        $comments_start = (int) (($comments_current_page - 1) * $this->number_of_comments_by_page);
        $sql            = 'SELECT comments.id AS id_comment, comments.id_user AS user_com, comments.author, comments.content,
      DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
      DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
      users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com
      FROM comments
      LEFT JOIN users
      ON comments.id_user = users.id_user
      WHERE id_item = ?
      ORDER BY date_creation
      DESC LIMIT ' . $comments_start . ', ' . $this->number_of_comments_by_page . '';
        $comments       = $this->dbConnect($sql, array(
            $item_id
        ));
        return $comments;
    }

    // Pagination des commentaires sur un article :
    public function getPaginationComments($item_id, $comments_current_page)
    {
        $comments_start = (int) (($comments_current_page - 1) * $this->number_of_comments_by_page);
        $sql            = 'SELECT comments.id AS id_comment, comments.id_user AS user_com, comments.author, comments.content,
      DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
      DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
      users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com
      FROM comments
      LEFT JOIN users
      ON comments.id_user = users.id_user
      WHERE id_item = ?
      ORDER BY date_creation
      DESC LIMIT ' . $comments_start . ', ' . $this->number_of_comments_by_page . '';
        $comments       = $this->dbConnect($sql, array(
            $item_id
        ));
        return $comments;
    }

    // Affichage d'un commentaire pour le modifier ensuite :
    public function getComment($id_comment)
    {
        $sql     = 'SELECT comments.id, comments.id_user AS user_com, comments.author, comments.content,
        DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
        DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
        users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com
        FROM comments
        LEFT JOIN users
        ON comments.id_user = users.id_user
        WHERE comments.id = ?
        ';
        $req     = $this->dbConnect($sql, array(
            $id_comment
        ));
        $comment = $req->fetch();
        return $comment;
    }

    // READ
    // ADMIN

    // Afficher la liste complète de tous les commentaires en Admin :
    public function selectComments($comments_current_page)
    {
        $comments_start = (int) (($comments_current_page - 1) * $this->number_of_comments_by_page);
        $sql            = 'SELECT comments.id, comments.id_user, comments.author, comments.content,
    DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
    DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
     users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com FROM comments
    LEFT JOIN users
    ON comments.id_user = users.id_user
    ORDER BY date_creation DESC LIMIT ' . $comments_start . ', ' . $this->number_of_comments_by_page . '';
        $comments       = $this->dbConnect($sql);
        return $comments;
    }

    // Afficher la liste complète des commentaires signalés en Admin :
    public function selectCommentsReported($comments_reported_current_page)
    {
        $comments_start    = (int) (($comments_reported_current_page - 1) * $this->number_of_comments_reported_by_page);
        $sql               = 'SELECT comments.id, comments.id_user, comments.author, comments.content,
    DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
    DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
     users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com FROM comments
    LEFT JOIN users
    ON comments.id_user = users.id_user
    WHERE report = :report
    ORDER BY date_creation DESC LIMIT ' . $comments_start . ', ' . $this->number_of_comments_reported_by_page . '';
        $comments_reported = $this->dbConnect($sql, array(
            ':report' => "yes"
        ));
        return $comments_reported;
    }

    // UPDATE
    // FRONT

    // Modification d'un commentaire depuis le Front :
    public function changeComment($content)
    {
        $q                        = explode("/", $_SERVER['REQUEST_URI']);
        $valuei                   = $q[4];
        $valuec                   = $q[5];
        $item                     = (int) $valuei;
        $comment                  = (int) $valuec;
        $content                  = !empty($_POST['content']) ? trim($_POST['content']) : null;
        $sql                      = 'UPDATE comments SET content = :content, date_update = NOW() WHERE id = :id';
        $newComment               = $this->dbConnect($sql, array(
            ':id' => $comment,
            ':content' => $content
        ));
        $messages['confirmation'] = 'Merci ! Le commentaire a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: '. BASE_URL. 'item/readcomment/' . $item . '/' . $comment);
            exit;
        }
    }


    // UPDATE
    // FRONT

    // Signaler des commentaires :
    public function reportBadComment($id_comment)
    {
        $q                        = explode("/", $_SERVER['REQUEST_URI']);
        $valuei                   = $q[4];
        $valuec                   = $q[5];
        $item                     = (int) $valuei;
        $comment                  = (int) $valuec;
        $sql                      = 'UPDATE comments SET report = :report WHERE id = :id';
        $newComment               = $this->dbConnect($sql, array(
            ':id' => $comment,
            ':report' => "yes"
        ));
        $messages['confirmation'] = 'Merci ! Le commentaire a bien été signalé !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            if (ISSET($_SESSION['id_user'])) {
                header('Location: '. BASE_URL. 'item/indexuser/' . $item . '/1/#comments');
                exit;
            } else {
                header('Location: '. BASE_URL. 'item/' . $item . '/1/#comments');
                exit;
            }
        }
    }


    // UPDATE
    // ADMIN

    // Modification d'un commentaire depuis l'Admin
    public function changeCommentAdmin($content)
    {
        $comment                  = $_GET['id'];
        $content                  = !empty($_POST['content']) ? trim($_POST['content']) : null;
        $sql                      = 'UPDATE comments SET content = :content, date_update = NOW() WHERE id = :id';
        $newComment               = $this->dbConnect($sql, array(
            ':id' => $comment,
            ':content' => $content
        ));
        $messages['confirmation'] = 'Merci ! Votre commentaire a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../readcomment/' . $comment);
            exit;
        }
    }

    // Modification d'un commentaire signalé depuis l'Admin
    public function changeCommentReportedAdmin($content)
    {
        $comment                  = $_GET['id'];
        $content                  = !empty($_POST['content']) ? trim($_POST['content']) : null;
        $sql                      = 'UPDATE comments SET content = :content, date_update = NOW() WHERE id = :id';
        $newComment               = $this->dbConnect($sql, array(
            ':id' => $comment,
            ':content' => $content
        ));
        $messages['confirmation'] = 'Merci ! Votre commentaire a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../readcommentreported/' . $comment);
            exit;
        }
    }

    // Modification d'un commentaire signalé depuis l'Admin
    public function approveComment($id_comment)
    {
        // $comment                  = $_GET['id'];
        $report                   = "no";
        $sql                      = 'UPDATE comments SET report = :report, date_update = NOW() WHERE id = :id';
        $newComment               = $this->dbConnect($sql, array(
            ':id' => $id_comment,
            ':report' => $report
        ));
        $messages['confirmation'] = 'Merci ! Le commentaire a bien été approuvé !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../tomoderate/');
            exit;
        }
    }


    // DELETE

    // Suppression d'un commentaire :
    public function eraseComment($id_comment)
    {
        $sql = 'DELETE FROM comments WHERE id = ' . (int) $id_comment;
        $req = $this->dbConnect($sql);
        $req->execute();
    }



}
