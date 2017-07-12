<?php

namespace Repository;

use Entity\Gift;
use Repository\RepositoryAbstract;

class GiftRepository extends RepositoryAbstract{
    
    public function findAllGifts(){
        
        $dbGifts = $this->db->fetchAll('
            SELECT *
            FROM gift s
            INNER JOIN product p
            ON s.id_product = p.id_product
            INNER JOIN shipping h
            ON s.id_shipping = h.id_shipping
            INNER JOIN users u
            ON s.id_user = u.id_user 
            ORDER BY s.id_gift
            ');
 
        $gifts = [];
        
        foreach ($dbGifts as $dbGift){
            
            $gifts[] = $dbGift;
        }  
        return $gifts;
        // retourne un tableau des abonnements
        
    }
    
    public function findById($id_gift) {
        $query = <<<EOS
            SELECT *
            FROM gift
            WHERE id_gift = :id_gift
EOS;

        $dbGift = $this->db->fetchAssoc(
            $query,
            [':id_gift' => $id_gift]
        );

        $gift = $this->buildGiftFromArray($dbGift);
        
        return $gift;
    }
        
    /**
     * Fonction permettant de trouver l'abonnement souscrit par un membre en particulier
     * @param string $id
     * @return gift $gift
     */
    public function findByIdUser($id){
        $dbGift = $this->db->fetchAssoc(
            'SELECT * FROM gift WHERE id_user= :id_user',
            [':id_user' => $id]    
        );
        
        $gift = $this->buildGiftFromArray($dbGift);
        
        return $gift;
    }
    
    public function findByCode($code){
        $dbGift = $this->db->fetchAssoc(
            'SELECT * FROM gift WHERE code = :code',
            [':code' => $code]
        );
        
        if($dbGift){
            $gift = $this->buildGiftFromArray($dbGift);
            return $gift;
        }
        else{
            return false;
        }
    }
    

    
    protected function buildGiftFromArray(array $dbGift){
        $gift = new Gift();
        
        $gift->setIdGift($dbGift['id_gift']);
        $gift->setIdUser($dbGift['id_user']);
        $gift->setIdReceiver($dbGift['id_receiver']);
        $gift->setIdProduct($dbGift['id_product']);
        $gift->setIdShipping($dbGift['id_shipping']);
        $gift->setDuration($dbGift['duration']);
        $gift->setStartDate($dbGift['start_date']);
        $gift->setEndDate($dbGift['end_date']);
        $gift->setTotalPrice($dbGift['total_price']);
        
        return $gift;
    }
    
    public function insert(Gift $gift){

        $data = [
                'id_user' => $gift->getIdUser(),
                'id_product' => $gift->getIdProduct(),
                'id_shipping' => $gift->getIdShipping(),
                'duration' => $gift->getDuration(),
                'total_price' => $gift->getTotalPrice(),
                'code' => $gift->getCode()
            ];
        
        $this->db->insert('gift', $data);
        
        $gift->setIdGift($this->db->lastInsertId());

    }
    
    
    public function findProfilInfo($id){
        $profil = $this->db->fetchAssoc(
            'SELECT p.product_name, p.description, p.price, s.start_date, sh.mode, sh.shipping_fees, s.soft_delete
            FROM gift s
            INNER JOIN product p
            ON s.id_product = p.id_product
            INNER JOIN shipping sh
            ON s.id_shipping = sh.id_shipping
            WHERE s.id_user = :id_user ', 
            [':id_user' => $id]
        );
        
        
        return $profil;        
    }
    
    public function update(gift $gift){ 
        
        $data = [ 
                'id_receiver' => $gift->getIdReceiver(),
                'start_date' => $gift->getStartDate(),
                'end_date'=> $gift->getEndDate(),
        ];
        
        $this->db->update(
            'gift',
            $data, 
                ['id_gift' => $gift->getIdGift()] // clause WHERE
        );
   
    }
    
    public function delete(gift $gift){
        
        $this->db->delete(
            'gift', 
            ['id_gift' => $gift->getIdgift()]
        );
        
    }
    
    
   
    
}