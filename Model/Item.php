<?php
require_once 'Framework/Model.php';

/**
 * Fournit les fonctions liées aux articles
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class Item extends Model
{
    public $number_of_items, $items_current_page, $number_of_items_pages, $number_of_items_by_page = 5;

    // CREATE

    // Création d'un nouvel article sans photo :
    public function insertItem($user_id, $title, $date_native, $licence, $langage, $links, $content)
    {
        $errors   = array();
        $messages = array();
        $user_id  = $_SESSION['id_user_admin'];
        $sql      = 'INSERT INTO extended_cards (id_user, title, date_native, licence, langage, links, content, date_creation)
                      VALUES
                      (:id_user, :title, :date_native, :licence, :langage, :links, :content, NOW())';
        $items    = $this->dbConnect($sql, array(
            ':id_user' => $user_id,
            ':title' => $title,
            ':date_native' => $date_native,
            ':licence' => $licence,
            ':langage' => $langage,
            ':links' => $links,
            ':content' => $content
        ));
        $messages['confirmation'] = 'Votre extended card a bien été ajoutée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL. 'dashboard');
            exit;
        }
    }

    // Création d'un nouvel article avec photo :
    public function insertItemImage($user_id, $title, $itemimagename, $content)
    {
        $errors   = array();
        $messages = array();
        $user_id  = $_SESSION['id_user_admin'];
        $sql      = 'INSERT INTO extended_cards (id_user, title, image, date_native, licence, langage, links, content, date_creation)
                      VALUES
                      (:id_user, :title, :image, :date_native, :licence, :langage, :links, :content, NOW())';
        $items    = $this->dbConnect($sql, array(
            ':id_user' => $user_id,
            ':title' => $title,
            ':image' => $itemimagename,
            ':date_native' => $date_native,
            ':licence' => $licence,
            ':langage' => $langage,
            ':links' => $links,
            ':content' => $content
        ));

        $messages['confirmation'] = 'Votre extended card a bien été ajoutée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL. 'dashboard');
            exit;
        }
    }


    // READ

    // Afficher la liste des Articles :
    public function getItems($items_current_page)
    {
        $items_start = (int) (($items_current_page - 1) * $this->number_of_items_by_page);
        $sql   = 'SELECT extended_cards.id, extended_cards.title, extended_cards.image, extended_cards.content,
     DATE_FORMAT(extended_cards.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
     DATE_FORMAT(extended_cards.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
     users.id_user, users.firstname, users.name FROM extended_cards
     LEFT JOIN users
     ON extended_cards.id_user = users.id_user
     ORDER BY date_creation DESC LIMIT ' . $items_start . ', ' . $this->number_of_items_by_page . '';
        $items = $this->dbConnect($sql);
        return $items;
    }


    // Afficher un Article en particulier :
    public function getItem($item_id)
    {
        $sql  = 'SELECT extended_cards.id, extended_cards.title AS title, extended_cards.image AS image,
        DATE_FORMAT(extended_cards.date_native, \'%Y-%m-%d\') AS date_native,
        extended_cards.licence AS licence,
        extended_cards.langage AS langage,
        extended_cards.links AS links,
        extended_cards.content AS content,
        DATE_FORMAT(extended_cards.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
        DATE_FORMAT(extended_cards.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
        users.id_user, users.firstname, users.name
        FROM extended_cards
        LEFT JOIN users
        ON extended_cards.id_user = users.id_user
        WHERE extended_cards.id = ? ';
        $req  = $this->dbConnect($sql, array(
            $item_id
        ));
        $item = $req->fetch();
        return $item;
    }


    // UPDATE

    // Modification d'un article avec photo :
    public function changeItemImage($title, $itemimagename, $date_native, $licence, $langage, $links, $content, $item_id)
    {
        $title   = !empty($_POST['title']) ? trim($_POST['title']) : null;
        $date_native = !empty($_POST['date_native']) ? trim($_POST['date_native']) : null;
        $licence = !empty($_POST['licence']) ? trim($_POST['licence']) : null;
        $langage = !empty($_POST['langage']) ? trim($_POST['langage']) : null;
        $links = !empty($_POST['links']) ? trim($_POST['links']) : null;
        $content = !empty($_POST['content']) ? trim($_POST['content']) : null;
        $sql     = 'UPDATE extended_cards SET title = :title, image = :image,
        date_native = :date_native, licence = :licence, langage = :langage, links = :links,
        content = :content,
        date_update = NOW() WHERE id = :id';
        $item    = $this->dbConnect($sql, array(
            ':id' => $item_id,
            ':title' => $title,
            ':image' => $itemimagename,
            ':date_native' => $date_native,
            ':licence' => $licence,
            ':langage' => $langage,
            ':links' => $links,
            ':content' => $content
        ));
        $messages['confirmation'] = 'Votre Extended Card a bien été modifiée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../readitem/' . $item_id);
            exit;
        }
    }

    // Modification d'un article sans photo :
    public function changeItem($title, $date_native, $licence, $langage, $links, $content, $item_id)
    {
        $title   = !empty($_POST['title']) ? trim($_POST['title']) : null;
        $date_native = !empty($_POST['date_native']) ? trim($_POST['date_native']) : null;
        $licence = !empty($_POST['licence']) ? trim($_POST['licence']) : null;
        $langage = !empty($_POST['langage']) ? trim($_POST['langage']) : null;
        $links = !empty($_POST['links']) ? trim($_POST['links']) : null;
        $content = !empty($_POST['content']) ? trim($_POST['content']) : null;
        $sql     = 'UPDATE extended_cards SET title = :title,
        date_native = :date_native, licence = :licence, langage = :langage, links = :links,
        content = :content, date_update = NOW() WHERE id = :id';
        $item    = $this->dbConnect($sql, array(
            ':id' => $item_id,
            ':title' => $title,
            ':date_native' => $date_native,
            ':licence' => $licence,
            ':langage' => $langage,
            ':links' => $links,
            ':content' => $content
        ));
        $messages['confirmation'] = 'Merci ! Votre article a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../readitem/' . $item_id);
            exit;
        }
    }

    // DELETE
    // Suppression d'un article :
    public function eraseItem($item_id)
    {
        $sql = 'DELETE FROM extended_cards WHERE id = ' . (int) $item_id;
        $req = $this->dbConnect($sql);
        $req->execute();
        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! Votre article a bien été supprimé !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../');
            exit;
        }
    }




}
