<?php
class User {
    private $id;
    private $username;
    private $password;
    private $isAdmin;
    private $poste;
    private $nom;
    private $prenom;
    private $mail;
    private $telephone;

    // Add getters and setters here
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }
    
    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function getisAdmin() {
        return $this->isAdmin;
    }
    
    public function setisAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
    }
    
    public function getPoste() {
        return $this->poste;
    }
    
    public function setPoste($poste) {
        $this->poste = $poste;
    }
    
    public function getNom() {
        return $this->nom;
    }
    
    public function setNom($nom) {
        $this->poste = $nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }
    
    public function setPrenom($prenom) {
        $this->poste = $prenom;
    }
    public function getMail() {
        return $this->mail;
    }
    
    public function setMail($mail) {
        $this->poste = $mail;
    }
    public function getTelephone() {
        return $this->telephone;
    }
    
    public function setTelephone($telephone) {
        $this->poste = $telephone;
    }
}
?>
