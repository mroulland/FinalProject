<?php

namespace Controller;

//use ? + créer route

/*
* ABONNEMENT 
*/

class Abonnement extends ControllerAbstract{

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

                $user
                     ->setProduct_name($_POST['product_name'])
                    ->setMode($_POST['mode'])
                    ->setStart_date($_POST['start_date'])
                    ->setEnd_date($_POST['end_date'])
                    ->setFrequency($_POST['frequency'])
                ;

            $user = $this->app['subscription.repository']->save($id_subscription);
            $this->addFlashMessage('Modifications enregistrées');
          
            }
        }


    }







/*
* DESABONNEMENT 
*/
    public function deleteSubscription($id_subscription){

      $user = $this->app['subscription.repository']->find($id_subscription);
        
      $this->app['subscription.repository']->delete($id_subscription);
      $this->addFlashMessage("L'abonnement a bien été annulé");
        
      return $this->redirectRoute('profil');  
     
     }





}