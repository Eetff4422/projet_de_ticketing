<?php
require_once '../controller/TicketManagementController.php';
require_once '../model/TicketModel.php';

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

$controller = new TicketManagementController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['clear_filters'])) {
        $controller->clearFilters($userId,$user);
    } else {
        if (isset($_GET['sort'])) {
            $controller->manageTicketsSpe($userId,$user);
        } else {
            $controller->manageTickets($userId,$user);
        }
    }
}

?>
