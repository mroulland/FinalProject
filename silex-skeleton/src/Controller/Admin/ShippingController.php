<?php

// Gestion des livraisons en back office

namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\User;
use Entity\Product;
use Entity\Shipping;
use Entity\Subscription;
use Repository\ShippingRepository;

use Symfony\Component\Validator\Constraints as Assert;


class ShippingController extends ControllerAbstract{

    // Afficher une liste de livraisons
    public function listAction(){

        $shippings = $this->app['shipping.repository']->findAllShipping();

        return $this->render(
            'admin/shipping/list.html.twig',
            ['shippings' => $shippings]
        );

    }

    // Mettre à jour les livraisons
    public function editAction($id = null){

    $shipping = $this->app['shipping.repository']->findById($id);
 
        if(!empty($_POST)){
            $shipping
                ->setMode($_POST['mode'])
                ->setShippingFees($_POST['shipping_fees'])
            ;

            $this->app['shipping.repository']->update($shipping);
            $this->addFlashMessage("Les informations de livraison ont bien été modifiées");
            return $this->redirectRoute('admin_shipping');
        }

        return $this->render(
            'admin/shipping/edit.html.twig',
            [
                'shipping' =>$shipping,
            ]
               
        );
    }
    
    
    // Supprimer les livraisons
      public function deleteAction($id){
        $shipping = $this->app['shipping.repository']->findById($id);

        $this->app['shipping.repository']->delete($shipping);
        $this->addflashMessage('La livraison a bien été supprimée');

        return $this->redirectRoute('admin_shipping');

    }
}