<?php

namespace Controller;

use Controller\ControllerAbstract;
use Symfony\Component\Validator\Constraints as Assert;
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
                $shipping = $this->app['shipping.repository']->findById($_POST['mode']);
                             
                return $this->redirectRoute(
                    'panier', 
                        [
                            'productId' => $product->getIdProduct(),
                            'shippingId' => $shipping->getIdShipping()                     
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
    
/*
 * AFFICHAGE DU PANIER 
 */
    /**
     * Affiche le panier
     * @return string
     * 
     */
    public function panierList($productId, $shippingId){
        
            $product = $this->app['product.repository']->findById($productId);
            $shipping = $this->app['shipping.repository']->findById($shippingId);
            
    
        return $this->render(
            'panier.html.twig', 
            [
                'product' => $product,
                'shipping' => $shipping
            ]
        );
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
* Paiement
*/
     public function editPaiement(){
        
        // if(!is_null($id_subscription)){
        //  $user= $this->app['subscription.repository']->find($id_subscription);

        // }else{
        //     return $this->redirectRoute('login');
        // }

        

        if(!empty($_POST)){
         
       
            $token = $_POST['stripeToken'];
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $numbercb = $_POST['numbercb'];
            $monthcb = $_POST['monthcb'];
            $yearcb = $_POST['yearcb'];
            $cvc = $_POST['cvc'];


            $errors=[];
            
            //Vérification du token:
             if (!$this->validate($_POST['stripeToken'], new Assert\NotBlank())){
                    $errors['stripeToken'] = 'Token est obligatoire';
             }

            //Vérification des champs du form paiment:
             if (!$this->validate($_POST['lastname'], new Assert\NotBlank())){
                    $errors['lastname'] = 'Le nom est obligatoire';
             }

            if (!$this->validate($_POST['firstname'], new Assert\NotBlank())){
                    $errors['firstname'] = 'Le prénom est obligatoire';
            }

            if (!$this->validate($_POST['numbercb'], new Assert\NotBlank())){
                    $errors['numbercb'] = 'Le numéro de carte bleu est obligatoire';
            }

            if (!$this->validate($_POST['monthcb'], new Assert\NotBlank())){
                    $errors['monthcb'] = 'Le mois est obligatoire';

            }
            if (!$this->validate($_POST['yearcb'], new Assert\NotBlank())){
                    $errors['yearcb'] = 'L\'année estest obligatoire';

            }
            if (!$this->validate($_POST['cvc'], new Assert\NotBlank())){
                    $errors['cvc'] = 'Le cvc est obligatoire';
            }

            if(empty($errors)){

            

                $ch=curl_init();

                $data = [
                    'source' => $token,
                    'description' =>  $lastname,
                ];

                curl_setopt_array($ch,[ 

                    CURLOPT_URL => 'https://api.stripe.com/v1/customers', 
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_USERPWD => 'sk_test_3JZ1xtsopRAl4LskpBAUKKFX',
                    CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                    CURLOPT_POSTFIELDS => http_build_query($data)
                ]);

                $response = json_decode(curl_exec($ch));
                curl_close($ch);
                var_dump($response);
                die();
            }
    }

     return $this->render('paiement.html.twig');

}




    
/*
* DESABONNEMENT 
*/
    public function deleteSubscription($id){

      $subscription = $this->app['subscription.repository']->findById($id);
        
      $this->app['subscription.repository']->delete($subscription);
      $this->addFlashMessage("L'abonnement a bien été annulé");
        
      return $this->redirectRoute('profil');  
     
     }


     


}