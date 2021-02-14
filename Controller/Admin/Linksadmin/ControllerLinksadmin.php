<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Link.php';
require_once 'Model/Calculate.php';
require_once 'Model/Message.php';

/**
 * Contrôleur gérant les Liens depuis l'administration du site
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerLinksadmin extends Controller
{
    private $item;
    private $link;
    private $calculate;
    private $message;

    public function __construct()
    {
        $this->item      = new Item();
        $this->link      = new Link();
        $this->calculate = new Calculate();
        $this->message   = new Message();
    }


    // CREATE

    // Affichage du formulaire de création d'une lien :
    public function linkadd()
    {
        $this->generateadminView();
    }

    // Processus de création d'un lien :
    public function createlink()
    {
        if (isset($_POST["create"])) {
            $id_item     = $_POST['id_item'];
            $name        = $_POST['name'];
            $url         = $_POST['url'];
            $description = $_POST['description'];
            if (empty($id_item) || empty($name) || empty($url)) {
                $errors['errors'] = 'Veuillez remplir tous les champs !';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . BASE_ADMIN_URL . 'linksadmin/linkadd');
                    exit;
                }
            }
              else {
            $this->link->insertLink($id_item, $name, $url, $description);
            $this->message->linkCreated();
          }
        }
    }


    // READ

    // Affichage de la page Liens :
    public function index()
    {
        $number_of_links = $this->calculate->getTotalOfLinks();
        $links           = $this->link->getLinksAdmin();
        $this->generateadminView(array(
            'links' => $links,
            'number_of_links' => $number_of_links
        ));
    }

    // Affichage d'un lien seul :
    public function linkread()
    {
        $id_link = $this->request->getParameter("id");
        $link    = $this->link->getLinkAdmin($id_link);
        $this->generateadminView(array(
            'link' => $link
        ));
    }


    // UPDATE

    // Modification d'un lien :
    public function updatelink()
    {
        if (isset($_POST["update"])) {
            $id_link     = $this->request->getParameter("id");
            $id_item     = $this->request->getParameter("id_item");
            $name        = $this->request->getParameter("name");
            $url         = $this->request->getParameter("url");
            $description = $this->request->getParameter("description");
            $this->link->changeLink($id_link, $id_item, $name, $url, $description);
            $this->message->linkUpdated($id_link);
        }
    }

    // DELETE

    // Affichage de la Corbeille Liens :
    public function linksbin()
    {
        $number_of_links_deleted = $this->calculate->getTotalOfLinksDeleted();
        $links_deleted           = $this->link->getLinksDeleted();
        $this->generateadminView(array(
            'links_deleted' => $links_deleted,
            'number_of_links_deleted' => $number_of_links_deleted
        ));
    }

    // Déplacer un lien vers la Corbeille :
    public function movelinktobin()
    {
        $id_link = $this->request->getParameter("id");
        $this->link->moveLink($id_link);
        $this->message->linkMovedToBin();
    }

    // Suppression définitive d'un Lien :
    public function removelink()
    {
        $id_link = $this->request->getParameter("id");
        $this->link->eraseLink($id_link);
        $this->message->linkErased();
    }

    // Vider la Corbeille Liens :
    public function emptylinks()
    {
        $this->link->emptybin();
        $this->message->linkEmptyBin();
    }

    // Restaurer un lien depuis la Corbeille :
    public function restorethislink()
    {
        $id_link = $this->request->getParameter("id");
        $this->link->restoreLink($id_link);
        $this->message->linkRestored();
    }


}
