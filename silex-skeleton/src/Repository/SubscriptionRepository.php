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
}