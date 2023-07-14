<?php
require_once '../model/TicketModel.php';
require_once '../vendor/autoload.php';

class UserController {
    private $model;
    private $twig;

    public function __construct() {
        $this->model = new TicketModel();
        // Initialize the Twig environment
        $loader = new \Twig\Loader\FilesystemLoader('../view');
        $this->twig = new \Twig\Environment($loader);
    }

    public function create($idAdmin, $idClient, $numeroDemande, $typeDemande, $priorite, $sujet, $message) {
        // Use the model to create a new user
        $this->model->create($idAdmin, $idClient, $numeroDemande, $typeDemande, $priorite, $sujet, $message);

        // Redirect to the user list page (or wherever you want)
        // header('Location: user_list.php');
    }

    public function getById($id) {
        // Use the model to get a user by id
        $ticket = $this->model->getById($id);

        
        // Render the user detail view with the user data
        echo $this->twig->render('ticket_detail.html.twig', ['ticket' => $ticket]);
    }

    // Add more methods as needed
}
?>
