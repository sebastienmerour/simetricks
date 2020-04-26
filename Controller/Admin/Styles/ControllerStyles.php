<?php
require_once 'Framework/Controller.php';
require_once 'Model/Style.php';

/**
 * Contrôleur gérant les Styles depuis l'administration du site
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerStyles extends Controller
{
    private $style;

    public function __construct()
    {
        $this->style     = new Style();
    }


    // CREATE

    // Affichage du formulaire de création d'un style :
    public function styleadd()
    {
        $this->generateadminView();
    }

    // Processus de création d'un style :
    public function createstyle()
    {
        if (isset($_POST["create"])) {
            $name         = $_POST['name'];
            $description  = $_POST['description'];
            $hexadecimal  = $_POST['hexadecimal'];

            if (empty($name) || empty($hexadecimal)) {
                $errors['errors'] = 'Veuillez remplir tous les champs !';
                if (!empty($errors)) {
                    $_SESSION['errors'] = $errors;
                    header('Location: ' . BASE_ADMIN_URL . 'styles/styleadd');
                    exit;
                }
            }
            else {
            $this->style->insertStyle($name, $description, $hexadecimal);
          }
        }
    }

    // READ

    // Affichage de la page Styles : :
    public function index()
    {
        $styles           = $this->style->getStyles();
        $this->generateadminView(array(
            'styles' => $styles
        ));
    }

    // Affichage d'un style seul :
    public function styleread()
    {

        $id_style    = $this->request->getParameter("id");
        $style       = $this->style->getStyle($id_style);
        $this->generateadminView(array(
            'style' => $style
        ));
    }


    // UPDATE

    // Modification d'un style :
    public function updatestyle()
    {
        if (isset($_POST["update"])) {
            $id_style     = $this->request->getParameter("id");
            $name         = $this->request->getParameter("name");
            $description  = $this->request->getParameter("description");
            $hexadecimal  = $this->request->getParameter("hexadecimal");
            $this->style->changeStyle($id_style, $name, $description, $hexadecimal);
        }
    }

    // Restaurer un Style depuis la Corbeille :
    public function restorethisstyle()
    {
        $id_style = $this->request->getParameter("id");
        $this->category->restoreStyle($id_style);
    }


    // DELETE

    // Affichage de la Corbeille Styles :
    public function stylesbin()
    {
        $styles_deleted          = $this->style->getStylesDeleted();
        $this->generateadminView(array(
            'styles_deleted' => $styles_deleted
        ));
    }

    // Déplacer un style vers la Corbeille :
    public function movestyletobin()
    {
        $id_style = $this->request->getParameter("id");
        $this->style->moveStyle($id_style);
    }

    // Suppression définitive d'un Style :
    public function removestyle()
    {
        $id_style = $this->request->getParameter("id");
        $this->style->eraseCategory($id_style);
        if ($id_style === false) {
            throw new Exception('Impossible de supprimer le style !');
        } else {
            $messages['confirmation'] = 'Le Style a bien été supprimé !';
            $this->generateadminView();
        }
    }

    // Vider la Corbeille Styles :
    public function emptycategories()
    {
        $this->style->emptybin();
    }

}
