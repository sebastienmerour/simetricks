<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Card.php';

/**
 * Contrôleur gérant la génération d'un Sitemap
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerSitemap extends Controller
{
  private $item;
  private $card;

  public function __construct()
  {
      $this->item      = new Item();
      $this->card      = new Card();
  }

  public function index()
  {
      $items                 = $this->item->getAllItems();
      $cards                 = $this->card->getAllCards();
      $this->generateView(array(
          'items' => $items,
          'cards' => $cards
      ));
  }


}
