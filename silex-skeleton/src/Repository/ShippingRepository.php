<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Repository;

use Entity\Shipping;


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
}
