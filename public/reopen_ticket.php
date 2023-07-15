<?php
require_once '../controller/TicketManagementController.php';
$controller = new TicketManagementController();
$ticketId = $_POST['ticketId'];
$controller->reopenTicket($ticketId);
header('Location: user.php'); 
?>
