<?php

namespace Controller;

use Controller\ControllerAbstract;
use Entity\Subscription;
use Entity\Product;

// Créer route

/*
* ABONNEMENT 
*/

class SubscriptionController extends ControllerAbstract{

    public function listSubscription(){

        
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

                $suscription
                    ->setFrequency($_POST['frequency'])
                    ->setSize($_POST['size'])
                ;

            $this->app['subscription.repository']->save($subscription);
            $this->addFlashMessage('Modifications enregistrées');
            return $this->redirectRoute('profil');
            }
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