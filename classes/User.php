<?php
class User {
    private $id;
    private $username;
    private $password;
    private $isAdmin;
    private $poste;

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
    
    
}
?>
