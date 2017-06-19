<?php

namespace Controller\Admin;

use Controller\ControllerAbstract;


class ProductController extends ControllerAbstract {

    public function listAction(){

        $products = $this->app['product.repository']->findAllProducts();

        return $this->render(
            'admin/user/product.html.twig',
            ['products' => $products]
        );
    }

        public function editAction($id_product = null){

                if(!is_null($id_product)){

                    $product= $this->app['product.repository']->find($id_product);
                }else{ //Si non, création d'un nouveau membre

                    $product = new Product;
                }

                if(empty($_POST)){ // création d'un nouvel utilsateur
                    $product
                            ->setIdProduct($_POST['id_product'])
                            ->setProductName($_POST['product_name'])
                            ->setDescription($_POST['description'])
                            ->setPhoto($_POST['photo'])
                            ->setPrice($_POST['price']);

                    $this->app['product.repository']->save($product);
                    $this->addFlashMessage("Le produit a bien été modifié");
                    return $this->redirectRoute('admin_product');
                }

                return $this->render(
                    'admin/product/edit.html.twwig',
                    [
                        'product' =>$product,
                    ]
                );
            }

        public function deleteAction($id_product){
            $product = $this->app['product.repository']->find($id_product);

            $this->app['product.repository']->delete($product);
            $this->addflashMessage('le produit a été supprimé');

            return $this->redirectRoute('admin_product');

        }

}