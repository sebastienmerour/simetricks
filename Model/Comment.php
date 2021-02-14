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
    public $number_of_comments, $comments_current_page, $number_of_comments_by_page = 5, $number_of_comments_reported_by_page = 3;

    // CREATE
    // Création d'un commentaire :
    public function insertComment($id_item, $author, $content)
    {
        $id_item;
        $sql     = 'INSERT INTO comments(id_item, author, content, report, bin, date_creation) VALUES(?, ?, ?, "no", "no", NOW())';
        $comment = $this->dbConnect($sql, array(
            $id_item,
            $author,
            $content
        ));
    }

    // Création d'un commentaire d'un utilisateur connecté :
    public function insertCommentLoggedIn($id_item, $id_user, $author, $content)
    {
        $id_item;
        $id_user                  = $_SESSION['id_user'];
        $sql                      = 'INSERT INTO comments(id_item, id_user, author, content, report, bin, date_creation) VALUES(?, ?, ?, ?, "no", "no", NOW())';
        $comment                  = $this->dbConnect($sql, array(
            $id_item,
            $id_user,
            $author,
            $content
        ));
    }

    // READ
    // FRONT

    // Afficher la liste des commentaires d'un Article :
    public function getComments($id_item)
    {
      $comments_start = (int) (($comments_current_page - 1) * $this->number_of_comments_by_page);
      $sql            = 'SELECT comments.id AS id_comment, comments.id_user AS user_com, comments.author, comments.content,
      DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
      DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
      users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com
      FROM comments
      LEFT JOIN users
      ON comments.id_user = users.id_user
      WHERE id_item = ? AND comments.bin != "yes"
      ORDER BY date_creation
      DESC LIMIT ' . $comments_start . ', ' . $this->number_of_comments_by_page . '';
      $comments       = $this->dbConnect($sql, array(
            $id_item
        ));
      return $comments;
    }

    // Pagination des commentaires sur un article :
    public function getPaginationComments($id_item, $comments_current_page)
    {
      $comments_start = (int) (($comments_current_page - 1) * $this->number_of_comments_by_page);
      $sql            = 'SELECT comments.id AS id_comment, comments.id_user AS user_com, comments.author, comments.content,
      DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
      DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
      users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com
      FROM comments
      LEFT JOIN users
      ON comments.id_user = users.id_user
      WHERE id_item = ? AND comments.bin != "yes"
      ORDER BY date_creation
      DESC LIMIT ' . $comments_start . ', ' . $this->number_of_comments_by_page . '';
      $comments       = $this->dbConnect($sql, array(
            $id_item
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
        if ($req->rowCount() == 1)
           return $comment = $req->fetch();
       else
         throw new Exception("Ce commentaire n'existe pas.");
}


    // READ
    // ADMIN

    // Afficher la liste complète de tous les commentaires en Admin :
    public function selectComments($comments_current_page)
    {
        $comments_start = (int) (($comments_current_page - 1) * $this->number_of_comments_by_page);
        $sql            = 'SELECT comments.id, comments.id_item, comments.id_user, comments.author, comments.content,
    DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
    DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
    users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com,
    extended_cards.id AS extended_card_id, extended_cards.title AS extended_card_title, extended_cards.slug AS extended_card_slug
    FROM comments
    LEFT JOIN users
    ON comments.id_user = users.id_user
    LEFT JOIN extended_cards
    ON comments.id_item = extended_cards.id
    WHERE comments.bin = "no"
    AND comments.report = "no"
    ORDER BY date_creation_fr DESC LIMIT ' . $comments_start . ', ' . $this->number_of_comments_by_page . '';
    $comments       = $this->dbConnect($sql);
    return $comments;
    }

    // Afficher la liste complète des commentaires signalés en Admin :
    public function selectCommentsReported($comments_reported_current_page)
    {
        $comments_start    = (int) (($comments_reported_current_page - 1) * $this->number_of_comments_by_page);
        $sql               = 'SELECT comments.id,comments.id_user, comments.author, comments.content,
    DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
    DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
    users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com,
    extended_cards.id AS extended_card_id, extended_cards.title AS extended_card_title, extended_cards.slug AS extended_card_slug
    FROM comments
    LEFT JOIN users
    ON comments.id_user = users.id_user
    LEFT JOIN extended_cards
    ON comments.id_item = extended_cards.id
    WHERE report = :report AND comments.bin != "yes"
    ORDER BY date_creation_fr DESC LIMIT ' . $comments_start . ', ' . $this->number_of_comments_by_page . '';
        $comments_reported = $this->dbConnect($sql, array(
            ':report' => "yes"
        ));
        return $comments_reported;
    }

    // Afficher la liste complète des Commentaires dans la Corbeille en Admin :
    public function selectCommentsDeleted($comments_deleted_current_page)
    {
        $comments_start = (int) (($comments_deleted_current_page - 1) * $this->number_of_comments_by_page);
        $sql            = 'SELECT comments.id, comments.id_user, comments.author, comments.content,
    DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
    DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
    users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com,
    extended_cards.id AS extended_card_id, extended_cards.title AS extended_card_title, extended_cards.slug AS extended_card_slug
    FROM comments
    LEFT JOIN users
    ON comments.id_user = users.id_user
    LEFT JOIN extended_cards
    ON comments.id_item = extended_cards.id
    WHERE comments.bin = :bin
    AND comments.report = :report
    ORDER BY date_creation_fr DESC LIMIT ' . $comments_start . ', ' . $this->number_of_comments_by_page . '';
    $comments_deleted    = $this->dbConnect($sql, array(
          ':bin' => "yes",
          ':report' => "no"
      ));
    return $comments_deleted;
    }

    // Afficher la liste complète des Commentaires Signalés dans la Corbeille en Admin :
    public function selectCommentsReportedDeleted($comments_reported_deleted_current_page)
    {
        $comments_start = (int) (($comments_reported_deleted_current_page - 1) * $this->number_of_comments_by_page);
        $sql            = 'SELECT comments.id, comments.id_user, comments.author, comments.content,
    DATE_FORMAT(comments.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
    DATE_FORMAT(comments.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
    users.id_user, users.firstname AS firstname_com, users.name AS name_com, users.avatar AS avatar_com,
    extended_cards.id AS extended_card_id, extended_cards.title AS extended_card_title, extended_cards.slug AS extended_card_slug
    FROM comments
    LEFT JOIN users
    ON comments.id_user = users.id_user
    LEFT JOIN extended_cards
    ON comments.id_item = extended_cards.id
    WHERE comments.bin = :bin
    AND comments.report = :report
    ORDER BY date_creation_fr DESC LIMIT ' . $comments_start . ', ' . $this->number_of_comments_by_page . '';
    $comments_deleted    = $this->dbConnect($sql, array(
          ':bin' => "yes",
          ':report' => "yes"
      ));
    return $comments_deleted;
    }


    // UPDATE
    // FRONT

    // Modification d'un commentaire depuis le Front :
    public function changeComment($content)
    {
        $q                        = explode("/", $_SERVER['REQUEST_URI']);
        $valuei                   = $q[3];
        $valuec                   = $q[4];
        $item                     = (int) $valuei;
        $comment                  = (int) $valuec;
        $content                  = !empty($_POST['content']) ? trim($_POST['content']) : null;
        $sql                      = 'UPDATE comments SET content = :content, date_update = NOW() WHERE id = :id';
        $newComment               = $this->dbConnect($sql, array(
            ':id' => $comment,
            ':content' => $content
        ));
    }

    // Signaler des commentaires :
    public function reportBadComment($id_comment)
    {
        $q                        = explode("/", $_SERVER['REQUEST_URI']);
        $valuei                   = $q[3];
        $valuec                   = $q[4];
        $item                     = (int) $valuei;
        $comment                  = (int) $valuec;
        $sql                      = 'UPDATE comments SET report = :report WHERE id = :id';
        $newComment               = $this->dbConnect($sql, array(
            ':id' => $comment,
            ':report' => "yes"
        ));
    }


    // UPDATE
    // ADMIN

    // Modification d'un commentaire depuis l'Admin
    public function changeCommentAdmin($content)
    {
        $comment                  = $_GET['id'];
        $sql                      = 'UPDATE comments SET content = :content, date_update = NOW() WHERE id = :id';
        $this->dbConnect($sql, array(
            ':id' => $comment,
            ':content' => $content
        ));
    }

    // Modification d'un commentaire signalé depuis l'Admin
    public function changeCommentReportedAdmin($content)
    {
        $comment                  = $_GET['id'];
        $content                  = !empty($_POST['content']) ? trim($_POST['content']) : null;
        $sql                      = 'UPDATE comments SET content = :content, date_update = NOW() WHERE id = :id';
        $this->dbConnect($sql, array(
            ':id' => $comment,
            ':content' => $content
        ));
    }

    // Approbation d'un commentaire signalé depuis l'Admin
    public function approveComment($id_comment)
    {
        //$comment                  = $_GET['id'];
        $report                   = "no";
        $sql                      = 'UPDATE comments SET report = :report, date_update = NOW() WHERE id = :id';
        $this->dbConnect($sql, array(
            ':id' => $id_comment,
            ':report' => $report
        ));
    }

    // Restaurer un commentaire depuis la Corbeille
    public function restoreComment($id_comment)
    {
        $bin                      = "no";
        $sql                      = 'UPDATE comments SET bin = :bin, date_update = NOW() WHERE id = :id';
        $this->dbConnect($sql, array(
            ':id' => $id_comment,
            ':bin' => $bin
        ));
    }

    // Restaurer un commentaire signalé depuis la Corbeille
    public function restoreCommentReported($id_comment)
    {
        $bin                      = "no";
        $sql                      = 'UPDATE comments SET bin = :bin, date_update = NOW() WHERE id = :id';
        $this->dbConnect($sql, array(
            ':id' => $id_comment,
            ':bin' => $bin
        ));
    }

    // DELETE

    // Déplacement d'un commentaire vers la Corbeille
    public function moveComment($id_comment)
    {
        $bin                      = "yes";
        $sql                      = 'UPDATE comments SET bin = :bin, date_update = NOW() WHERE id = :id';
        $move                     = $this->dbConnect($sql, array(
            ':id' => $id_comment,
            ':bin' => $bin
        ));
    }

    // Déplacement d'un commentaire signalé vers la Corbeille
    public function moveCommentReported($id_comment)
    {
        $bin                      = "yes";
        $sql                      = 'UPDATE comments SET bin = :bin, date_update = NOW() WHERE id = :id';
        $move                     = $this->dbConnect($sql, array(
            ':id' => $id_comment,
            ':bin' => $bin
        ));
    }

    // Suppression définitive d'un commentaire :
    public function eraseComment($id_comment)
    {
        $sql = 'DELETE FROM comments WHERE id = ' . (int) $id_comment;
        $req = $this->dbConnect($sql);
        $req->execute();
    }

    // Suppression définitive d'un commentaire :
    public function eraseCommentReported($id_comment)
    {
        $sql = 'DELETE FROM comments WHERE id = ' . (int) $id_comment;
        $req = $this->dbConnect($sql);
        $req->execute();
    }

    // Vidage de la Corbeille Commentaires:
    public function emptycommentsbin()
    {
        $sql = 'DELETE FROM comments WHERE bin = :bin AND report = :report';
        $req = $this->dbConnect($sql, array(
            ':bin' => "yes",
            ':report' => "no"
        ));
        $req->execute();
    }

    // Vidage de la Corbeille Commentaires Signalés:
    public function emptycommentsreportedbin()
    {
        $sql = 'DELETE FROM comments WHERE bin = :bin AND report = :report';
        $req = $this->dbConnect($sql, array(
            ':bin' => "yes",
            ':report' => 'yes'
        ));
        $req->execute();
    }

}
