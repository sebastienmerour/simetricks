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
    public $number_of_links, $links_current_page, $number_of_links_pages, $number_of_links_by_page = 6;

    // CREATE

    // Création d'un nouveau lien :
    public function insertLink($id_item, $name, $url, $description)
    {
        $sql                      = 'INSERT INTO links (id_item, name, url, description)
                     VALUES
                      (:id_item, :name, :url, :description)';
        $links                    = $this->dbConnect($sql, array(
            ':id_item' => $id_item,
            ':name' => $name,
            ':url' => $url,
            ':description' => $description
        ));
    }


    // READ

    // Afficher la liste des liens d'un Article :
    public function getLinks($id_item)
    {
        $sql   = 'SELECT id, id_item, name AS name, url, description, bin
      FROM links
      WHERE id_item = ? AND bin != "yes"
      ORDER BY id';
        $links = $this->dbConnect($sql, array(
            $id_item
        ));
        return $links;
    }

    // Afficher la liste des Liens en Front
    public function getLinksList($links_current_page, $number_of_links_pages)
    {
        $links_start = (int) (($links_current_page - 1) * $this->number_of_links_by_page);
        $sql  = 'SELECT *
        FROM links
        WHERE bin != "yes"
        ORDER BY id ASC LIMIT ' . $links_start . ', ' . $this->number_of_links_by_page . '';
        if ($links_current_page > $number_of_links_pages)
          throw new Exception("Aucun Lien trouvé.");
          else return $links       = $this->dbConnect($sql);
        }


    // Afficher la liste des Liens en Admin :
    public function getLinksAdmin()
    {
        $sql   = 'SELECT links.id AS id, links.id_item AS id_item, links.name AS name, links.url AS url, links.description AS description, links.bin AS bin,
      extended_cards.id AS extended_cards, extended_cards.title AS title
     FROM links
     LEFT JOIN extended_cards
     ON links.id_item = extended_cards.id
     WHERE links.bin != "yes"
     ORDER BY id ASC LIMIT 0, 100';
        $links = $this->dbConnect($sql);
        return $links;
    }

    // Afficher un Lien en particulier :
    public function getLinkAdmin($id_link)
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
    public function getLinksDeleted()
    {
        $sql           = 'SELECT *
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
    public function changeLink($id_link, $id_item, $name, $url, $description)
    {

        $sql                      = 'UPDATE links SET id_item = :id_item, name = :name, url = :url, description = :description
        WHERE id = :id_link';
        $link                     = $this->dbConnect($sql, array(
            ':id_link' => $id_link,
            ':id_item' => $id_item,
            ':name' => $name,
            ':url' => $url,
            ':description' => $description
        ));
    }

    // Restaurer un lien depuis la Corbeille
    public function restoreLink($id_link)
    {
        $bin                      = "no";
        $sql                      = 'UPDATE links SET bin = :bin WHERE id = :id';
        $restore                  = $this->dbConnect($sql, array(
            ':id' => $id_link,
            ':bin' => $bin
        ));
    }


    // DELETE

    // Déplacement d'un lien vers la Corbeille
    public function moveLink($id_link)
    {
        $bin                      = "yes";
        $sql                      = 'UPDATE links SET bin = :bin WHERE id = :id';
        $move                     = $this->dbConnect($sql, array(
            ':id' => $id_link,
            ':bin' => $bin
        ));
    }

    // Suppression définitive d'un lien
    public function eraseLink($id_link)
    {
        $sql = 'DELETE
        FROM links
        WHERE id = ' . (int) $id_link;
        $req = $this->dbConnect($sql);
        $req->execute();
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
    }


}
