<?php
require_once 'Framework/Controller.php';
require_once 'Model/Item.php';
require_once 'Model/Comment.php';
require_once 'Model/User.php';
require_once 'Model/Calculate.php';

/**
 * Contrôleur gérant la page d'accueil de l'administration du site
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerAdmintricks extends Controller
{
    private $user;
    private $item;
    private $comment;
    private $calculate;

    public function __construct()
    {
        $this->user    = new User();
        $this->item    = new Item();
        $this->comment = new Comment();
        $this->calculate = new Calculate();
    }

    // CREATE
    // ITEMS

    // Affichage du formulaire de création d'un article :
    public function extendedcardadditem()
    {
        $this->generateadminView();
    }

    // Processus de création d'un article :
    public function createitem()
    {
        if (isset($_POST["modify"])) {
            $errors                = array();
            $messages              = array();
            $id_user               = $_SESSION['id_user_admin'];
            $title                 = $_POST['title'];
            $date_native           = $_POST['date_native'];
            $licence               = $_POST['licence'];
            $langage               = $_POST['langage'];
            $links                 = $_POST['links'];
            $content               = $_POST['content'];
            $fileinfo              = @getimagesize($_FILES["image"]["tmp_name"]);
            $width                 = $fileinfo[0];
            $height                = $fileinfo[1];
            $extensions_authorized = array(
                "gif",
                "png",
                "jpg",
                "jpeg"
            );
            $extension_upload      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $time                  = date("Y-m-d-H-i-s") . "-";
            $newtitle              = str_replace(' ', '-', strtolower($title));
            $itemimagename         = str_replace(' ', '-', strtolower($_FILES['image']['name']));
            $itemimagename         = preg_replace("/\.[^.\s]{3,4}$/", "", $itemimagename);
            $itemimagename         = "{$time}$newtitle.{$extension_upload}";
            $destination           = ROOT_PATH . 'public/images/item_images';

            if (empty($title) || empty($content)) {
                $errors['errors'] = 'Veuillez remplir tous les champs';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: extendedcardadditem');
                    exit;
                }
            }

            else if (!file_exists($_FILES["image"]["tmp_name"])) {
                $this->item->insertItem($id_user, $title, $date_native, $licence, $langage, $links, $content);
            }

            else if (!in_array($extension_upload, $extensions_authorized)) {
                $errors['errors'] = 'L\'extension du fichier n\'est pas autorisée.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: extendedcardadditem');
                    exit;
                }
            } else if (($_FILES["image"]["size"] > 1000000)) {
                $errors['errors'] = 'Le fichier est trop lourd.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: extendedcardadditem');
                    exit;
                }
            } else if ($width < "300" || $height < "200") {
                $errors['errors'] = 'Le fichier n\'a pas les bonnes dimensions';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: extendedcardadditem');
                    exit;
                }
            }

            else {
                move_uploaded_file($_FILES['image']['tmp_name'], $destination . "/" . $itemimagename);
                $this->item->insertItemImage($id_user, $title, $itemimagename, $date_native, $licence, $langage, $links, $content);

            }
        }
    }

    // READ
    // ITEMS

    // Affichage de la page de connexion :
    public function index()
    {
        $this->generateadminView();
    }

    // Affichage de la page d'accueil après connexion :
    public function dashboard()
    {
        $default                  = "default.png";
        $items_current_page     = 1;
        $comments_current_page  = 1;
        $users_current_page  = 1;
        $items                 = $this->item->getItems($items_current_page);
        $comments                 = $this->comment->selectComments($comments_current_page);
        $users                 = $this->user->selectUsers($users_current_page);
        $this->generateadminView(array(
            'default' => $default,
            'items' => $items,
            'comments' => $comments,
            'users' => $users
        ));
    }

    // Affichage de la page Extended Cards :
    public function extendedcards()
    {
        $number_of_items       = $this->calculate->getTotalOfItems();
        if (null!= $this->request->ifParameter("id"))  {
          $items_current_page  = $this->request->getParameter("id");
          }
          else {
            $items_current_page = 1;
          }
        $items                 = $this->item->getItems($items_current_page);
        $page_previous_items   = $items_current_page - 1;
        $page_next_items       = $items_current_page + 1;
        $number_of_items_pages = $this->calculate->getNumberOfPages();
        $this->generateadminView(array(
            'items' => $items,
            'number_of_items' => $number_of_items,
            'items_current_page' => $items_current_page,
            'page_previous_items' => $page_previous_items,
            'page_next_items' => $page_next_items,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }

    // Affichage d'un article seul :
    public function readitem()
    {

        $id_item = $this->request->getParameter("id");
        $item    = $this->item->getItem($id_item);
        $this->generateadminView(array(
            'item' => $item
        ));
    }

    // UPDATE
    // ITEMS

    // Modification d'un article :
    public function updateitem()
    {
        if (isset($_POST["modify"])) {
            $errors                = array();
            $messages              = array();
            $id_item               = $this->request->getParameter("id");
            $title                 = $this->request->getParameter("title");
            $date_native  = $this->request->getParameter("date_native");
            $licence  = $this->request->getParameter("licence");
            $langage  = $this->request->getParameter("langage");
            $links  = $this->request->getParameter("links");
            $content               = $this->request->getParameter("content");
            $fileinfo              = @getimagesize($_FILES["image"]["tmp_name"]);
            $width                 = $fileinfo[0];
            $height                = $fileinfo[1];
            $extensions_authorized = array(
                "gif",
                "png",
                "jpg",
                "jpeg"
            );
            $extension_upload      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $time                  = date("Y-m-d-H-i-s") . "-";
            $newtitle              = str_replace(' ', '-', strtolower($title));
            $itemimagename         = str_replace(' ', '-', strtolower($_FILES['image']['name']));
            $itemimagename         = preg_replace("/\.[^.\s]{3,4}$/", "", $itemimagename);
            $itemimagename         = "{$time}$newtitle.{$extension_upload}";
            $destination           = ROOT_PATH . 'public/images/item_images';

            if (!file_exists($_FILES["image"]["tmp_name"])) {
                $messages = array();
                $id_item  = $this->request->getParameter("id");
                $title    = $this->request->getParameter("title");
                $date_native  = $this->request->getParameter("date_native");
                $licence  = $this->request->getParameter("licence");
                $langage  = $this->request->getParameter("langage");
                $links  = $this->request->getParameter("links");
                $content  = $this->request->getParameter("content");
                $this->item->changeItem($title, $date_native, $licence, $langage, $links, $content, $id_item);
            } else if (!in_array($extension_upload, $extensions_authorized)) {
                $errors['errors'] = 'L\'extension du fichier n\'est pas autorisée.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ../readitem/' . $id_item);
                    exit;
                }
            } else if (($_FILES["image"]["size"] > 1000000)) {
                $errors['errors'] = 'Le fichier est trop lourd.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ../readitem/' . $id_item);
                    exit;
                }
            } else if ($width < "300" || $height < "200") {
                $errors['errors'] = 'Le fichier n\'a pas les bonnes dimensions';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ../readitem/' . $id_item);
                    exit;
                }
            } else {
                move_uploaded_file($_FILES['image']['tmp_name'], $destination . "/" . $itemimagename);
                $this->item->changeItemImage($title, $itemimagename, $date_native, $licence, $langage, $links, $content, $id_item);
            }
        }
    }

    // Restaurer un item depuis la Corbeille :
    public function restorethisitem()
    {
        $id_item = $this->request->getParameter("id");
        $this->item->restoreItem($id_item);
    }


    // DELETE
    // ITEMS

    // Affichage de la Corbeille :
    public function extendedcardsbin()
    {
      $number_of_items_deleted       = $this->calculate->getTotalOfItemsDeleted();
      if (null!= $this->request->ifParameter("id"))  {
        $items_deleted_current_page  = $this->request->getParameter("id");
        }
        else {
          $items_deleted_current_page = 1;
        }
      $items_deleted                 = $this->item->getItemsDeleted($items_deleted_current_page);
      $page_previous_items_deleted   = $items_deleted_current_page - 1;
      $page_next_items_deleted       = $items_deleted_current_page + 1;
      $number_of_items_deleted_pages = $this->calculate->getNumberOfPagesDeleted();
      $this->generateadminView(array(
          'items_deleted' => $items_deleted,
          'number_of_items_deleted' => $number_of_items_deleted,
          'items_deleted_current_page' => $items_deleted_current_page,
          'page_previous_items_deleted' => $page_previous_items_deleted,
          'page_next_items_deleted' => $page_next_items_deleted,
          'number_of_items_deleted_pages' => $number_of_items_deleted_pages
      ));
    }


    // Déplacer un item vers la Corbeille :
    public function moveitemtobin()
    {
        $id_item = $this->request->getParameter("id");
        $this->item->moveItem($id_item);
    }

    // Suppression définitive d'un article :
    public function removeitem()
    {
        $id_item = $this->request->getParameter("id");
        $this->item->eraseItem($id_item);
        if ($id_item === false) {
            throw new Exception('Impossible de supprimer l\' article !');
        } else {
            $messages['confirmation'] = 'L\'article a bien été supprimé !';
            $this->generateadminView();
        }
    }

    // Vider la Corbeille Extended Cards :
    public function empty()
    {
        $this->item->emptybin();
    }


    // READ
    // COMMENTS

    // Affichage des commentaires à modérer :
    public function tomoderate()
    {
      if (null!= $this->request->ifParameter("id"))  {
        $comments_reported_current_page  = $this->request->getParameter("id");
        }
        else {
          $comments_reported_current_page = 1;
        }
        $comments_reported_previous_page   = $comments_reported_current_page - 1;
        $comments_reported_next_page       = $comments_reported_current_page + 1;
        $comments_reported                 = $this->comment->selectCommentsReported($comments_reported_current_page);
        $default                           = "default.png";
        $number_of_comments_reported_pages = $this->calculate->getNumberOfCommentsReportedPagesFromAdmin();
        $counter_comments_reported         = $this->calculate->getTotalOfCommentsReported();
        $this->generateadminView(array(
            'comments_reported' => $comments_reported,
            'default' => $default,
            'comments_reported_current_page' => $comments_reported_current_page,
            'comments_reported_previous_page' => $comments_reported_previous_page,
            'comments_reported_next_page' => $comments_reported_next_page,
            'number_of_comments_reported_pages' => $number_of_comments_reported_pages,
            'counter_comments_reported' => $counter_comments_reported
        ));
    }

    // Affichage de l'ensemble des commentaires :
    public function allcomments()
    {
        if (null!= $this->request->ifParameter("id"))  {
        $comments_current_page    = $this->request->getParameter("id");
        }
        else {
          $comments_current_page  = 1;
        }
        $comments_previous_page   = $comments_current_page - 1;
        $comments_next_page       = $comments_current_page + 1;
        $comments                 = $this->comment->selectComments($comments_current_page);
        $default                  = "default.png";
        $number_of_comments_pages = $this->calculate->getNumberOfCommentsPagesFromAdmin();
        $counter_comments         = $this->calculate->getTotalOfComments();
        $this->generateadminView(array(
            'comments' => $comments,
            'default' => $default,
            'comments_current_page' => $comments_current_page,
            'comments_previous_page' => $comments_previous_page,
            'comments_next_page' => $comments_next_page,
            'number_of_comments_pages' => $number_of_comments_pages,
            'counter_comments' => $counter_comments
        ));
    }

    // Affichage d'un commentaire
    public function commentread()
    {
        $id_comment = $this->request->getParameter("id");
        $comment    = $this->comment->getComment($id_comment);
        $default    = "default.png";
        $this->generateadminView(array(
            'comment' => $comment,
            'default' => $default
        ));
    }

    // Affichage d'un commentaire signalé :
    public function commentreportedread()
    {
        $id_comment = $this->request->getParameter("id");
        $comment    = $this->comment->getComment($id_comment);
        $default    = "default.png";
        $this->generateadminView(array(
            'comment' => $comment,
            'default' => $default
        ));
    }



    // UPDATE
    // COMMENTS

    // Modification d'un commentaire :
    public function updatecomment()
    {
        $id_comment = $this->request->getParameter("id");
        $comment    = $this->comment->getComment($id_comment);
        $content    = $comment['content'];
        $this->comment->changeCommentAdmin($content);
    }

    // Modification d'un commentaire :
    public function updatecommentreported()
    {
        $id_comment = $this->request->getParameter("id");
        $comment    = $this->comment->getComment($id_comment);
        $content    = $comment['content'];
        $this->comment->changeCommentReportedAdmin($content);
    }

    // Approuver un commentaire signalé :
    public function approve()
    {
        $id_comment = $this->request->getParameter("id");
        $this->comment->approveComment($id_comment);
    }

    // Restaurer un commentaire depuis la Corbeille :
    public function restorethiscomment()
    {
        $id_comment = $this->request->getParameter("id");
        $this->comment->restoreComment($id_comment);
    }


    // DELETE
    // COMMENTS

    // Affichage de la Corbeille des commentaires :
    public function allcommentsbin()
    {
        if (null!= $this->request->ifParameter("id"))  {
        $comments_deleted_current_page    = $this->request->getParameter("id");
        }
        else {
          $comments_deleted_current_page  = 1;
        }
        $comments_deleted_previous_page   = $comments_deleted_current_page - 1;
        $comments_deleted_next_page       = $comments_deleted_current_page + 1;
        $comments_deleted                 = $this->comment->selectCommentsDeleted($comments_deleted_current_page);
        $default                          = "default.png";
        $number_of_comments_deleted_pages = $this->calculate->getNumberOfCommentsDeletedPagesFromAdmin();
        $counter_comments_deleted        = $this->calculate->getTotalOfCommentsDeleted();
        $this->generateadminView(array(
            'comments_deleted' => $comments_deleted,
            'default' => $default,
            'comments_deleted_current_page' => $comments_deleted_current_page,
            'comments_deleted_previous_page' => $comments_deleted_previous_page,
            'comments_deleted_next_page' => $comments_deleted_next_page,
            'number_of_comments_deleted_pages' => $number_of_comments_deleted_pages,
            'counter_comments_deleted' => $counter_comments_deleted
        ));
    }

    // Déplacer un commentaire vers la Corbeille :
    public function movecommenttobin()
    {
        $id_comment = $this->request->getParameter("id");
        $this->comment->moveComment($id_comment);
    }

    // Vider la Corbeille Commentaires
    public function emptycomments()
    {
        $this->comment->emptycommentsbin();
    }

    // Suppression d'un commentaire définitivement :
    public function removecomment()
    {
        $id_comment = $this->request->getParameter("id");
        $this->comment->eraseComment($id_comment);
        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! Le commentaire a bien été supprimé définitivement!';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../allcomments');
            exit;
        }
    }

    // Suppression d'un commentaire signalé :
    public function removecommentreported()
    {
        $id_comment = $this->request->getParameter("id");
        $this->comment->eraseComment($id_comment);
        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! Le commentaire a bien été supprimé !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../tomoderate');
            exit;
        }
    }

    // READ
    // USERS

    // Affichage de la liste des utilisateurs en Admin :
    public function users()
    {
      if (null!= $this->request->ifParameter("id"))  {
        $users_current_page    = $this->request->getParameter("id");
        }
        else {
          $users_current_page  = 1;
        }
        $users_previous_page   = $users_current_page - 1;
        $users_next_page       = $users_current_page + 1;
        $users                 = $this->user->selectUsers($users_current_page);
        $default               = "default.png";
        $number_of_users_pages = $this->calculate->getNumberOfUsersPagesFromAdmin();
        $counter_users         = $this->calculate->getTotalOfUSers();
        $this->generateadminView(array(
            'users' => $users,
            'default' => $default,
            'users_current_page' => $users_current_page,
            'users_previous_page' => $users_previous_page,
            'users_next_page' => $users_next_page,
            'number_of_users_pages' => $number_of_users_pages,
            'counter_users' => $counter_users
        ));
    }

    // Affichage du compte Admin :
    public function useraccount()
    {
        $id_user = $_SESSION['id_user_admin'];
        $user    = $this->user->getUser($id_user);
        $this->generateadminView(array(
            'user' => $user
        ));
    }



    // Affichage d'un user seul :
    public function userread()
    {

        $id_user = $this->request->getParameter("id");
        $user    = $this->user->getUser($id_user);
        $this->generateadminView(array(
            'user' => $user
        ));
    }


    // UPDATE
    // USERS

    // Modification d'un user :
    public function updateuser()
    {
        $id_user               = $this->request->getParameter("id");

        if (isset($_POST["modify"]) && !empty($_POST["firstname"]) && !empty($_POST["name"])) {
            $errors                = array();
            $messages              = array();
            $status                = $this->request->getParameter("status");
            $firstname             = $this->request->getParameter("firstname");
            $name                  = $this->request->getParameter("name");
            $email                 = $this->request->getParameter("email");
            $date_birth            = $this->request->getParameter("date_birth");
            $fileinfo              = @getimagesize($_FILES["avatar"]["tmp_name"]);
            $width                 = $fileinfo[0];
            $height                = $fileinfo[1];
            $extensions_authorized = array(
                "gif",
                "png",
                "jpg",
                "jpeg"
            );
            $extension_upload      = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
            $time                  = date("Y-m-d-H-i-s");
            $avatarname            = str_replace(' ', '-', strtolower($_FILES['avatar']['name']));
            $avatarname            = preg_replace("/\.[^.\s]{3,4}$/", "", $avatarname);
            $avatarname            = "{$time}-{$id_user}-avatar.{$extension_upload}";
            $destination           = ROOT_PATH . 'public/images/avatars';

            if (!file_exists($_FILES["avatar"]["tmp_name"])) {
                $this->user->changeUserFromAdmin($id_user, $status, $firstname, $name, $email, $date_birth);
            } else if (!in_array($extension_upload, $extensions_authorized)) {
                $errors['errors'] = 'L\'extension du fichier n\'est pas autorisée.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ../userread/' . $id_user);
                    exit;
                }
            } else if (($_FILES["avatar"]["size"] > 1000000)) {
                $errors['errors'] = 'Le fichier est trop lourd.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ../userread/' . $id_user);
                    exit;
                }
            } else if ($width < "300" || $height < "200") {
                $errors['errors'] = 'Le fichier n\'a pas les bonnes dimensions';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ../userread/' . $id_user);
                    exit;
                }
            } else {
                move_uploaded_file($_FILES['avatar']['tmp_name'], $destination . "/" . $avatarname);
                $this->user->changeUserImageFromAdmin($id_user, $status, $firstname, $name, $avatarname, $email, $date_birth);
            }
        }
        else {
          $errors['errors'] = 'Merci de renseigner tous les champs !';
          if (!empty($errors)) {
              $_SESSION['errors'] = $errors;
              header('Location: ../userread/' . $id_user);
              exit;
          }

        }
    }

    // Restaurer un user depuis la Corbeille :
    public function restorethisuser()
    {
        $id_user = $this->request->getParameter("id");
        $this->user->restoreUser($id_user);
    }


    // DELETE
    // USERS

    // Affichage de la Corbeille des utilisateurs :
    public function usersbin()
    {
        if (null!= $this->request->ifParameter("id"))  {
        $users_deleted_current_page    = $this->request->getParameter("id");
        }
        else {
          $users_deleted_current_page  = 1;
        }
        $users_deleted_previous_page   = $users_deleted_current_page - 1;
        $users_deleted_next_page       = $users_deleted_current_page + 1;
        $users_deleted                 = $this->user->selectUsersDeleted($users_deleted_current_page);
        $default                          = "default.png";
        $number_of_users_deleted_pages = $this->calculate->getNumberOfUsersDeletedPagesFromAdmin();
        $counter_users_deleted        = $this->calculate->getTotalOfUsersDeleted();
        $this->generateadminView(array(
            'users_deleted' => $users_deleted,
            'default' => $default,
            'users_deleted_current_page' => $users_deleted_current_page,
            'users_deleted_previous_page' => $users_deleted_previous_page,
            'users_deleted_next_page' => $users_deleted_next_page,
            'number_of_users_deleted_pages' => $number_of_users_deleted_pages,
            'counter_users_deleted' => $counter_users_deleted
        ));
    }

    // Déplacer un user vers la Corbeille :
    public function moveusertobin()
    {
        $id_user = $this->request->getParameter("id");
        $this->user->moveUser($id_user);
    }

    // Vider la Corbeille Utilisateurs
    public function emptyusers()
    {
        $this->user->emptyusersbin();
    }

    // Suppression d'un user définitivement :
    public function removeuser()
    {
        $id_user = $this->request->getParameter("id");
        $this->user->eraseUser($id_user);
        if ($id_user === false) {
            throw new Exception('Impossible de supprimer l\'Utilisateur !');
        } else {
            $messages['confirmation'] = 'L\'utilisateur bien été supprimé définitivement!';
            $this->generateadminView();
        }
    }


}
