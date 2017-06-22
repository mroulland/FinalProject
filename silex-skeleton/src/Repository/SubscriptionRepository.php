<?php

namespace Repository;

//Gérer use
use Controller\SubscriptionController;
use Entity\Subscription;
use Entity\Product;

class SubscriptionRepository extends RepositoryAbstract{

    public function findall(){
        $dbSubscription = $this->db->FetchAll('
        SELECT *
        FROM subscription
        ');

            if(!empty($dbSubscription)){
                $subscription = new Subscription();

            $subscription
                ->setStartDate($dbSubscription['start_date'])
                ->setEndDate($dbSubscription['end_date'])
                ;

            return $subscription;
            }
            return null;
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