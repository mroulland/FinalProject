<?php

namespace Entity;

class User {

    private $id;

    private $email;

    private $password;

    private $lastname;

    private $firstname;

    private $adress;

    private $zipCode;

    private $city;

    private $phone;

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
        return $this->firstname;
    }

     public function getAdress() {
        return $this->adress;
    }

    public function getZipCode() {
        return $this->zipCode;
    }

    public function getCity() {
        return $this->city;
    }

     public function getPhone() {
        return $this->phone;
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

    public function setAdress($adress){
        $this->adress= $adress;
        return $this;
    }

    public function setZipCode($zipCode){
        $this->zipCode= $zipCode;
        return $this;
    }

    public function setCity($city){
        $this->city= $city;
        return $this;
    }

    public function setPhone($phone){
        $this->phone= phone;
        return $this;
    }

    public function setstatut($statut){
        $this->statut=$statut;
        return $this;
    }

}