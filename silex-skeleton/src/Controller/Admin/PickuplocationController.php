<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\Pickuplocation;
use Repository\PickuplocationRepository;
use Symfony\Component\Validator\Constraints as Assert;


class PickuplocationController extends ControllerAbstract{
    
    public function listAction(){
        
        $pickuplocations = $this->app['pickuplocation.repository']->findAllPuls();
        
        return $this->render(
            'admin/pickuplocation/list.html.twig',
            ['pickuplocations' => $pickuplocations]
        );
    }
    
    public function registerAction(){
        
        $pickuplocation = new Pickuplocation();
        $errors = [];
        
        if(!empty($_POST)){
            
             if (!$this->validate($_POST['name_pul'], new Assert\NotBlank())){ 
               $errors['name_pul'] = 'Vous devez indiquer le nom du point relais';
            }   

            if (!$this->validate($_POST['address_pul'], new Assert\NotBlank())){ 
                $errors['address_pul'] = 'L\'adresse est obligatoire';
            }  

            if (!$this->validate($_POST['zipcode_pul'], new Assert\NotBlank())){ 
                $errors['zipcode_pul'] = 'Le code postal est obligatoire';

            } elseif(!$this->validate($_POST['city_pul'], new Assert\NotBlank())){
                $errors['city_pul'] = "La ville est obligatoire";
            }

            if (!$this->validate($_POST['phone_pul'], new Assert\NotBlank())){ 
                $errors['phone_pul'] = "Le numéro de téléphone est obligatoire";
            }
            
            if (!$this->validate($_POST['hours'], new Assert\NotBlank())){ 
                $errors['hours'] = 'Aucune horaire indiqué';
            }
            
            if (!$this->validate($_POST['googlemapslocation'], new Assert\NotBlank())){ 
                $errors['googlemapslocation'] = 'Aucune localisation indiquée';
            }
             
            if(empty($errors)){
            
                $pickuplocation
                    ->setNamePul($_POST['name_pul'])             
                    ->setAddressPul($_POST['address_pul'])
                    ->setZipcodePul($_POST['zipcode_pul'])
                    ->setCityPul($_POST['city_pul'])
                    ->setPhonePul($_POST['phone_pul'])
                    ->setHours($_POST['hours'])
                    ->setGooglemapsLocation($_POST['googlemapslocation'])
                ;
                
                $this->app['pickuplocation.repository']->insert($pickuplocation);           
                $this->addFlashMessage("Le point relais a bien été ajouté");
                return $this->redirectRoute('admin_pickuplocation');
                
            }else{
                $msg = '<strong>Le formulaire contient des erreurs</strong>';
                $msg .='<br>- ' . implode('</br>- ', $errors);
                
                $this->addFlashMessage($msg,'error');
            }
        } 
        return $this->render('admin/pickuplocation/ajout.html.twig');
        
    }
    
    
    
    public function editAction($id = null){
        
        $pickuplocation = $this->app['pickuplocation.repository']->findById($id);
        
        if(!empty($_POST)){
            $pickuplocation
                ->setNamePul($_POST['name_pul'])             
                ->setAddressPul($_POST['address_pul'])
                ->setZipcodePul($_POST['zipcode_pul'])
                ->setCityPul($_POST['city_pul'])
                ->setPhonePul($_POST['phone_pul'])
                ->setHours($_POST['hours'])
                ->setGooglemapsLocation($_POST['googlemapslocation'])
            ;
        
            $this->app['pickuplocation.repository']->update($pickuplocation);           
            $this->addFlashMessage("Le point relais a bien été modifié");
            return $this->redirectRoute('admin_pickuplocation');
        }
        
        return $this->render(
            'admin/pickuplocation/edit.html.twig',
            ['pickuplocation' => $pickuplocation]
        );
    }
    
    public function deleteAction($id){
        $pickuplocation = $this->app['pickuplocation.repository']->findById($id);
        
        $this->app['pickuplocation.repository']->delete($pickuplocation);
        $this->addflashMessage("Le point relais a bien été supprimé");
        
        return $this->redirectRoute('admin_pickuplocation');
    }
}
