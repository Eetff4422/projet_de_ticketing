<?php
require_once '../model/TicketModel.php';
session_start();

if (isset($_SESSION['adminId'])) {
    $userId = $_SESSION['adminId']['id'];
} elseif (isset($_SESSION['clientId'])) {
    $userId = $_SESSION['clientId']['id'];
} else {
    // Handle the case where neither adminId nor clientId is set
    die('No user is logged in');
}

$ticketModel = new TicketModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form data and call the model's method to insert the ticket
    $clientId = $userId;
    $ticketNumber = $_POST['ticketNumber'];
    $requestType = $_POST['requestType'];
    $priority = $_POST['priority'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $date = date('Y-m-d H:i:s'); // Date et heure actuelles
    $statut = 'Ouvert'; // Valeur par défaut : Ouvert

    $assignedTo = $ticketModel->assignTicket($priority, $requestType);
    $result = $ticketModel->submitTicket($assignedTo, $clientId, $ticketNumber, $requestType, $priority, $subject, $message, $statut, $date);

    if ($result) {
        echo "Ticket ajouté avec succès .... <br> Redirection en cours ....";
        header("refresh:1;url=user.php");
    } else {
        echo "Erreur : " . $ticketModel->getError();
    }
}
