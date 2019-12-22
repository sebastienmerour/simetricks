<?php
require_once 'Framework/Controller.php';
require_once 'Framework/Model.php';
require_once 'Framework/Request.php';

/**
 * Fournit les fonctions liées aux utilisateurs
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class User extends Model
{

    public $number_of_users_by_page = 5;

    // CREATE

    // Création d'un utilisateur :
    public function insertUser($username, $pass, $email)
    {
        $errors    = array();
        $messages  = array();
        $username  = !empty($_POST['username']) ? trim($_POST['username']) : null;
        $avatar    = 'default.png';
        $firstname = '';
        $name      = '';
        $pass      = !empty($_POST['pass']) ? trim($_POST['pass']) : null;
        $email     = !empty($_POST['email']) ? trim($_POST['email']) : null;
        // On vérifie d'abord si l'identifiant choisi existe déjà ou non :

        // Préparation de la reqûete SQL et déclaration de la requête :
        $sql  = 'SELECT COUNT(id_user) AS num FROM users WHERE username = :username';
        $stmt = $this->dbConnect($sql, array(
            ':username' => $username
        ));

        // Associer le username fourni avec la déclaration :
        // $stmt->bindValue(':username', $username);

        // Execution :
        // $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Si l'identifiant est déjà pris, on affiche une erreur.
        // Si row est supérieur à 0 cela veut dire que l'identifiant se trouve déjà en bdd :
        if ($row['num'] > 0) {
            $errors['username'] = 'Désolé, cet identifiant est déjà pris.<br>';
        }

        // Ensuite on vérifie si l'adresse mail possède un format valide :
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // L'adresse e-mail a-t-elle une forme valide ? Regex ou non ?
            $errors['email'] = 'Désolé, cette adresse e-mail n\'est pas valide.<br>';
        }

        if (empty($username) OR empty($pass) OR empty($email)) {
            $errors['field'] = 'Tous les champs ne sont pas renseignés !';
        }

        // Ensuite on vérifie si les 2 mots de passe sont identiques :
        if ($_POST['pass'] != $_POST['passcheck']) // Les deux mots de passe saisis sont-ils identiques ?
            {
            $errors['passdifferent'] = 'Désolé, les mots de passe ne correspondent pas !<br>';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            die(header('Location: adduser'));
            exit;
        }

        // Maintenant, on hasshe le mot de passe, car on ne veut pas enregistrer
        // le vrai mot de passe dans la basse de données :
        $passwordHash = password_hash($pass, PASSWORD_BCRYPT, array(
            "cost" => 12
        ));

        // OK, le formulaire est OK, on peut alors insérer le nouveau membre :
        $sql2                    = 'INSERT INTO users (status, username, firstname, name, avatar, pass, email, date_birth, date_register)
           VALUES (:status, :username, :firstname, :name, :avatar, :pass, :email, :date_birth, NOW())';
        $userLines               = $this->dbConnect($sql2, array(
            ':status' => htmlspecialchars(0),
            ':username' => htmlspecialchars($username),
            ':firstname' => htmlspecialchars($firstname),
            ':name' => htmlspecialchars($name),
            ':avatar' => htmlspecialchars($avatar),
            ':pass' => htmlspecialchars($passwordHash),
            ':email' => htmlspecialchars($email),
            ':date_birth' => htmlspecialchars('1950-01-01 00:00:00')
        ));
        $messages['confirmation'] = 'Votre compte a bien été créé !';
        header('Location: adduser');
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: adduser');
            exit;
        }

    }

    // READ

    // Affichage d'un utilisateur :
    public function getUser($user_id)
    {
        $sql   = 'SELECT id_user, status, username, firstname, name, avatar, pass, email, DATE_FORMAT(date_birth, \'%Y-%m-%d \')
       AS date_birth, DATE_FORMAT(date_register, \'%Y-%m-%d \') AS date_register
       FROM users WHERE id_user = :id_user';
        $query = $this->dbConnect($sql, array(
            ':id_user' => $user_id
        ));
        $user  = $query->fetch(\PDO::FETCH_ASSOC);
        return $user;
    }

    // Afficher la liste complète de tous les users en Admin :
    public function selectUsers($users_current_page)
    {
        $users_start = (int) (($users_current_page - 1) * $this->number_of_users_by_page);
        $sql            = 'SELECT id_user, firstname, name, avatar, email,
    DATE_FORMAT(date_register, \'%d/%m/%Y à %Hh%i\') AS date_register_fr
    FROM users
    ORDER BY date_register DESC LIMIT ' . $users_start . ', ' . $this->number_of_users_by_page . '';
        $users       = $this->dbConnect($sql);
        return $users;
    }


    // UPDATE

    // Modification d'un utilisateur en front :
    public function changeUser($pass, $email, $firstname, $name, $date_birth)
    {
        $errors         = array();
        $messages       = array();
        $identification = $_SESSION['id_user'];
        $pass           = !empty($_POST['pass']) ? trim($_POST['pass']) : null;
        $email          = !empty($_POST['email']) ? trim($_POST['email']) : null;
        $firstname      = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
        $name           = !empty($_POST['name']) ? trim($_POST['name']) : null;
        $date_birth     = !empty($_POST['date_birth']) ? trim($_POST['date_birth']) : null;

        // Ensuite on vérifie si l'adresse mail possède un format valide :
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // L'adresse e-mail a-t-elle une forme valide ? Regex ou non ?
            $errors['email'] = 'Désolé, cette adresse e-mail n\'est pas valide.<br>';
        }

        // Ensuite on vérifie si les 2 mots de passe sont identiques :
        if ($_POST['pass'] != $_POST['passcheck']) // Les deux mots de passe saisis sont-ils identiques ?
            {
            $errors['passdifferent'] = 'Désolé, les mots de passe ne correspondent pas !<br>';
        }
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            die(header('Location: ../user/modifyuser'));
            exit;
        }
        // Maintenant, on hashe le mot de passe, car on ne veut pas enregistrer
        // le vrai mot de passe dans la basse de données :
        $passwordHash = password_hash($pass, PASSWORD_BCRYPT, array(
            "cost" => 12
        ));

        $sql  = 'UPDATE users
           SET pass = :pass, email= :email, firstname= :firstname, name= :name, date_birth= :date_birth
           WHERE id_user= :id_user';
        $user = $this->dbConnect($sql, array(
            ':id_user' => htmlspecialchars($identification),
            ':pass' => htmlspecialchars($passwordHash),
            ':email' => htmlspecialchars($email),
            ':firstname' => htmlspecialchars($firstname),
            ':name' => htmlspecialchars($name),
            ':date_birth' => htmlspecialchars($date_birth)
        ));

        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Votre compte a bien été mis à jour !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../user/');
            exit;
        }
    }

    // Modification d'un utilisateur en Admin :
    public function changeUserFromAdmin($user_id, $status, $firstname, $name, $email, $date_birth)
    {

        $errors         = array();
        $messages       = array();
        $identification = $user_id;
        $status         = !empty($_POST['status']) ? trim($_POST['status']) : null;
        $firstname      = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
        $name           = !empty($_POST['name']) ? trim($_POST['name']) : null;
        $email          = !empty($_POST['email']) ? trim($_POST['email']) : null;
        $date_birth     = !empty($_POST['date_birth']) ? trim($_POST['date_birth']) : null;

        // Ensuite on vérifie si l'adresse mail possède un format valide :
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // L'adresse e-mail a-t-elle une forme valide ? Regex ou non ?
            $errors['email'] = 'Désolé, cette adresse e-mail n\'est pas valide.<br>';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            die(header('Location: ../readuser/'.$user_id));
            exit;
        }

        $sql  = 'UPDATE users
           SET status = :status, firstname= :firstname, name= :name, email= :email, date_birth= :date_birth
           WHERE id_user= :id_user';
        $user = $this->dbConnect($sql, array(
            ':id_user' => htmlspecialchars($identification),
            ':status' => htmlspecialchars($status),
            ':firstname' => htmlspecialchars($firstname),
            ':name' => htmlspecialchars($name),
            ':email' => htmlspecialchars($email),
            ':date_birth' => htmlspecialchars($date_birth)
        ));

        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Le compte a bien été mis à jour !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../readuser/'.$user_id);
            exit;
        }
    }


    // Modification d'un utilisateur en front :
    public function changeUserImageFromAdmin($user_id, $status, $firstname, $name, $avatarname, $email, $date_birth)
    {
        $errors         = array();
        $messages       = array();
        $identification = $user_id;
        $status         = !empty($_POST['status']) ? trim($_POST['status']) : null;
        $firstname      = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
        $name           = !empty($_POST['name']) ? trim($_POST['name']) : null;
        $email          = !empty($_POST['email']) ? trim($_POST['email']) : null;
        $date_birth     = !empty($_POST['date_birth']) ? trim($_POST['date_birth']) : null;

        // Ensuite on vérifie si l'adresse mail possède un format valide :
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // L'adresse e-mail a-t-elle une forme valide ? Regex ou non ?
            $errors['email'] = 'Désolé, cette adresse e-mail n\'est pas valide.<br>';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            die(header('Location: ../user/'.$user_id));
            exit;
        }

        $sql  = 'UPDATE users
           SET status = :status, firstname= :firstname, name= :name, avatar= :avatar, email= :email, date_birth= :date_birth
           WHERE id_user= :id_user';
        $user = $this->dbConnect($sql, array(
            ':id_user' => htmlspecialchars($identification),
            ':status' => htmlspecialchars($status),
            ':firstname' => htmlspecialchars($firstname),
            ':name' => htmlspecialchars($name),
            ':avatar' => htmlspecialchars($avatarname),
            ':email' => htmlspecialchars($email),
            ':date_birth' => htmlspecialchars($date_birth)
        ));

        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Le compte a bien été mis à jour !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../readuser/'.$user_id);
            exit;
        }
    }

    // Modification d'un identifiant :
    public function changeUsername($username)
    {
        $errors         = array();
        $messages       = array();
        $identification = $_SESSION['id_user'];
        $username       = !empty($_POST['username']) ? trim($_POST['username']) : null;
        $sql            = 'SELECT COUNT(id_user) AS num FROM users WHERE username = :username';
        $stmt           = $this->dbConnect($sql, array(
            ':username' => $username
        ));

        // On vérifie d'abord si l'identifiant choisi existe déjà ou non :

        // Associer le username fourni avec la déclaration :
        // $stmt->bindValue(':username', $username);

        // Execution :
        // $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        // Si l'identifiant est déjà pris, on affiche une erreur.
        // Si row est supérieur à 0 cela veut dire que l'identifiant se trouve déjà en bdd :
        if ($row['num'] > 0) {
            $errors['username'] = 'Désolé, cet identifiant est déjà pris.<br>';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            die(header('Location: ../user/modifyuser#username'));

            exit;
        }
        $sql2                     = 'UPDATE users
         SET username= :username
         WHERE id_user= :id_user';
        $userupdate               = $this->dbConnect($sql2, array(
            ':id_user' => htmlspecialchars($identification),
            ':username' => htmlspecialchars($username)
        ));
        $messages['confirmation'] = 'Votre identifiant a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../user/modifyuser#username');
            exit;
        }
    }

    // Modification d'un avatar :
    public function changeAvatar($avatarname)
    {
        $user_id                  = $_SESSION['id_user'];
        $sql                      = 'UPDATE users
           SET avatar = :avatar
           WHERE id_user = :id_user';
        $avatarCreation           = $this->dbConnect($sql, array(
            ':avatar' => htmlspecialchars($avatarname),
            ':id_user' => htmlspecialchars($user_id)
        ));
        $messages['confirmation'] = 'Votre avatar a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../user/');
            exit;
        }
    }

    // DELETE
    // Suppression d'un utilisateur :
    public function eraseUser($user_id)
    {
        $sql = 'DELETE FROM users WHERE id_user = ' . (int) $user_id;
        $req = $this->dbConnect($sql);
        $req->execute();
        // Ici on affiche le message de confirmation :
        $messages['confirmation'] = 'Merci ! L\'utilisateur a bien été supprimé !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ../users');
            exit;
        }
    }




    // CONNEXION ET DECONNEXION

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
                header('Location: ../login/');

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
                    header('Location: ../user/');
                    exit;

                } else {
                    // Dans le cas où le mot de passe est faux, on envoie un message :
                    $_SESSION['errors']['loginfailed'] = 'Identifiant ou Mot de passe incorrect !';
                    header('Location: ../login/');
                }
            }
        }
    } // fin de logInUser


    // Connexion d'un Admin :
    public function logInUserAdmin($username, $passwordAttempt)
    {
        if (isset($_POST['login'])) {

            // On récupère les valeurs saisies dans le formulaire de login :
            $username        = !empty($_POST['username']) ? trim($_POST['username']) : null;
            $passwordAttempt = !empty($_POST['pass']) ? trim($_POST['pass']) : null;

            // On prépare une rquête pour aller chercher le username dans la BBD :
            $sql      = 'SELECT id_user, status, username, pass FROM users WHERE username = :username';
            $req      = $this->dbConnect($sql, array(
                'username' => $username
            ));
            $resultat = $req->fetch();

            // On vérifie si le username existe : .
            if (!$resultat) { // si le resultat est False

                // on indique à l'utilisateur qu'il s'est trompé de username ou de mot de passe.
                // on ne préciser pas qu'il s'agit du username qui est faux, pour raison de sécurité :
                $errors['errors'] = 'Identifiant ou Mot de passe incorrect !';
                $_SESSION['errors'] = $errors;
                header('Location:' . BASE_ADMIN_URL);
            } else {

                // Sinon, si le username a bien été trouvé, il faut vérifier que le mot de passe est correct.
                // On récupère le mot de passe hashé dans la base, et on le déchiffre pour le comparer :

                $validPassword = password_verify($passwordAttempt, $resultat['pass']);
                $validAdmin    = $resultat['status'] == 5;

                // Si $validPassword est True (donc correct), alors la connexion est réussie :
                if ($validPassword && $validAdmin) {

                    // On déclenche alors l'ouverture d'une session :
                    $_SESSION['id_user_admin'] = $resultat['id_user'];
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
                    header('Location:' . BASE_ADMIN_URL. 'dashboard');
                    exit;

                } else {
                    // Dans le cas où le mot de passe est faux, on envoie un message :
                    $errors['errors'] = 'Vous n\'êtes pas autorisés à accéder à l\'administration !';
                    $_SESSION['errors'] = $errors;

                    header('Location:' . BASE_ADMIN_URL);
                }
            }
        }
    }

    // CALCULS
    // FRONT

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
