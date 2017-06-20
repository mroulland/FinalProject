<?php

namespace Repository;

//Gérer use
use Controller\SubscriptionController;
use Entity\Subscription;
use Entity\Product;

class SubscriptionRepository extends RepositoryAbstract{

    public function findChoosenProduct($parameters){
    
    $dbSubscription = $this->db->fetchAssoc(
            'SELECT * FROM product WHERE size = :size AND frequency = :frequency',
            [
                ':size' => $parameters['size'],
                ':frequency' => $parameters['frequency']
            ]
        );

    }
    






}



