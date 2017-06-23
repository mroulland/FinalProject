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
            
            // Vérification des champs du formulaire 
            if($_POST['frequency'] != "null" && $_POST['size'] != "null"){
                // La fonction findChoosenProduct analyse les choix de l'utilisateur pour trouver le produit correspondant
                $product = $this->app['product.repository']->findChoosenProduct($_POST['size'], $_POST['frequency']);
                
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

        return $this->render('subscription.html.twig');
    }
    
    /**
     * Affiche le panier
     * @return string
     * 
     */
    public function panierList($productId){
        $product = $this->app['product.repository']->find($productId);
        var_dump($product);
         return $this->render('panier.html.twig', ['product' => $product]);
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

                $subscription
                    ->setFrequency($_POST['frequency'])
                    ->setSize($_POST['size'])
                ;

            $this->app['subscription.repository']->update($subscription);
            $this->addFlashMessage('Modifications enregistrées');
            return $this->redirectRoute('profil');
            }
        }     

/*
* SUSPENSION/REPRISE ABONNEMENT
*/ 
    public function toggleSubscription($id = null){

        if(!is_null($id)){
            $subscription = $this->app['subscription.repository']->findByIdUser($id);
            
            if($subscription->getSoftDelete() == '1'){
                $subscription
                ->setSoftDelete('0');

                $this->app['subscription.repository']->update($subscription);

                $this->addFlashMessage("L'abonnement a bien été suspendu");

            }
            elseif($subscription->getSoftDelete() == '0'){
                $subscription
                ->setSoftDelete('1');

                $this->app['subscription.repository']->update($subscription);

                $this->addFlashMessage("L'abonnement a bien été réactivé");
            }
            
            return $this->redirectRoute('profil');
        }
    }        
  
    
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