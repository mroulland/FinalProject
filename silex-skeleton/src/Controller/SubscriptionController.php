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
                
                // on redirige vers le panier
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
    public function panierList($productId, $shippingId){
        
        if($productId != null && $shippingId != null){          
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
    /*public function createPaiement($productId, $shippingId){

        // Si l'utilisateur n'est pas connecté, on le redirige

        if($this->app['user.manager']->isUserConnected()){

            // On récupère un objet produit correspondant à celui du panier
            // On le stock en Session
            $product = $this->app['product.repository']->findById($productId);
            $_SESSION['product'] = $product;

            // Idem avec la livraison
            $shipping = $this->app['shipping.repository']->findById($shippingId);
            $_SESSION['shipping'] = $shipping;

            $totalPrice = $product->getPrice() + $shipping->getShippingFees();

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
                        $errors['yearcb'] = 'L\'année estest obligatoire';

                }
                if (!$this->validate($_POST['cvc'], new Assert\NotBlank())){
                        $errors['cvc'] = 'Le cvc est obligatoire';
                }

                // S'il n'y a pas d'erreur ...
                if(empty($errors)){

                    // On instancie une classe StripeController
                    $stripe= new StripeController ('sk_test_3JZ1xtsopRAl4LskpBAUKKFX');

                    // On crée un nouvel utilisateur Stripe
                    $customer= $stripe->api('customers',[
                        'source' => $token,
                        'description' =>  $email,
                    ]);

                   //Création charges:
                    $charge = $stripe->api('charges',[

                        //En centimes!
                        'amount'=> $totalPrice * 100,
                        'currency' => 'eur',
                        'customer' => $customer->id,
                    ]);

                    // On instancie une nouvelle classe Subscription
                    $subscription = new Subscription();

                    // On ajoute en BDD les informations concernant la commande
                    $subscription
                        ->setIdUser($this->app['user.manager']->getUserId())
                        ->setIdProduct($_SESSION['product']->getIdProduct())
                        ->setIdShipping($_SESSION['shipping']->getIdShipping())
                        ->setStartDate($this->app['subscription.repository']->date())
                        ->setEndDate(NULL)
                    ;
                    // Insertion en BDD
                    $this->app['subscription.repository']->insert($subscription);

                    $this->addFlashMessage("Votre commande a bien été enregistrée");
                    return $this->redirectRoute('profil');
                }

                else{
                    $msg = '<strong>Le formulaire contient des erreurs</strong>';
                    $msg .='<br>- ' . implode('</br>- ', $errors);

                    $this->addFlashMessage($msg,'error');
                }
            }
    }
        else {

            return $this->redirectRoute('login');
        }
    return $this->render('paiement.html.twig');
}*/



public function createNewSubscription($productId, $shippingId){

        // Si l'utilisateur n'est pas connecté, on le redirige

        if($this->app['user.manager']->isUserConnected()){

            // On récupère un objet produit correspondant à celui du panier
            // On le stock en Session
            $product = $this->app['product.repository']->findById($productId);
            $_SESSION['product'] = $product;

            // Idem avec la livraison
            $shipping = $this->app['shipping.repository']->findById($shippingId);
            $_SESSION['shipping'] = $shipping;


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

                    // CA MARCHE !!! var_dump($customer); die;
                    
                    $stripe->api("customers/{$customer->id}", [
                       'plan' => $plan
                    ]);          
                    
                    
                    // On instancie une nouvelle classe Subscription
                    $subscription = new Subscription();

                    // On ajoute en BDD les informations concernant la commande
                    $subscription
                        ->setIdUser($this->app['user.manager']->getUserId())
                        ->setIdProduct($_SESSION['product']->getIdProduct())
                        ->setIdShipping($_SESSION['shipping']->getIdShipping())
                        ->setStartDate($this->app['subscription.repository']->date())
                        ->setEndDate(NULL)
                    ;
                    // Insertion en BDD
                    $this->app['subscription.repository']->insert($subscription);

                    $this->addFlashMessage("Votre commande a bien été enregistrée");
                    return $this->redirectRoute('profil');
                }

                else{
                    $msg = '<strong>Le formulaire contient des erreurs</strong>';
                    $msg .='<br>- ' . implode('</br>- ', $errors);

                    $this->addFlashMessage($msg,'error');
                }
            }
    }
        else {

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