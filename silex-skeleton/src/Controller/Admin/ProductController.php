<?php

namespace Controller\Admin;

use Controller\ControllerAbstract;


class ProductController extends ControllerAbstract {

    public function listAction(){

        $products = $this->app['product.repository']->findAllProducts();

        return $this->render(
            'product.html.twig',
            ['products' => $products]
        );
    }

    public function editAction($id = null){



    }


}