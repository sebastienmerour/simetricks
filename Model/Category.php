<?php
require_once 'Framework/Model.php';

/**
 * Fournit les fonctions liées aux catégories
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class Category extends Model
{
    public $number_of_categories, $categories_current_page, $number_of_categories_pages, $number_of_categories_by_page = 5;

    // CREATE


    // Création d'une nouvelle catégorie :
    public function insertCategory($name, $slugcategory, $description)
    {
        $sql        = 'INSERT INTO categories (name, slug, description)
                     VALUES
                      (:name, :slug, :description)';
        $categories = $this->dbConnect($sql, array(
            ':name' => $name,
            ':slug' => $slugcategory,
            ':description' => $description
        ));
    }

    // READ

    // Afficher la liste des Catégories :
    public function getCategories()
    {
        $sql        = 'SELECT categories.*,
     COUNT(extended_cards.id_category) AS count
     FROM categories
     LEFT JOIN extended_cards
     ON extended_cards.id_category = categories.id
     GROUP BY categories.id
     HAVING categories.bin != "yes"
     ORDER BY categories.name ASC LIMIT 0, 100';
        $categories = $this->dbConnect($sql);
        if ($categories->rowCount() > 0)
            return $categories;
        else
            throw new Exception("Aucune Catégorie trouvée.");
    }


    // Afficher une Catégorie en particulier :
    public function getCategory($id_category)
    {
        $sql = 'SELECT id AS catid, name, slug, description, bin
        FROM categories
        WHERE id = ? ';
        $req = $this->dbConnect($sql, array(
            $id_category
        ));
        if ($req->rowCount() == 1)
            return $category = $req->fetch();
        else
            throw new Exception("Cette Catégorie n'existe pas.");
    }

    // Afficher la liste des Catégories Supprimées :
    public function getCategoriesDeleted()
    {
        $sql                = 'SELECT *
     FROM categories
     WHERE bin = :bin
     ORDER BY name DESC LIMIT 0, 100';
        $categories_deleted = $this->dbConnect($sql, array(
            ':bin' => "yes"
        ));
        return $categories_deleted;
    }


    // UPDATE

    // Modification d'une catégorie :
    public function changeCategory($id_category, $name, $slugcategory, $description)
    {
        $sql      = 'UPDATE categories SET name = :name, slug = :slug, description = :description
        WHERE id = :id_category';
        $category = $this->dbConnect($sql, array(
            ':id_category' => $id_category,
            ':slug' => $slugcategory,
            ':name' => $name,
            ':description' => $description
        ));
    }

    // Restaurer une Catégorie depuis la Corbeille
    public function restoreCategory($id_category)
    {
        $bin     = "no";
        $sql     = 'UPDATE categories SET bin = :bin WHERE id = :id';
        $restore = $this->dbConnect($sql, array(
            ':id' => $id_category,
            ':bin' => $bin
        ));
    }

    // DELETE

    // Déplacement d'une catégorie vers la Corbeille
    public function moveCategory($id_category)
    {
        $bin  = "yes";
        $sql  = 'UPDATE categories SET bin = :bin WHERE id = :id';
        $move = $this->dbConnect($sql, array(
            ':id' => $id_category,
            ':bin' => $bin
        ));
    }

    // Suppression définitive d'une catégorie
    public function eraseCategory($id_category)
    {
        $sql = 'DELETE
        FROM categories
        WHERE id = ' . (int) $id_category;
        $req = $this->dbConnect($sql);
        $req->execute();
    }

    // Vidage de la Corbeille des catégories.
    public function emptybin()
    {
        $bin = "yes";
        $sql = 'DELETE
        FROM categories
        WHERE bin = :bin';
        $req = $this->dbConnect($sql, array(
            ':bin' => $bin
        ));
        $req->execute();
    }
    
}
