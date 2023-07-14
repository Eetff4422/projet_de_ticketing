<?php
require_once '../model/AdminModel.php';
require_once '../vendor/autoload.php';

class AdminController {
    private $model;
    private $twig;

    public function __construct() {
        $this->model = new AdminModel();
        // Initialize the Twig environment
        $loader = new \Twig\Loader\FilesystemLoader('../view');
        $this->twig = new \Twig\Environment($loader);
    }


    public function getById($id) {
        // Use the model to get a user by id
        $admin = $this->model->getById($id);

        // Render the user detail view with the user data
        echo $this->twig->render('admin_detail.html.twig', ['admin' => $admin]);
    }

    public function handleAdminChoice() {
        if(isset($_POST["choice"])){
            $choice = $_POST["choice"];
            if ($choice == "client") {
                header("location:/projet_web/public/client_management.php");
            } else if ($choice == "ticket") {
                header("location:/projet_web/public/ticket_management.php");
            }
        } else {
            $this->renderAdminPage("Veuillez sélectionner un choix.");
        }
    }

    public function renderAdminPage($erreur = null) {
        echo $this->twig->render('admin.html.twig', ['erreur' => $erreur]);
    }
}
?>
