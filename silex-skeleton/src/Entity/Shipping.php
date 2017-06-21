<?php

namespace Entity;

Class Shipping{

    /**
    *
    *@var int
    */

    private $id_shipping;

    /**
    *
    *@var string
    */

    private $mode;


    /**
    *
    *@var string
    */

    private $shipment_status;


    /**
    *
    *@var decimal
    */

    private $shipping_fees;

    /**
    *
    *@var decimal
    */

    private $id_pul;



    /**
     * Associated user.
     * @var \Entity\user
     */
    private $user;



    /**
     * Associated sub.
     * @var \Entity\Subscription
     */
    private $subscription;


    // getter

    public function getIdshipping(){
        return $this->id_shipping;
    }

    public function  getMode(){
        return $this->mode;
    }

    public function getShipmentStatus(){
        return  $this->shipment_status;
    }

    public function getShippingFees(){
            return $this->shipping_fees;
    }

    public function getIdPul(){
            return $this->id_pul;
    }

    public function getUser() {
        return $this->user;
    }

    public function getSubscription() {
        return $this->subscription;
    }



    //setter

    public function setIdShipping(){
        $this->id_shipping = $id_shipping;
        return $this;
    }

    public function setMode(){
        $this->mode = $mode;
        return $this;
    }


    public function setShipmentStatus(){
        $this->shipment_status = $shipment_status;
        return $this;
    }

    public function setShippingFees(){
        $this->shipping_fees = $shipping_fees;
        return $this;
    }

    public function setIdPul(){
        $this->Id_Pul = $id_pul;
        return $this;
    }

    public function setUser(User $user) {
         $this->user = $user;
    }

    public function setSubscription(Subscription $subscription) {
         $this->subscription = $subscription;
    }

}