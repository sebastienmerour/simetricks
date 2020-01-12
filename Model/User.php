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

    // Vérification avant création de l'utilisateur :
    public function checkUser($username, $pass, $email)
    {
        $errors   = array();
        $messages = array();
        $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
        $pass     = !empty($_POST['pass']) ? trim($_POST['pass']) : null;
        $email    = !empty($_POST['email']) ? trim($_POST['email']) : null;

        // On vérifie d'abord si l'identifiant choisi existe déjà ou non :
        // Préparation de la reqûete SQL et déclaration de la requête :
        $sql  = 'SELECT COUNT(id_user) AS num FROM users WHERE username = :username';
        $stmt = $this->dbConnect($sql, array(
            ':username' => $username
        ));

        // Associer le username fourni avec la déclaration :
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Si l'identifiant est déjà pris, on affiche une erreur.
        // Si row est supérieur à 0 cela veut dire que l'identifiant se trouve déjà en bdd :
        if ($row['num'] > 0) {
            $errors['username'] = 'Désolé, cet identifiant est déjà pris.<br>';
        }

        // Ensuite on vérifie si l'adresse mail possède un format valide :
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Désolé, cette adresse e-mail n\'est pas valide.<br>';
        }

        if (empty($username) OR empty($pass) OR empty($email)) {
            $errors['field'] = 'Tous les champs ne sont pas renseignés !';
        }

        // Ensuite on vérifie si les 2 mots de passe sont identiques :
        if ($_POST['pass'] != $_POST['passcheck']) {
            $errors['passdifferent'] = 'Désolé, les mots de passe ne correspondent pas !<br>';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ' . BASE_URL . 'user/useradd');
            exit;
        }

        // Maintenant, on hasshe le mot de passe :
        $passwordHash = password_hash($pass, PASSWORD_BCRYPT, array(
            "cost" => 12
        ));

        // OK, tout est correct, on peut alors insérer le nouveau membre :
        $this->insertUser($username, $passwordHash, $email);
    }

    // Insertion de l'utilisateur en base de données :
    public function insertUser($username, $passwordHash, $email)
    {
        $avatar    = 'default.png';
        $firstname = '';
        $name      = '';
        $sql       = 'INSERT INTO users (status, username, firstname, name, avatar, pass, email, date_birth, date_register)
       VALUES (:status, :username, :firstname, :name, :avatar, :pass, :email, :date_birth, NOW())';
        $this->dbConnect($sql, array(
            ':status' => htmlspecialchars(0),
            ':username' => htmlspecialchars($username),
            ':firstname' => htmlspecialchars($firstname),
            ':name' => htmlspecialchars($name),
            ':avatar' => htmlspecialchars($avatar),
            ':pass' => htmlspecialchars($passwordHash),
            ':email' => htmlspecialchars($email),
            ':date_birth' => htmlspecialchars('1950-01-01 00:00:00')
        ));
        $messages['confirmation'] = 'Votre compte a bien été créé !<br>
        Pour vous identifier, <a href="'.BASE_URL.'login">cliquez ici</a><br>';
        header('Location: ' . BASE_URL . 'useradd');
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_URL . 'user/useradd');
            exit;
        }
    }


    // READ

    // Affichage d'un utilisateur :
    public function getUser($id_user)
    {
        $sql   = 'SELECT id_user, status, username, firstname, name, avatar, pass, email, DATE_FORMAT(date_birth, \'%Y-%m-%d \')
       AS date_birth, DATE_FORMAT(date_register, \'%d/%m/%Y \') AS date_register, DATE_FORMAT(date_update, \'%d/%m/%Y \') AS date_update
       FROM users WHERE id_user = :id_user';
        $query = $this->dbConnect($sql, array(
            ':id_user' => $id_user
        ));
        $user  = $query->fetch(\PDO::FETCH_ASSOC);
        return $user;
    }

    // Afficher la liste complète de tous les users en Admin :
    public function selectUsers($users_current_page)
    {
        $id_admin    = ID_ADMIN;
        $users_start = (int) (($users_current_page - 1) * $this->number_of_users_by_page);
        $sql         = 'SELECT id_user, firstname, name, avatar, email,
    DATE_FORMAT(date_register, \'%d/%m/%Y à %Hh%i\') AS date_register_fr
    FROM users
    WHERE bin != "yes" AND id_user != :id_admin
    ORDER BY date_register DESC LIMIT ' . $users_start . ', ' . $this->number_of_users_by_page . '';
        $users       = $this->dbConnect($sql, array(
            ':id_admin' => "$id_admin"
        ));
        return $users;
    }

    // Afficher la liste complète des users dans la Corbeille en Admin :
    public function selectUsersDeleted($users_deleted_current_page)
    {
        $users_start   = (int) (($users_deleted_current_page - 1) * $this->number_of_users_by_page);
        $sql           = 'SELECT id_user, firstname, name, avatar, email,
    DATE_FORMAT(date_register, \'%d/%m/%Y à %Hh%i\') AS date_register_fr
    FROM users
    WHERE bin = :bin
    ORDER BY date_register DESC LIMIT ' . $users_start . ', ' . $this->number_of_users_by_page . '';
        $users_deleted = $this->dbConnect($sql, array(
            ':bin' => "yes"
        ));
        return $users_deleted;
    }


    // UPDATE
    // Modification d'un utilisateur en front :
    public function changeUser($pass, $email, $firstname, $name, $date_birth)
    {
        $identification = $_SESSION['id_user'];
        $pass           = !empty($_POST['pass']) ? trim($_POST['pass']) : null;
        $email          = !empty($_POST['email']) ? trim($_POST['email']) : null;
        $firstname      = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
        $name           = !empty($_POST['name']) ? trim($_POST['name']) : null;
        $date_birth     = !empty($_POST['date_birth']) ? trim($_POST['date_birth']) : null;

        // Ensuite on vérifie si l'adresse mail possède un format valide :
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Désolé, cette adresse e-mail n\'est pas valide.<br>';
        }

        // Ensuite on vérifie si les 2 mots de passe sont identiques :
        if ($_POST['pass'] != $_POST['passcheck']) {
            $errors['passdifferent'] = 'Désolé, les mots de passe ne correspondent pas !<br>';
        }
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            die(header('Location: ' . BASE_URL . 'user/useredit'));
            exit;
        }
        // Maintenant, on hashe le mot de passe :
        $passwordHash = password_hash($pass, PASSWORD_BCRYPT, array(
            "cost" => 12
        ));

        $sql  = 'UPDATE users
           SET pass = :pass, email= :email, firstname= :firstname, name= :name, date_birth= :date_birth,
           date_update = NOW()
           WHERE id_user= :id_user';
        $user = $this->dbConnect($sql, array(
            ':id_user' => htmlspecialchars($identification),
            ':pass' => htmlspecialchars($passwordHash),
            ':email' => htmlspecialchars($email),
            ':firstname' => htmlspecialchars($firstname),
            ':name' => htmlspecialchars($name),
            ':date_birth' => htmlspecialchars($date_birth)
        ));

        $messages['confirmation'] = 'Votre compte a bien été mis à jour !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_URL . 'user');
            exit;
        }
    }

    // Modification d'un utilisateur en Admin :
    public function changeUserFromAdmin($id_user, $status, $firstname, $name, $email, $date_birth)
    {
        $identification = $id_user;
        $status         = !empty($_POST['status']) ? trim($_POST['status']) : null;
        $firstname      = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
        $name           = !empty($_POST['name']) ? trim($_POST['name']) : null;
        $email          = !empty($_POST['email']) ? trim($_POST['email']) : null;
        $date_birth     = !empty($_POST['date_birth']) ? trim($_POST['date_birth']) : null;

        // Ensuite on vérifie si l'adresse mail possède un format valide :
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Désolé, cette adresse e-mail n\'est pas valide.<br>';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            die(header('Location: ' . BASE_ADMIN_URL . 'userread/' . $id_user));
            exit;
        }

        $sql  = 'UPDATE users
           SET status = :status, firstname= :firstname, name= :name, email= :email, date_birth= :date_birth,
           date_update = NOW()
           WHERE id_user= :id_user';
        $user = $this->dbConnect($sql, array(
            ':id_user' => htmlspecialchars($identification),
            ':status' => htmlspecialchars($status),
            ':firstname' => htmlspecialchars($firstname),
            ':name' => htmlspecialchars($name),
            ':email' => htmlspecialchars($email),
            ':date_birth' => htmlspecialchars($date_birth)
        ));

        $messages['confirmation'] = 'Le compte a bien été mis à jour !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'userread/' . $id_user);
            exit;
        }
    }

    // Modification d'un utilisateur en front :
    public function changeUserImageFromAdmin($id_user, $status, $firstname, $name, $avatarname, $email, $date_birth)
    {
        $identification = $id_user;
        $status         = !empty($_POST['status']) ? trim($_POST['status']) : null;
        $firstname      = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
        $name           = !empty($_POST['name']) ? trim($_POST['name']) : null;
        $email          = !empty($_POST['email']) ? trim($_POST['email']) : null;
        $date_birth     = !empty($_POST['date_birth']) ? trim($_POST['date_birth']) : null;

        // Ensuite on vérifie si l'adresse mail possède un format valide :
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Désolé, cette adresse e-mail n\'est pas valide.<br>';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            die(header('Location: ' . BASE_ADMIN_URL . 'userread/' . $id_user));
            exit;
        }

        $sql  = 'UPDATE users
           SET status = :status, firstname= :firstname, name= :name, avatar= :avatar, email= :email, date_birth= :date_birth,
           date_update = NOW()
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

        $messages['confirmation'] = 'Le compte a bien été mis à jour !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'userread/' . $id_user);
            exit;
        }
    }

    // Vérification de disponibilité du username :
    public function checkUsername($username)
    {
        $identification = $_SESSION['id_user'];
        $username       = !empty($_POST['username']) ? trim($_POST['username']) : null;
        $sql            = 'SELECT COUNT(id_user) AS num FROM users WHERE username = :username';
        $stmt           = $this->dbConnect($sql, array(
            ':username' => $username
        ));

        // On vérifie d'abord si l'identifiant choisi existe déjà ou non :
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Si l'identifiant est déjà pris, on affiche une erreur.
        // Si row est supérieur à 0 cela veut dire que l'identifiant se trouve déjà en bdd :
        if ($row['num'] > 0) {
            $errors['username'] = 'Désolé, cet identifiant est déjà pris.<br>';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            die(header('Location: ' . BASE_URL . 'user/useredit#username'));
            exit;
        }
        $this->changeUsername($username);
    }

    // Modification d'un identifiant :
    public function changeUsername($username)
    {
        $identification = $_SESSION['id_user'];

        $sql        = 'UPDATE users
     SET username= :username, date_update = NOW()
     WHERE id_user= :id_user';
        $userupdate = $this->dbConnect($sql, array(
            ':id_user' => htmlspecialchars($identification),
            ':username' => htmlspecialchars($username)
        ));

        $messages['confirmation'] = 'Votre identifiant a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_URL . 'user/useredit#username');
            exit;
        }
    }


    // Modification d'un avatar :
    public function changeAvatar($avatarname)
    {
        $id_user = $_SESSION['id_user'];
        $sql     = 'UPDATE users
           SET avatar = :avatar,
           date_update = NOW()
           WHERE id_user = :id_user';
        $this->dbConnect($sql, array(
            ':avatar' => htmlspecialchars($avatarname),
            ':id_user' => htmlspecialchars($id_user)
        ));
        $messages['confirmation'] = 'Votre avatar a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_URL . 'user');
            exit;
        }
    }

    // Restaurer un user depuis la Corbeille :
    public function restoreUser($id_user)
    {
        $bin                      = "no";
        $sql                      = 'UPDATE users SET bin = :bin, date_update = NOW() WHERE id_user = :id';
        $restore                  = $this->dbConnect($sql, array(
            ':id' => $id_user,
            ':bin' => $bin
        ));
        $messages['confirmation'] = 'Merci ! L\'utilisateur a bien été restauré !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'usersbin');
            exit;
        }
    }


    // DELETE

    // Déplacement d'un user vers la Corbeille :
    public function moveUser($id_user)
    {
        $bin = "yes";
        $sql = 'UPDATE users SET bin = :bin, date_update = NOW() WHERE id_user = :id';
        $this->dbConnect($sql, array(
            ':id' => $id_user,
            ':bin' => $bin
        ));
        $messages['confirmation'] = 'Merci ! L\'utilisateur a bien été déplacé dans la corbeille !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'users');
            exit;
        }
    }

    // Suppression définitive d'un user avec ses commentaires associés :
    public function eraseUser($id_user)
    {
        $sql = 'DELETE users.*, comments.*
        FROM users
        LEFT JOIN comments
        ON users.id_user = comments.id_user
        WHERE users.id_user = ' . (int) $id_user;
        $req = $this->dbConnect($sql);
        $req->execute();
        $messages['confirmation'] = 'Merci ! L\'utilisateur a bien été supprimé !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'users');
            exit;
        }
    }

    // Vidage de la Corbeille des Users et des Commentaires associés :
    public function emptyusersbin()
    {
        $bin = "yes";
        $sql = 'DELETE users.*, comments.*
        FROM users
        LEFT JOIN comments
        ON users.id_user = comments.id_user
        WHERE users.bin = :bin';
        $req = $this->dbConnect($sql, array(
            ':bin' => $bin
        ));
        $req->execute();

        $messages['confirmation'] = 'Merci ! La corbeille a été vidée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'usersbin');
            exit;
        }
    }

    // Génération d'un mot de passe depuis la page "Mot de passe oublié"
    public function checkUsernameReset($username)
    {

        if (isset($_POST["username"]) && (!empty($_POST["username"]))) {
            $username = !empty($_POST['username']) ? trim($_POST['username']) : null;

            // On vérifie d'abord si l'identifiant choisi existe déjà ou non :
            // Préparation de la reqûete SQL et déclaration de la requête :
            $sql  = 'SELECT COUNT(id_user) AS num, email FROM users WHERE username = :username';
            $stmt = $this->dbConnect($sql, array(
                ':username' => $username
            ));

            // Associer le username fourni avec la déclaration :
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Si l'identifiant n'existe pas, on retourne une erreur :
            if ($row['num'] == 0) {
                $errors['username'] = 'Cet identifiant n\'existe pas !';
                $_SESSION['errors'] = $errors;
                die(header('Location:' . BASE_URL . 'login/forgottenpassword'));
                exit;
            } else {
                $email = $row['email'];
                return $email;
            }
        }
    }

    // Insérer le Token de ré-initialisation en base de données :
    public function insertResetTemp($email, $token, $expdate)
    {
        $sql = 'INSERT INTO password_reset_temp (email, token, expdate)
        VALUES (:email, :token, :expdate)';
        $this->dbConnect($sql, array(
            ':email' => htmlspecialchars($email),
            ':token' => htmlspecialchars($token),
            ':expdate' => htmlspecialchars($expdate)
        ));
    }

    // Vérifier si le token de reset est valable :
    public function checkResetLink($token, $email, $username, $current_date)
    {
        $sql     = 'SELECT expdate, COUNT(id) AS num FROM password_reset_temp WHERE email = :email
        AND token = :token';
        $stmt    = $this->dbConnect($sql, array(
            ':email' => $email,
            ':token' => $token,
        ));

        $row     = $stmt->fetch(\PDO::FETCH_ASSOC);
        $expiration = $row['expdate'];
        if ($row['num'] == 0) {
            $errors['invalidlink'] = 'Ce lien est invalide.<br>
            Veuillez redemander un nouveau <br>
            mot de passe ci-dessous.';
            $_SESSION['errors']    = $errors;
            die(header('Location:' . BASE_URL . 'login/forgottenpassword'));
            exit;
        }
         else if ($expiration <= $current_date) {
              $errors['invalidlink'] = 'Ce lien a expiré.<br>
              Veuillez redemander un nouveau <br>
              mot de passe ci-dessous.';
              $_SESSION['errors']    = $errors;
              die(header('Location:' . BASE_URL . 'login/forgottenpassword'));
              exit;
          }
        else {
          $_SESSION['username']    = $username;
          $_SESSION['email']    = $email;
          die(header('Location:' . BASE_URL . 'login/createnewpassword'));
          exit;
        }
    }

    // Mise à jour du mot de passe depuis la page de reset :
    public function updatePassword($username, $passwordHash, $email)
    {
        $sql                      = 'UPDATE users
         SET pass = :pass
         WHERE username= :username';
        $user                     = $this->dbConnect($sql, array(
            ':pass' => htmlspecialchars($passwordHash),
            ':username' => htmlspecialchars($username)
        ));
        $this->deleteToken($email);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        $messages['confirmation'] = 'Votre mot de passe a bien été mis à jour !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
    }

    public function deleteToken($email)
    {

      $sql = 'DELETE
      FROM password_reset_temp
      WHERE email = :email';
      $req = $this->dbConnect($sql, array(
          ':email' => $email
      ));
      $req->execute();
    }

}
