<?php
 

 
namespace Controller;
 

 
use Controller\ControllerAbstract;
 
use Repository\ShippingRepository;
 
use Entity\Shipping;
 
use Entity\Product;
 

 
/*
 
* Livraison
 
*/
 

 
class ShippingController extends ControllerAbstract{
 

 
    // Modification du mode de livraison
 

 
    public function editShipping($id_shipping= null){
 

 
        if(!is_null($id_shipping)){
 
         $user= $this->app['shipping.repository']->find($id_shipping);
 

 
        }else{
 

 
            return $this->redirectRoute('login');
 
        }
 

 
        if(empty($_POST)){
 

 
                $shipping
 
                    ->setMode($_POST['mode'])
 
                ;
 

 
            $this->app['shipping.repository']->save($shipment);
 
            $this->addFlashMessage('Modifications enregistrées');
 
            return $this->redirectRoute('profil');
 
            }
 
        }
 