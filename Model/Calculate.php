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
  $number_of_items_by_page = 6,
  $number_of_pages_by_page = 6,
  $number_of_cards_by_page = 6,
  $number_of_links_by_page = 6,
  $number_of_comments_by_page = 5,
  $number_of_comments_reported_by_page = 5,
  $number_of_users_by_page = 5,
  $number_of_categories,
  $number_of_categories_by_page = 5;

  // EXTENDED CARDS
  // FRONT

  // Obtenir le nombre total des Items en Home :
  public function getTotalOfItemsHome()
  {
      $sql               = 'SELECT COUNT(id) AS counter FROM extended_cards
      WHERE bin != "yes"
      AND draft = "no"
      UNION SELECT COUNT(id) AS countercards FROM cards
      WHERE bin != "yes"
      ';
      $this->items_count = $this->dbConnect($sql);
      $items             = $this->items_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_items   = $items['counter'];
      return $number_of_items;
  }

  // Obtenir le nombre total des Items en Front :
  public function getTotalOfItemsFront()
  {
      $sql               = 'SELECT COUNT(id) AS counter FROM extended_cards
      WHERE bin != "yes"
      AND draft = "no"
      ';
      $this->items_count = $this->dbConnect($sql);
      $items             = $this->items_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_items   = $items['counter'];
      return $number_of_items;
  }

  // Obtenir le nombre total des Items d'une Catégorie :
  public function getTotalOfItemsFromCatFront($id_category)
  {
      $sql               = 'SELECT COUNT(id) AS counter FROM extended_cards
      WHERE bin != "yes"
      AND draft = "no"
      AND id_category = :cat';
      $this->items_count = $this->dbConnect($sql, array(
          ':cat' => $id_category
      ));
      $items             = $this->items_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_items   = $items['counter'];
      return $number_of_items;
  }

  // Obtenir le nombre de pages des Extended Cards en Home :
  public function getNumberOfPagesOfExtHome()
  {
      $number_of_items       = $this->getTotalOfItemsHome();
      // Calculer le nombre de pages nécessaires :
      $number_of_items_pages = ceil($number_of_items / $this->number_of_items_by_page);
      return $number_of_items_pages;
  }

  // Obtenir le nombre de pages des Extended Cards en Front :
  public function getNumberOfPagesOfExtFront()
  {
      $number_of_items       = $this->getTotalOfItemsFront();
      // Calculer le nombre de pages nécessaires :
      $number_of_items_pages = ceil($number_of_items / $this->number_of_items_by_page);
      return $number_of_items_pages;
  }

  // Obtenir le nombre de pages des Extended Cards d'une Catégorie précise :
  public function getNumberOfCatPagesFront($id_category)
  {
      $number_of_itemsFromCat       = $this->getTotalOfItemsFromCatFront($id_category);
      // Calculer le nombre de pages nécessaires :
      $number_of_items_pages = ceil($number_of_itemsFromCat / $this->number_of_items_by_page);
      return $number_of_items_pages;
  }

  // Obtenir l'ID d'une Extended Card sur la page de modification de commentaires :
  public function getItemId()
  {
      $q       = explode("/", $_SERVER['REQUEST_URI']);
      $value   = $q[3];
      $id_item = (int) $value;
      return $id_item;
  }

  // Ajouter 1 vue pour calculer le nombre de pages vues
  public function pageviewItemId($id_item)
  {
      $sql               = 'UPDATE extended_cards SET views = views+1
      WHERE id = :id';
      $item              = $this->dbConnect($sql, array(
        ':id' => $id_item
      ));

  }

  // Afficher le nombre de pages vues pour une Extended Card :
  public function displayPageView($id_item)
  {
      $sql               = 'SELECT * FROM extended_cards
      WHERE id = :id';
      $this->views_count = $this->dbConnect($sql);
      $items             = $this->views_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_page_view = $items['views'];
      return $number_of_page_view;
  }


  // ADMIN
  // Extended Cards

  // Obtenir le nombre total des Extended Cards en Admin :
  public function getTotalOfItemsAdmin()
  {
      $sql               = 'SELECT COUNT(id) AS counter FROM extended_cards
      WHERE bin != "yes"
      ';
      $this->items_count = $this->dbConnect($sql);
      $items             = $this->items_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_items   = $items['counter'];
      return $number_of_items;
  }

  // Obtenir le nombre de pages des Extended Cards en Admin :
  public function getNumberOfPagesOfExtAdmin()
  {
      $number_of_items       = $this->getTotalOfItemsAdmin();
      // Calculer le nombre de pages nécessaires :
      $number_of_items_pages = ceil($number_of_items / $this->number_of_items_by_page);
      return $number_of_items_pages;
  }

  // Obtenir le nombre de pages des Extended Cards d'une Catégorieen Admin :
  public function getNumberOfPagesOfExtAdminSelected($id_category)
  {
      $number_of_items       = $this->getTotalOfItemsFromCatFront($id_category);
      // Calculer le nombre de pages nécessaires :
      $number_of_items_pages = ceil($number_of_items / $this->number_of_items_by_page);
      return $number_of_items_pages;
  }



  // Obtenir le nombre total des Extended Cards supprimées :
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

  // Obtenir le nombre de pages des Extended Cards supprimées :
  public function getNumberOfPagesOfExtDeleted()
  {
      $number_of_items_deleted       = $this->getTotalOfItemsDeleted();
      // Calculer le nombre de pages nécessaires :
      $number_of_items_deleted_pages = ceil($number_of_items_deleted / $this->number_of_items_by_page);
      return $number_of_items_deleted_pages;
  }



  // PAGES

  // Obtenir le nombre de pages des Pages en Admin :
  public function getNumberOfPagesOfPagesAdmin()
  {
    $number_of_pages       = $this->getTotalOfPagesAdmin();
    // Calculer le nombre de pages nécessaires :
    $number_of_pages_pages = ceil($number_of_pages / $this->number_of_pages_by_page);
    return $number_of_pages_pages;
  }

  // Obtenir le nombre total des Pages en Admin :
  public function getTotalOfPagesAdmin()
  {
      $sql               = 'SELECT COUNT(id) AS counter FROM pages
      WHERE bin != "yes"
      ';
      $this->pages_count = $this->dbConnect($sql);
      $pages             = $this->pages_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_pages   = $pages['counter'];
      return $number_of_pages;
  }

  // Obtenir le nombre total des Pages supprimées :
  public function getTotalOfPagesDeleted()
  {
      $sql                  = 'SELECT COUNT(id) AS counter FROM pages WHERE bin = :bin ';
      $pages_deleted_count = $this->dbConnect($sql, array(
          ':bin' => "yes"
      ));
      $this->pages_deleted_count = $pages_deleted_count->fetch(\PDO::FETCH_ASSOC);
      $total_pages_deleted_count = $this->pages_deleted_count['counter'];
      return $total_pages_deleted_count;
  }

  // Obtenir le nombre de pages des Pages supprimées :
  public function getNumberOfPagesOfPagesDeleted()
  {
      $number_of_pages_deleted       = $this->getTotalOfPagesDeleted();
      // Calculer le nombre de pages nécessaires :
      $number_of_pages_deleted_pages = ceil($number_of_pages_deleted / $this->number_of_pages_by_page);
      return $number_of_pages_deleted_pages;
  }

  // CARDS
  // FRONT

  // Obtenir le nombre total des Cards :
  public function getTotalOfCards()
  {
      $sql               = 'SELECT COUNT(id) AS counter FROM cards
      WHERE bin != "yes"';
      $this->cards_count = $this->dbConnect($sql);
      $cards             = $this->cards_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_cards   = $cards['counter'];
      return $number_of_cards;
  }

  // Obtenir le nombre de pages des Cards :
  public function getNumberOfPagesOfCards()
  {
      $number_of_cards       = $this->getTotalOfCards();
      // Calculer le nombre de pages nécessaires :
      $number_of_cards_pages = ceil($number_of_cards / $this->number_of_cards_by_page);
      return $number_of_cards_pages;
  }


  // LINKS
  // FRONT

  // Obtenir le nombre de pages des Links :
  public function getNumberOfPagesOfLinks()
  {
      $number_of_links       = $this->getTotalOfLinks();
      // Calculer le nombre de pages nécessaires :
      $number_of_links_pages = ceil($number_of_links / $this->number_of_links_by_page);
      return $number_of_links_pages;
  }



  // ADMIN

  // Obtenir le nombre total des Cards supprimées :
  public function getTotalOfCardsDeleted()
  {
      $sql                  = 'SELECT COUNT(id) AS counter FROM cards WHERE bin = :bin ';
      $cards_deleted_count = $this->dbConnect($sql, array(
          ':bin' => "yes"
      ));
      $this->cards_deleted_count = $cards_deleted_count->fetch(\PDO::FETCH_ASSOC);
      $total_cards_deleted_count = $this->cards_deleted_count['counter'];
      return $total_cards_deleted_count;
  }

  // Obtenir le nombre de pages des Cards supprimées :
  public function getNumberOfPagesOfCardsDeleted()
  {
      $number_of_cards_deleted       = $this->getTotalOfCardsDeleted();
      // Calculer le nombre de pages nécessaires :
      $number_of_cards_deleted_pages = ceil($number_of_cards_deleted / $this->number_of_cards_by_page);
      return $number_of_cards_deleted_pages;
  }


  // COMMENTAIRES
  // FRONT

  // Calculer le nombre total de commentaires :
  public function getTotalOfComments()
  {
      $sql                  = 'SELECT COUNT(id) as counter FROM comments
      WHERE bin != "yes" AND report !="yes"
      ';
      $comments             = $this->dbConnect($sql);
      $this->comments_count = $comments->fetch();
      $total_comments_count = $this->comments_count['counter'];
      return $total_comments_count;
  }

  // Calculer le nombre de Commentaires d'une Extended Card précise :
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

  // Obtenir la page courante des commentaires sur une Extended Card précise :
  public function getCommentsCurrentPage()
  {
      $q                     = explode("/", $_SERVER['REQUEST_URI']);
      $value                 = $q[3];
      $comments_current_page = (int) $value;
      return $comments_current_page;
  }

  // Obtenir la page courante des commentaires sur une Extended Card précise avec user connecté :
  public function getCommentsCurrentPageUser()
  {
      $q                     = explode("/", $_SERVER['REQUEST_URI']);
      $value                 = $q[4];
      $comments_current_page = (int) $value;
      return $comments_current_page;
  }

  // Obtenir le nombre de pages des commentaires sur une Extended Card précise :
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

  // Calculer le nombre total de Commentaires signalés pour l'admin :
  public function getTotalOfCommentsReported()
  {
      $sql                     = 'SELECT COUNT(id) as counter FROM comments
      WHERE report = :report
      AND bin = :bin
      ';
      $comments_reported_count = $this->dbConnect($sql, array(
          ':report' => "yes",
          ':bin'    => "no"
      ));
      $this->comments_reported_count = $comments_reported_count->fetch(\PDO::FETCH_ASSOC);
      $total_comments_reported_count = $this->comments_reported_count['counter'];
      return $total_comments_reported_count;
  }

  // Calculer le nombre total de Commentaires supprimés :
  public function getTotalOfCommentsDeleted()
  {
      $sql                  = 'SELECT COUNT(id) as counter FROM comments WHERE bin = :bin AND report = :report ';
      $comments_deleted           = $this->dbConnect($sql, array(
          ':bin' => "yes",
          ':report'=> "no"
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

  // Calculer le nombre total de Commentaires signalés supprimés :
  public function getTotalOfCommentsReportedDeleted()
  {
      $sql                  = 'SELECT COUNT(id) as counter FROM comments WHERE bin = :bin AND report = :report ';
      $comments_reported_deleted           = $this->dbConnect($sql, array(
          ':bin' => "yes",
          ':report' => "yes"
      ));
      $this->comments_reported_deleted_count = $comments_reported_deleted->fetch(\PDO::FETCH_ASSOC);
      $total_comments_reported_deleted_count = $this->comments_reported_deleted_count['counter'];
      return $total_comments_reported_deleted_count;
  }

  // Calculer le nombre total de Pages de Commentaires Signalés Supprimés pour l'admin :
  public function getNumberOfCommentsReportedDeletedPagesFromAdmin()
  {
      $total_comments_reported_deleted_count     = $this->getTotalOfCommentsReportedDeleted();
      $number_of_comments_reported_deleted_pages = ceil($total_comments_reported_deleted_count / $this->number_of_comments_by_page);
      return $number_of_comments_reported_deleted_pages;
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

  // Calculer le nombre total de Users :
  public function getTotalOfUsers()
  {
      $id_admin = ID_ADMIN;
      $sql                  = 'SELECT COUNT(id_user) as counter
      FROM users
      WHERE id_user != :id_admin AND bin != "yes"
      ';
      $users                = $this->dbConnect($sql, array(
          ':id_admin' => "$id_admin"
      ));
      $this->users_count    = $users->fetch(\PDO::FETCH_ASSOC);
      $total_users_count    = $this->users_count['counter'];
      return $total_users_count;
  }

  // Calculer le nombre total de Users supprimés :
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

  // Calculer le nombre total de Pages de Users supprimés pour l'admin :
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

  // LINKS
  // ADMIN

  // Obtenir le nombre total des Liens :
  public function getTotalOfLinks()
  {
      $sql               = 'SELECT COUNT(id) AS counter FROM links
      WHERE bin != "yes"';
      $this->links_count = $this->dbConnect($sql);
      $links             = $this->links_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_links   = $links['counter'];
      return $number_of_links;
  }

  // Obtenir le nombre total des Liens supprimés :
  public function getTotalOfLinksDeleted()
  {
      $sql                  = 'SELECT COUNT(id) AS counter FROM links WHERE bin = :bin ';
      $links_deleted_count = $this->dbConnect($sql, array(
          ':bin' => "yes"
      ));
      $this->links_deleted_count = $links_deleted_count->fetch(\PDO::FETCH_ASSOC);
      $total_links_deleted_count = $this->links_deleted_count['counter'];
      return $total_links_deleted_count;
  }


  // STYLES
  // ADMIN

  // Obtenir le nombre total des Styles :
  public function getTotalOfStyles()
  {
      $sql               = 'SELECT COUNT(id) AS counter FROM styles
      WHERE bin != "yes"';
      $this->styles_count = $this->dbConnect($sql);
      $styles             = $this->styles_count->fetch(\PDO::FETCH_ASSOC);
      $number_of_styles   = $styles['counter'];
      return $number_of_styles;
  }

  // Obtenir le nombre total des Styles supprimés :
  public function getTotalOfStylesDeleted()
  {
      $sql               = 'SELECT id FROM styles
      WHERE bin = "yes"';
      $req = $this->dbConnect($sql);
      $number_of_styles_deleted = $req->rowCount();
      return $number_of_styles_deleted;
  }


}
