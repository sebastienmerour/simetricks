<?php
require_once 'Framework/Controller.php';
require_once 'Model/User.php';
require_once 'Model/Cgu.php';
require_once 'Model/Item.php';
require_once 'Model/Calculate.php';
require_once 'PHPMailer/PHPMailerAutoload.php';

/**
 * Contrôleur des actions liées aux utilisateurs
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerUser extends Controller
{
    private $user;
    private $cgu;
    private $item;
    private $calculate;
    private $mail;

    public function __construct()
    {
        $this->user      = new User();
        $this->cgu       = new Cgu();
        $this->item      = new Item();
        $this->calculate = new Calculate();
        $this->mail      = new PHPMailer();

    }

    // CREATE

    // Affichage du formulaire d'inscription :
    public function useradd()
    {
        $number_of_items       = $this->calculate->getTotalOfItems();
        $total_comments_count  = $this->calculate->getTotalOfComments();
        $total_users_count     = $this->calculate->getTotalOfUsers();
        $number_of_items_pages = $this->calculate->getNumberOfPages();
        $this->generateView(array(
            'number_of_items' => $number_of_items,
            'total_comments_count' => $total_comments_count,
            'total_users_count' => $total_users_count,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }

    // Création du user :
    public function createuser()
    {
        if (!empty($_POST['username']) && !empty($_POST['pass']) && !empty($_POST['email']) && !empty($_POST['cgu'])) {

            if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
                $secretKey      = RECAPTCHA_SECRET_KEY;
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
                $responseData   = json_decode($verifyResponse);
                $username       = $this->request->getParameter("username");
                $pass           = $this->request->getParameter("pass");
                $email          = $this->request->getParameter("email");

                if ($responseData->success) {
                    $this->user->checkUser($username, $pass, $email);
                    ob_start();
                    include 'View/themes/front/template_newuser.php';
                    $body = ob_get_contents();
                    ob_end_clean();
                    $subject             = "Bienvenue sur " . WEBSITE_NAME;
                    $email_to            = $email;
                    $fromserver          = WEBMASTER_EMAIL;
                    $this->mail->CharSet = 'UTF-8';
                    $this->mail->IsSMTP();
                    $this->mail->Host     = SMTP_HOST;
                    $this->mail->SMTPAuth = true;
                    $this->mail->Username = SMTP_USERNAME;
                    $this->mail->Password = SMTP_PASSWORD;
                    $this->mail->Port     = SMTP_PORT;
                    $this->mail->IsHTML(true);
                    $this->mail->From     = WEBMASTER_EMAIL;
                    $this->mail->FromName = WEBSITE_NAME;
                    $this->mail->Sender   = $fromserver; // indicates ReturnPath header
                    $this->mail->Subject  = $subject;
                    $this->mail->Body     = $body;
                    $this->mail->AddAddress($email_to);
                    if (!$this->mail->Send()) {
                        $errors['errors']   = $this->mail->ErrorInfo;
                        $_SESSION['errors'] = $errors;
                        header('Location: ' . BASE_URL . 'user/useradd');
                        exit;
                    } else {
                        $messages['confirmation'] = 'Votre compte a bien été créé !<br>
                    Un e-mail de confirmation vous a été envoyé.<br>
                    Pour vous identifier, <a href="' . BASE_URL . 'login">cliquez ici</a><br>';
                        $_SESSION['messages']     = $messages;
                        header('Location: ' . BASE_URL . 'user/useradd');
                    }
                } else {
                    $errors['errors'] = 'La vérification a échoué. Merci de re-essayer plus tard.';
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header('Location: ' . BASE_URL . 'user/useradd');
                        exit;
                    }
                }
            } else {
                $errors['errors']   = 'Merci de cocher la case reCAPTCHA.';
                $_SESSION['errors'] = $errors;
                header('Location: ' . BASE_URL . 'user/useradd');
                exit;
            }
        } else {
            $errors['errors']   = 'Merci de renseigner tous les champs';
            $_SESSION['errors'] = $errors;
            header('Location: ' . BASE_URL . 'user/useradd');
            exit;
        }

    }

    // READ

    // Affichage de Mon Compte :
    function index()
    {
        //$user                  = $this->request->getSession()->setAttribut("user", $this->user);
        $user                  = $this->user->getUser($_SESSION['id_user']);
        $number_of_items       = $this->calculate->getTotalOfItems();
        $total_comments_count  = $this->calculate->getTotalOfComments();
        $total_users_count     = $this->calculate->getTotalOfUsers();
        $number_of_items_pages = $this->calculate->getNumberOfPages();
        $this->generateView(array(
            'user' => $user,
            'number_of_items' => $number_of_items,
            'total_comments_count' => $total_comments_count,
            'total_users_count' => $total_users_count,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }

    // Affichage du Profil d'un utilisateur :
    function profile()
    {
        $id_user              = $this->request->getParameter("id");
        $user                 = $this->user->getUser($id_user);
        $number_of_items      = $this->calculate->getTotalOfItems();
        $total_comments_count = $this->calculate->getTotalOfComments();
        $total_users_count    = $this->calculate->getTotalOfUsers();
        $this->generateView(array(
            'user' => $user,
            'number_of_items' => $number_of_items,
            'total_comments_count' => $total_comments_count,
            'total_users_count' => $total_users_count
        ));
    }

    // UPDATE

    // Affichage de la page de modification de user :
    function useredit()
    {
        $number_of_items       = $this->calculate->getTotalOfItems();
        $number_of_items_pages = $this->calculate->getNumberOfPages();
        $user                  = $this->request->getSession()->setAttribut("user", $this->user);
        $user                  = $this->user->getUser($_SESSION['id_user']);
        $this->generateView(array(
            'user' => $user,
            'number_of_items' => $number_of_items,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }

    // Modification d'utilisateur :
    public function updateuser()
    {
        $pass       = $this->request->getParameter("pass");
        $email      = $this->request->getParameter("email");
        $firstname  = $this->request->getParameter("firstname");
        $name       = $this->request->getParameter("name");
        $date_birth = $this->request->getParameter("date_birth");
        $user       = $this->request->getSession()->getAttribut("user");
        $this->user->changeUser($pass, $email, $firstname, $name, $date_birth);
        $user = $this->user->getUser($id_user);
        if ($user === false) {
            throw new Exception('Impossible de modifier l\' utilisateur !');
        } else {
            $this->request->getSession()->setAttribut("user", $user);
            $this->generateView();
        }
    }

    // Modification d'identifiant :
    public function updateusername()
    {
        $username = $this->request->getParameter("username");
        $user     = $this->request->getSession()->getAttribut("user");
        $this->user->checkUsername($username);
        $user = $this->user->getUser($id_user);
        if ($user === false) {
            throw new Exception('Impossible de modifier l\' identifiant !');
        } else {
            $this->request->getSession()->setAttribut("user", $user);
            $this->generateView();
        }
    }

    // Modification de l'avatar :
    public function updateavatar()
    {
        $user = $this->user->getUser($_SESSION['id_user']);

        if (isset($_POST["update"])) {
            $errors                = array();
            $messages              = array();
            $fileinfo              = @getimagesize($_FILES["avatar"]["tmp_name"]);
            $width                 = $fileinfo[0];
            $height                = $fileinfo[1];
            $extension_upload      = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
            $extensions_authorized = array(
                'jpg',
                'jpeg',
                'gif',
                'png'
            );
            $id_user               = $_SESSION['id_user'];
            $time                  = date("Y-m-d-H-i-s");
            $avatarname            = str_replace(' ', '-', strtolower($_FILES['avatar']['name']));
            $avatarname            = preg_replace("/\.[^.\s]{3,4}$/", "", $avatarname);
            $avatarname            = "{$time}-{$id_user}-avatar.{$extension_upload}";
            $destination           = ROOT_PATH . 'public/images/avatars';

            if (!in_array($extension_upload, $extensions_authorized)) {
                $errors['errors'] = 'L\'extension du fichier n\'est pas autorisée.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . BASE_URL . 'user/');
                    exit;
                }
            } else if (($_FILES["avatar"]["size"] > 1000000)) {
                $errors['errors'] = 'Le fichier est trop lourd.';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . BASE_URL . 'user/');
                    exit;
                }
            } else if ($width < "800" && $height < "600") {
                $errors['errors'] = 'Les dimensions sont trop petites. <br>Minimum : 800 X 600 px';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . BASE_URL . 'user/');
                    exit;
                }
            } else {
                move_uploaded_file($_FILES['avatar']['tmp_name'], $destination . "/" . $avatarname);
                $newAvatar = $this->user->changeAvatar($avatarname);
            }
        }
    }

    // Affichage des CGU :
    public function cgu()
    {
        $number_of_items      = $this->calculate->getTotalOfItems();
        $total_comments_count = $this->calculate->getTotalOfComments();
        $total_users_count    = $this->calculate->getTotalOfUsers();
        $text                 = $this->cgu->conditions();
        $this->generateView(array(
            'number_of_items' => $number_of_items,
            'total_comments_count' => $total_comments_count,
            'total_users_count' => $total_users_count,
            'text' => $text
        ));
    }


}