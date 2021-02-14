<?php
require_once 'Framework/Model.php';

/**
 * Fournit les fonctions liées aux Messages d'erreur
 *
 * @version 1.0
 * @author Sébastien Merour
 */


class Message extends Model
{

    // Extended Cards
    public function extendedCardCreated()
    {
      $messages['confirmation'] = 'Votre Extended Card a bien été ajoutée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'extendedcardsadmin');
            exit;
        }
    }

    public function extendedCardUpdated($id_item)
    {
        $messages['confirmation'] = 'Votre Extended Card a bien été modifiée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'extendedcardsadmin/extendedcardread/' . $id_item);
            exit;
        }
    }

    public function extendedCardMoveToBin()
    {
        $messages['confirmation'] = 'L\'Extended Card a été déplacée dans la corbeille !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'extendedcardsadmin');
            exit;
        }
    }

    public function extendedCardErased()
    {
        $messages['confirmation'] = 'Votre Extended Card a bien été supprimée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'extendedcardsadmin/extendedcardsbin');
            exit;
        }
    }

    public function extendedCardEmptyBin()
    {
        $messages['confirmation'] = 'La corbeille a été vidée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'extendedcardsadmin/extendedcardsbin');
            exit;
        }
    }

    public function extendedCardRestored()
    {

        $messages['confirmation'] = 'L\'Extended Card a bien été restaurée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'extendedcardsadmin/extendedcardsbin');
            exit;
        }
    }


    // Cards

    public function cardCreated()
    {
        $messages['confirmation'] = 'Votre Card a bien été ajoutée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'cardsadmin');
            exit;
        }
    }

    public function cardUpdated($id_card)
    {
        $messages['confirmation'] = 'Votre Card a bien été modifiée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'cardsadmin/cardread/' . $id_card);
            exit;
        }
    }

    public function cardMoveTobBin()
    {
        $messages['confirmation'] = 'La Card a été déplacée dans la corbeille !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'cardsadmin');
            exit;
        }
    }

    public function cardErased()
    {
        $messages['confirmation'] = 'Votre Card a bien été supprimée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'cardsadmin/cardsbin');
            exit;
        }
    }

    public function cardEmptyBin()
    {
        $messages['confirmation'] = 'La corbeille a été vidée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'cardsadmin/cardsbin');
            exit;

        }
    }

    public function cardRestored()
    {
        $messages['confirmation'] = 'La Card a bien été restaurée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'cardsadmin/cardsbin');
            exit;
        }
    }


    // CATEGORIES

    public function categoryCreated()
    {
        $messages['confirmation'] = 'La catégorie a bien été ajoutée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'categories');
            exit;
        }
    }

    public function categoryUpdated($id_category)
    {
        $messages['confirmation'] = 'La catégorie a bien été modifiée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'categories/categoryread/' . $id_category);
            exit;
        }
    }

    public function categoryMoveTobBin()
    {
        $messages['confirmation'] = 'La catégorie a été déplacée dans la corbeille !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'categories');
            exit;
        }
    }

    public function categoryErased()
    {
        $messages['confirmation'] = 'La catégorie a été supprimée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'categories/categoriesbin');
            exit;
        }
    }

    public function categoryEmptyBin()
    {
        $messages['confirmation'] = 'La corbeille a été vidée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'categories/categoriesbin');
            exit;
        }
    }

    public function categoryRestored()
    {
        $messages['confirmation'] = 'La Catégorie a bien été restaurée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'categories/categoriesbin');
            exit;
        }
    }


    // COMMENTS
    public function commentCreated($id_item)
    {
        $messages['confirmation'] = 'Votre commentaire a bien été ajouté !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_URL . 'extendedcard/' . $id_item . '/1/#comments');
            exit;
        }
    }

    public function commentCreatedLoggedIn($id_item)
    {
        $messages['confirmation'] = 'Votre commentaire a bien été ajouté !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_URL . 'extendedcard/indexuser/' . $id_item . '/1/#comments');
            exit;
        }
    }

    public function commentUpdated($id_comment)
    {
        $messages['confirmation'] = 'Le commentaire a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            if (ISSET($_SESSION['id_user_admin'])) {
                header('Location: ' . BASE_ADMIN_URL . 'comments/commentread/' . $id_comment);
                exit;

            } else {
                header('Location: ' . BASE_URL . 'extendedcard/commentread/' . $item . '/' . $id_comment);
                exit;
            }
        }
    }

    public function commentReported($id_item)
    {
        $messages['confirmation'] = 'Le commentaire a bien été signalé !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            if (ISSET($_SESSION['id_user'])) {
                header('Location: ' . BASE_URL . 'extendedcard/indexuser/' . $id_item . '/1/#comments');
                exit;
            } else {
                header('Location: ' . BASE_URL . 'extendedcard/' . $id_item . '/1/#comments');
                exit;
            }
        }
    }

    public function commentReportedAdmin($id_comment)
    {
        $messages['confirmation'] = 'Votre commentaire a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'commentsreported/commentreportedread/' . $id_comment);
            exit;
        }
    }

    public function commentApprovedAdmin($id_comment)
    {
        $messages['confirmation'] = 'Le commentaire a bien été approuvé !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'commentsreported/commentreportedread/' . $id_comment);
            exit;
        }
    }

    public function commentReportedMovedToBin()
    {
        $messages['confirmation'] = 'Le commentaire signalé a été déplacé dans la corbeille !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'commentsreported');
            exit;
        }
    }

    public function commentReportedErased()
    {
        $messages['confirmation'] = 'Merci ! Le commentaire a été supprimé définitivement!';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'commentsreported/commentsreportedbin');
            exit;
        }
    }

    public function commentReportedEmptyBin()
    {
        $messages['confirmation'] = 'Merci ! La corbeille a été vidée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'commentsreported/commentsreportedbin');
            exit;
        }
    }

    public function commentReportedRestored()
    {
        $messages['confirmation'] = 'Le commentaire a bien été restauré !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'commentsreported/commentsreportedbin');
            exit;
        }
    }

    public function commentMovedToBin()
    {
        $messages['confirmation'] = 'Le commentaire a été déplacé dans la corbeille !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'comments');
            exit;
        }
    }

    public function commentErased()
    {
        $messages['confirmation'] = 'Le commentaire a été supprimé définitivement!';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'comments/commentsbin');
            exit;
        }
    }

    public function commentEmptyBin()
    {
        $messages['confirmation'] = 'Merci ! La corbeille a été vidée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'comments/commentsbin');
            exit;
        }
    }

    public function commentRestored()
    {
        $messages['confirmation'] = 'Le commentaire a bien été restauré !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'comments/commentsbin');
            exit;
        }
    }


    // LINKS
    public function linkCreated()
    {
        $messages['confirmation'] = 'Votre lien a bien été ajouté !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'linksadmin');
            exit;
        }
    }

    public function linkUpdated($id_link)
    {
        $messages['confirmation'] = 'Le lien a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'linksadmin/linkread/' . $id_link);
            exit;
        }
    }

    public function linkMovedToBin()
    {
        $messages['confirmation'] = 'Le lien a été déplacé dans la corbeille !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'linksadmin');
            exit;
        }
    }

    public function linkErased()
    {
        $messages['confirmation'] = 'Le lien a été supprimé !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'linksadmin/linksbin');
            exit;
        }
    }

    public function linkEmptyBin()
    {
        $messages['confirmation'] = 'La corbeille a été vidée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'linksadmin/linksbin');
            exit;
        }
    }

    public function linkRestored()
    {
        $messages['confirmation'] = 'Le lien a bien été restauré !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'linksadmin/linksbin');
            exit;
        }
    }


    // PAGES

    public function pageCreated()
    {
        $messages['confirmation'] = 'Votre page a bien été ajoutée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'pagesadmin');
            exit;
        }
    }

    public function pageUpdated()
    {
        $messages['confirmation'] = 'Votre page a bien été ajoutée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'pagesadmin');
            exit;
        }
    }

    public function pageMovedToBin()
    {
        $messages['confirmation'] = 'La page a été déplacée dans la corbeille !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'pagesadmin');
            exit;
        }
    }

    public function pageErased()
    {
        $messages['confirmation'] = 'Votre page a bien été supprimée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'pagesadmin/pagesbin');
            exit;
        }
    }

    public function pageEmptyBin()
    {
        $messages['confirmation'] = 'La corbeille a été vidée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'pagesadmin/pagesbin');
            exit;
        }
    }

    public function pageRestored()
    {
        $messages['confirmation'] = 'La page a bien été restaurée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'pagesadmin/pagesbin');
            exit;
        }
    }


    // STYLES

    public function styleCreated()
    {
        $messages['confirmation'] = 'Le style a bien été ajouté !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'styles');
            exit;
        }
    }
    public function styleUpdated($id_style)
    {
        $messages['confirmation'] = 'Le style a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'styles/styleread/' . $id_style);
            exit;
        }
    }

    public function styleMovedToBin()
    {
        $messages['confirmation'] = 'Le style a été déplacé dans la corbeille !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'styles');
            exit;
        }
    }

    public function styleErased()
    {
        $messages['confirmation'] = 'Le style a été supprimé !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'styles/stylesbin');
            exit;
        }
    }

    public function styleEmptyBin()
    {
        $messages['confirmation'] = 'Merci ! La corbeille a été vidée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'styles/stylesbin');
            exit;
        }
    }

    public function styleRestored()
    {
        $messages['confirmation'] = 'Le style a bien été restauré !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'styles/stylesbin');
            exit;
        }
    }


    // USERS
    public function userUpdated()
    {
        $messages['confirmation'] = 'Votre compte a bien été mis à jour !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_URL . 'user');
            exit;
        }

    }

    public function userPasswordUpdated()
    {
        $messages['confirmation'] = 'Votre mot de passe a bien été mis à jour !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_URL . 'user');
            exit;
        }
    }

    public function userAccountUpdated($id_user)
    {
        $messages['confirmation'] = 'Le compte a bien été mis à jour !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'users/userread/' . $id_user);
            exit;
        }
    }

    public function userUsernameUpdated()
    {
        $messages['confirmation'] = 'Votre identifiant a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_URL . 'user/useredit#username');
            exit;
        }
    }

    public function userAvatarUpdated()
    {
        $messages['confirmation'] = 'Votre avatar a bien été modifié !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_URL . 'user');
            exit;
        }
    }

    public function userPasswordUpdatedFromLogin()
    {
        $messages['confirmation'] = 'Votre mot de passe a bien été mis à jour !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
    }

    public function userMovedToBin()
    {
        $messages['confirmation'] = 'L\'utilisateur a bien été déplacé dans la corbeille !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'users');
            exit;
        }
    }

    public function userErased()
    {
        $messages['confirmation'] = 'L\'utilisateur a bien été supprimé !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'users');
            exit;
        }
    }

    public function userEmptyBin()
    {

        $messages['confirmation'] = 'La corbeille a été vidée !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location:' . BASE_ADMIN_URL . 'users/usersbin');
            exit;
        }
    }

    public function userRestored()
    {
        $messages['confirmation'] = 'L\'utilisateur a bien été restauré !';
        if (!empty($messages)) {
            $_SESSION['messages'] = $messages;
            header('Location: ' . BASE_ADMIN_URL . 'users/usersbin');
            exit;
        }
    }


}
