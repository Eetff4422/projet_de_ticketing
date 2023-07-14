<?php
require_once 'User.php';

class Client extends User {
    private $nom;
    private $prenom;
    private $mail;
    private $telephone;

    // Add getters and setters here
    public function getNom() {
        return $this->nom;
    }
    
    public function setNom($nom) {
        $this->nom = $nom;
    }
    
    public function getPrenom() {
        return $this->prenom;
    }
    
    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function getMail() {
        return $this->mail;
    }
    
    public function setMail($mail) {
        $this->mail = $mail;
    }
    
    public function getTelephone() {
        return $this->telephone;
    }
    
    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }
}
?>
