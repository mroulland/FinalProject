<?php

namespace Repository;

//Gérer use
use Entity\Subscription;
use Entity\Product;

class SubscriptionRepository extends RepositoryAbstract{

    public function findAll(){
   
        $query = <<<EOS
            SELECT * 
            FROM product
            WHERE size=$size AND frequency=$frequency
EOS;

    $dbSubscription = $this -> db -> fetchAll($query);
        $subscription = [];
        
        foreach ($dbSubscriptions as $dbSubscription){
            $subscription= $this->buildArticleFromArray($dbSubscription);
            $subscription[] = $subscritpions;          
        }      
        return $subscription;
    }
    






}



