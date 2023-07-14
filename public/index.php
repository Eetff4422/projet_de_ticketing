<?php

require_once '../vendor/autoload.php';
require_once '../controller/AuthController.php';
require_once '../controller/ClientManagementController.php';
require_once '../controller/TicketManagementController.php';

$loader = new \Twig\Loader\FilesystemLoader('../view');
$twig = new \Twig\Environment($loader);

$authController = new AuthController($twig);
$clientManagementController = new ClientManagementController($twig);
$ticketManagementController = new TicketManagementController($twig);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'login':
                $username = $_POST['username'];
                $password = $_POST['mdp'];
                $authController->login($username, $password);
                break;
            case 'client_management':
                $clientManagementController->renderClientManagementPage();
                break;
            case 'client_list':
                    $clientManagementController->manageClients();
                    break;
            default:
                echo "Invalid action";
                exit();
        }
    }
} else {
    $authController->render('login.html.twig');
}
