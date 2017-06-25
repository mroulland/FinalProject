<?php

namespace Controller;

use Controller\ControllerAbstract;

/*
* ABONNEMENT 
*/

class SubscriptionController extends ControllerAbstract{

    // Affichage et traitement du formulaire d'abonnement
    
    public function subscriptionAction(){

        if(!empty($_POST)){
            
            // Vérification des champs du formulaire 
            if($_POST['frequency'] != "null" && $_POST['size'] != "null" && (!empty($_POST['mode']))){
                // La fonction findChoosenProduct analyse les choix de l'utilisateur pour trouver le produit correspondant
                $product = $this->app['product.repository']->findChoosenProduct($_POST['size'], $_POST['frequency']);   
                $shipping = $this->app['shipping.repository']->findById($_POST);
                
                return $this->redirectRoute(
                    'panier', 
                        [
                            'productId' => $product->getIdProduct(),
                            'shipping' => $shipping                     
                        ]      
                );
            }
            else{
                $msg = '<strong>Le formulaire contient des erreurs</strong>';
                $this->addFlashMessage($msg, 'error');
            }             
        }
//intval pour transformer string en int
        return $this->render('subscription.html.twig');
    }
    
    /**
     * Affiche le panier
     * @return string
     * 
     */
    public function panierList($productId){
        $product = $this->app['product.repository']->find($productId);
        return $this->render('panier.html.twig', ['product' => $product]);
    }

    
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