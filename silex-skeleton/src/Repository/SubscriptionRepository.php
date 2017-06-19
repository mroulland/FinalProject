<?php

namespace Repository;

//Gérer use
use Controller\SubscriptionController;
use Entity\Subscription;
use Entity\Product;

class SubscriptionRepository extends RepositoryAbstract{

    public function findChoosenProduct($size, $freq){
    
    $dbScription = $this->db->fetchAssoc(
            'SELECT * FROM category WHERE size = :size AND frequency = :frequency',
            [
                ':size' => $size,
                ':frequency => $freq'
            ]
        );

    }
    






}



