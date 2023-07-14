<?php
require_once '../model/ClientModel.php';
require_once '../model/UserModel.php';
require_once '../vendor/autoload.php';

class ClientManagementController {
    private $clientModel;
    private $userModel;
    private $twig;

    public function __construct() {
        $this->clientModel = new ClientModel();
        $this->userModel = new UserModel();
        $loader = new \Twig\Loader\FilesystemLoader('../view');
        $this->twig = new \Twig\Environment($loader);
    }

    public function manageClients() {
        if(isset($_POST["client_choice"])){
            $client_choice = $_POST["client_choice"];
            if ($client_choice == "client_list"){
                $search = $_GET['search'] ?? null;
                $sort = $_GET['sort'] ?? null;
                $clients = $this->clientModel->getAllClients($search, $sort);
                echo $this->twig->render('client_list.html.twig', ['clients' => $clients]);
            } elseif($client_choice == "client_modify"){
                $this->modifyClient();
            }
        }
    }

    public function manageOnlyClients($userId) {    
        $client = $this->clientModel->getDataClient($userId);
        echo $this->twig->render('client_infos.html.twig', ['client' => $client]); 
    }

    public function modifyClient() {
        if(isset($_POST["modify"])){
            $nom = $_POST["modify"];
            $client = $this->clientModel->getClientByName($nom);
            echo $this->twig->render('client_modify.html.twig', ['client' => $client]);
        } else {
            $clients = $this->clientModel->getAllClients();
            echo $this->twig->render('client_modify.html.twig', ['clients' => $clients]);
        }
    }
    
    

    public function clearFilters() {
        $search = $_GET['search'] ?? null;
        $sort = $_GET['sort'] ?? null;
        $clients = $this->clientModel->getAllClients($search, $sort);
        echo $this->twig->render('client_list.html.twig', ['clients' => $clients]); 
    }

    public function manageClientsSpe(){
            // Check if search or sort parameters are set
            $search = $_GET['search'] ?? null;
            $sort = $_GET['sort'] ?? null;
    
            // If they are, fetch the clients and display them
            if ($search || $sort) {
                $clients = $this->clientModel->getAllClients($search, $sort);
                echo $this->twig->render('client_list.html.twig', ['clients' => $clients]);
            } else {
                echo $this->renderClientManagementPage("Veuillez sélectionner un choix.");
            }
        }
    

    public function renderClientManagementPage($erreur = null) {
        echo $this->twig->render('client_management.html.twig', ['erreur' => $erreur]);
    }


    public function updateClient() {
            $id = $_POST["id"];
            $idUser = $_POST["idUser"];
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $mail = $_POST["mail"];
            $telephone = $_POST["telephone"];

        
            // valider les données
            $errors = [];
        
            if (!preg_match("/^[a-zA-Z-' ]*$/",$nom)) {
                $errors[] = "Le nom ne doit contenir que des lettres et des espaces.";
            }
            if (!preg_match("/^[a-zA-Z-' ]*$/",$prenom)) {
                $errors[] = "Le prénom ne doit contenir que des lettres et des espaces.";
            }
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'adresse e-mail n'est pas valide.";
            }
            if (!preg_match("/^[0-9]*$/",$telephone)) {
                $errors[] = "Le numéro de téléphone doit contenir uniquement des chiffres.";
            }
        
            if (!empty($errors)) {
                echo $this->twig->render('client_modify.html.twig', ['errors' => $errors]);
            } else {
                // mettre à jour le client
                $rowCount = $this->clientModel->updateClient($id, $idUser, $nom, $prenom, $mail, $telephone);
                if ($rowCount > 0) {
                    $message = "La mise à jour du client a été effectuée avec succès.";
                    echo $this->twig->render('client_modify.html.twig', ['message' => $message]);
                } else {
                    $message = "Une erreur s'est produite lors de la mise à jour du client.";
                    echo $this->twig->render('client_modify.html.twig', ['message' => $message]);
                }
            }
        }
 
}
