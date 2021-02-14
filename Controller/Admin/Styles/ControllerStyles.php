<?php
require_once 'Framework/Controller.php';
require_once 'Model/Style.php';
require_once 'Model/Message.php';
require_once 'Model/Calculate.php';

/**
 * Contrôleur gérant les Styles depuis l'administration du site
 *
 * @version 1.0
 * @author Sébastien Merour
 */

class ControllerStyles extends Controller
{
    private $style;
    private $message;
    private $calculate;

    public function __construct()
    {
        $this->style     = new Style();
        $this->message     = new Message();
        $this->calculate     = new Calculate();
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
            $this->message->styleCreated();
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
            $this->message->styleUpdated($id_style);
        }
    }

    // Restaurer un Style depuis la Corbeille :
    public function restorethisstyle()
    {
        $id_style = $this->request->getParameter("id");
        $this->category->restoreStyle($id_style);
        $this->message->styleRestored();
    }


    // DELETE

    // Affichage de la Corbeille Styles :
    public function stylesbin()
    {
        $styles_deleted          = $this->style->getStylesDeleted();
        $number_of_styles_deleted =  $this->calculate->getTotalOfStylesDeleted();
        $this->generateadminView(array(
            'styles_deleted' => $styles_deleted,
            'number_of_styles_deleted'=> $number_of_styles_deleted
        ));
    }

    // Déplacer un style vers la Corbeille :
    public function movestyletobin()
    {
        $id_style = $this->request->getParameter("id");
        $this->style->moveStyle($id_style);
        $this->message->styleMovedToBin();
    }

    // Suppression définitive d'un Style :
    public function removestyle()
    {
        $id_style = $this->request->getParameter("id");
        $this->style->eraseCategory($id_style);
        $this->message->styleErased();
    }

    // Vider la Corbeille Styles :
    public function emptystyles()
    {
        $this->style->emptybin();
        $this->message->styleEmptyBin();
    }

}
