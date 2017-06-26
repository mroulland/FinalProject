<?php

namespace Entity;

Class Pickuplocation{

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
    private $zipcode_pul;
    
    /**
     *
     * @var string
     */
    private $city_pul;

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

    public function getAddressPul(){
        return $this->address_pul;
    }
    
    public function getZipcodePul(){
        return $this->zipcode_pul;
    }
    
    public function getCityPul(){
        return $this->city_pul;
    }
    
    public function getPhonePul(){
        return $this->phone_pul;
    }

    public function getHours(){
        return $this->hours;
    }

    public function getGooglemapsLocation(){
        return $this->googlemaps_location;
    }

    // setter
    /**
     * 
     * @param int $id_pul
     * @return $this
     */
    public function setIdPul($id_pul) {
        $this->id_pul = $id_pul;
        return $this;
    }

    public function setNamePul($name_pul) {
        $this->name_pul = $name_pul;
        return $this;
    }

    public function setAddressPul($address_pul) {
        $this->address_pul = $address_pul;
        return $this;
    }

    public function setZipcodePul($zipcode_pul) {
        $this->zipcode_pul = $zipcode_pul;
        return $this;
    }
    
    public function setCityPul($city_pul) {
        $this->city_pul = $city_pul;
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

    public function setGooglemapsLocation($googlemaps_location) {
        $this->googlemaps_location = $googlemaps_location;
        return $this;
    }

}