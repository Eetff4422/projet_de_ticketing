<?php
require_once '../controller/ClientManagementController.php';
require_once '../model/ClientModel.php';
session_start();

if(isset($_SESSION['adminId'])){
    $userId = $_SESSION['adminId']['id'];
}elseif(isset($_SESSION['clientId'])){
    $userId = $_SESSION['clientId']['id'];
} else {
    // Handle the case where neither adminId nor clientId is set
    die('No user is logged in');
}
$controller = new ClientManagementController();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['client_choice'] == 'client_list'){
        $controller->manageClients();
    } elseif($_POST['client_choice'] == 'client_modify'){
        $controller->modifyClient();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['clear_filters'])) {
        $controller->clearFilters();
    } else {
        $controller->manageClientsSpe();
    }
} else {
    $controller->renderClientManagementPage();
}