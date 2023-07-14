<?php

require_once '../model/TicketModel.php';
require_once '../model/UserModel.php';
require_once '../vendor/autoload.php';

class TicketManagementController {
    private $ticketModel;
    private $userModel;
    private $twig;

    public function __construct() {
        $this->ticketModel = new TicketModel();
        $this->userModel = new UserModel();
        $loader = new \Twig\Loader\FilesystemLoader('../view');
        $this->twig = new \Twig\Environment($loader);
    }

    public function manageTickets($userId, $user) {
        $search = $_GET['search'] ?? null;
        $sort = $_GET['sort'] ?? null;
        //$username = $_POST['username'] ?? null; 
        //$userId = $this->userModel->getUserIdByUsername($username);
        $tickets = $this->ticketModel->getAllTickets($userId, $search, $sort);
    
        echo $this->twig->render('ticket_management.html.twig', ['tickets' => $tickets, 'user' => $user]);
    }
    

    public function manageTicketsSpe($userId,$user){
        // Check if search or sort parameters are set
        $search = $_GET['search'] ?? null;
        $sort = $_GET['sort'] ?? null;
        //$username = $_POST['username'] ?? null;
        // If they are, fetch the tickets and display them
        if ($search || $sort) {
            //$userId = $this->userModel->getUserIdByUsername($username);
            $tickets = $this->ticketModel->getAllTickets($userId, $search, $sort);
            echo $this->twig->render('ticket_management.html.twig', ['tickets' => $tickets, 'user' => $user]);
        } else {
            echo $this->renderTicketManagementPage("Veuillez sélectionner un choix.");
        }
    }

    public function clearFilters($userId,$user) {
        $search = $_GET['search'] ?? null;
        $sort = $_GET['sort'] ?? null;
        //$username = $_POST['username'] ?? null; 
        //$userId = $this->userModel->getUserIdByUsername($username);
        $tickets = $this->ticketModel->getAllTickets($userId, $search, $sort);
        echo $this->twig->render('ticket_management.html.twig', ['tickets' => $tickets, 'user' => $user]); 
    }

    public function renderTicketManagementPage($erreur = null) {
        echo $this->twig->render('ticket_management.html.twig', ['erreur' => $erreur]);
    }

    public function showTicketDetails($ticketId, $error = null) {
        $ticket = $this->ticketModel->getById($ticketId);
        $discussion = $this->ticketModel->getDiscussion($ticketId);
        echo $this->twig->render('ticket_detail.html.twig', ['ticket' => $ticket, 'discussion' => $discussion, 'error' => $error]);
    }
    

    public function handleDiscussionForm($user) {
        if (isset($_POST['newMessage']) && !empty($_POST['newMessage'])) {
            // Determine the sender based on the current session
            $sender = $user == 'admin' ? 'admin' : 'client';
            $this->ticketModel->addMessageToDiscussion($_POST['ticketId'], $sender, $_POST['newMessage']);
            $this->showTicketDetails($_POST['ticketId']);
        } else {
            $this->showTicketDetails($_POST['ticketId'], "Veuillez entrer un message.");
        }
    }

}
