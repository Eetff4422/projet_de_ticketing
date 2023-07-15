<?php
require_once '../classes/Database.php';

class TicketModel {
    private $db;
    protected $error;

    public function __construct() {
        $this->db = (new Database())->getPDO();
    }

    // Method to create a new ticket
    public function create($idAdmin, $idClient, $numeroDemande, $typeDemande, $priorite, $sujet, $message) {
        $sql = "INSERT INTO tickets (idAdmin, idClient, numeroDemande, typeDemande, priorite, sujet, message) VALUES (:idAdmin, :idClient, :numeroDemande, :typeDemande, :priorite, :sujet, :message)";
        $stmt = $this->db->prepare($sql);

        // Bind parameters
        $stmt->bindValue(':idAdmin', $idAdmin);
        $stmt->bindValue(':idClient', $idClient);
        $stmt->bindValue(':numeroDemande', $numeroDemande);
        $stmt->bindValue(':typeDemande', $typeDemande);
        $stmt->bindValue(':priorite', $priorite);
        $stmt->bindValue(':sujet', $sujet);
        $stmt->bindValue(':message', $message);

        // Execute the statement
        $stmt->execute();
    }

    // Method to get a ticket by id
    public function getById($id) {
        $sql = "SELECT * FROM tickets WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        // Bind parameters
        $stmt->bindValue(':id', $id);

        // Execute the statement
        $stmt->execute();

        // Fetch the ticket
        $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

        return $ticket;
    }

    public function getAllTickets($userId, $search = null, $sort = null) {
        $sql = "SELECT * FROM tickets WHERE idAdmin = :userId1 OR idClient = :userId2";
        if ($search) {
            $sql .= " AND sujet LIKE :search";
        }
        if ($sort) {
            $sql .= " ORDER BY date";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':userId1', $userId['id']);
        $stmt->bindValue(':userId2', $userId['id']);
        if ($search) {
            $stmt->bindValue(':search', '%' . $search . '%');
        }
        $stmt->execute();
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tickets;
    }
    
    
    public function assignTicket($priority, $requestType) {
        // Récupérer tous les administrateurs
        $query = "SELECT id,poste FROM administrateurs";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $eligibleAdmins = []; // Pour stocker les administrateurs éligibles
        $quota = 10; // Définir le quota de tickets de haute priorité
    
        foreach ($admins as $admin) {
            $adminId = $admin['id'];
            $adminPoste = $admin['poste'];
    
            // Vérifier le nombre de tickets de priorité élevée et critique
            $query = "SELECT COUNT(*) as count FROM tickets WHERE idAdmin = :adminId AND (priorite = 'critique' OR priorite = 'élevée')";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':adminId', $adminId);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
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
                $query = "SELECT COUNT(*) as count FROM tickets WHERE idAdmin = :adminId";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':adminId', $adminId);
                $stmt->execute();
                $total = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
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
    

    public function submitTicket($assignedTo, $clientId, $ticketNumber, $requestType, $priority, $subject, $message, $statut, $date) {
        $query = "INSERT INTO tickets (idAdmin, idClient, numeroDemande, typeDemande, priorite, sujet, message, statut, date) 
                  VALUES (:assignedTo, :clientId, :ticketNumber, :requestType, :priority, :subject, :message, :statut, :date)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':assignedTo', $assignedTo);
        $stmt->bindValue(':clientId', $clientId);
        $stmt->bindValue(':ticketNumber', $ticketNumber);
        $stmt->bindValue(':requestType', $requestType);
        $stmt->bindValue(':priority', $priority);
        $stmt->bindValue(':subject', $subject);
        $stmt->bindValue(':message', $message);
        $stmt->bindValue(':statut', $statut);
        $stmt->bindValue(':date', $date);
        try {
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }
    
    public function getError() {
        return $this->error;
    }
    


    public function getDiscussion($ticketId) {
        $sql = "SELECT * FROM discussion WHERE ticketId = :ticketId ORDER BY date";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':ticketId', $ticketId);
        $stmt->execute();
        $discussion = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $discussion;
    }


    public function addMessageToDiscussion($ticketId, $sender, $message) {
        $sql = "INSERT INTO discussion (ticketId, sender, message) VALUES (:ticketId, :sender, :message)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':ticketId', $ticketId);
        $stmt->bindValue(':sender', $sender);
        $stmt->bindValue(':message', $message);
        $stmt->execute();
    }
    public function closeTicket($ticketId) {
        $sql = "UPDATE tickets SET statut = 'Fermé' WHERE id = :ticketId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':ticketId', $ticketId);
        return $stmt->execute();
    }

    public function reopenTicket($ticketId) {
        $sql = "UPDATE tickets SET statut = 'Ouvert' WHERE id = :ticketId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':ticketId', $ticketId);
        return $stmt->execute();
    }
    
}
?>
