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

        public function listAction(){

        $shipments = $this->app['shipping.repository']->findAllShipments();

        return $this->render(
            'admin/shipping/list.html.twig',
            ['shipments' => $shipments]
        );

    }

        public function editAction($id = null){

        $shipment= $this->app['shipping.repository']->find($id);

                if(!empty($_POST)){
                    $shipment
                        ->setMode($_POST['mode'])
                        ->setShipmentStatus($_POST['shipment_status'])
                        ->setShippingFees($_POST['shipping_fees'])
                        ->setIdPul($_POST['id_pul']);
                    ;

                    $this->app['shipping.repository']->update($shipment);
                    $this->addFlashMessage("Les informations de livraison ont bien été modifiées");
                    return $this->redirectRoute('admin_shipping');
                }

                return $this->render(
                    'admin/shipping/edit.html.twig',
                    [
                        'shipment' =>$shipment,
                    ]
                );
            }
        }