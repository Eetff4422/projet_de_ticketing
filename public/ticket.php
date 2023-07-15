<?php

require_once '../controller/TicketManagementController.php';

$controller = new TicketManagementController();
session_start();

if(isset($_SESSION['adminId'])){
    $userId = $_SESSION['adminId'];
    $user = 'admin';
}elseif(isset($_SESSION['clientId'])){
    $userId = $_SESSION['clientId'];
    $user = 'client';
} else {
    // Handle the case where neither adminId nor clientId is set
    die('No user is logged in');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['newMessage'])) {
        // Handle the discussion form submission
        $controller->handleDiscussionForm($user);
    } else if (isset($_POST['ticketId'])) {
        // Handle the ticket details form submission
        $ticketId = $_POST['ticketId'];
        $controller->showTicketDetails($ticketId,$user);
    }
}

?>
