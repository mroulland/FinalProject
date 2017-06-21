<?php

// Gestion des livraisons en back office

namespace Controller\Admin;

use Controller\ControllerAbstract;
use Repository\UserRepository;
use Entity\User;
use Symfony\Component\Validator\Constraints as Assert;


    class ShippingController extends ControllerAbstract{

        public function listAction(){

        ship = $this->app['shipping.repository']->findAllShips();

        return $this->render(
            'admin/shipping/list.html.twig',
            ['ships' => $ships]
        );

    }