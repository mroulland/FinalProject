<?php

namespace Repository;

use Controller\ShippingController;
use Entity\Shipping;
use Entity\User;
use Service\UserManager;



class ShippingRepository extends RepositoryAbstract {



    public function findAllShipments(){

        $dbShipments = $this->db->fetchAll('

            SELECT s.id_shipping, s.mode, s.shipment_status, s.shipping_fees, s.id_pul, su.id_subscription, u.id_user, u.lastname, u.firstname, U.address, u.zipcode
            FROM shipping s
            JOIN subscription su
            ON s.id_shipping = su.id_shipping
            JOIN users u
            ON su.id_user = u.id_user
            WHERE su.id_user = u.id_user
            ');

            $shipments = [];

            foreach ($dbShipments as $dbShipment){

                $shipments [] = $dbShipment;
            }        

            return $shipments;
        }




    public function find($id_shipping) {

        $query = <<<EOS
        SELECT *
        FROM shipping
        WHERE id_shipping = :id_shipping
EOS;

        $dbShippings = $this -> db -> fetchAssoc(
            $query,

            [':id_shipping' => $id_shipping]
        );

        if($dbShippings == false){
            return false;
        }
        else{
            foreach ($dbShippings as $dbShipping){
            $shipping [] = $dbShipping;

            }
            return $shipping;

        }
    }
}

        // if(!empty($dbShipment)){
        //     $shipment = new Shipment();
        //     $shipment
        //          ->setIdShipping($dbShipment['id_shipping'])
        //          ->setMode($dbShipment['mode'])
        //          ->setShipmentStatus($dbShipment['shipment_status'])
        //          ->setShippingFees($dbShipment['shipping_fees'])
        //          ->setIdPul($dbShipment['id_pul'])
        //          ;


        //  return $shipments;
