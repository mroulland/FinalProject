<?php

// Gestion des livraisons en back office

namespace Controller\Admin;

use Controller\ControllerAbstract;
use Repository\UserRepository;
use Entity\User;
use Symfony\Component\Validator\Constraints as Assert;


    class ShippingController extends ControllerAbstract{

        public function listAction(){

        $ship = $this->app['shipping.repository']->findAllShips();

        return $this->render(
            'admin/shipping/list.html.twig',
            ['ships' => $ships]
        );

    }

        public function editAction($id = null){

        $shipment= $this->app['shipping.repository']->find($id);

                if(!empty($_POST)){
                    $shipment
                        ->setMode($_POST['id_shipping'])
                        ->setShipmentStatus($_POST['shipment_status'])
                        ->setShippingFees($_POST['shipping_fees'])
                        ->setIdPul($_POST['id_pul']);
                    ;

                    $this->app['shipping.repository']->update($shipment);
                    $this->addFlashMessage("Le es informations de livraison ont bien été modifiées");
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