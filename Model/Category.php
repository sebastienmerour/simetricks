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
        $sql                      = 'INSERT INTO categories (name, slug, description)
                     VALUES
                      (:name, :slug, :description)';
        $categories               = $this->dbConnect($sql, array(
            ':name' => $name,
            ':slug' => $slugcategory,
            ':description' => $description
        ));
        $messages['confirmation'] = 'La catégorie a bien été ajoutée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'categories');
            exit;
        }
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
     ORDER BY categories.id ASC LIMIT 0, 100';
        $categories = $this->dbConnect($sql);
        return $categories;
    }

    // Afficher une Catégorie en particulier :
    public function getCategory($id_category)
    {
        $sql      = 'SELECT *
        FROM categories
        WHERE id = ? ';
        $req      = $this->dbConnect($sql, array(
            $id_category

        ));
        $category = $req->fetch();
        return $category;
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
        $sql                      = 'UPDATE categories SET name = :name, slug = :slug, description = :description
        WHERE id = :id_category';
        $category                 = $this->dbConnect($sql, array(
            ':id_category' => $id_category,
            ':slug' => $slugcategory,
            ':name' => $name,
            ':description' => $description
        ));
        $messages['confirmation'] = 'La Catégorie a bien été modifiée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'categories/categoryread/' . $id_category);
            exit;
        }
    }

    // Restaurer une Catégorie depuis la Corbeille
    public function restoreCategory($id_category)
    {
        $bin                      = "no";
        $sql                      = 'UPDATE categories SET bin = :bin WHERE id = :id';
        $restore                  = $this->dbConnect($sql, array(
            ':id' => $id_category,
            ':bin' => $bin
        ));
        $messages['confirmation'] = 'Merci ! La Catégorie a bien été restaurée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'categories/categoriesbin');
            exit;
        }
    }

    // DELETE

    // Déplacement d'une catégorie vers la Corbeille
    public function moveCategory($id_category)
    {
        $bin                      = "yes";
        $sql                      = 'UPDATE categories SET bin = :bin WHERE id = :id';
        $move                     = $this->dbConnect($sql, array(
            ':id' => $id_category,
            ':bin' => $bin
        ));
        $messages['confirmation'] = 'Merci ! La Catégorie a été déplacée dans la corbeille !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'categories');
            exit;
        }
    }

    // Suppression définitive d'une catégorie
    public function eraseCategory($id_category)
    {
        $sql = 'DELETE
        FROM categories
        WHERE id = ' . (int) $id_category;
        $req = $this->dbConnect($sql);
        $req->execute();

        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! La Catégorie a été supprimée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'categories/categoriesbin');
            exit;
        }
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
        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! La corbeille a été vidée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'categories/categoriesbin');
            exit;
        }
    }


}
