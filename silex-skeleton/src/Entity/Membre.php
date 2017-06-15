<?php

namespace Entity;

class User {

    private $id;

    private $email;

    private $password;

    private $lastname;

    private $name;

    private $adresse;

    private $code_postal;

    private $ville;

    private $telephone;

    private $statut;

    

    //GETTER
    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getFirstname() {
        return $this->lastname;
    }

     public function getAdresse() {
        return $this->adresse;
    }

    public function getCode_postal() {
        return $this->code_postal;
    }

    public function getVille() {
        return $this->ville;
    }

     public function getTelephone() {
        return $this->telephone;
    }

     public function getStatut() {
        return $this->statut;
    }
    


      public function isAdmin() {
        return $this->statut == 'admin';
    }


    //Setter
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password){
        $this->password=$password;
        return $this;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
        return $this;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
        return $this;
    }

    public function setAdresse($adresse){
        $this->adresse= $adresse;
        return $this;
    }

    public function setCode_postal($code_postal){
        $this->code_postal= $code_postal;
        return $this;
    }

    public function setVille($ville){
        $this->ville= $ville;
        return $this;
    }

    public function setTelephone($telephone){
        $this->telephone= $telephone;
        return $this;
    }

    public function setstatut($statut){
        $this->statut=$statut;
        return $this;
    }

}