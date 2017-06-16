<?php

namespace Entity;

Class Shipping{

    /**
    *
    * @var int
    */

    private $id_pul;


    /**
    *
    * @var string
    */

    private $name_pul;


    /**
    *
    * @var string
    */

    private $address_pul;


    /**
    *
    * @var int
    */

    private $phone_pul;

    /**
    *
    * @var string
    */

    private $hours;


    /**
    *
    * @var string
    */

    private $googlemaps_location;



    // getter

    public function getIdPul(){
        return $this->id_pul;
    }

    public function getNamePul(){
        return $this->name_pul;
    }

    public function getAdressPul(){
        return $this->adress_pul;
    }

    public function getPhonePul(){
        return $this->phone_pul;
    }

    public function getHours(){
        return $this->hours;
    }

    public function getGooglemapsLocation(){
        return $this->googlemapslocation;
    }

    // setter

    public function setIdPul($id_pul) {
    $this->id_pul = $id_pul;
    return $this;
    }

    public function setNamePul($name_pul) {
    $this->name_pul = $name_pul;
    return $this;
    }

    public function setAdressPul($adress_pul) {
    $this->adress_pul = $adress_pul;
    return $this;
    }

    public function setPhonePul($phone_pul) {
    $this->phone_pul = $phone_pul;
    return $this;
    }

    public function setHours($hours) {
    $this->hours = $hours;
    return $this;
    }

    public function setGooglemapsLovation($googlemaps_location) {
    $this->googlemaps_location = $googlemaps_location;
    return $this;
    }

}