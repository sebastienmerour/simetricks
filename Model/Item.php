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
    public function insertItem($id_user, $id_category, $title, $slug, $description, $date_native, $year_native, $licence, $sgbdr, $pdm, $langage, $features, $content, $version, $draft)
    {
        $errors   = array();
        $messages = array();
        $id_user  = $_SESSION['id_user_admin'];

        $sql   = 'INSERT INTO extended_cards (id_user, id_category, title, slug, description, date_native, year_native, licence, sgbdr, pdm, langage, features, content, version, draft, date_creation)
                      VALUES (:id_user, :id_category, :title, :slug, :description, :date_native, :year_native, :licence, :sgbdr, :pdm, :langage, :features, :content, :version, :draft, NOW())';
        $query = $this->dbConnectLastId($sql, array(
            ':id_user' => $id_user,
            ':id_category' => $id_category,
            ':title' => $title,
            ':slug' => $slug,
            ':description' => $description,
            ':date_native' => $date_native,
            ':year_native' => $year_native,
            ':licence' => $licence,
            ':sgbdr' => $sgbdr,
            ':pdm' => $pdm,
            ':langage' => $langage,
            ':features' => $features,
            ':content' => $content,
            ':version' => $version,
            ':draft' => $draft
        ));

        if (isset($_POST['linkname']) && is_array($_POST['linkname'])) {
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
    public function insertItemImage($id_user, $id_category, $title, $slug, $description, $itemimagename, $date_native, $year_native, $licence, $sgbdr, $pdm, $langage, $features, $content, $version, $draft)
    {
        $errors   = array();
        $messages = array();
        $id_user  = $_SESSION['id_user_admin'];
        $sql      = 'INSERT INTO extended_cards (id_user, id_category, title, slug, description, image, date_native, year_native, licence, sgbdr, pdm, langage, features, content, version, draft, date_creation)
                      VALUES
                      (:id_user, :id_category, :title, :slug, :description, :image, :date_native, :year_native, :licence, :sgbdr, :pdm, :langage, :features, :content, :version, :draft, NOW())';
        $items    = $this->dbConnect($sql, array(
            ':id_user' => $id_user,
            ':id_category' => $id_category,
            ':title' => $title,
            ':slug' => $slug,
            ':description' => $description,
            ':image' => $itemimagename,
            ':date_native' => $date_native,
            ':year_native' => $year_native,
            ':licence' => $licence,
            ':sgbdr' => $sgbdr,
            ':pdm' => $pdm,
            ':langage' => $langage,
            ':features' => $features,
            ':content' => $content,
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
        $sql         = 'SELECT extended_cards.id AS itemid, extended_cards.id_category AS categoryid, extended_cards.title, extended_cards.slug, extended_cards.image, extended_cards.content,
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
    public function getItemsAdmin($items_current_page)
    {
        $items_start = (int) (($items_current_page - 1) * $this->number_of_items_by_page);
        $sql         = 'SELECT extended_cards.id AS itemid, extended_cards.id_category AS categoryid, extended_cards.title, extended_cards.slug, extended_cards.image, extended_cards.content,
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

    // Afficher la liste des Extended Cards appartenant à une Catégorie en Front :
    public function getItemsFromCategoryFront($cat, $items_current_page)
    {
        $items_start = (int) (($items_current_page - 1) * $this->number_of_items_by_page);
        $sql         = 'SELECT extended_cards.id AS itemid, extended_cards.id_category AS categoryid, extended_cards.title, extended_cards.slug, extended_cards.image, extended_cards.content,
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
        $sql   = 'SELECT extended_cards.id, extended_cards.id_category, extended_cards.title, extended_cards.slug, extended_cards.image, extended_cards.content,
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
        $sql  = 'SELECT extended_cards.id AS itemid, extended_cards.id_category AS category, extended_cards.title AS title, extended_cards.slug AS slug, extended_cards.description AS description, extended_cards.image AS image,
        DATE_FORMAT(extended_cards.date_native, \'%Y-%m-%d\') AS date_native,
        extended_cards.year_native AS year_native,
        extended_cards.licence AS licence,
        extended_cards.sgbdr AS sgbdr,
        extended_cards.pdm AS pdm,
        extended_cards.langage AS langage,
        extended_cards.features AS features,
        extended_cards.links AS links,
        extended_cards.content AS content,
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
        $sql           = 'SELECT extended_cards.id AS itemid, extended_cards.id_category, extended_cards.title, extended_cards.slug, extended_cards.image, extended_cards.content,
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
    public function changeItemImage($id_category, $title, $slug, $description, $itemimagename, $date_native, $year_native, $licence, $sgbdr, $pdm, $langage, $features, $content, $version, $draft, $id_item)
    {
        $id_category              = !empty($_POST['category']) ? trim($_POST['category']) : null;
        $title                    = !empty($_POST['title']) ? trim($_POST['title']) : null;
        $slug                     = !empty($_POST['slug']) ? trim($_POST['slug']) : null;
        $description              = !empty($_POST['description']) ? trim($_POST['description']) : null;
        $date_native              = !empty($_POST['date_native']) ? trim($_POST['date_native']) : null;
        $year_native              = !empty($_POST['year_native']) ? trim($_POST['year_native']) : null;
        $licence                  = !empty($_POST['licence']) ? trim($_POST['licence']) : null;
        $sgbdr                    = !empty($_POST['sgbdr']) ? trim($_POST['sgbdr']) : null;
        $pdm                      = !empty($_POST['pdm']) ? trim($_POST['pdm']) : null;
        $features                 = !empty($_POST['features']) ? trim($_POST['features']) : null;
        $langage                  = !empty($_POST['langage']) ? trim($_POST['langage']) : null;
        $content                  = !empty($_POST['content']) ? trim($_POST['content']) : null;
        $version                  = !empty($_POST['version']) ? trim($_POST['version']) : null;
        $sql                      = 'UPDATE extended_cards SET id_category = :id_category, title = :title, slug = :slug, description = :description, image = :image,
        date_native = :date_native, year_native = :year_native, licence = :licence, sgbdr = :sgbdr, pdm = :pdm,  langage = :langage, features = :features,
        content = :content, version = :version, draft = :draft,
        date_update = NOW() WHERE id = :id';
        $item                     = $this->dbConnect($sql, array(
            ':id' => $id_item,
            ':id_category' => $id_category,
            ':title' => $title,
            ':slug' => $slug,
            ':description' => $description,
            ':image' => $itemimagename,
            ':date_native' => $date_native,
            ':year_native' => $year_native,
            ':licence' => $licence,
            ':sgbdr' => $sgbdr,
            ':pdm' => $pdm,
            ':langage' => $langage,
            ':features' => $features,
            ':content' => $content,
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
    public function changeItem($id_category, $title, $slug, $description, $date_native, $year_native, $licence, $sgbdr, $pdm, $langage, $features, $content, $version, $draft, $id_item)
    {
        $id_category              = !empty($_POST['category']) ? trim($_POST['category']) : null;
        $title                    = !empty($_POST['title']) ? trim($_POST['title']) : null;
        $slug                     = !empty($_POST['slug']) ? trim($_POST['slug']) : null;
        $description              = !empty($_POST['description']) ? trim($_POST['description']) : null;
        $date_native              = !empty($_POST['date_native']) ? trim($_POST['date_native']) : null;
        $year_native              = !empty($_POST['year_native']) ? trim($_POST['year_native']) : null;
        $licence                  = !empty($_POST['licence']) ? trim($_POST['licence']) : null;
        $sgbdr                    = !empty($_POST['sgbdr']) ? trim($_POST['sgbdr']) : null;
        $pdm                      = !empty($_POST['pdm']) ? trim($_POST['pdm']) : null;
        $langage                  = !empty($_POST['langage']) ? trim($_POST['langage']) : null;
        $features                 = !empty($_POST['features']) ? trim($_POST['features']) : null;
        $content                  = !empty($_POST['content']) ? trim($_POST['content']) : null;
        $version                  = !empty($_POST['version']) ? trim($_POST['version']) : null;
        $sql                      = 'UPDATE extended_cards SET id_category = :id_category, title = :title, slug = :slug,
        description = :description, date_native = :date_native, year_native = :year_native, licence = :licence, sgbdr = :sgbdr, pdm = :pdm, langage = :langage, features = :features,
        content = :content, version = :version, draft= :draft, date_update = NOW() WHERE id = :id';
        $item                     = $this->dbConnect($sql, array(
            ':id' => $id_item,
            ':id_category' => $id_category,
            ':title' => $title,
            ':slug' => $slug,
            ':description' => $description,
            ':date_native' => $date_native,
            ':year_native' => $year_native,
            ':licence' => $licence,
            ':sgbdr' => $sgbdr,
            ':pdm' => $pdm,
            ':langage' => $langage,
            ':features' => $features,
            ':content' => $content,
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
