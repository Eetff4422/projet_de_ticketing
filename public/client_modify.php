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
    if ($_POST['form_type'] === 'choose') {
        $controller->modifyClient();
    } elseif ($_POST['form_type'] === 'update') {
        $controller->updateClient();
    }
    
} else {
    $controller->renderClientManagementPage();
}