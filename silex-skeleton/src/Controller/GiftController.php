<?php

namespace Controller;

use Service\UserManager; 
use Controller\ControllerAbstract;
use Repository\SubscriptionRepository;
use Entity\Subscription;
use Entity\Product;
use Entity\Shipping;
use Entity\Gift;
use Repository\GiftRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Controller\StripeController;

class GiftController extends ControllerAbstract{
      
    public function createNewPaiement(){
        
        // Si l'utilisateur n'est pas connecté, on le redirige
        if($this->app['user.manager']->isUserConnected()){  
            // On récupère les éléments stockés dans la session
            $product = $this->app['subscription.manager']->getProduct();
            $shipping = $this->app['subscription.manager']->getShipping();
            $duration = $this->app['subscription.manager']->getDuration();

            $totalPrice = ($product->getPrice() + $shipping->getShippingFees())* $duration;

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
                
                //Vérification des champs du form paiment:
                if(!(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))){
                        $errors['email'] = 'L\'email est obligatoire';
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

                    // Une fois le paiment réalisé ... 
                    // Envoyer le mail à l'utilisateur contenant la carte cadeau : 
                    
                    $code = $this->GiftCard($email);

                    // On instancie une nouvelle classe Gift
                    $gift = new Gift();

                    // On ajoute en BDD les informations concernant la carte cadeau
                    $gift
                        ->setIdUser($this->app['user.manager']->getUserId())
                        ->setIdProduct($product->getIdProduct())
                        ->setIdShipping($shipping->getIdShipping())
                        ->setDuration($duration)
                        ->setTotalPrice($totalPrice)
                        ->setCode($code);
                    ;
                    // Insertion en BDD
                    $this->app['gift.repository']->insert($gift);
                    
                    
                    
                    $this->addFlashMessage("Votre carte cadeau a bien été envoyée par mail !");
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
    

    public function random($car){
        $string = "";
        $chaine = "ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
        
        srand((double)microtime()*1000000);
        
        for($i=0; $i<$car; $i++) {
            $string .= $chaine[rand()%strlen($chaine)];
        }
        
        return $string;
    }
    
    public function giftCard(){
        $code = $this->random(20);
        return $code;
    }
    
    public function mailGiftCard($email){
        
        $duration = $this->getDuration();
        $shipping = $this->getShippingMode($this->findById($this->getIdShipping()));
        $product = $this->getNameProduct($this->findById($this->getIdProduct()));
        $description = $this->getDescription($this->findById($this->getIdProduct()));
        
        var_dump($duration);
        var_dump($shipping);
        var_dump($product);
        var_dump($description); die;
        
        // Génère un code de carte cadeau
        $code = $this->giftCard();
        
        // Destinataire : 
        $to  = $email; 
        
        $subject = 'Votre carte cadeau Fleurs d\'ici !';
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";    
        $message = "<html>
            <head>
            <title>Votre Carte cadeau Fleurs d'Ici !</title>
            </head>
            <body>
        
                Voici votre code cadeau à offrir : 
                Pour rappel de votre commande : 
                Bouquet choisi : $product
                Description : $description
                Abonnement de : $duration mois
                Avec livraison : $shipping
            

            </body>
            </html>
        '";
         
        // Envoi
        mail($to, $subject, $message, $headers);
    
        return $code;
        
    }
}
