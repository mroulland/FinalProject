<?php

namespace Entity;

class User {

    private $id;

    private $lastname;

    private $name;

    private $phone;

    private $email;

    private $password;

    private $status;

    

    //Getter-Setter
    public function getId() {
        return $this->id;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getFirstname() {
        return $this->lastname;
    }

     public function getPhone() {
        return $this->email;
    }

     public function getEmail() {
        return $this->email;
    }

     public function getPassword() {
        return $this->password;
    }

     public function getStatus() {
        return $this->status;
    }
    


}