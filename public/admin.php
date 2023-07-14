<?php

require_once '../controller/AdminController.php';
session_start();

if(isset($_SESSION['adminId'])){
    $userId = $_SESSION['adminId']['id'];
}elseif(isset($_SESSION['clientId'])){
    $userId = $_SESSION['clientId']['id'];
} else {
    // Handle the case where neither adminId nor clientId is set
    die('No user is logged in');
}
$controller = new AdminController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleAdminChoice();
}
else{
    $controller->renderAdminPage();
}