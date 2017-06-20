<?php

namespace Repository;

//Gérer use
use Controller\SubscriptionController;
use Entity\Subscription;
use Entity\Product;


// class SubscriptionRepository extends RepositoryAbstract{

//     public function findChoosenProduct($size, $frequency){
//         // On demande à la fonction de trouver le produit correspondant aux deux valeurs obtenues par le client
//         $dbSubscription = $this->db->fetchAssoc(
//             'SELECT * FROM product WHERE size = :size AND frequency = :frequency',
//             [
//                 ':size' => $size,
//                 ':frequency' => $frequency
//             ]
//         );

//         //var_dump($dbSubscription);
//         // Instanciation d'un nouvel objet produit qui correspondra à celui choisi par l'utilisateur
//         $product = new Product;

//         // Initialisation des valeurs dans l'objet product
//         $product->setIdProduct($dbSubscription['id_product']);
//         $product->setProductName($dbSubscription['product_name']);
//         $product->setDescription($dbSubscription['description']);
//         $product->setPhoto($dbSubscription['photo']);
//         $product->setPrice($dbSubscription['price']);
//         $product->setSize($dbSubscription['size']);
//         $product->setFrequency($dbSubscription['frequency']);

//         var_dump($product);

//         return $product;

//     }







// }






class SubscriptionRepository extends RepositoryAbstract{

public function findall(){
    $dbSubscription = $this->db->FetchAssoc('
    SELECT *
    FROM product
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



