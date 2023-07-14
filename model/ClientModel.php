<?php
require_once '../classes/Database.php';

class ClientModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getPDO();
    }

    // Method to get a client by id
    public function getById($id) {
        $sql = "SELECT * FROM clients WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        // Bind parameters
        $stmt->bindValue(':id', $id);

        // Execute the statement
        $stmt->execute();

        // Fetch the ticket
        $client = $stmt->fetch(PDO::FETCH_ASSOC);

        return $client;
    }

    public function getAllClients($search = null, $sort = null) {
        $sql = "SELECT * FROM clients";
        if ($search) {
            $sql .= " WHERE nom LIKE :search";
        }
        if ($sort) {
            $sql .= " ORDER BY nom";
        }
        $stmt = $this->db->prepare($sql);
        if ($search) {
            $stmt->bindValue(':search', '%' . $search . '%');
        }
        $stmt->execute();
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $clients;
    }
    public function getDataClient($userId) {
        $sql = "SELECT * FROM users WHERE id = :userId";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        
        $stmt->execute();
        $client = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $client;
    }
    
    
    
    public function updateClient($id, $idUser, $nom, $prenom, $mail, $telephone) {
        // Préparer la requête
        $sql = "UPDATE clients SET nom = ?, prenom = ?, mail = ?, telephone = ? WHERE id = ? AND idUser = ?";
        $stmt = $this->db->prepare($sql);

        // Exécuter la requête
        if ($stmt->execute([$nom, $prenom, $mail, $telephone, $id, $idUser])) {
            return $stmt->rowCount();
        } else {
            throw new Exception("Erreur lors de l'exécution de la requête SQL");
        }
    }
   
    public function getAllClientNames() {
        $req = "SELECT nom FROM clients ORDER BY nom";
        $stmt = $this->db->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getClientByName($nom) {
        $req = "SELECT * FROM clients WHERE nom = ?";
        $stmt = $this->db->prepare($req);
        $stmt->execute([$nom]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
?>
