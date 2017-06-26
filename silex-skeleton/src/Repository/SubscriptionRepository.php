<?php

namespace Repository;

//Gérer use
use Controller\SubscriptionController;
use Entity\Subscription;
use Entity\Product;
use Entity\User;
use Entity\Shipping;

class SubscriptionRepository extends RepositoryAbstract{

    public function findAllSubscriptions(){
        
        $dbSubscriptions = $this->db->fetchAll('
            SELECT *
            FROM subscription s
            INNER JOIN product p
            ON s.id_product = p.id_product
            INNER JOIN shipping h
            ON s.id_shipping = h.id_shipping
            INNER JOIN users u
            ON s.id_user = u.id_user 
            ');
 
        $subscriptions = [];
        
        foreach ($dbSubscriptions as $dbSubscription){
            
            $subscriptions[] = $dbSubscription;
        }  
        return $subscriptions;
        // retourne un tableau des abonnements
        
    }
    
    public function findById($id_subscription) {
        $query = <<<EOS
            SELECT *
            FROM subscription
            WHERE id_subscription= :id_subscription
EOS;

        $dbSubscription = $this->db->fetchAssoc(
            $query,
            [':id_subscription' => $id_subscription]
        );

        $subscription = $this->buildSubscriptionFromArray($dbSubscription);
        
        return $subscription;
    }
      
      
    public function date(){
        $date = 'SELECT DATE("d-m-Y")';
        return $date;
    }
    
    protected function buildSubscriptionFromArray(array $dbSubscription){
        $subscription = new Subscription();
        $user = new User();
        $product = new Product();
        $shipping = new Shipping(); 
        
        $subscription->setIdSubscription($dbSubscription['id_subscription']);
        $subscription->setIdUser($dbSubscription['id_user']);
        $subscription->setIdProduct($dbSubscription['id_product']);
        $subscription->setIdShipping($dbSubscription['id_shipping']);
        $subscription->setStartDate($dbSubscription['start_date']);
        $subscription->setEndDate($dbSubscription['end_date']);
        $subscription->setSoftDelete($dbSubscription['soft_delete']);
        
        return $subscription;
    }
    
    public function insert(Subscription $subscription){

        $data = [
                'id_user' => $subscription->getIdUser(),
                'id_product' => $subscription->getIdProduct(),
                'id_shipping' => $subscription->getIdShipping(),
                'start_date' => $subscription->getStartDate(),
                'end_date'   => $subscription->getEndDate()
            ];
        
        $this->db->insert('subscription', $data);
        
        $subscription->setIdSubscription($this->db->lastInsertId());

    }
    
    /**
     * Fonction permettant de trouver l'abonnement souscrit par un membre en particulier
     * @param string $id
     * @return Subscription $subscription
     */
    public function findByIdUser($id){
        $dbSubscription = $this->db->fetchAssoc(
            'SELECT * FROM subscription WHERE id_user= :id_user',
            [':id_user' => $id]    
        );
        
        $subscription = $this->buildSubscriptionFromArray($dbSubscription);
        
        return $subscription;
    }
    
    public function findProfilInfo($id){
        $profil = $this->db->fetchAssoc(
            'SELECT p.product_name, p.description, p.price, s.start_date, sh.mode, sh.shipping_fees, s.soft_delete
            FROM subscription s
            INNER JOIN product p
            ON s.id_product = p.id_product
            INNER JOIN shipping sh
            ON s.id_shipping = sh.id_shipping
            WHERE s.id_user = :id_user ', 
            [':id_user' => $id]
        );
        
        
        return $profil;        
    }
    
    public function update(Subscription $subscription){ 
        
        $data = [ 
                'id_user' => $subscription->getIdUser(),
                'id_product' => $subscription->getIdProduct(),               
                'id_shipping' => $subscription->getIdShipping(),
                'start_date' => $subscription->getStartDate(),
                'end_date'=> $subscription->getEndDate(),
                'soft_delete' => $subscription->getSoftDelete()
        ];
        
        $this->db->update(
            'subscription',
            $data, 
                ['id_subscription' => $subscription->getIdSubscription()] // clause WHERE
        );
   
    }
   
    
}