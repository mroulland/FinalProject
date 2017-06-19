<?php


namespace Repository;

use Repository\ProductRepository;


class ProductFrontRepository {
    /**
     * Le client choisit l'abonnement qui lui convient
     * Via le formulaire de selection
     * Requête SQL
     */
    public function chooseProduct(){
        $query = <<<EOS
SELECT *
FROM product
WHERE taille=?
AND frequency=?
EOS;
                
        
        
    }
}
