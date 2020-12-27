<?php
require_once 'Framework/Controller.php';
require_once 'Model/Login.php';
require_once 'Model/User.php';
require_once 'Model/Item.php';
require_once 'Model/Calculate.php';
require_once 'PHPMailer/PHPMailerAutoload.php';

/**
 * Contrôleur gérant la connexion au site
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerLogin extends Controller
{
    private $login;
    private $user;
    private $item;
    private $calculate;
    private $mail;

    public function __construct()
    {
        $this->login     = new Login();
        $this->user      = new User();
        $this->item      = new Item();
        $this->calculate = new Calculate();
        $this->mail      = new PHPMailer();
    }

    // Affichage de la page de connexion :
    public function index()
    {
        $number_of_items       = $this->calculate->getTotalOfItemsFront();
        $number_of_cards       = $this->calculate->getTotalOfCards();
        $number_of_links       = $this->calculate->getTotalOfLinks();
        $total_comments_count  = $this->calculate->getTotalOfComments();
        $total_users_count     = $this->calculate->getTotalOfUsers();
        $number_of_items_pages = $this->calculate->getNumberOfPagesOfExtFront();
        $this->generateView(array(
            'number_of_items' => $number_of_items,
            'number_of_cards' => $number_of_cards,
            'number_of_links' => $number_of_links,
            'total_comments_count' => $total_comments_count,
            'total_users_count' => $total_users_count,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }

    // Processus de Connexion d'un user :
    public function login()
    {
        if ($this->request->ifParameter("username") && $this->request->ifParameter("pass")) {
            $username        = $this->request->getParameter("username");
            $passwordAttempt = $this->request->getParameter("pass");
            $this->login->logInUser($username, $passwordAttempt);
        } else
            throw new Exception("Action impossible : identifiant ou mot de passe non défini");
    }

    // Appui sur le bouton Deconnexion d'un user :
    public function logout()
    {
        $number_of_items      = $this->calculate->getTotalOfItemsFront();
        $total_comments_count = $this->calculate->getTotalOfComments();
        $number_of_cards       = $this->calculate->getTotalOfCards();
        $number_of_links       = $this->calculate->getTotalOfLinks();
        $total_users_count    = $this->calculate->getTotalOfUsers();
        if (ISSET($_SESSION['id_user'])) {
            $this->request->getSession()->destroy();
            // Suppression des cookies de connexion automatique
            setcookie('username', '');
            setcookie('pass', '');
            $this->generateView(array(
                'number_of_items' => $number_of_items,
                'number_of_cards' => $number_of_cards,
                'number_of_links' => $number_of_links,
                'total_comments_count' => $total_comments_count,
                'total_users_count' => $total_users_count
            ));
        } else {
            $this->redirect("login/invite");
        }
    }

    // On invite un utilisateur non connecté à se connecter :
    public function invite()
    {
        $number_of_items      = $this->calculate->getTotalOfItemsFront();
        $number_of_cards       = $this->calculate->getTotalOfCards();
        $number_of_links       = $this->calculate->getTotalOfLinks();
        $total_comments_count = $this->calculate->getTotalOfComments();
        $total_users_count    = $this->calculate->getTotalOfUsers();
        $this->generateView(array(
            'number_of_items' => $number_of_items,
            'number_of_cards' => $number_of_cards,
            'number_of_links' => $number_of_links,
            'total_comments_count' => $total_comments_count,
            'total_users_count' => $total_users_count
        ));
    }

    // Affichage de la page Forgotten Password :
    public function forgottenpassword()
    {
        $number_of_items       = $this->calculate->getTotalOfItemsFront();
        $number_of_cards       = $this->calculate->getTotalOfCards();
        $number_of_links       = $this->calculate->getTotalOfLinks();
        $total_comments_count  = $this->calculate->getTotalOfComments();
        $total_users_count     = $this->calculate->getTotalOfUsers();
        $number_of_items_pages = $this->calculate->getNumberOfPagesOfExtFront();
        $this->generateView(array(
            'number_of_items' => $number_of_items,
            'number_of_cards' => $number_of_cards,
            'number_of_links' => $number_of_links,
            'total_comments_count' => $total_comments_count,
            'total_users_count' => $total_users_count,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }

    // Processus de Connexion d'un user :
    public function generatepassword()
    {
        if ($this->request->ifParameter("username")) {
            $username  = $this->request->getParameter("username");
            $email     = $this->user->checkUsernameReset($username);
            $random    = rand(999, 99999);
            // autre option : $random = 2418*2+$username
            $token     = password_hash($random, PASSWORD_DEFAULT, array(
                "cost" => 12
            ));
            //$key = password_hash($random, PASSWORD_DEFAULT);
            $expformat = mktime(date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y"));
            $expdate   = date("Y-m-d H:i:s", $expformat);
            $this->user->insertResetTemp($email, $token, $expdate);
            ob_start();
            include 'View/themes/front/template_resetpassword.php';
            $body = ob_get_contents();
            ob_end_clean();
            $subject             = "Ré-initialisation de mot de passe - " . WEBSITE_NAME;
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
                header('Location: ' . BASE_URL . 'login/forgottenpassword');
                exit;
            } else {
                $messages['confirmation'] = 'Un e-mail vous a été envoyé <br>
              avec les instructions nécessaires<br>
              pour ré-initialiser votre mot de passe.';
                $_SESSION['messages']     = $messages;
                header('Location: ' . BASE_URL . 'login/forgottenpassword');
                exit;
            }
        } else
            throw new Exception("Action impossible : identifiant non défini");
    }

    // Affichage de la page Reset Password :
    public function resetpassword()
    {

        if (ISSET($_GET['token']) && ISSET($_GET['email']) && ISSET($_GET['username'])){
            $token        = $_GET['token'];
            $email        = $_GET['email'];
            $username     = $_GET['username'];
            $current_date = date("Y-m-d H:i:s");
            $this->user->checkResetLink($token, $email, $username, $current_date);
        } else {
            die(header('Location:' . BASE_URL . 'login'));
            exit;
        }
    }

    // Affichage de la page Reset Password :
    public function createnewpassword()
    {
        $number_of_items       = $this->calculate->getTotalOfItemsFront();
        $number_of_cards       = $this->calculate->getTotalOfCards();
        $total_comments_count  = $this->calculate->getTotalOfComments();
        $total_users_count     = $this->calculate->getTotalOfUsers();
        $number_of_items_pages = $this->calculate->getNumberOfPagesOfExtFront();
        $this->generateView(array(
            'username' => $username,
            'email' => $email,
            'number_of_items' => $number_of_items,
            'number_of_cards' => $number_of_cards,
            'total_comments_count' => $total_comments_count,
            'total_users_count' => $total_users_count,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }

    // Affichage de la page Reset Password :
    public function validnewpassword()
    {
        $number_of_items       = $this->calculate->getTotalOfItemsFront();
        $number_of_cards       = $this->calculate->getTotalOfCards();
        $total_comments_count  = $this->calculate->getTotalOfComments();
        $total_users_count     = $this->calculate->getTotalOfUsers();
        $number_of_items_pages = $this->calculate->getNumberOfPagesOfExtFront();
        if (isset($_POST["email"]) && isset($_POST["username"])) {

            if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
                $secretKey      = RECAPTCHA_SECRET_KEY;
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
                $responseData   = json_decode($verifyResponse);
                $email          = $_POST["email"];
                $username       = $_POST["username"];
                $current_date   = date("Y-m-d H:i:s");
                $pass           = $this->request->getParameter("pass");
                if ($responseData->success) {
                    // Ensuite on vérifie si les 2 mots de passe sont identiques :
                    if ($_POST['pass'] != $_POST['passcheck']) {
                        $errors['passdifferent'] = 'Désolé, les mots de passe ne correspondent pas !<br>';
                    }
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        die(header('Location: ' . BASE_URL . 'login/createnewpassword'));
                        exit;
                    }
                    // Maintenant, on hasshe le mot de passe :
                    $passwordHash = password_hash($pass, PASSWORD_BCRYPT, array(
                        "cost" => 12
                    ));
                    // OK, tout est correct, on peut alors insérer le nouveau mot de passe :
                    $this->user->updatePassword($username, $passwordHash, $email);
                } else {
                    $errors['errors'] = 'La vérification a échoué. Merci de re-essayer plus tard.';
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        header('Location: ' . BASE_URL . 'login/createnewpassword');
                        exit;
                    }
                }
            } else {
                $errors['errors']   = 'Merci de cocher la case reCAPTCHA.';
                $_SESSION['errors'] = $errors;
                header('Location: ' . BASE_URL . 'login/createnewpassword');
                exit;
            }
        } else {
            $errors['errors']   = 'Merci de renseigner tous les champs';
            $_SESSION['errors'] = $errors;
            header('Location: ' . BASE_URL . 'login/createnewpassword');
            exit;
        }
        $this->generateView(array(
            'number_of_items' => $number_of_items,
            'number_of_cards' => $number_of_cards,
            'total_comments_count' => $total_comments_count,
            'total_users_count' => $total_users_count,
            'number_of_items_pages' => $number_of_items_pages
        ));
    }


}
