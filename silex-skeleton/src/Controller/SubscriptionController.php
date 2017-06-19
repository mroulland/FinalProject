<?php

namespace Controller;

use Controller\ControllerAbstract;
use Repository\SubscriptionRepository;
use Entity\Subscription;
use Entity\Product;

// Créer route

/*
* ABONNEMENT 
*/

class SubscriptionController extends ControllerAbstract{

    // Affichage du formulaire d'aboonement
    
    public function subscriptionAction(){

        // 1ere étape : Traiter le formulaire 
        if(!empty($_POST)){
            $errors = [];
            $parameters = [];
            
            // Vérification des champs du formulaire 
            if($_POST['frequency'] != 'null'){
                $parameters['frequency'] = $_POST['frequency'];
            }
            else{
                $error['frequency'] = 'La fréquence indiquée est incorrecte';
            }
            
            if($_POST['size'] != 'null'){
                $parameters['size'] = $_POST['size'];
            }
            else{
                $error['size'] = 'La taille indiquée est incorrecte';
            }
            
            var_dump($parameters);  
             // S'il n'y a pas d'erreur, on cherche le produit correspondant
            if(empty($errors)){
            
                $choosenProduct = $this->app['subscription.repository']->findChoosenProduct($parameters);
            
                return $this->render('panier.html.twig', $choosenProduct);
            
          
            }
            
            else{
               $msg = '<strong>Le formulaire contient des erreurs</strong>';
               $msg .='<br>-' . implode('</br>-', $errors);

               $this->addFlashMessage($msg,'error');
            }
             
        } else{
            return $this->render('subscription.html.twig');
        }
    }
    

    
    // 2eme étape : stocker dans des variable celles de $_POST

    
  
    // 3e étape : Appeler la fonction SQL chooseProduct() 
    
    // 4e étape : Renvoyer vers le panier avec un objet $chosenProduct
    

/*
* MODIFICATION ABONNEMENT 
*/
    public function editSubscription($id_subscription= null){

        if(!is_null($id_subscription)){
         $user= $this->app['subscription.repository']->find($id_subscription);

        }else{
            return $this->redirectRoute('login');
        }

        if(empty($_POST)){

                $suscription
                    ->setFrequency($_POST['frequency'])
                    ->setSize($_POST['size'])
                ;

            $this->app['subscription.repository']->save($subscription);
            $this->addFlashMessage('Modifications enregistrées');
            return $this->redirectRoute('profil');
            }
        }     

/*
* SUSPENSION ABONNEMENT
*/ 





/*
* DESABONNEMENT 
*/
    public function deleteSubscription($id_subscription){

      $subscription = $this->app['subscription.repository']->find($id_subscription);
        
      $this->app['subscription.repository']->delete($subscription);
      $this->addFlashMessage("L'abonnement a bien été annulé");
        
      return $this->redirectRoute('profil');  
     
     }





}