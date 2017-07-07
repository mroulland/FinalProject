<?php

namespace Service;

use Entity\Product;
use Entity\Shipping;
use Entity\Subscription;

use Symfony\Component\HttpFoundation\Session\Session;


class SubscriptionManager {
    
    private $session;
    
    public function __construct(Session $session){
        $this->session =$session;
    }
    
     public function setProduct(Product $product){
        $this->session->set('product', $product);
        
    }
    
    public function getProduct(){
        if($this->session->has('product')){
            return $this->session->get('product');
        }
    }
    
    public function setShipping(Shipping $shipping){
        $this->session->set('shipping', $shipping);
        
    }
    
    public function getShipping(){
        if($this->session->has('shipping')){
            return $this->session->get('shipping');
        }
    }
    
    public function setDuration($duration){
        $this->session->set('duration', $duration);
    }
    
    public function getDuration(){
        if($this->session->has('duration')){
            return $this->session->get('duration');
        }
    }
    
    public function setEndDate($end_date){
        $this->session->set('end_date', $end_date);
        
    }
    
    public function getEndDate(){
        if($this->session->has('end_date')){
            return $this->session->get('end_date');
        }
    }
    
    public function setStartDate($start_date){
        $this->session->set('start_date', $start_date);
        
    }
    
    public function getStartDate(){
        if($this->session->has('start_date')){
            return $this->session->get('start_date');
        }
    }
    
    public function datefr($date){
        $datefr = strtotime('d/m/Y', $date);
        return $datefr;
    }
}
