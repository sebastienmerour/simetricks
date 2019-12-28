<?php
require_once 'Framework/Model.php';

/**
 * Fournit les fonctions liées aux commentaires
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
  $number_of_users_by_page = 5;

  // ITEMS
  // FRONT

  // Obtenir le nombre total des Items :
  public function getTotalOfItems()
  {
      $sql               = 'SELECT COUNT(id) AS counter FROM extended_cards';
      $this->items_count = $this->dbConnect($sql);
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

  // Obtenir l'ID d'un item sur la page de modification de commentaires :
  public function getItemId()
  {
      $q       = explode("/", $_SERVER['REQUEST_URI']);
      $value   = $q[4];
      $item_id = (int) $value;
      return $item_id;
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
      $sql                  = 'SELECT COUNT(id) as counter FROM comments';
      $comments             = $this->dbConnect($sql);
      $this->comments_count = $comments->fetch(\PDO::FETCH_ASSOC);
      $total_comments_count = $this->comments_count['counter'];
      return $total_comments_count;
  }


  // COMMENTAIRES
  // FRONT

  // Calculer le nombre de Commentaires d'un article en particulier :
  public function countComments($item_id)
  {
      $sql                  = 'SELECT COUNT(id) as counter FROM comments WHERE id_item = ?';
      $this->comments_count = $this->dbConnect($sql, array(
          $item_id
      ));
      $comments             = $this->comments_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_comments   = $comments['counter'];
      return $number_of_comments;
  }

  // Obtenir l'ID du commentaire pour une modification du commentaire en Front :
  public function getCommentId()
  {
      $q          = explode("/", $_SERVER['REQUEST_URI']);
      $value      = $q[5];
      $id_comment = (int) $value;
      return $id_comment;
  }

  // Obtenir la page courante des commentaires sur un article en particulier :
  public function getCommentsCurrentPage()
  {
      $q                     = explode("/", $_SERVER['REQUEST_URI']);
      $value                 = $q[4];
      $comments_current_page = (int) $value;
      return $comments_current_page;
  }

  // Obtenir la page courante des commentaires sur un article en particulier avec user connecté :
  public function getCommentsCurrentPageUser()
  {
      $q                     = explode("/", $_SERVER['REQUEST_URI']);
      $value                 = $q[5];
      $comments_current_page = (int) $value;
      return $comments_current_page;
  }

  // Obtenir le nombre de pages des commentaires sur un article en particulier :
  public function getNumberOfCommentsPagesFromItem($item_id)
  {
      $number_of_comments       = $this->countComments($item_id);
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
      $sql                  = 'SELECT COUNT(id_user) as counter FROM users';
      $users                = $this->dbConnect($sql);
      $this->users_count    = $users->fetch(\PDO::FETCH_ASSOC);
      $total_users_count    = $this->users_count['counter'];
      return $total_users_count;
  }

}
