<?php
require_once '../controller/TicketCreationController.php';
require_once '../model/TicketModel.php';
session_start();

if(isset($_SESSION['adminId'])){
    $userId = $_SESSION['adminId']['id'];
}elseif(isset($_SESSION['clientId'])){
    $userId = $_SESSION['clientId']['id'];
} else {
    // Handle the case where neither adminId nor clientId is set
    die('No user is logged in');
}


$controller = new TicketCreateController();
$controller->createTicket();