<?php
 
namespace Repository;
use Controller\SshippingController;
use Entity\User;
use Service\UserManager;
 
 
 
class ShippingRepository extends RepositoryAbstract {
 
     Public function findAll(){
        //on récupère la liste des livraisons 
        $dbShipment = $this->db->fetchAll('
        SELECT *
        FROM shipping s
        ');

        $shipment=[];

        foreach ($dbShipments as $dbShipment){
            $shipment = $this->buildSshipFromArray($dbShipment);
            $shipment[] = $shipments;
 
            $shipment
                 ->setId($dbShipment['id_shipping'])
                 ->setMode($dbShipment['mode'])
                 ->setShipmentStatus($dbShipment['shipment_status'])
                 ->setShippingFees($dbShipment['shipping_fees'])
                 ->setIdPul($dbShipment['id_pul'])
                 ;
 
 
        return $shipments;
 
    }
 
    /**
    * Fonction permettant d'afficher les détails de livraison par l'id user
    *  
    */

    
 
    Public function findByIdUser($id){

        //on récupère la liste des livraisons en fonction des utilisateurs avec détails

        $dbShipment = $this->db->fetchAssoc('

        SELECT s.id_shipping, s.mode, s.shipment_status, s.shipping_fees, s.id_pul, su.id_subscription, u.id_user, u.lastname, u.firstname, U.address, u.zipcode
        FROM shipping s
        JOIN subscription su
        ON s.id_shipping = su.id_shipping
        JOIN users u
        ON su.id_user = u.id_user
        WHERE su.id_user = u.id_user
        '
        [':u.id_user' => $id]);

        );

        return $shipments;
 
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
 

 
}