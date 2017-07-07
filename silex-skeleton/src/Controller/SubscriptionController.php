<?php

namespace Controller;


use Controller\ControllerAbstract;
use Repository\SubscriptionRepository;
use Entity\Subscription;
use Entity\Product;
use Entity\Shipping;
use Symfony\Component\Validator\Constraints as Assert;
use Controller\StripeController;
use Service\UserManager;

/*
* ABONNEMENT
*/

class SubscriptionController extends ControllerAbstract{

    // Affichage et traitement du formulaire d'abonnement

    public function subscriptionAction($productId = null){
        
        // Si le formulaire est rempli = traitement du formulaire
        if(!empty($_POST)){
  
            $product = new Product();
            $shipping = new Shipping();
            
            $product
                ->setSize($_POST['size'])
                ->setFrequency($_POST['frequency'])
            ; 
            
            $shipping
                ->setMode($_POST['mode'])
            ; 
            
            // Vérification des champs du formulaire
            if($_POST['frequency'] != "null" && $_POST['size'] != "null" && (!empty($_POST['mode']))){
                // La fonction findChoosenProduct analyse les choix de l'utilisateur pour trouver le produit correspondant
                $product = $this->app['product.repository']->findChoosenProduct($_POST['size'], $_POST['frequency']);
                $shipping = $this->app['shipping.repository']->findById($_POST['mode']);
                
                // On inscrit les choix dans la Session
                $this->app['subscription.manager']->setProduct($product);
                $this->app['subscription.manager']->setShipping($shipping);
                
                if($_POST['offre'] == 'offrir' && $_POST['duration'] != null){                    
                    
                    $duration = $_POST['duration'];
                    
                    $this->app['subscription.manager']->setDuration($duration);
                    return $this->redirectRoute('panier');
                    
                    
                    /*$date = date('d/m/Y', time());
                    $this->app['subscription.manager']->setStartDate($date);
                    
                    $date_array = explode("/", $date);              
                    $date_try = $date_array[1] + $_POST['duration'];
                    $end_date = $date_array[0 ] .'/' . $date_try.'/'.$date_array[2];
                    $this->app['subscription.manager']->setEndDate($end_date);   
                    
                    return $this->redirectRoute('cartecadeau'); */
                    
                }
      
                // on redirige vers le panier
                return $this->redirectRoute('panier');
            }
            else{
                $msg = '<strong>Le formulaire contient des erreurs</strong>';
                $this->addFlashMessage($msg, 'error');
            }
        }
        //intval pour transformer string en int
        return $this->render('subscription.html.twig',  ['productId' => $productId]
                );
    }

/*
 * AFFICHAGE DU PANIER
 */
    /**
     * Affiche le panier
     * @return string
     *
     */
    public function panierList(){
      
        if($this->app['subscription.manager']->getProduct()){
            $product = $this->app['subscription.manager']->getProduct();
            $shipping = $this->app['subscription.manager']->getShipping();
            
            $duration = $this->app['subscription.manager']->getDuration();
            
            
            return $this->render(
                'panier.html.twig',
                [
                    'duration' => $duration,
                    'product' => $product,
                    'shipping' => $shipping   
                ]                    
            ); 
            
        }
        return $this->render('panier.html.twig');      
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
* Création d'un utilisateur qui paye (customer)
*/


    public function createNewSubscription(){
        
        
        // Si l'utilisateur n'est pas connecté, on le redirige

        if($this->app['user.manager']->isUserConnected()){
            // On récupère les éléments stockés dans la session 
            
            $product = $this->app['subscription.manager']->getProduct();
            $shipping = $this->app['subscription.manager']->getShipping();
           
            $productId = $product->getIdProduct();
            $shippingId = $shipping->getIdShipping();
            
            // On associe le produit récupéré au plan de payement
            if($productId == 1 && $shippingId == 2){
                $plan = '1';
            }
            elseif($productId == 1 && $shippingId == 1){
                $plan = '2';
            }
            elseif($productId == 3 && $shippingId == 2){
                $plan = '3';
            }
            elseif($productId == 3 && $shippingId == 1){
                $plan = '4';
            }
            elseif($productId == 2 && $shippingId == 2){
                $plan = '5';
            }
            elseif($productId == 2 && $shippingId == 1){
                $plan = '6';
            }
            elseif($productId == 4 && $shippingId == 2){
                $plan = '7';
            }
            elseif($productId == 4 && $shippingId == 1){
                $plan = '8';
            }

            // On vérifie les champs du formulaire de paiement
            if(!empty($_POST)){

                $token = $_POST['stripeToken'];
                $email = $_POST['email'];
                $lastname = $_POST['lastname'];
                $firstname = $_POST['firstname'];
                $numbercb = $_POST['numbercb'];
                $monthcb = $_POST['monthcb'];
                $yearcb = $_POST['yearcb'];
                $cvc = $_POST['cvc'];

                $errors = [];

                //Vérification du token:
                if (!$this->validate($_POST['stripeToken'], new Assert\NotBlank())){
                        $errors['stripeToken'] = 'Token est obligatoire';
                }

                //Vérification des champs du form paiment:
                if(!(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))){
                        $errors['email'] = 'L\'email obligatoire';

                } elseif(!$this->validate($_POST['email'], new Assert\Email())){
                        $errors['email'] = "L'email n'est pas valide";
                }

                if (!$this->validate($_POST['numbercb'], new Assert\NotBlank())){
                        $errors['numbercb'] = 'Le numéro de carte bleu est obligatoire';
                }

                if (!$this->validate($_POST['monthcb'], new Assert\NotBlank())){
                        $errors['monthcb'] = 'Le mois est obligatoire';
                }

                if (!$this->validate($_POST['yearcb'], new Assert\NotBlank())){
                        $errors['yearcb'] = 'L\'année est obligatoire';

                }
                if (!$this->validate($_POST['cvc'], new Assert\NotBlank())){
                        $errors['cvc'] = 'Le cvc est obligatoire';
                }

                // S'il n'y a pas d'erreur ...
                if(empty($errors)){
                    $user = $this->app['user.manager']->getUser();

                    $user->setStripeToken($token);
                    $this->app['user.repository']->update($user);

                    // On instancie une classe StripeController
                    $stripe = new StripeController ('sk_test_3JZ1xtsopRAl4LskpBAUKKFX');

                    // On crée un nouvel utilisateur Stripe
                    $customer = $stripe->api('customers',[
                        'source' => $token,
                        'description' => $lastname,
                        'email' => $email
                    ]);
                    
                    // On souscrit l'abonnement sur le plan correspondant
                    $stripe->api("customers/{$customer->id}", [
                       'plan' => $plan
                    ]);         
                    
                    // On instancie une nouvelle classe Subscription
                    $subscription = new Subscription();
                    
                    // On ajoute en BDD les informations concernant la commande
                    $subscription
                        ->setIdUser($this->app['user.manager']->getUserId())
                        ->setIdProduct($product->getIdProduct())
                        ->setIdShipping($shipping->getIdShipping())
                        ->setStartDate($this->app['subscription.repository']->date())
                        ->setEndDate(NULL)
                    ;
                    // Insertion en BDD
                    $this->app['subscription.repository']->insert($subscription);

                    $this->addFlashMessage("Votre commande a bien été enregistrée");
                    
                    return $this->redirectRoute('profil');
                }else{
                    $msg = '<strong>Le formulaire contient des erreurs</strong>';
                    $msg .='<br>- ' . implode('</br>- ', $errors);

                    $this->addFlashMessage($msg,'error');
                }
            }
        }else {

            return $this->redirectRoute('login');
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