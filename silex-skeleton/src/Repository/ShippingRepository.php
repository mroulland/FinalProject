<?php

namespace Repository;

use Entity\Shipping;
use Repository\RepositoryAbstract;


class ShippingRepository extends RepositoryAbstract {
   
    
    public function findAllShipping(){
        $dbshippings = $this->db->fetchAll('SELECT * FROM shipping');
        
        $shipping = [];

        foreach ($dbshippings as $dbShipping){
            $shipping = $this->buildShippingFromArray($dbShipping);
            $shippings [] = $shipping;
        }        

        return $shippings;
    }
    
    public function findById($id) {

        $query = <<<EOS
        SELECT *
        FROM shipping
        WHERE id_shipping = :id_shipping
EOS;

        $dbShipping = $this -> db -> fetchAssoc(
            $query,
            [':id_shipping' => $id]
        );
           
        
        $shipping = $this->buildShippingFromArray($dbShipping);
     
        return $shipping;
    }
    
    protected function buildShippingFromArray(array $dbShipping){
        $shipping = new Shipping();
        $shipping->setIdShipping($dbShipping['id_shipping']);
        $shipping->setMode($dbShipping['mode']);
        $shipping->setShippingFees($dbShipping['shipping_fees']);
        
        return $shipping;
    }
    
    // Fonction de mise à jour d'une livraison
     public function update(Shipping $shipping){ 
        
        $data = [ 
                'mode' => $shipping->getMode(),// valeurs dans la BDD
                'shipping_fees' => $shipping->getShippingFees()              
                     
        ];
      
        $this->db->update(
            'shipping', // Nom de la table dans laquelle les modifications sont effectuées
            $data, 
                ['id_shipping' => $shipping->getIdShipping()] // clause WHERE
        );
   
    }
    
    
    // Fonction supprimer une livraison
    public function delete(Shipping $shipping){
        
        $this->db->delete(
            'shipping', 
            ['id_shipping' => $shipping->getIdShipping()]
        );
        
    }
}
