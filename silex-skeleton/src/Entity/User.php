<?php

namespace Entity;

class User {

    private $id;

    private $email;

    private $password;

    private $lastname;

    private $firstname;

    private $address;

    private $zipCode;

    private $city;

    private $phone;

    private $status;



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

     public function getAddress() {
        return $this->address;
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

     public function getStatus() {
        return $this->status;
    }



      public function isAdmin() {
        return $this->status == 'admin';
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

    public function setAddress($address){
        $this->adress= $address;
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
        $this->phone= $phone;
        return $this;
    }

    public function setStatus($status){
        $this->status=$status;
        return $this;
    }

}