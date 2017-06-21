<?php

namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;


class ProductController extends ControllerAbstract {


    public function registerAction(){

        if(!empty($_POST)){ // validation des infos

            if (!$this->validate($_POST['product_name'], new Assert\notBlank())){
                $errors['product_name'] = 'le nom du produit est obligatoire';
            }

            if (!$this->validate($_POST['description'], new Assert\Notblank())){
                $errors['description'] = 'Veuillez indiquer une description';
            }

            if (!$this->validate($_POST['photo'], new Assert\notBlank())){
                $errors['photo']= 'Il faut intégrer une photo pour le produit';
            }

            if (!$this->validate($_POST['price'], new Assert\nootBlank())){
                $errors['price'] = 'Il faut renseigner un prix';
            }

            if (!$this->validate($_POST['size'], new Assert\notBlank())){
                $errors['size'] = 'Il faut spécifier une taille';
            }

            if (!$this->validate($_POST['frequency'], new Assert\notBlank())){
                $errors['frequency'] = 'Il faut spécifier une fréquence';
            }

            if(empty($errors)){

                $product
                    ->setProductName($_POST['product_name'])
                    ->setDescription($_POST['description'])
                    ->setPhoto($_PHOTO['photo'])
                    ->setPrice($_POST['price'])
                    ->setSize($_POST['size'])
                    ->setFrequency($_POST['frequency'])
                ;

                $this->app['product.repository']->insert($product);


                return $this->redirectRoute('homepage');
            }else{
                $msg = '<strong>Le formulaire contient des erreurs</strong>';
                $msg .='<br>-' . implode('</br>-', $errors);

                $this->addFlashMessage($msg,'error');
            }

            return $this->render('register.html.twig');

        }
    }

    public function listAction(){

        $product = $this->app['product.repository']->findAllProducts();

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
                    'admin/product/edit.html.twig',
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