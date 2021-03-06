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
    public function insertCard($id_user, $id_category, $id_style, $title, $slugcard, $definition, $content)
    {
        $errors   = array();
        $messages = array();
        $id_user  = $_SESSION['id_user_admin'];

        $sql   = 'INSERT INTO cards (id_user, id_category, id_style, title, slug, definition, content, date_creation)
                      VALUES (:id_user, :id_category, :id_style, :title, :slug, :definition, :content, NOW())';
        $query = $this->dbConnectLastId($sql, array(
            ':id_user' => $id_user,
            ':id_category' => $id_category,
            ':id_style' => $id_style,
            ':title' => $title,
            ':slug' => $slugcard,
            ':definition' => $definition,
            ':content' => $content
        ));

    }

    // Création d'une nouvelle Card avec photo :
    public function insertCardImage($id_user, $id_category, $id_style, $title, $slug, $cardimagename, $definition, $content)
    {
        $errors   = array();
        $messages = array();
        $id_user  = $_SESSION['id_user_admin'];
        $sql      = 'INSERT INTO cards (id_user, id_category, id_style, title, slug, image, definition, content, date_creation)
                      VALUES
                      (:id_user, :id_category, :id_style, :title, :slug, :image, :definition, content, NOW())';
        $cards    = $this->dbConnect($sql, array(
            ':id_user' => $id_user,
            ':id_category' => $id_category,
            ':id_style' => $id_style,
            ':title' => $title,
            ':slug' => $slug,
            ':image' => $cardimagename,
            ':definition' => $definition,
            ':content' => $content
        ));

    }


    // READ

    // Afficher la liste des Cards :
    public function getCards($cards_current_page,$number_of_cards_pages)
    {
        $cards_start = (int) (($cards_current_page - 1) * $this->number_of_cards_by_page);
        $sql  = 'SELECT cards.id AS id, cards.id_category AS category, cards.id_style AS style, cards.title, cards.slug AS slug,
        cards.image AS image, cards.definition AS definition, cards.content AS content,
        DATE_FORMAT(cards.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
        DATE_FORMAT(cards.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
        categories.name AS categoryname, categories.slug AS categoryslug,
        styles.name AS stylename, styles.description AS styledescription, styles.hexadecimal AS stylehexadecimal
        FROM cards
        LEFT JOIN categories
        ON cards.id_category = categories.id
        LEFT JOIN styles
        ON cards.id_style = styles.id
        WHERE cards.bin != "yes"
        ORDER BY cards.date_creation DESC LIMIT ' . $cards_start . ', ' . $this->number_of_cards_by_page . '';
        if ($cards_current_page > $number_of_cards_pages)
          throw new Exception("Aucune Card trouvée.");
          else return $cards       = $this->dbConnect($sql);
        }

    // Afficher la liste des Cards ur la Sitemap :
    public function getAllCards()
    {
        $sql         = 'SELECT *
     FROM cards
     ORDER BY id ASC';
        $cards       = $this->dbConnect($sql);
        return $cards;
    }

    // Pagniation des Cards :
    public function getPaginationCards($cards_current_page)
    {
        $start = (int) (($cards_current_page - 1) * $this->number_of_cards_by_page);
        $sql   = 'SELECT id, title, slug, image, definition,
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
        $sql  = 'SELECT cards.id AS id, cards.id_category AS category, cards.id_style AS style, cards.title, cards.slug AS slug,
        cards.image AS image, cards.definition AS definition, cards.content AS content,
        DATE_FORMAT(cards.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
        DATE_FORMAT(cards.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
        users.id_user, users.avatar, users.firstname AS firstname, users.name AS name,
        categories.name AS categoryname, categories.slug AS categoryslug,
        styles.name AS stylename, styles.description AS styledescription
        FROM cards
        LEFT JOIN users
        ON cards.id_user = users.id_user
        LEFT JOIN categories
        ON cards.id_category = categories.id
        LEFT JOIN styles
        ON cards.id_style = styles.id
        WHERE cards.id = ? ';
        $req  = $this->dbConnect($sql, array(
            $id_card
        ));
        if ($req->rowCount() == 1)
                   return $card = $req->fetch();
               else
                 throw new Exception("Cette Card n'existe pas.");
    }


    // Afficher la liste des Cards Supprimées :
    public function getCardsDeleted($cards_deleted_current_page)
    {
        $cards_start   = (int) (($cards_deleted_current_page - 1) * $this->number_of_cards_by_page);
        $sql           = 'SELECT id, title, slug, image, definition,
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
    public function changeCardImage($id_category, $id_style, $title, $slug, $cardimagename, $definition, $content, $id_card)
    {
        $sql                      = 'UPDATE cards
        SET id_category = :id_category, id_style = :id_style, title = :title, slug = :slug, image = :image,
        definition = :definition, content = :content, date_update = NOW()
        WHERE id = :id';
        $card                     = $this->dbConnect($sql, array(
            ':id' => $id_card,
            ':id_category' => $id_category,
            ':id_style' => $id_style,
            ':title' => $title,
            ':slug' => $slug,
            ':image' => $cardimagename,
            ':definition' => $definition,
            ':content' => $content
        ));
    }

    // Modification d'une Card sans photo :
    public function changeCard($id_category, $id_style, $title, $slug, $definition, $content, $id_card)
    {
        $sql                      = 'UPDATE cards
        SET id_category = :id_category, id_style = :id_style, title = :title, slug = :slug, definition = :definition, content = :content, date_update = NOW()
        WHERE id = :id';
        $card                     = $this->dbConnect($sql, array(
            ':id' => $id_card,
            ':id_category' => $id_category,
            ':id_style' => $id_style,
            ':title' => $title,
            ':slug' => $slug,
            ':definition' => $definition,
            ':content' => $content
        ));
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
    }

    // Suppression définitive d'une Card avec ses commentaires associés.
    public function eraseCard($id_card)
    {
        $sql = 'DELETE cards.*
        FROM cards
        WHERE id = ' . (int) $id_card;
        $req = $this->dbConnect($sql);
        $req->execute();
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
    }

}
