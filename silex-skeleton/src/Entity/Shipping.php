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

// getter

public function getIdshipping(){
    return $this->id_shipping;
}

public function  getMode(){
    return $this->mode;
}

public function getSshipmentStatus(){
    return  $this->shipment_status
}

public function getShippingFees(){
        return $this->shipping_fees;
}

public function getIdPul(){
        return $this->id_pul;
}



//setter

public function setIdShipping(){
    $this->id_shipping = $id_shipping;
    return $this;
}

public function setMode(){
    $this->mode = $mode
    return $mode;
}


public function setShipmentStatus(){
    $this->shipment_status = $shipment_status;
    return $this;
}

public function setShiippingFees(){
    $this->shipping_fees = $shipping_fees;
    return $this;
}

public function setIdPul(){
    $this->Id_Pul = $Id_pul;
    return $this;
}

}