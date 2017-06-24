<?php

namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;


class ProductController extends ControllerAbstract {

    public function listAction(){

        $products = $this->app['product.repository']->findAllProducts();

        return $this->render(
            'admin/product/list.html.twig',
            ['products' => $products]
        );
    }

    public function registerAction() {
        
        $product = new Product();
        $errors = [];
        
        if(!empty($_POST)){ // Validation des infos
            
             if (!$this->validate($_POST['product_name'], new Assert\NotBlank())){ 
               $errors['product_name'] = 'Vous devez donner un nom à votre produit';
            }   

            if (!$this->validate($_POST['description'], new Assert\NotBlank())){ 
                $errors['description'] = 'Ajoutez une description';
            }  

            if (!$this->validate($_POST['photo'], new Assert\NotBlank())){ 
                $errors['photo'] = 'La photo est obligatoire';

            } elseif(!$this->validate($_POST['price'], new Assert\NotBlank())){
                $errors['price'] = "Vous devez ajouter un prix";
            }

            if (!$this->validate($_POST['size'], new Assert\NotBlank())){ 
                $errors['size'] = "Aucune taille n'est indiquée";
            }
            
            if (!$this->validate($_POST['frequency'], new Assert\NotBlank())){ 
                $errors['frequency'] = 'Aucune fréquence n\'est indiquée';
            }
             
            if(empty($errors)){
            
                $product
                    ->setProductName($_POST['product_name'])             
                    ->setDescription($_POST['description'])
                    ->setPhoto($_POST['photo'])
                    ->setPrice($_POST['price'])
                    ->setSize($_POST['size'])
                    ->setFrequency($_POST['frequency'])
                ;
 
                $this->app['product.repository']->insert($product);           
                $this->addFlashMessage("Le produit a bien été ajouté");
                return $this->redirectRoute('admin_products');
                
            }else{
                $msg = '<strong>Le formulaire contient des erreurs</strong>';
                $msg .='<br>- ' . implode('</br>- ', $errors);
                
                $this->addFlashMessage($msg,'error');
            }
        } 
        return $this->render('admin/product/ajout.html.twig');
        
    }

    

    public function editAction($id = null){

        $product= $this->app['product.repository']->find($id);

        if(!empty($_POST)){
            $product
                ->setProductName($_POST['product_name'])
                ->setDescription($_POST['description'])
                ->setPhoto($_POST['photo'])
                ->setPrice($_POST['price'])
                ->setSize($_POST['size'])
                ->setFrequency($_POST['frequency'])                            
            ;
            
            $this->app['product.repository']->update($product);
            $this->addFlashMessage("Le produit a bien été modifié");
            return $this->redirectRoute('admin_products');
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