<?php
require_once 'Framework/Model.php';

/**
 * Fournit les fonctions liées aux Cards
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class Card extends Model
{
    public $number_of_cards, $cards_current_page, $number_of_cards_pages, $number_of_cards_by_page = 6;

    // CREATE

    // Création d'une nouvelle Card sans photo :
    public function insertCard($id_user, $id_category, $title, $slugcard, $content)
    {
        $errors   = array();
        $messages = array();
        $id_user  = $_SESSION['id_user_admin'];

        $sql   = 'INSERT INTO cards (id_user, id_category, title, slug, content, date_creation)
                      VALUES (:id_user, :id_category, :title, :slug, :content, NOW())';
        $query = $this->dbConnectLastId($sql, array(
            ':id_user' => $id_user,
            ':id_category' => $id_category,
            ':title' => $title,
            ':slug' => $slugcard,
            ':content' => $content
        ));

        $messages['confirmation'] = 'Votre card a bien été ajoutée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'cardsadmin');
            exit;
        }
    }

    // Création d'une nouvelle Card avec photo :
    public function insertCardImage($id_user, $id_category, $title, $slug, $cardimagename, $content)
    {
        $errors   = array();
        $messages = array();
        $id_user  = $_SESSION['id_user_admin'];
        $sql      = 'INSERT INTO cards (id_user, id_category, title, slug, image, content, date_creation)
                      VALUES
                      (:id_user, :id_category, :title, :slug, :image, :content, NOW())';
        $cards    = $this->dbConnect($sql, array(
            ':id_user' => $id_user,
            ':id_category' => $id_category,
            ':title' => $title,
            ':slug' => $slug,
            ':image' => $cardimagename,
            ':content' => $content
        ));

        $messages['confirmation'] = 'Votre card a bien été ajoutée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'cardsadmin');
            exit;
        }
    }


    // READ

    // Afficher la liste des Cards :
    public function getCards($cards_current_page)
    {
        $cards_start = (int) (($cards_current_page - 1) * $this->number_of_cards_by_page);
        $sql         = 'SELECT id, title, slug, image, content,
     DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
     DATE_FORMAT(date_update, \'%d/%m/%Y à %Hh%i\') AS date_update
     FROM cards
     WHERE bin != "yes"
     ORDER BY date_creation DESC LIMIT ' . $cards_start . ', ' . $this->number_of_cards_by_page . '';
        $cards       = $this->dbConnect($sql);
        return $cards;
    }

    // Pagniation des Cards :
    public function getPaginationCards($cards_current_page)
    {
        $start = (int) (($cards_current_page - 1) * $this->number_of_cards_by_page);
        $sql   = 'SELECT id, title, slug, image, content,
    DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
    DATE_FORMAT(date_update, \'%d/%m/%Y à %Hh%i\') AS date_update
    FROM cards
    ORDER BY date_creation DESC LIMIT ' . $start . ', ' . $this->number_of_cards_by_page . '';
        $cards = $this->dbConnect($sql);
        return $cards;
    }

    // Afficher une Card en particulier :
    public function getCard($id_card)
    {
        $sql  = 'SELECT cards.id AS id, cards.id_category AS category, cards.title, cards.slug AS slug,
        cards.image AS image, cards.content AS content,
        DATE_FORMAT(cards.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
        DATE_FORMAT(cards.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
        users.id_user, users.avatar, users.firstname, users.name,
        categories.name AS categoryname, categories.slug AS categoryslug
        FROM cards
        LEFT JOIN users
        ON cards.id_user = users.id_user
        LEFT JOIN categories
        ON cards.id_category = categories.id
        WHERE cards.id = ? ';
        $req  = $this->dbConnect($sql, array(
            $id_card
        ));
        $card = $req->fetch();
        return $card;
    }

    // Afficher la liste des Cards Supprimées :
    public function getCardsDeleted($cards_deleted_current_page)
    {
        $cards_start   = (int) (($cards_deleted_current_page - 1) * $this->number_of_cards_by_page);
        $sql           = 'SELECT id, title, slug, image, content,
     DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
     DATE_FORMAT(date_update, \'%d/%m/%Y à %Hh%i\') AS date_update
     FROM cards
     WHERE bin = :bin
     ORDER BY date_creation DESC LIMIT ' . $cards_start . ', ' . $this->number_of_cards_by_page . '';
        $cards_deleted = $this->dbConnect($sql, array(
            ':bin' => "yes"
        ));
        return $cards_deleted;
    }


    // UPDATE


    // Modification d'une Card avec photo :
    public function changeCardImage($id_category, $title, $slug, $cardimagename, $content, $id_card)
    {
        $id_category              = !empty($_POST['category']) ? trim($_POST['category']) : null;
        $title                    = !empty($_POST['title']) ? trim($_POST['title']) : null;
        $slug                     = !empty($_POST['slug']) ? trim($_POST['slug']) : null;
        $content                  = !empty($_POST['content']) ? trim($_POST['content']) : null;
        $sql                      = 'UPDATE cards
        SET id_category = :id_category, title = :title, slug = :slug, image = :image,
        content = :content, date_update = NOW()
        WHERE id = :id';
        $card                     = $this->dbConnect($sql, array(
            ':id' => $id_card,
            ':id_category' => $id_category,
            ':title' => $title,
            ':slug' => $slug,
            ':image' => $cardimagename,
            ':content' => $content
        ));
        $messages['confirmation'] = 'Votre Card a bien été modifiée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'cardsadmin/cardread/' . $id_card);
            exit;
        }
    }

    // Modification d'une Card sans photo :
    public function changeCard($id_category, $title, $slug, $content, $id_card)
    {
        $id_category              = !empty($_POST['category']) ? trim($_POST['category']) : null;
        $title                    = !empty($_POST['title']) ? trim($_POST['title']) : null;
        $slug                     = !empty($_POST['slug']) ? trim($_POST['slug']) : null;
        $content                  = !empty($_POST['content']) ? trim($_POST['content']) : null;
        $sql                      = 'UPDATE cards
        SET id_category = :id_category, title = :title, slug = :slug, content = :content, date_update = NOW()
        WHERE id = :id';
        $card                     = $this->dbConnect($sql, array(
            ':id' => $id_card,
            ':id_category' => $id_category,
            ':title' => $title,
            ':slug' => $slug,
            ':content' => $content
        ));
        $messages['confirmation'] = 'Merci ! Votre Card a bien été modifiée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'cardsadmin/cardread/' . $id_card);
            exit;
        }
    }

    // Restaurer une Card depuis la Corbeille
    public function restoreCard($id_card)
    {
        $bin                      = "no";
        $sql                      = 'UPDATE cards SET bin = :bin, date_update = NOW() WHERE id = :id';
        $restore                  = $this->dbConnect($sql, array(
            ':id' => $id_card,
            ':bin' => $bin
        ));
        $messages['confirmation'] = 'Merci ! La Card a bien été restaurée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'cardsadmin/cardsbin');
            exit;
        }
    }

    // DELETE

    // Déplacement d'une Card vers la Corbeille
    public function moveCard($id_card)
    {
        $bin                      = "yes";
        $sql                      = 'UPDATE cards SET bin = :bin, date_update = NOW() WHERE id = :id';
        $move                     = $this->dbConnect($sql, array(
            ':id' => $id_card,
            ':bin' => $bin
        ));
        $messages['confirmation'] = 'Merci ! La Card Card a été déplacée dans la corbeille !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'cardsadmin');
            exit;
        }
    }

    // Suppression définitive d'une Card avec ses commentaires associés.
    public function eraseCard($id_card)
    {
        $sql = 'DELETE cards.*
        FROM cards
        WHERE id = ' . (int) $id_card;
        $req = $this->dbConnect($sql);
        $req->execute();

        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! Votre Card a bien été supprimée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'cardsadmin/cardsbin');
            exit;
        }
    }

    // Vidage de la Corbeille des Cards avec ses commentaires associés.
    public function emptybin()
    {
        $bin = "yes";
        $sql = 'DELETE cards.*
        FROM cards
        WHERE bin = :bin';
        $req = $this->dbConnect($sql, array(
            ':bin' => $bin
        ));
        $req->execute();
        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! La corbeille a été vidée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'cardsadmin/cardsbin');
            exit;
        }
    }

}
