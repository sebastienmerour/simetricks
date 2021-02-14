<?php
require_once 'Framework/Controller.php';
require_once 'Model/Page.php';
require_once 'Model/Category.php';
require_once 'Model/User.php';
require_once 'Model/Calculate.php';
require_once 'Model/Message.php';

/**
 * Contrôleur gérant les Items de type Pages
 *
 * @version 1.0
 * @author Sébastien Merour
 */

 class ControllerPagesadmin extends Controller
 {
     private $user;
     private $page;
     private $category;
     private $calculate;
     private $message;

     public function __construct()
     {
         $this->user      = new User();
         $this->page      = new Page();
         $this->category  = new Category();
         $this->calculate = new Calculate();
         $this->message = new Message();
     }

     // CREATE

     // Affichage du formulaire de création d'une Page :
     public function pageaddpage()
     {
         $this->generateadminView(array(
         ));
     }

     // Processus de création d'une Page :
     public function createpage()
     {
         if (isset($_POST["create"])) {
             $errors                = array();
             $messages              = array();
             $draft                 = "yes";
             $id_user               = $_SESSION['id_user_admin'];
             $title                 = $_POST['title'];
             $content               = $_POST['content'];
             $delimiter             = '-';
             $slug                  = $this->slugify($title, $delimiter);

             if(isset($_POST['draft'])){
                 $draft = "no";
             }

             if (empty($title) || empty($content)) {
                 $errors['errors'] = 'Veuillez remplir les champs <strong>Titre et Contenu</strong>';
                 if (!empty($errors)) {
                     $_SESSION['errors'] = $errors;
                     header('Location: ' . BASE_ADMIN_URL . 'pagesadmin/pageaddpage');
                     exit;
                 }
             }
             else {
                 $this->page->insertPage($id_user, $title, $slug, $content, $draft);
                 $this->message->pageCreated();
             }
         }
     }

     // READ

     // Affichage de la page Pages en Admnin :
     public function index()
     {
         $number_of_pages = $this->calculate->getTotalOfPagesAdmin();
         if (null != $this->request->ifParameter("id")) {
             $pages_current_page = $this->request->getParameter("id");
         } else {
             $pages_current_page = 1;
         }
         $pages                 = $this->page->getPagesAdmin($pages_current_page);
         $page_previous_pages   = $pages_current_page - 1;
         $page_next_pages       = $pages_current_page + 1;
         $number_of_pages_pages = $this->calculate->getNumberOfPagesOfPagesAdmin();
         $this->generateadminView(array(
             'pages' => $pages,
             'number_of_pages' => $number_of_pages,
             'pages_current_page' => $pages_current_page,
             'page_previous_pages' => $page_previous_pages,
             'page_next_pages' => $page_next_pages,
             'number_of_pages_pages' => $number_of_pages_pages
         ));
     }

     // Affichage d'une seule Page :
     public function pageread()
     {
         $id_page     = $this->request->getParameter("id");
         $page       = $this->page->getPage($id_page);
         $this->generateadminView(array(
             'page' => $page
         ));
     }

     // UPDATE

     // Modification d'une Page :
     public function updatepage()
     {
          if(isset($_POST['draft'])){
           $draft = "no";
           $id_page               = $this->request->getParameter("id");
           $title                 = $this->request->getParameter("title");
           $slug                  = $_POST['slug'];
           $content               = $this->request->getParameter("content");
           $delimiter             = '-';
           $slug                  = $this->slugify($title, $delimiter);
           $this->page->changePage($title, $slug, $content, $draft, $id_page);
           $this->message->pageUpdated();
          }
          else {
             $id_page               = $this->request->getParameter("id");
             $draft                 = "yes";
             $title                 = $this->request->getParameter("title");
             $slug                  = $_POST['slug'];
             $content               = $this->request->getParameter("content");
             $delimiter             = '-';
             $slug                  = $this->slugify($title, $delimiter);
             $this->page->changePage($title, $slug, $content, $draft, $id_page);
             $this->message->pageUpdated();
         }
     }


     // DELETE

     // Affichage de la Corbeille :
     public function pagesbin()
     {
         $number_of_pages_deleted = $this->calculate->getTotalOfPagesDeleted();
         if (null != $this->request->ifParameter("id")) {
             $pages_deleted_current_page = $this->request->getParameter("id");
         } else {
             $pages_deleted_current_page = 1;
         }
         $pages_deleted                 = $this->page->getPagesDeleted($pages_deleted_current_page);
         $page_previous_pages_deleted   = $pages_deleted_current_page - 1;
         $page_next_pages_deleted       = $pages_deleted_current_page + 1;
         $number_of_pages_deleted_pages = $this->calculate->getNumberOfPagesOfPagesDeleted();
         $this->generateadminView(array(
             'pages_deleted' => $pages_deleted,
             'number_of_pages_deleted' => $number_of_pages_deleted,
             'pages_deleted_current_page' => $pages_deleted_current_page,
             'page_previous_pages_deleted' => $page_previous_pages_deleted,
             'page_next_pages_deleted' => $page_next_pages_deleted,
             'number_of_pages_deleted_pages' => $number_of_pages_deleted_pages
         ));
     }

     // Déplacer une page vers la Corbeille :
     public function movepagetobin()
     {
         $id_page = $this->request->getParameter("id");
         $this->page->movePage($id_page);
         $this->message->pageMovedToBin();
     }

     // Suppression définitive d'une Page :
     public function removepage()
     {
         $id_page = $this->request->getParameter("id");
         $this->page->erasePage($id_page);
         $this->message->pageErased();
       }

       // Vider la Corbeille Pages :
       public function emptypages()
       {
           $this->page->emptybin();
           $this->message->pageEmptyBin();
       }

       // Restaurer une page depuis la Corbeille :
       public function restorethispage()
       {
           $id_page = $this->request->getParameter("id");
           $this->page->restorePage($id_page);
           $this->message->pageRestored();
       }

       public function slugify($title, $delimiter) {
       	$oldLocale = setlocale(LC_ALL, '0');
       	setlocale(LC_ALL, 'en_US.UTF-8');
       	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $title);
        $clean = str_replace('\'', ' ', $clean);
       	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
       	$clean = strtolower($clean);
       	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
       	$clean = trim($clean, $delimiter);
       	setlocale(LC_ALL, $oldLocale);
       	return $clean;
       }



}
