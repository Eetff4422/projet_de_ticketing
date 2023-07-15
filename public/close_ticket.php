<?php
require_once '../controller/TicketManagementController.php';
$controller = new TicketManagementController();
$ticketId = $_POST['ticketId'];
$controller->closeTicket($ticketId);
header('Location: admin.php'); 
?>
