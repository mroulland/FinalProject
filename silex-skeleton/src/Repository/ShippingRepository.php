<?php

namespace Repository;

use Entity\User;
use Service\UserManager;

class ShippingRepository extends RepositoryAbstract {



    Public function findAll(){
        //on récupère la liste des livraisons en fonction des utilisateurs

        $dbShip = $this->db->fetchAll('
        SELECT *
        FROM shipping s
        ');

        $ship=[];

        foreach ($dbShips as $dbShip)

            $ship= $this->buildSshipFromArray($dbShip);
            $ship[] = $ships;

            $ship
                ->setId($dbShip['id_shipping'])
                ->setMode($dbShip['mode'])
                ->setShipmentStatus($dbShip['shipment_status'])
                ->setShippingFees($dbShip['shipping_fees'])
                ->setIdPul($dbShip['id_pul'])
                ;
        }

        return $ships;

}


    Public function findShip(){
        //on récupère la liste des livraisons en fonction des utilisateurs avec détails

        $dbShip = $this->db->fetchAssoc('
        SELECT s.id_shipping, s.mode, s.shipment_status, s.shipping_fees, s.id_pul, su.id_subscription, u.id_user, u.lastname, u.firstname, U.address, u.zipcode
        FROM shipping s
        JOIN subscription su
        ON s.id_shipping = su.id_shipping
        JOIN users u
        ON su.id_user = u.id_user
        WHERE su.id_user = u.id_user
        '
        [':u.id_user' => $idUser]);

        if(!empty($dbShip)){

            $ship = new Ship();


            $ship
                ->setIdShipping($dbShip['id_shipping'])
                ->setMode($dbShip['mode'])
                ->setShipmentStatus($dbShip['shipment_status'])
                ->setShippingFees($dbShip['shipping_fees'])
                ->setIdPul($dbShip['id_pul'])
                ;
        }

        return $ships;

}