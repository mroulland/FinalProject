<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Entity;


class Gift {
    
    private $id_gift;
    
    private $id_user;
    
    private $id_receiver;
    
    private $id_product;
    
    private $id_shipping;
    
    private $start_date;
    
    private $end_date;
    
    private $total_price;
    
    public function getIdGift() {
        return $this->id_gift;
    }

    public function getIdUser() {
        return $this->id_user;
    }

    public function getIdReceiver() {
        return $this->id_receiver;
    }

    public function getIdProduct() {
        return $this->id_product;
    }

    public function getIdShipping() {
        return $this->id_shipping;
    }

    public function getStartDate() {
        return $this->start_date;
    }

    public function getEndDate() {
        return $this->end_date;
    }

    public function getTotalPrice() {
        return $this->total_price;
    }

    public function setIdGift($id_gift) {
        $this->id_gift = $id_gift;
        return $this;
    }

    public function setIdUser($id_user) {
        $this->id_user = $id_user;
        return $this;
    }

    public function setIdReceiver($id_receiver) {
        $this->id_receiver = $id_receiver;
        return $this;
    }

    public function setIdProduct($id_product) {
        $this->id_product = $id_product;
        return $this;
    }

    public function setIdShipping($id_shipping) {
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

    public function setTotalPrice($total_price) {
        $this->total_price = $total_price;
        return $this;
    }


}
