<?php



namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\Products;


class ProductController extends ControllerAbstract {

    public function listAction(){

        $products = $this->app['product.repository']->findAll();

        return $this->render(
            'admin/product/product.twig.html',
            ['products' => $products]
        );
    }

    public function editAction($id = null){



    }


}