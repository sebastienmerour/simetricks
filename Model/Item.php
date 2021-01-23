<?php
require_once 'Framework/Model.php';

/**
 * Fournit les fonctions liées aux Extended Cards
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class Item extends Model
{
    public $number_of_items, $items_current_page, $number_of_items_pages, $number_of_items_by_page = 6;

    // CREATE

    // Création d'une nouvelle Extended Card sans photo :
    public function insertItem($id_user, $id_category, $title, $slug, $content, $owner, $date_native, $year_native, $licence, $os_supported, $sgbdr, $number_of_users, $pdm, $langage, $features, $last_news, $version, $draft)
    {
        $errors   = array();
        $messages = array();
        $id_user  = $_SESSION['id_user_admin'];

        $sql   = 'INSERT INTO extended_cards (id_user, id_category, title, slug, content, owner, date_native, year_native, licence, os_supported, sgbdr, number_of_users, pdm, langage, features, last_news, version, draft, date_creation)
                      VALUES (:id_user, :id_category, :title, :slug, :content, :owner, :date_native, :year_native, :licence, :os_supported, :sgbdr, :number_of_users, :pdm, :langage, :features, :last_news, :version, :draft, NOW())';
        $query = $this->dbConnectLastId($sql, array(
            ':id_user' => $id_user,
            ':id_category' => $id_category,
            ':title' => $title,
            ':slug' => $slug,
            ':content' => $content,
            ':owner' => $owner,
            ':date_native' => $date_native,
            ':year_native' => $year_native,
            ':licence' => $licence,
            ':os_supported' => $os_supported,
            ':sgbdr' => $sgbdr,
            ':number_of_users' => $number_of_users,
            ':pdm' => $pdm,
            ':langage' => $langage,
            ':features' => $features,
            ':last_news' => $last_news,
            ':version' => $version,
            ':draft' => $draft
        ));

        if (!empty($_POST['linkname'][0]) && is_array($_POST['linkname'])) {
            for ($i = 0; $i < count($_POST['linkname']); $i++) {
                $linkname = $_POST['linkname'][$i];
                $linkurl  = $_POST['linkurl'][$i];

                $stmt     = 'INSERT INTO links (id_item, name, url)
                                VALUES(:id_item,:name,:url)';
                $newquery = $this->dbConnect($stmt, array(
                    ':id_item' => $query,
                    ':name' => $linkname,
                    ':url' => $linkurl
                ));
            }
        }

        $messages['confirmation'] = 'Votre extended card a bien été ajoutée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'extendedcardsadmin');
            exit;
        }
    }

    // Création d'une nouvelle Extended Card avec photo :
    public function insertItemImage($id_user, $id_category, $title, $slug, $content, $itemimagename, $owner, $date_native, $year_native, $licence, $os_supported, $sgbdr, $number_of_users, $pdm, $langage, $features, $last_news, $version, $draft)
    {
        $errors   = array();
        $messages = array();
        $id_user  = $_SESSION['id_user_admin'];
        $sql      = 'INSERT INTO extended_cards (id_user, id_category, title, slug, content, image, owner, date_native, year_native, licence, os_supported, sgbdr, number_of_users, pdm, langage, features, last_news, version, draft, date_creation)
                      VALUES
                      (:id_user, :id_category, :title, :slug, :content, :image, :owner, :date_native, :year_native, :licence, :os_supported, :sgbdr, :number_of_users, :pdm, :langage, :features, :last_news, :version, :draft, NOW())';
        $items    = $this->dbConnect($sql, array(
            ':id_user' => $id_user,
            ':id_category' => $id_category,
            ':title' => $title,
            ':slug' => $slug,
            ':content' => $content,
            ':image' => $itemimagename,
            ':owner' => $owner,
            ':date_native' => $date_native,
            ':year_native' => $year_native,
            ':licence' => $licence,
            ':os_supported' => $os_supported,
            ':sgbdr' => $sgbdr,
            ':number_of_users' => $number_of_users,
            ':pdm' => $pdm,
            ':langage' => $langage,
            ':features' => $features,
            ':last_news' => $last_news,
            ':version' => $version,
            ':draft' => $draft
        ));

        $messages['confirmation'] = 'Votre extended card a bien été ajoutée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'extendedcardsadmin');
            exit;
        }
    }


    // READ

    // Afficher la liste des Extended Cards en Front :
    public function getItemsFront($items_current_page)
    {
        $items_start = (int) (($items_current_page - 1) * $this->number_of_items_by_page);
        $sql         = 'SELECT extended_cards.id AS itemid, extended_cards.id_category AS categoryid, extended_cards.title, extended_cards.slug, extended_cards.content, extended_cards.image, extended_cards.last_news,
     DATE_FORMAT(extended_cards.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
     DATE_FORMAT(extended_cards.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
     users.id_user, users.avatar, users.firstname, users.name, categories.id, categories.name AS categoryname,
     categories.slug AS categoryslug
     FROM extended_cards
     LEFT JOIN users
     ON extended_cards.id_user = users.id_user
     LEFT JOIN categories
     ON extended_cards.id_category = categories.id
     WHERE extended_cards.bin != "yes" AND extended_cards.draft = "no"
     ORDER BY date_creation DESC LIMIT ' . $items_start . ', ' . $this->number_of_items_by_page . '';
        $items       = $this->dbConnect($sql);
        return $items;
    }

    // Afficher la liste des Extended Cards en Admin :

    public function getItemsForAdmin($items_current_page)
    {
        $items_start = (int) (($items_current_page - 1) * $this->number_of_items_by_page);
        $sql         = 'SELECT extended_cards.id AS itemid, extended_cards.id_category AS categoryid, extended_cards.title AS title, extended_cards.slug AS slug, extended_cards.image AS image,
  DATE_FORMAT(extended_cards.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
  DATE_FORMAT(extended_cards.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
  extended_cards.draft AS draft, extended_cards.bin AS bin,
  users.id_user AS id_user, users.firstname AS firstname, users.name AS name, categories.id, categories.name AS categoryname,
  categories.slug AS categoryslug
  FROM extended_cards
  LEFT JOIN users
  ON extended_cards.id_user = users.id_user
  LEFT JOIN categories
  ON extended_cards.id_category = categories.id
  WHERE extended_cards.bin != "yes"
  ORDER BY extended_cards.date_creation DESC LIMIT ' . $items_start . ', ' . $this->number_of_items_by_page . '';
        $items       = $this->dbConnect($sql);
        return $items;
    }

    public function getItemsForCategory($id_category, $items_current_page)
    {
        $items_start = (int) (($items_current_page - 1) * $this->number_of_items_by_page);
        $sql         = 'SELECT extended_cards.id AS itemid, extended_cards.id_category AS categoryid, extended_cards.title AS title, extended_cards.slug AS slug, extended_cards.image AS image,
  DATE_FORMAT(extended_cards.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
  DATE_FORMAT(extended_cards.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
  extended_cards.draft AS draft, extended_cards.bin AS bin,
  users.id_user AS id_user, users.firstname AS firstname, users.name AS name, categories.id, categories.name AS categoryname,
  categories.slug AS categoryslug
  FROM extended_cards
  LEFT JOIN users
  ON extended_cards.id_user = users.id_user
  LEFT JOIN categories
  ON extended_cards.id_category = categories.id
  WHERE extended_cards.bin != "yes"
  AND extended_cards.id_category = ?
  ORDER BY extended_cards.date_creation DESC LIMIT ' . $items_start . ', ' . $this->number_of_items_by_page . '';
        $items       = $this->dbConnect($sql, array(
            $id_category
        ));
        return $items;
    }

    // Afficher la liste des Extended Cards en Admin :
    public function getItemsAdmin($items_current_page)
    {
        $items_start = (int) (($items_current_page - 1) * $this->number_of_items_by_page);
        $sql         = 'SELECT extended_cards.id AS itemid, extended_cards.id_category AS categoryid, extended_cards.title, extended_cards.slug, extended_cards.image, extended_cards.last_news,
     DATE_FORMAT(extended_cards.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
     DATE_FORMAT(extended_cards.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
     extended_cards.draft AS draft,
     users.id_user, users.avatar, users.firstname, users.name, categories.id, categories.name AS categoryname,
     categories.slug AS categoryslug
     FROM extended_cards
     LEFT JOIN users
     ON extended_cards.id_user = users.id_user
     LEFT JOIN categories
     ON extended_cards.id_category = categories.id
     WHERE extended_cards.bin != "yes"
     ORDER BY date_creation DESC LIMIT ' . $items_start . ', ' . $this->number_of_items_by_page . '';
        $items       = $this->dbConnect($sql);
        return $items;
    }

    // Afficher la liste des Extended Cards sur la Sitemap :
    public function getAllItems()
    {
        $sql   = 'SELECT *
     FROM extended_cards
     ORDER BY id ASC';
        $items = $this->dbConnect($sql);
        return $items;
    }

    // Afficher la liste des Extended Cards appartenant à une Catégorie en Front :
    public function getItemsFromCategoryFront($cat, $items_current_page)
    {
        $items_start = (int) (($items_current_page - 1) * $this->number_of_items_by_page);
        $sql         = 'SELECT extended_cards.id AS itemid, extended_cards.id_category AS categoryid, extended_cards.title, extended_cards.slug, extended_cards.content, extended_cards.image, extended_cards.last_news,
     DATE_FORMAT(extended_cards.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
     DATE_FORMAT(extended_cards.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
     users.id_user, users.avatar, users.firstname, users.name, categories.id, categories.name AS categoryname,
     categories.slug AS categoryslug
     FROM extended_cards
     LEFT JOIN users
     ON extended_cards.id_user = users.id_user
     LEFT JOIN categories
     ON extended_cards.id_category = categories.id
     WHERE extended_cards.bin != "yes"
     AND extended_cards.draft = "no"
     AND extended_cards.id_category = :cat
     ORDER BY date_creation DESC LIMIT ' . $items_start . ', ' . $this->number_of_items_by_page . '';
        $items       = $this->dbConnect($sql, array(
            ':cat' => $cat
        ));
        return $items;
    }

    // Pagniation des Extended Cards :
    public function getPaginationItems($items_current_page)
    {
        $start = (int) (($items_current_page - 1) * $this->number_of_items_by_page);
        $sql   = 'SELECT extended_cards.id, extended_cards.id_category, extended_cards.title, extended_cards.slug, extended_cards.image, extended_cards.last_news,
    DATE_FORMAT(extended_cards.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
    DATE_FORMAT(extended_cards.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
    users.id_user, users.avatar, users.firstname, users.name FROM extended_cards
    LEFT JOIN users
    ON extended_cards.id_user = users.id_user
    ORDER BY date_creation DESC LIMIT ' . $start . ', ' . $this->number_of_items_by_page . '';
        $items = $this->dbConnect($sql);
        return $items;
    }

    // Afficher une Extended Card en particulier :
    public function getItem($id_item)
    {
        $sql  = 'SELECT extended_cards.id AS itemid, extended_cards.id_category AS category, extended_cards.title AS title, extended_cards.slug AS slug, extended_cards.content AS content, extended_cards.image AS image,
        DATE_FORMAT(extended_cards.date_native, \'%Y-%m-%d\') AS date_native,
        extended_cards.owner AS owner,
        extended_cards.year_native AS year_native,
        extended_cards.licence AS licence,
        extended_cards.os_supported AS os_supported,
        extended_cards.sgbdr AS sgbdr,
        extended_cards.number_of_users AS number_of_users,
        extended_cards.pdm AS pdm,
        extended_cards.langage AS langage,
        extended_cards.features AS features,
        extended_cards.links AS links,
        extended_cards.last_news AS last_news,
        extended_cards.version AS version,
        extended_cards.views AS views,
        extended_cards.draft AS draft,
        DATE_FORMAT(extended_cards.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
        DATE_FORMAT(extended_cards.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
        users.id_user, users.avatar, users.firstname, users.name,
        categories.name AS categoryname, categories.slug AS categoryslug
        FROM extended_cards
        LEFT JOIN users
        ON extended_cards.id_user = users.id_user
        LEFT JOIN categories
        ON extended_cards.id_category = categories.id
        WHERE extended_cards.id = ? ';
        $req  = $this->dbConnect($sql, array(
            $id_item
        ));
        $item = $req->fetch();
        return $item;
    }

    // Afficher la liste des Extended Cards Supprimées :
    public function getItemsDeleted($items_deleted_current_page)
    {
        $items_start   = (int) (($items_deleted_current_page - 1) * $this->number_of_items_by_page);
        $sql           = 'SELECT extended_cards.id AS itemid, extended_cards.id_category, extended_cards.title, extended_cards.slug, extended_cards.image, extended_cards.last_news,
     DATE_FORMAT(extended_cards.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
     DATE_FORMAT(extended_cards.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
     users.id_user, users.firstname, users.name FROM extended_cards
     LEFT JOIN users
     ON extended_cards.id_user = users.id_user
     WHERE extended_cards.bin = :bin
     ORDER BY date_creation DESC LIMIT ' . $items_start . ', ' . $this->number_of_items_by_page . '';
        $items_deleted = $this->dbConnect($sql, array(
            ':bin' => "yes"
        ));
        return $items_deleted;
    }


    // UPDATE

    // Modification d'une Extended Card avec photo :
    public function changeItemImage($id_category, $title, $slug, $content, $itemimagename, $owner, $date_native, $year_native, $licence, $os_supported, $sgbdr, $number_of_users, $pdm, $langage, $features, $last_news, $version, $draft, $id_item)
    {
        $sql                      = 'UPDATE extended_cards SET id_category = :id_category, title = :title, slug = :slug, content = :content, image = :image,
        owner = :owner, date_native = :date_native, year_native = :year_native, licence = :licence, os_supported = :os_supported, sgbdr = :sgbdr, number_of_users = :number_of_users, pdm = :pdm,  langage = :langage, features = :features,
        last_news = :last_news, version = :version, draft = :draft,
        date_update = NOW() WHERE id = :id';
        $item                     = $this->dbConnect($sql, array(
            ':id' => $id_item,
            ':id_category' => $id_category,
            ':title' => $title,
            ':slug' => $slug,
            ':content' => $content,
            ':image' => $itemimagename,
            ':owner' => $owner,
            ':date_native' => $date_native,
            ':year_native' => $year_native,
            ':licence' => $licence,
            ':os_supported' => $os_supported,
            ':sgbdr' => $sgbdr,
            ':number_of_users' => $number_of_users,
            ':pdm' => $pdm,
            ':langage' => $langage,
            ':features' => $features,
            ':last_news' => $last_news,
            ':version' => $version,
            ':draft' => $draft
        ));
        $messages['confirmation'] = 'Votre Extended Card a bien été modifiée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'extendedcardsadmin/extendedcardread/' . $id_item);
            exit;
        }
    }

    // Modification d'une Extended Card sans photo :
    public function changeItem($id_category, $title, $slug, $content, $owner, $date_native, $year_native, $licence, $os_supported, $sgbdr, $number_of_users, $pdm, $langage, $features, $last_news, $version, $draft, $id_item)
    {
        $sql                      = 'UPDATE extended_cards SET id_category = :id_category, title = :title, slug = :slug,
        content = :content,
        owner = :owner, date_native = :date_native, year_native = :year_native, licence = :licence, os_supported = :os_supported, sgbdr = :sgbdr, number_of_users = :number_of_users, pdm = :pdm,  langage = :langage, features = :features,
        last_news = :last_news, version = :version, draft= :draft, date_update = NOW() WHERE id = :id';
        $item                     = $this->dbConnect($sql, array(
            ':id' => $id_item,
            ':id_category' => $id_category,
            ':title' => $title,
            ':slug' => $slug,
            ':content' => $content,
            ':owner' => $owner,
            ':date_native' => $date_native,
            ':year_native' => $year_native,
            ':licence' => $licence,
            ':os_supported' => $os_supported,
            ':sgbdr' => $sgbdr,
            ':number_of_users' => $number_of_users,
            ':pdm' => $pdm,
            ':langage' => $langage,
            ':features' => $features,
            ':last_news' => $last_news,
            ':version' => $version,
            ':draft' => $draft
        ));
        $messages['confirmation'] = 'Merci ! Votre Extended Card a bien été modifiée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'extendedcardsadmin/extendedcardread/' . $id_item);
            exit;
        }
    }

    // Restaurer un item depuis la Corbeille
    public function restoreItem($id_item)
    {
        $bin                      = "no";
        $sql                      = 'UPDATE extended_cards SET bin = :bin, date_update = NOW() WHERE id = :id';
        $restore                  = $this->dbConnect($sql, array(
            ':id' => $id_item,
            ':bin' => $bin
        ));
        $messages['confirmation'] = 'Merci ! L\'Extended Card a bien été restaurée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'extendedcardsadmin/extendedcardsbin');
            exit;
        }
    }

    // DELETE

    // Déplacement d'un item vers la Corbeille
    public function moveItem($id_item)
    {
        $bin                      = "yes";
        $sql                      = 'UPDATE extended_cards SET bin = :bin, date_update = NOW() WHERE id = :id';
        $move                     = $this->dbConnect($sql, array(
            ':id' => $id_item,
            ':bin' => $bin
        ));
        $messages['confirmation'] = 'Merci ! L\'Extended Card a été déplacée dans la corbeille !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'extendedcardsadmin');
            exit;
        }
    }

    // Suppression définitive d'une Extended Card avec ses commentaires associés.
    public function eraseItem($id_item)
    {
        $sql = 'DELETE extended_cards.*, comments.*
        FROM extended_cards
        LEFT JOIN comments
        ON extended_cards.id = comments.id_item
        WHERE extended_cards.id = ' . (int) $id_item;
        $req = $this->dbConnect($sql);
        $req->execute();

        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! Votre Extended Card a bien été supprimée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'extendedcardsadmin/extendedcardsbin');
            exit;
        }
    }

    // Vidage de la Corbeille des Extended Cards avec ses commentaires associés.
    public function emptybin()
    {
        $bin = "yes";
        $sql = 'DELETE extended_cards.*, comments.*
        FROM extended_cards
        LEFT JOIN comments
        ON extended_cards.id = comments.id_item
        WHERE extended_cards.bin = :bin';
        $req = $this->dbConnect($sql, array(
            ':bin' => $bin
        ));
        $req->execute();
        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! La corbeille a été vidée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'extendedcardsadmin/extendedcardsbin');
            exit;
        }
    }

}
