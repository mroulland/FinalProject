<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller;

use Repository\ProductRepository;


/**
 * Description of IndexController
 *
 * @author Etudiant
 */
class IndexController extends ControllerAbstract
{
    public function indexAction()
    {
         // 1ere étape : Traiter le formulaire 
        if(!empty($_POST)){
            
            // Vérification des champs du formulaire 
            if($_POST['frequency'] != "null" && $_POST['size'] != "null"){
                var_dump($_POST);
                // La fonction findChoosenProduct analyse les choix de l'utilisateur pour trouver le produit correspondant
                $product = $this->app['product.repository']->findChoosenProduct($_POST['size'], $_POST['frequency']);
                var_dump($product); 
                return $this->redirectRoute(
                    'panier', 
                    ['productId' => $product->getIdProduct()]      
                );
            }
            else{
                $msg = '<strong>Le formulaire contient des erreurs</strong>';
                $this->addFlashMessage($msg, 'error');
            }
             
        }
        return $this->render('index.html.twig');
    }
}
