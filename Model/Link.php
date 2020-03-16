<?php
require_once 'Framework/Model.php';

/**
 * Fournit les fonctions liées aux liens
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class link extends Model
{
    public $number_of_links, $links_current_page, $number_of_links_pages, $number_of_links_by_page = 5;

    // CREATE

    // Création d'un nouveau lien :
    public function insertlink($name, $url)
    {
        $sql      = 'INSERT INTO links (name, url)
                     VALUES
                      (:name, :url)';
        $links    = $this->dbConnect($sql, array(
            ':name' => $name,
            ':url' => $url
        ));
        $messages['confirmation'] = 'Votre lien a bien été ajouté !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL. 'links');
            exit;
        }
    }

    // READ

    // Afficher la liste des Liens :
    public function getlinks()
    {
        $sql   = 'SELECT *
     FROM links
     WHERE bin != "yes"
     ORDER BY id ASC LIMIT 0, 100';
        $links = $this->dbConnect($sql);
        return $links;
    }

    // Afficher un Lien en particulier :
    public function getlink($id_link)
    {
        $sql  = 'SELECT *
        FROM links
        WHERE id = ? ';
        $req  = $this->dbConnect($sql, array(
            $id_link

        ));
        $link = $req->fetch();
        return $link;
    }

    // Afficher la liste des Liens Supprimés :
    public function getlinksDeleted()
    {
        $sql   = 'SELECT *
     FROM links
     WHERE bin = :bin
     ORDER BY name DESC LIMIT 0, 100';
        $links_deleted = $this->dbConnect($sql, array(
            ':bin' => "yes"
        ));
        return $links_deleted;
    }


    // UPDATE

    // Modification d'un lien :
    public function changelink($id_link, $name, $url)
    {
        $name = !empty($_POST['name']) ? trim($_POST['name']) : null;
        $url = !empty($_POST['url']) ? trim($_POST['url']) : null;
        $sql     = 'UPDATE links SET name = :name, url = :url
        WHERE id = :id_link';
        $link    = $this->dbConnect($sql, array(
            ':id_link' => $id_link,
            ':name' => $name,
            ':url' => $url
        ));
        $messages['confirmation'] = 'La lien a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: '. BASE_ADMIN_URL. 'linkread/' . $id_link);
            exit;
        }
    }

    // Restaurer un lien depuis la Corbeille
    public function restorelink($id_link)
    {
        $bin                      = "no";
        $sql                      = 'UPDATE links SET bin = :bin WHERE id = :id';
        $restore                  = $this->dbConnect($sql, array(
            ':id' => $id_link,
            ':bin' => $bin
        ));
        $messages['confirmation'] = 'Merci ! La lien a bien été restaurée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: '. BASE_ADMIN_URL. 'linksbin');
            exit;
        }
    }

    // DELETE

    // Déplacement d'un lien vers la Corbeille
    public function movelink($id_link)
    {
        $bin                      = "yes";
        $sql                      = 'UPDATE links SET bin = :bin WHERE id = :id';
        $move               = $this->dbConnect($sql, array(
            ':id' => $id_link,
            ':bin' => $bin
        ));
        $messages['confirmation'] = 'Merci ! La lien a été déplacée dans la corbeille !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: '. BASE_ADMIN_URL. 'links');
            exit;
        }
    }

    // Suppression définitive d'un lien
    public function eraselink($id_link)
    {
        $sql = 'DELETE
        FROM links
        WHERE id = ' . (int) $id_link ;
        $req = $this->dbConnect($sql);
        $req->execute();

        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! La lien a été supprimé !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL. 'linksbin');
            exit;
        }
    }

    // Vidage de la Corbeille des liens.
    public function emptybin()
    {

        $bin = "yes";
        $sql = 'DELETE
        FROM links
        WHERE bin = :bin';
        $req = $this->dbConnect($sql, array(
            ':bin' => $bin
        ));
        $req->execute();
        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! La corbeille a été vidée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL. 'linksbin');
            exit;
        }
    }



}
