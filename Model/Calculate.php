<?php
require_once 'Framework/Model.php';

/**
 * Fournit les fonctions liées aux Calculs
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class Calculate extends Model
{
  public
  $number_of_comments,
  $comments_current_page,
  $number_of_items_by_page = 5,
  $number_of_comments_by_page = 5,
  $number_of_comments_reported_by_page = 5,
  $number_of_users_by_page = 5,
  $number_of_categories,
  $number_of_categories_by_page = 5;

  // ITEMS
  // FRONT

  // Obtenir le nombre total des Items :
  public function getTotalOfItems()
  {
      $sql               = 'SELECT COUNT(id) AS counter FROM extended_cards
      WHERE bin != "yes"';
      $this->items_count = $this->dbConnect($sql);
      $items             = $this->items_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_items   = $items['counter'];
      return $number_of_items;
  }

  // Obtenir le nombre total des Items d'une Catégorie :
  public function getTotalOfItemsFromCat($id_category)
  {
      $sql               = 'SELECT COUNT(id) AS counter FROM extended_cards
      WHERE bin != "yes"
      AND id_category = :cat';
      $this->items_count = $this->dbConnect($sql, array(
          ':cat' => $id_category
      ));
      $items             = $this->items_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_items   = $items['counter'];
      return $number_of_items;
  }

  // Obtenir le nombre de pages des articles :
  public function getNumberOfPages()
  {
      $number_of_items       = $this->getTotalOfItems();
      // Calculer le nombre de pages nécessaires :
      $number_of_items_pages = ceil($number_of_items / $this->number_of_items_by_page);
      return $number_of_items_pages;
  }

  // Obtenir le nombre de pages des articles :
  public function getNumberOfCatPages($id_category)
  {
      $number_of_items       = $this->getTotalOfItemsFromCat($id_category);
      // Calculer le nombre de pages nécessaires :
      $number_of_items_pages = ceil($number_of_items / $this->number_of_items_by_page);
      return $number_of_items_pages;
  }

  // Obtenir l'ID d'un item sur la page de modification de commentaires :
  public function getItemId()
  {
      $q       = explode("/", $_SERVER['REQUEST_URI']);
      $value   = $q[3];
      $id_item = (int) $value;
      return $id_item;
  }


  // ADMIN

  // Obtenir le nombre total des Items supprimés :
  public function getTotalOfItemsDeleted()
  {
      $sql                  = 'SELECT COUNT(id) AS counter FROM extended_cards WHERE bin = :bin ';
      $items_deleted_count = $this->dbConnect($sql, array(
          ':bin' => "yes"
      ));
      $this->items_deleted_count = $items_deleted_count->fetch(\PDO::FETCH_ASSOC);
      $total_items_deleted_count = $this->items_deleted_count['counter'];
      return $total_items_deleted_count;
  }

  // Obtenir le nombre de pages des articles supprimés :
  public function getNumberOfPagesDeleted()
  {
      $number_of_items_deleted       = $this->getTotalOfItemsDeleted();
      // Calculer le nombre de pages nécessaires :
      $number_of_items_deleted_pages = ceil($number_of_items_deleted / $this->number_of_items_by_page);
      return $number_of_items_deleted_pages;
  }

  // COMMENTAIRES
  // FRONT

  // Calculer le nombre total de commentaires :
  public function getTotalOfComments()
  {
      $sql                  = 'SELECT COUNT(id) as counter FROM comments
      WHERE bin != "yes"
      ';
      $comments             = $this->dbConnect($sql);
      $this->comments_count = $comments->fetch(\PDO::FETCH_ASSOC);
      $total_comments_count = $this->comments_count['counter'];
      return $total_comments_count;
  }

  // Calculer le nombre de Commentaires d'un article en particulier :
  public function countComments($id_item)
  {
      $sql                  = 'SELECT COUNT(id) as counter FROM comments
      WHERE id_item = ? AND bin != "yes"
      ';
      $this->comments_count = $this->dbConnect($sql, array(
          $id_item
      ));
      $comments             = $this->comments_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_comments   = $comments['counter'];
      return $number_of_comments;
  }

  // Obtenir l'ID du commentaire pour une modification du commentaire en Front :
  public function getCommentId()
  {
      $q          = explode("/", $_SERVER['REQUEST_URI']);
      $value      = $q[4];
      $id_comment = (int) $value;
      return $id_comment;
  }

  // Obtenir la page courante des commentaires sur un article en particulier :
  public function getCommentsCurrentPage()
  {
      $q                     = explode("/", $_SERVER['REQUEST_URI']);
      $value                 = $q[3];
      $comments_current_page = (int) $value;
      return $comments_current_page;
  }

  // Obtenir la page courante des commentaires sur un article en particulier avec user connecté :
  public function getCommentsCurrentPageUser()
  {
      $q                     = explode("/", $_SERVER['REQUEST_URI']);
      $value                 = $q[4];
      $comments_current_page = (int) $value;
      return $comments_current_page;
  }

  // Obtenir le nombre de pages des commentaires sur un article en particulier :
  public function getNumberOfCommentsPagesFromItem($id_item)
  {
      $number_of_comments       = $this->countComments($id_item);
      $number_of_comments_pages = ceil($number_of_comments / $this->number_of_comments_by_page);
      return $number_of_comments_pages;
  }

  // ADMIN

  // Calculer le nombre total de Pages de Commentaires pour l'admin :
  public function getNumberOfCommentsPagesFromAdmin()
  {
      $total_comments_count     = $this->getTotalOfComments();
      $number_of_comments_pages = ceil($total_comments_count / $this->number_of_comments_by_page);
      return $number_of_comments_pages;
  }

  // Calculer le nombre total de Pages de Commentaires Signalés pour l'admin :
  public function getNumberOfCommentsReportedPagesFromAdmin()
  {
      $total_comments_reported_count     = $this->getTotalOfCommentsReported();
      // Calculer le nombre de pages nécessaires :
      $number_of_comments_reported_pages = ceil($total_comments_reported_count / $this->number_of_comments_reported_by_page);
      return $number_of_comments_reported_pages;
  }

  // Calculer le nombre total de commentaires signalés pour l'admin :
  public function getTotalOfCommentsReported()
  {
      $sql                     = 'SELECT COUNT(id) as counter FROM comments WHERE report = :report ';
      $comments_reported_count = $this->dbConnect($sql, array(
          ':report' => "yes"
      ));

      $this->comments_reported_count = $comments_reported_count->fetch(\PDO::FETCH_ASSOC);
      $total_comments_reported_count = $this->comments_reported_count['counter'];
      return $total_comments_reported_count;
  }

  // Calculer le nombre total de commentaires supprimés :
  public function getTotalOfCommentsDeleted()
  {
      $sql                  = 'SELECT COUNT(id) as counter FROM comments WHERE bin = :bin ';
      $comments_deleted           = $this->dbConnect($sql, array(
          ':bin' => "yes"
      ));
      $this->comments_deleted_count = $comments_deleted->fetch(\PDO::FETCH_ASSOC);
      $total_comments_deleted_count = $this->comments_deleted_count['counter'];
      return $total_comments_deleted_count;
  }

  // Calculer le nombre total de Pages de Commentaires Supprimés pour l'admin :
  public function getNumberOfCommentsDeletedPagesFromAdmin()
  {
      $total_comments_deleted_count     = $this->getTotalOfCommentsDeleted();
      $number_of_comments_deleted_pages = ceil($total_comments_deleted_count / $this->number_of_comments_by_page);
      return $number_of_comments_deleted_pages;
  }


  // USERS
  // ADMIN

  // Calculer le nombre total de Pages de Users pour l'admin :
  public function getNumberOfUsersPagesFromAdmin()
  {
      $total_users_count     = $this->getTotalOfUsers();
      $number_of_users_pages = ceil($total_users_count / $this->number_of_users_by_page);
      return $number_of_users_pages;
  }

  // Calculer le nombre total de users :
  public function getTotalOfUsers()
  {
      $id_admin = ID_ADMIN;
      $sql                  = 'SELECT COUNT(id_user) as counter
      FROM users
      WHERE id_user != :id_admin';
      $users                = $this->dbConnect($sql, array(
          ':id_admin' => "$id_admin"
      ));
      $this->users_count    = $users->fetch(\PDO::FETCH_ASSOC);
      $total_users_count    = $this->users_count['counter'];
      return $total_users_count;
  }

  // Calculer le nombre total d'utilisateurs supprimés :
  public function getTotalOfUsersDeleted()
  {
      $sql                  = 'SELECT COUNT(id_user) as counter FROM users WHERE bin = :bin ';
      $users_deleted           = $this->dbConnect($sql, array(
          ':bin' => "yes"
      ));
      $this->users_deleted_count = $users_deleted->fetch(\PDO::FETCH_ASSOC);
      $total_users_deleted_count = $this->users_deleted_count['counter'];
      return $total_users_deleted_count;
  }

  // Calculer le nombre total de Pages d' utilisateurs supprimés pour l'admin :
  public function getNumberOfUsersDeletedPagesFromAdmin()
  {
      $total_users_deleted_count     = $this->getTotalOfUsersDeleted();
      $number_of_users_deleted_pages = ceil($total_users_deleted_count / $this->number_of_users_by_page);
      return $number_of_users_deleted_pages;
  }

  // CATEGORIES
  // ADMIN

  // Obtenir le nombre total des Catégories :
  public function getTotalOfCategories()
  {
      $sql               = 'SELECT COUNT(id) AS counter FROM categories
      WHERE bin != "yes"';
      $this->categories_count = $this->dbConnect($sql);
      $categories             = $this->categories_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_categories   = $categories['counter'];
      return $number_of_categories;
  }


  // Obtenir le nombre total des Catégories supprimées :
  public function getTotalOfCategoriesDeleted()
  {
      $sql                  = 'SELECT COUNT(id) AS counter FROM categories WHERE bin = :bin ';
      $categories_deleted_count = $this->dbConnect($sql, array(
          ':bin' => "yes"
      ));
      $this->categories_deleted_count = $categories_deleted_count->fetch(\PDO::FETCH_ASSOC);
      $total_categories_deleted_count = $this->categories_deleted_count['counter'];
      return $total_categories_deleted_count;
  }


}
