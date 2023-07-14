<?php

require_once '../model/TicketModel.php';
require_once '../vendor/autoload.php';

class TicketCreateController {
    private $twig;
    private $ticketModel;

    public function __construct() {
        $loader = new \Twig\Loader\FilesystemLoader('../view');
        $this->twig = new \Twig\Environment($loader);
        $this->ticketModel = new TicketModel();
    }

    public function createTicket() {
        /*session_start();
        if(!isset($_SESSION["clientId"])) {
            header("location:index.php");
            exit();
        }*/
        //$clientId = $_SESSION['clientId'];
        $ticketNumber = uniqid();
        echo $this->twig->render('create_ticket_view.html.twig', ['ticketNumber' => $ticketNumber]);
    }
}

