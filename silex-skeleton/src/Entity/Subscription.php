<?php

namespace Entity;

Class Subscription {
    /**
    *
    *@var int
    */
    private $id_subscription;

    /**
    *
    *@var int
    */
    private $id_user;
    /**
    *
    *@var int
    */
    private $id_product;

    /**
    *
    *@var int
    */
    private $id_shipping;

    /**
    *
    *@var date
    */
    private $start_date;

    /**
    *
    *@var date
    */
    private $end_date;

    /**
    *
    *@var periodicite
    */
    private $frequency;


    /**
    *
    *@var soft delete
    *
    */
    private $soft_delete

    public function getIdsubscription(){
        return $this->id_subscription;
    }

    public function getIduser(){
        return $this->id_user;
    }

    public function getIdProduct(){
        return $this->id_product;
    }

    public function getIdShipping(){
        return $this->id_shipping;
    }

    public function getStartDate(){
        return $this->start_date;
    }

    public function getEndDate(){
        return $this->end_date;
    }

    public function getFrequency(){
        return $this->frequency;
    }

    public function getSoftDelete(){
        return $this->soft_delete;
    }


    public function setIdSubscription($id_subscription) {
        $this->id_subscription = $id_subscription;
        return $this;
    }

    public function setIdUser($id_user) {
        $this->id_user = $id_user;
        return $this;
    }

    public function setIdproduct($id_product) {
        $this->id_product = $id_product;
        return $this;
    }

    public function setIdshipping($id_shipping) {
        $this->id_shipping = $id_shipping;
        return $this;
    }

    public function setStartDate($start_date) {
        $this->start_date = $start_date;
        return $this;
    }

    public function setEndDate($end_date) {
        $this->end_date = $end_date;
        return $this;
    }

    public function setSoftDelete($soft_delete){
        $this->soft_delete =$soft_delete;
        return $this;
    }

}