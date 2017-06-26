<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Repository;

use Entity\Pickuplocation;
use Repository\RepositoryAbstract;


class PickuplocationRepository extends RepositoryAbstract{
    
    public function findAllPuls(){
        
        $dbPuls = $this->db->fetchAll(' SELECT * FROM pickuplocation');
        
        $puls = [];
        foreach ($dbPuls as $dbPul){
            $pul = $this->buildPulFromArray($dbPul);
            $puls[] = $pul;
        }
        
        return $puls;
    }
    
    
    public function findById($id_pul){
        $dbPul = $this->db->fetchAssoc(
            'SELECT * FROM pickuplocation WHERE id_pul = :id_pul',
            ['id_pul' => $id_pul]
        );
        
        $pul = $this->buildPulFromArray($dbPul);

        return $pul;
    }
    
    public function findByName($name_pul){
        $dbPul = $this->db->fetchAssoc(
            'SELECT * FROM pickuplocation WHERE name_pul = :name_pul',
            ['name_pul' => $name_pul]
        );
        
        $pul = $this->buildPulFromArray($dbPul);
        
        return $pul;
        
    }
    
    public function insert(Pickuplocation $pickuplocation){
        $data = [
            'name_pul' => $pickuplocation->getNamePul(),
            'address_pul' => $pickuplocation->getAddressPul(),
            'zipcode_pul' => $pickuplocation->getZipcodePul(),
            'city_pul' => $pickuplocation->getCityPul(),
            'phone_pul' => $pickuplocation->getPhonePul(),
            'hours'   => $pickuplocation->getHours(),
            'googlemaps_location' => $pickuplocation->getGooglemapsLocation()               
        ];
        
        $this->db->insert('pickuplocation', $data);
        
        $pickuplocation->setIdPul($this->db->lastInsertId());

    }
    
    public function update(Pickuplocation $pickuplocation){
        $data = [
            'id_pul' => $pickuplocation->getIdPul(),
            'name_pul' => $pickuplocation->getNamePul(),
            'address_pul' => $pickuplocation->getAddressPul(),
            'zipcode_pul' => $pickuplocation->getZipcodePul(),
            'city_pul' => $pickuplocation->getCityPul(),
            'phone_pul' => $pickuplocation->getPhonePul(),
            'hours'   => $pickuplocation->getHours(),
            'googlemaps_location' => $pickuplocation->getGooglemapsLocation()               
        ];
        
        $this->db->update(
            'pickuplocation', 
            $data, 
            ['id_pul' => $pickuplocation->getIdPul()]
        );
        
    }
    
    public function delete(Pickuplocation $pickuplocation){
        
        $this->db->delete(
            'pickuplocation', 
            ['id_pul' => $pickuplocation->getIdPul()]
        );
        
    }
    
    public function buildPulFromArray(array $dbPul){
        $pul = new Pickuplocation();
        
        $pul->setIdPul($dbPul['id_pul']);
        $pul->setNamePul($dbPul['name_pul']);
        $pul->setAddressPul($dbPul['address_pul']);
        $pul->setZipcodePul($dbPul['zipcode_pul']);
        $pul->setCityPul($dbPul['city_pul']);
        $pul->setPhonePul($dbPul['phone_pul']);
        $pul->setHours($dbPul['hours']);
        $pul->setGoogleMapsLocation($dbPul['googlemaps_location']);
        
        return $pul;
    }
}
