<?php
require_once 'Framework/Model.php';

/**
 * Fournit les fonctions liées aux Pages
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class Page extends Model
{
    public $number_of_pages, $pages_current_page, $number_of_pages_pages, $number_of_pages_by_page = 6;

    // CREATE

    // Création d'une nouvelle Page sans photo :
    public function insertPage($id_user, $title, $slug, $content, $draft)
    {
        $errors   = array();
        $messages = array();
        $id_user  = $_SESSION['id_user_admin'];

        $sql   = 'INSERT INTO pages (id_user, title, slug, content, draft, date_creation)
                      VALUES (:id_user, :title, :slug, :content, :draft, NOW())';
        $query = $this->dbConnectLastId($sql, array(
            ':id_user' => $id_user,
            ':title' => $title,
            ':slug' => $slug,
            ':content' => $content,
            ':draft' => $draft
        ));

        $messages['confirmation'] = 'Votre page a bien été ajoutée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'pagesadmin');
            exit;
        }
    }

    // READ

    // Afficher la liste des Pages en Admin :
    public function getPagesAdmin($pages_current_page)
    {
        $pages_start = (int) (($pages_current_page - 1) * $this->number_of_pages_by_page);
        $sql         = 'SELECT pages.id AS pageid, pages.title, pages.slug,
     DATE_FORMAT(pages.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
     DATE_FORMAT(pages.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
     pages.draft AS draft,
     users.id_user, users.avatar, users.firstname, users.name
     FROM pages
     LEFT JOIN users
     ON pages.id_user = users.id_user
     WHERE pages.bin != "yes"
     ORDER BY date_creation DESC LIMIT ' . $pages_start . ', ' . $this->number_of_pages_by_page . '';
        $pages       = $this->dbConnect($sql);
        return $pages;
    }

    // Afficher la liste des Pages sur la Sitemap :
    public function getAllItems()
    {
        $sql         = 'SELECT *
     FROM pages
     ORDER BY id ASC';
        $pages      = $this->dbConnect($sql);
        return $pages;
    }


    // Pagniation des Pages :
    public function getPaginationPages($pages_current_page)
    {
        $start = (int) (($pages_current_page - 1) * $this->number_of_pages_by_page);
        $sql   = 'SELECT pages.id, pages.title, pages.slug,
    DATE_FORMAT(pages.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
    DATE_FORMAT(pages.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
    users.id_user, users.avatar, users.firstname, users.name
    FROM pages
    LEFT JOIN users
    ON pages.id_user = users.id_user
    ORDER BY date_creation DESC LIMIT ' . $start . ', ' . $this->number_of_pages_by_page . '';
        $pages = $this->dbConnect($sql);
        return $pages;
    }

    // Afficher une Page en particulier :
    public function getPage($id_page)
    {
        $sql  = 'SELECT pages.id AS pageid, pages.title AS title, pages.slug AS slug, pages.content AS content,
        pages.draft AS draft,
        DATE_FORMAT(pages.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
        DATE_FORMAT(pages.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
        users.id_user, users.avatar, users.firstname, users.name
        FROM pages
        LEFT JOIN users
        ON pages.id_user = users.id_user
        WHERE pages.id = ? ';
        $req  = $this->dbConnect($sql, array(
            $id_page
        ));
        $page = $req->fetch();
        return $page;
    }

    // Afficher la liste des Pages Supprimées :
    public function getPagesDeleted($pages_deleted_current_page)
    {
        $pages_start   = (int) (($pages_deleted_current_page - 1) * $this->number_of_pages_by_page);
        $sql           = 'SELECT pages.id AS pageid, pages.title, pages.slug,
     DATE_FORMAT(pages.date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr,
     DATE_FORMAT(pages.date_update, \'%d/%m/%Y à %Hh%i\') AS date_update,
     users.id_user, users.firstname, users.name
     FROM pages
     LEFT JOIN users
     ON pages.id_user = users.id_user
     WHERE pages.bin = :bin
     ORDER BY date_creation DESC LIMIT ' . $pages_start . ', ' . $this->number_of_pages_by_page . '';
        $pages_deleted = $this->dbConnect($sql, array(
            ':bin' => "yes"
        ));
        return $pages_deleted;
    }


    // UPDATE

    // Modification d'une Page :
    public function changePage($title, $slug, $content, $draft, $id_page)
    {
        $sql                        = 'UPDATE pages SET title = :title, slug = :slug,
        content = :content, draft= :draft, date_update = NOW() WHERE id = :id';
        $page                     = $this->dbConnect($sql, array(
            ':id' => $id_page,
            ':title' => $title,
            ':slug' => $slug,
            ':content' => $content,
            ':draft' => $draft
        ));
        $messages['confirmation'] = 'Merci ! Votre Page a bien été modifiée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'pagesadmin/pageread/' . $id_page);
            exit;
        }
    }

    // Restaurer une page depuis la Corbeille
    public function restorePage($id_page)
    {
        $bin                      = "no";
        $sql                      = 'UPDATE pages SET bin = :bin, date_update = NOW() WHERE id = :id';
        $restore                  = $this->dbConnect($sql, array(
            ':id' => $id_page,
            ':bin' => $bin
        ));
        $messages['confirmation'] = 'Merci ! La Page a bien été restaurée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'pagesadmin/pagesbin');
            exit;
        }
    }

    // DELETE

    // Déplacement d'une page vers la Corbeille
    public function movePage($id_page)
    {
        $bin                      = "yes";
        $sql                      = 'UPDATE pages SET bin = :bin, date_update = NOW() WHERE id = :id';
        $move                     = $this->dbConnect($sql, array(
            ':id' => $id_page,
            ':bin' => $bin
        ));
        $messages['confirmation'] = 'Merci ! La Page a été déplacée dans la corbeille !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'pagesadmin');
            exit;
        }
    }

    // Suppression définitive d'une Page.
    public function erasePage($id_page)
    {
        $sql = 'DELETE pages.*
        FROM pages
        WHERE pages.id = ' . (int) $id_page;
        $req = $this->dbConnect($sql);
        $req->execute();

        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! Votre Page a bien été supprimée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'pagesadmin/pagesbin');
            exit;
        }
    }

    // Vidage de la Corbeille des Pages.
    public function emptybin()
    {
        $bin = "yes";
        $sql = 'DELETE pages.*
        FROM pages
        WHERE pages.bin = :bin';
        $req = $this->dbConnect($sql, array(
            ':bin' => $bin
        ));
        $req->execute();
        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! La corbeille a été vidée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'pagesadmin/pagesbin');
            exit;
        }
    }

}
