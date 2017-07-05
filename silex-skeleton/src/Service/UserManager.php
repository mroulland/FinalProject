<?php

namespace Service;

use Entity\User;
use Entity\Product;
use Entity\Shipping;
use Symfony\Component\HttpFoundation\Session\Session;

class UserManager{

    /**
     *
     * @var session
     */
    private $session;
    public function __construct(Session $session){
        $this->session =$session;
    }


    /**
    *  Encodage:
    *
    */
  
    public function encodePassword($password){
        
        return password_hash($password, PASSWORD_BCRYPT);
    }

     /**
     * Vérifie la correspondance entre un mdp en clair et un mdp encodé
     * 
     * @param string $plainPassword
     * @param string $encodedPassword
     * @return bool
     */
    public function verifyPassword($plainPassword, $encodedPassword){
        return password_verify($plainPassword, $encodedPassword);
    }
    

    public function login(User $user){
        
        $this->session->set('user', $user);
        
    }
    
    public function logout(){
        
        $this->session->remove('user');
        
    }
    
    public function isUserConnected(){
        
        return $this->session->has('user');       
    }

    
    public function getUser()
    {
        // Methode pour récupérer l'utilisateur connecté
        if($this->isUserConnected()){
            return $this->session->get('user');
        }
        
    }
    
    public function getUserId()
    {
        // Méthode pour récupérer l'id de l'utilisateur connecté
        if($this->isUserConnected()){
            return $this->session->get('user')->getId();
        }
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
    
    
     /**
     * 
     * @return string
     */
     public function getUsername(){       
        if($this->isUserConnected()){
            return $this->session->get('user')->getFullname();
        }
        return '';
    }
    
    
    public function getEmail() {
         
        if ($this->isUserConnected()) {
            return $this->session->get('user')->getEmail();
        }

        return '';
    }
    
    public function getLastname(){
        if($this->isUserConnected()) {
            return $this->session->get('user')->getLastname();
        }
        return '';
    }
    
    public function getFirstname(){
        if($this->isUserConnected()) {
            return $this->session->get('user')->getFirstname();
        }
        return '';
    }
    
    public function isAdmin(){
        
        return $this->isUserConnected()&& $this->session->get('user')->isAdmin();
            
    }
    
    
}



