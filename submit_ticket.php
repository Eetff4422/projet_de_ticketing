<?php
session_start();
if(!isset($_SESSION["clientId"])) {
    header("location:connexion.php");
    exit();
}

$clientId = $_SESSION['clientId'];

$id = mysqli_connect("127.0.0.1", "root", "", "ticketing");

if (!$id) {
    die("Erreur de connexion: " . mysqli_connect_error());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticketNumber = $_POST['ticketNumber'];
    $requestType = $_POST['requestType'];
    $priority = $_POST['priority'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    function assignTicket($id, $priority, $requestType) {
        // Récupérer tous les administrateurs
        $query = "SELECT id,poste FROM administrateurs";
        $stmt = mysqli_prepare($id, $query);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $admins = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
        $eligibleAdmins = []; // Pour stocker les administrateurs éligibles
        $quota = 10; // Définir le quota de tickets de haute priorité
        
        foreach ($admins as $admin) {
            $adminId = $admin['id'];
            $adminPoste = $admin['poste'];
    
            // Vérifier le nombre de tickets de priorité élevée et critique
            $query = "SELECT COUNT(*) as count FROM tickets WHERE idAdmin = ? AND (priorite = 'critique' OR priorite = 'élevée')";
            $stmt = mysqli_prepare($id, $query);
            mysqli_stmt_bind_param($stmt, 'i', $adminId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $count = mysqli_fetch_assoc($result)['count'];
    
            // Si l'administrateur a atteint le quota, passer à l'administrateur suivant
            if ($count >= $quota) {
                continue;
            }
    
            // Vérifier si le poste de l'administrateur correspond au type de demande du ticket
            switch($requestType) {
                case 'Hardware_Problem':
                case 'Software_Problem':
                    if($adminPoste !== 'technicien_de_support_informatique' && $adminPoste !== 'administrateur_système') {
                        continue 2;
                    }
                    break;
                case 'Network_Issue':
                    if($adminPoste !== 'ingénieur_réseau') {
                        continue 2;
                    }
                    break;
                case 'Access_Problem':
                    if($adminPoste !== 'gestionnaire_de_service_informatique') {
                        continue 2;
                    }
                    break;
                case 'Service_Request':
                    if($adminPoste !== 'administrateur_système' && $adminPoste !== 'gestionnaire_de_service_informatique') {
                        continue 2;
                    }
                    break;
            }
    
            // Si l'administrateur est éligible, l'ajouter à la liste
            $eligibleAdmins[] = $adminId;
        }
    
        // Si aucun administrateur éligible n'a été trouvé, assigner le ticket en fonction du nombre total de tickets
        if (count($eligibleAdmins) == 0) {
            $assignedTo = null;
            foreach ($admins as $admin) {
                $adminId = $admin['id'];
    
                // Vérifier le nombre total de tickets
                $query = "SELECT COUNT(*) as count FROM tickets WHERE idAdmin = ?";
                $stmt = mysqli_prepare($id, $query);
                mysqli_stmt_bind_param($stmt, 'i', $adminId);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $total = mysqli_fetch_assoc($result)['count'];
    
                if ($assignedTo === null || $total < $assignedTo['count']) {
                    $assignedTo = ['id' => $adminId, 'count' => $total];
                }
            }
            return $assignedTo['id'];
        } else {
            // Si des administrateurs éligibles ont été trouvés, assigner le ticket à un administrateur choisi au hasard
            return $eligibleAdmins[array_rand($eligibleAdmins)];
        }
    }
    
    $assignedTo = assignTicket($id, $priority, $requestType);
    


    $query = "INSERT INTO tickets (idAdmin, idClient, numeroDemande, typeDemande, priorite, sujet, message) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($id, $query);
    if ($stmt === false) {
        die('Erreur de préparation : ' . mysqli_error($id));
    }

    // Remarquez le 'i' au début pour l'ID de l'admin attribué, qui est un entier.
    mysqli_stmt_bind_param($stmt, 'iisssss', $assignedTo, $clientId, $ticketNumber, $requestType, $priority, $subject, $message);

    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "Ticket ajouté avec succès .... <br> Redirection en cours ....";
        mysqli_close($id);
        header("refresh:1;url=user.php");   
    } else {
         
        echo "Erreur : " . mysqli_error($id);
        mysqli_close($id);
    }
}

?>

