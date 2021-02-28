<?php
require_once 'Framework/Controller.php';
require_once 'Model/User.php';
require_once 'Model/Calculate.php';
require_once 'Model/Message.php';

/**
 * Contrôleur gérant les Utilisateurs depuis l'administration du site
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerUsers extends Controller
{
    private $user;
    private $calculate;
    private $message;

    public function __construct()
    {
        $this->user      = new User();
        $this->calculate = new Calculate();
        $this->message   = new Message();
    }


    // READ

    // Affichage de la liste des utilisateurs en Admin :
    public function index()
    {
        if (null != $this->request->ifParameter("id")) {
            $users_current_page = $this->request->getParameter("id");
        } else {
            $users_current_page = 1;
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

    // Modification d'un user :
    public function updateuser()
    {
        $id_user = $this->request->getParameter("id");      
        if (isset($_POST["update"]) && !empty($_POST["firstname"]) && !empty($_POST["name"])) {
            $errors                = array();
            $messages              = array();
            $status                = $this->request->getParameter("status");
            $firstname             = $_POST["firstname"];
            $name                  = $_POST["name"];
            $email                 = $this->request->getParameter("email");
            $city                  = $_POST["city"];
            $linkedin              = $_POST["linkedin"];
            $github                = $_POST["github"];
            $twitter               = $_POST["twitter"];
            $website               = $_POST["website"];
            $date_birth            = $_POST["date_birth"];
            $extensions_authorized = array(
                "gif",
                "png",
                "jpg",
                "jpeg"
            );
            $extension_upload      = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
            if (!in_array($extension_upload, $extensions_authorized)) {
                $errors['errors'] = 'L\'extension du fichier n\'est pas autorisée.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . BASE_ADMIN_URL . 'users/userread/' . $id_user);
                    exit;
                }
            }
            if (!empty($_FILES['avatar']['tmp_name']) && file_exists($_FILES['avatar']['tmp_name'])) {
                $fileinfo    = @getimagesize($_FILES["avatar"]["tmp_name"]);
                $width       = $fileinfo[0];
                $height      = $fileinfo[1];
                $time        = date("Y-m-d-H-i-s");
                $avatarname  = str_replace(' ', '-', strtolower($_FILES['avatar']['name']));
                $avatarname  = preg_replace("/\.[^.\s]{3,4}$/", "", $avatarname);
                $avatarname  = "{$time}-{$id_user}-avatar.{$extension_upload}";
                $destination = ROOT_PATH . 'public/images/avatars';
                if (($_FILES["avatar"]["size"] > 1000000)) {
                    $errors['errors'] = 'Le fichier est trop lourd.';
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header('Location: ' . BASE_ADMIN_URL . 'users/userread/' . $id_user);
                        exit;
                    }
                } else if ($width < "800" && $height < "600") {
                    $errors['errors'] = 'Les dimensions sont trop petites. <br>Minimum : 800 X 600 px';
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header('Location: ' . BASE_ADMIN_URL . 'users/userread/' . $id_user);
                        exit;
                    }
                } else {
                    move_uploaded_file($_FILES['avatar']['tmp_name'], $destination . "/" . $avatarname);
                    $this->user->changeUserImageFromAdmin($id_user, $status, $firstname, $name, $avatarname, $email, $city, $linkedin, $github, $twitter, $website, $date_birth);
                    $this->message->userAccountUpdated($id_user);
                }
            } else {
                $this->user->changeUserFromAdmin($id_user, $status, $firstname, $name, $email, $city, $linkedin, $github, $twitter, $website, $date_birth);
                $this->message->userAccountUpdated($id_user);
            }
        } else {
            $errors['errors'] = 'Merci de renseigner les champs <strong>Prénom et Nom</strong> !';
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: ' . BASE_ADMIN_URL . 'users/userread/' . $id_user);
                exit;
            }
        }
    }

    // DELETE

    // Affichage de la Corbeille des utilisateurs :
    public function usersbin()
    {
        if (null != $this->request->ifParameter("id")) {
            $users_deleted_current_page = $this->request->getParameter("id");
        } else {
            $users_deleted_current_page = 1;
        }
        $users_deleted_previous_page   = $users_deleted_current_page - 1;
        $users_deleted_next_page       = $users_deleted_current_page + 1;
        $users_deleted                 = $this->user->selectUsersDeleted($users_deleted_current_page);
        $default                       = "default.png";
        $number_of_users_deleted_pages = $this->calculate->getNumberOfUsersDeletedPagesFromAdmin();
        $counter_users_deleted         = $this->calculate->getTotalOfUsersDeleted();
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
        $this->message->userMovedToBin();
    }

    // Vider la Corbeille Utilisateurs
    public function emptyusers()
    {
        $this->user->emptyusersbin();
        $this->message->userEmptyBin();
    }

    // Suppression d'un user définitivement :
    public function removeuser()
    {
        $id_user = $this->request->getParameter("id");
        $this->user->eraseUser($id_user);
        $this->message->userErased();
    }

    // Restaurer un user depuis la Corbeille :
    public function restorethisuser()
    {
        $id_user = $this->request->getParameter("id");
        $this->user->restoreUser($id_user);
        $this->message->userRestored();
    }

}
