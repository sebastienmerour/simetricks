<?php
require_once 'Framework/Model.php';

/**
 * Fournit les fonctions liées aux identifications / déconnexions
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class Login extends Model
{

    // Connexion d'un user :
    public function logInUser($username, $passwordAttempt)
    {
        if (isset($_POST['login'])) {
            // On récupère les valeurs saisies dans le formulaire de login :
            $username        = !empty($_POST['username']) ? trim($_POST['username']) : null;
            $passwordAttempt = !empty($_POST['pass']) ? trim($_POST['pass']) : null;

            // On prépare une requête pour aller chercher le username dans la BBD :
            $sql    = 'SELECT id_user, username, pass FROM users WHERE username = :username';
            $req    = $this->dbConnect($sql, array(
                'username' => $username
            ));
            $result = $req->fetch();

            // On vérifie si le username existe : .
            if (!$result) { // si le resultat est False

                // on indique à l'utilisateur qu'il s'est trompé de username ou de mot de passe.
                // on ne précise pas qu'il s'agit du username qui est faux, pour raison de sécurité :
                $_SESSION['errors']['loginfailed'] = 'Identifiant ou Mot de passe incorrect !';
                header('Location: '. BASE_URL. 'login/');

            } else {

                // Sinon, si le username a bien été trouvé, il faut vérifier que le mot de passe est correct.
                // On récupère le mot de passe hashé dans la base, et on le déchiffre pour le comparer :

                $validPassword = password_verify($passwordAttempt, $result['pass']);


                // Si $validPassword est True (donc correct), alors la connexion est réussie :
                if ($validPassword) {

                    // On déclenche alors l'ouverture d'une session :
                    $_SESSION['id_user'] = $result['id_user'];
                    if (!empty($_POST['rememberme'])) {

                        setcookie("username", $_POST['username'], time() + 365 * 24 * 3600, null, null, false, true);
                        setcookie("pass", $_POST['pass'], time() + 365 * 24 * 3600, null, null, false, true);
                    } else {
                        if (ISSET($_COOKIE['username'])) {
                            setcookie("username", "");
                        }
                        if (ISSET($_COOKIE['pass'])) {
                            setcookie("pass", "");
                        }
                    }

                    // On redirige l'utilisateur vers la page protégée :
                    header('Location: '. BASE_URL. 'user');
                    exit;

                } else {
                    // Dans le cas où le mot de passe est faux, on envoie un message :
                    $_SESSION['errors']['loginfailed'] = 'Identifiant ou Mot de passe incorrect !';
                    header('Location: '. BASE_URL. 'login/');
                }
            }
        }
    }


    // Connexion d'un Admin :
    public function logInUserAdmin($username, $passwordAttempt)
    {
        if (isset($_POST['login'])) {

            // On récupère les valeurs saisies dans le formulaire de login :
            $username        = !empty($_POST['username']) ? trim($_POST['username']) : null;
            $passwordAttempt = !empty($_POST['pass']) ? trim($_POST['pass']) : null;

            // On prépare une requête pour aller chercher le username dans la BBD :
            $sql    = 'SELECT id_user, status, username, pass FROM users WHERE username = :username';
            $req    = $this->dbConnect($sql, array(
                'username' => $username
            ));
            $result = $req->fetch();

            // On récupère le mot de passe hashé dans la base, et on le déchiffre pour le comparer :
            $validPassword = password_verify($passwordAttempt, $result['pass']);

            // On vérifie si l'utilisateur est un admin :
            $validAdmin = $result['status'] == 5;

            // On vérifie si le username existe : .
            if (!$result) {
                // on indique à l'utilisateur qu'il s'est trompé de username ou de mot de passe.
                // on ne précise pas qu'il s'agit du username qui est faux, pour raison de sécurité :
                $errors['errors']   = 'Identifiant ou Mot de passe incorrect !';
                $_SESSION['errors'] = $errors;
                header('Location:' . BASE_ADMIN_URL);
            } else if (!$validPassword) {
                $errors['errors']   = 'Identifiant ou Mot de passe incorrect !';
                $_SESSION['errors'] = $errors;
                header('Location:' . BASE_ADMIN_URL);
            } else if (!$validAdmin) {
                $errors['errors']   = 'Vous n\'êtes pas autorisés à accéder à l\'administration !';
                $_SESSION['errors'] = $errors;
                header('Location:' . BASE_ADMIN_URL);
            }

            // Si les 3 vérifications sont bonnes, alors la connexion est réussie :
            else if ($result && $validPassword && $validAdmin) {

                // On déclenche alors l'ouverture d'une session :
                $_SESSION['id_user_admin'] = $result['id_user'];
                if (!empty($_POST['rememberme'])) {

                    setcookie("username", $_POST['username'], time() + 365 * 24 * 3600, null, null, false, true);
                    setcookie("pass", $_POST['pass'], time() + 365 * 24 * 3600, null, null, false, true);
                } else {
                    if (ISSET($_COOKIE['username'])) {
                        setcookie("username", "");
                    }
                    if (ISSET($_COOKIE['pass'])) {
                        setcookie("pass", "");
                    }
                }

                // On redirige l'utilisateur vers la page protégée :
                header('Location:' . BASE_ADMIN_URL . 'dashboard');
                exit;

            } else {
                // Dans le cas où le mot de passe est faux, on envoie un message :
                $errors['errors']   = 'Vous n\'êtes pas autorisés à accéder à l\'administration !';
                $_SESSION['errors'] = $errors;

                header('Location:' . BASE_ADMIN_URL);
            }
        }
    }

}
