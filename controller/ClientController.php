<?php
require_once '../model/ClientModel.php';
require_once '../vendor/autoload.php';

class ClientController {
    private $model;
    private $twig;

    public function __construct() {
        $this->model = new ClientModel();
        // Initialize the Twig environment
        $loader = new \Twig\Loader\FilesystemLoader('../view');
        $this->twig = new \Twig\Environment($loader);
    }


    public function getById($id) {
        // Use the model to get a user by id
        $client = $this->model->getById($id);

        // Render the user detail view with the user data
        echo $this->twig->render('client_detail.html.twig', ['client' => $client]);
    }

    public function handleClientChoice() {
        if(isset($_POST["choice"])){
            $choice = $_POST["choice"];
            if ($choice == "create_ticket") {
                header("location:create_ticket.php");
            } else if ($choice == "consult_ticket") {
                header("location:ticket_management.php");
            }else if ($choice == "informations"){
                header("location:informations.php");
            }
        } else {
            $this->renderClientPage("Veuillez sélectionner un choix.");
        }
    }

    public function renderClientPage($erreur = null) {
        echo $this->twig->render('client.html.twig', ['erreur' => $erreur]);
    }
}
?>
