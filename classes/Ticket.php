<?php
class Ticket {
    private $id;
    private $idAdmin;
    private $idClient;
    private $numeroDemande;
    private $typeDemande;
    private $priorite;
    private $sujet;
    private $message;

    // Add getters and setters here
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getidAdmin() {
        return $this->idAdmin;
    }
    
    public function setidAdmin($idAdmin) {
        $this->idAdmin = $idAdmin;
    }

    public function getidClient() {
        return $this->idClient;
    }
    
    public function setidClient($idClient) {
        $this->idClient = $idClient;
    }
    
    public function getnumeroDemande() {
        return $this->numeroDemande;
    }
    
    public function setnumeroDemande($numeroDemande) {
        $this->numeroDemande = $numeroDemande;
    }
    public function gettypeDemande() {
        return $this->typeDemande;
    }
    
    public function settypeDemande($typeDemande) {
        $this->typeDemande = $typeDemande;
    }
    
    public function getPriorite() {
        return $this->priorite;
    }
    
    public function setPriorite($priorite) {
        $this->priorite = $priorite;
    }

    public function getSujet() {
        return $this->sujet;
    }
    
    public function setSujet($sujet) {
        $this->sujet = $sujet;
    }
    
    public function getMessage() {
        return $this->message;
    }
    
    public function setMessage($message) {
        $this->message = $message;
    }
}
?>
