<?php
require_once '../classes/Database.php';

class AdminModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getPDO();
    }

    // Method to get an admin by id
    public function getById($id) {
        $sql = "SELECT * FROM administrateurs WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        // Bind parameters
        $stmt->bindValue(':id', $id);

        // Execute the statement
        $stmt->execute();

        // Fetch the admin
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        return $admin;
    }

    // Add more methods as needed
}
?>
