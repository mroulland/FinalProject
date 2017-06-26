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
    *@var mode
    */
    private $mode;


    /**
    *
    *@var int
    */
    private $shipping_fees;


    // getter

    public function getIdShipping(){
        return $this->id_shipping;
    }

    public function getMode(){
        return $this->mode;
    }

    public function getShippingFees(){
            return $this->shipping_fees;
    }


    //setter

    public function setIdShipping($id_shipping){
        $this->id_shipping = $id_shipping;
        return $this;
    }

    public function setMode($mode){
        $this->mode = $mode;
        return $this;
    }

    public function setShippingFees($shipping_fees){
        $this->shipping_fees = $shipping_fees;
        return $this;
    }

}