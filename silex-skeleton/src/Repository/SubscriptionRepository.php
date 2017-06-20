<?php

namespace Repository;

//Gérer use
use Controller\SubscriptionController;
use Entity\Subscription;
use Entity\Product;

class SubscriptionRepository extends RepositoryAbstract{

    public function findChoosenProduct($size, $frequency){
        // On demande à la fonction de trouver le produit correspondant aux deux valeurs obtenues par le client
        $dbSubscription = $this->db->fetchAssoc(
            'SELECT * FROM product WHERE size = :size AND frequency = :frequency',
            [
                ':size' => $size,
                ':frequency' => $frequency
            ]
        );
        
        // Instanciation d'un nouvel objet produit qui correspondra à celui choisi par l'utilisateur
        $product = new Product;
        
        // Initialisation des valeurs dans l'objet product
        $product->setIdProduct($dbSubscription['id_product']);
        $product->setProductName($dbSubscription['product_name']);
        $product->setDescription($dbSubscription['description']);
        $product->setPhoto($dbSubscription['photo']);
        $product->setPrice($dbSubscription['price']);
        $product->setSize($dbSubscription['size']);
        $product->setFrequency($dbSubscription['frequency']);
        
        return $product;

    }
    

}



