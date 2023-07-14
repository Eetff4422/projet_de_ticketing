<?php
require_once '../classes/Database.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getPDO();
    }

    // Method to create a new user
    public function create($username, $password, $isAdmin, $poste) {
        $sql = "INSERT INTO users (username, mdp, isAdmin, poste) VALUES (:username, :password, :isAdmin, :poste)";
        $stmt = $this->db->prepare($sql);

        // Bind parameters
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':isAdmin', $isAdmin);
        $stmt->bindValue(':poste', $poste);

        // Execute the statement
        $stmt->execute();
    }

    public function getUserIdByUsername($username) {
        $sql = "SELECT id FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if a user was found and return the ID. If no user was found, return null.
        return $result ? $result['id'] : null;
    }
    

    // Method to get a user by id
    public function getById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        // Bind parameters
        $stmt->bindValue(':id', $id);

        // Execute the statement
        $stmt->execute();

        // Fetch the ticket
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    public function getByUsernameAndPassword($username, $password) {
        $sql = "SELECT * FROM users WHERE username = :username AND mdp = :password";
        $stmt = $this->db->prepare($sql);
    
        // Bind parameters
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);
    
        // Execute the statement
        $stmt->execute();
    
        // Fetch the user
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $user;
    }

    public function getByAdminId($id) {
        $sql = "SELECT id FROM administrateurs WHERE idUser = :id";
        $stmt = $this->db->prepare($sql);

        // Bind parameters
        $stmt->bindValue(':id', $id);

        // Execute the statement
        $stmt->execute();

        // Fetch the ticket
        $adminId = $stmt->fetch(PDO::FETCH_ASSOC);

        return $adminId;
    }

    public function getByClientId($id) {
        $sql = "SELECT id FROM clients WHERE idUser = :id";
        $stmt = $this->db->prepare($sql);

        // Bind parameters
        $stmt->bindValue(':id', $id);

        // Execute the statement
        $stmt->execute();

        // Fetch the ticket
        $clientId = $stmt->fetch(PDO::FETCH_ASSOC);

        return $clientId;
    }

    
}
?>
