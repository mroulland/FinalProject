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
        //var_dump($dbSubscriptions); 
        $subscription = [];
        
        foreach ($dbSubscriptions as $dbSubscription){
            
            $subscriptions[] = $dbSubscription;
        }
        
        
        return $subscriptions;
        // retourne un tableau des abonnements
        
    }
    
    public function date(){
        $date = 'SELECT DATE(NOW())';
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

        $date = [
                'startDate' => $subscription->getStartDate(),
                'endDate'   => $subscription->getEndDate(),
            ];

    }
    
    /**
     * Fonction permettant de trouver l'abonnement souscrit par un membre en particulier
     * @param string $id
     * @return Subscription $subscription
     */
    public function findByIdUser($id){
        $subscription = $this->db->fetchAssoc(
            'SELECT * FROM subscription WHERE id_user= :id_user',
            [':id_user' => $id]    
        );
        
        return $subscription;
    }
    
    public function findProfilInfo($id){
        $profil = $this->db->fetchAssoc(
            'SELECT p.product_name, p.description, p.price, s.start_date, sh.mode, sh.shipping_fees
            FROM subscription s
            INNER JOIN product p
            ON s.id_product = p.id_product
            INNER JOIN shipping sh
            ON s.id_shipping = sh.id_shipping
            WHERE s.id_user = :id_user ', 
            [':id_user' => $id]
        );
        
        //var_dump($profil); die;
        return $profil;
        
        
    }
    
}