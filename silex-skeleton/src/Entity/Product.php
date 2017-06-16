<?php

namespace Entity;

Class Product{

    private $id_product;

    private $product_name;

    private $descritption;

    private $photo;

    private $price;


// Getter


    public function getIdProduct(){
        return $this->id_product;
    }


    public function getProductName(){
        return $this->product_name;
    }

    public function getDescritption(){
        return $this->descritption;
    }

    public function getPhoto(){
        return $this->photo;
    }

    public function getPrice(){
        return $this->price;
    }

// Setter

    public function setIdProduct($id_product){
        $this->id_product = $id_product;
        return $this;
    }

    public function setProductName($product_name){
        $this->product_name = $product_name;
        return $this;
    }

    public function setDescription($description){
        $this->description = $description;
        return $this;
    }


    public function setPhoto($photo){
        $this->photo = $photo;
        return $this;
    }

    public function setPrice($price){
        $this->price = $price;
        return $this;
    }

}