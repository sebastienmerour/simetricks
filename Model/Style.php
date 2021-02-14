<?php
require_once 'Framework/Model.php';

/**
 * Fournit les fonctions liées aux styles
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class Style extends Model
{
    public $number_of_styles, $styles_current_page, $number_of_styles_pages, $number_of_styles_by_page = 5;

    // CREATE

    // Création d'un nouveau style :
    public function insertStyle($name, $description, $hexadecimal)
    {
        $sql                      = 'INSERT INTO styles (name, description, hexadecimal)
                     VALUES
                      (:name, :description, :hexadecimal)';
        $styles               = $this->dbConnect($sql, array(
            ':name' => $name,
            ':description' => $description,
            ':hexadecimal' => $hexadecimal
        ));
    }

    // READ

    // Afficher la liste des Styles :
    public function getStyles()
    {
        $sql        = 'SELECT *
     FROM styles
     WHERE bin != "yes"
     ORDER BY id ASC LIMIT 0, 100';
        $styles = $this->dbConnect($sql);
        return $styles;
    }

    // Afficher une Style en particulier :
    public function getStyle($id_style)
    {
        $sql      = 'SELECT *
        FROM styles
        WHERE id = ? ';
        $req      = $this->dbConnect($sql, array(
            $id_style

        ));
        $style = $req->fetch();
        return $style;
    }

    // Afficher la liste des Styles Supprimés :
    public function getStylesDeleted()
    {
        $sql                = 'SELECT *
     FROM styles
     WHERE bin = :bin
     ORDER BY name DESC LIMIT 0, 100';
        $styles_deleted = $this->dbConnect($sql, array(
            ':bin' => "yes"
        ));
        return $styles_deleted;
    }


    // UPDATE

    // Modification d'une catégorie :
    public function changeStyle($id_style, $name, $description, $hexadecimal)
    {
        $sql                      = 'UPDATE styles SET name = :name, description = :description, hexadecimal = :hexadecimal
        WHERE id = :id_style';
        $style                 = $this->dbConnect($sql, array(
            ':id_style' => $id_style,
            ':name' => $name,
            ':description' => $description,
            ':hexadecimal' => $hexadecimal
        ));
    }

    // Restaurer un Style depuis la Corbeille
    public function restoreStyle($id_style)
    {
        $bin                      = "no";
        $sql                      = 'UPDATE styles SET bin = :bin WHERE id = :id';
        $restore                  = $this->dbConnect($sql, array(
            ':id' => $id_style,
            ':bin' => $bin
        ));
    }

    // DELETE

    // Déplacement d'un style vers la Corbeille
    public function moveStyle($id_style)
    {
        $bin                      = "yes";
        $sql                      = 'UPDATE styles SET bin = :bin WHERE id = :id';
        $move                     = $this->dbConnect($sql, array(
            ':id' => $id_style,
            ':bin' => $bin
        ));
    }

    // Suppression définitive d'un style
    public function eraseStyle($id_style)
    {
        $sql = 'DELETE
        FROM styles
        WHERE id = ' . (int) $id_style;
        $req = $this->dbConnect($sql);
        $req->execute();
    }

    // Vidage de la Corbeille des styles.
    public function emptybin()
    {
        $bin = "yes";
        $sql = 'DELETE
        FROM styles
        WHERE bin = :bin';
        $req = $this->dbConnect($sql, array(
            ':bin' => $bin
        ));
        $req->execute();
    }


}
