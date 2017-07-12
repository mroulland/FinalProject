<?php

namespace Controller;

use Controller\ControllerAbstract;
use Controller\StripeController;
use Entity\Subscription;
use Entity\Gift;
use Symfony\Component\Validator\Constraints as Assert;

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
                    $stripe->api('charges',[

                        //En centimes!
                        'amount'=> $totalPrice * 100,
                        'currency' => 'eur',
                        'customer' => $customer->id,
                    ]);

                    // Une fois le paiment réalisé ... 
                    // Envoyer le mail à l'utilisateur contenant la carte cadeau : 
                    // Retourne le code de la carte cadeau
                    $code = $this->mailGiftCard($email, $duration, $shipping, $product);

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
    
    public function mailGiftCard($email, $duration, $shipping, $product){
        
        $mode = $shipping->getMode();
        $productName = $product->getProductName();
        $description = $product->getDescription();
    
        // Génère un code de carte cadeau
        $code = $this->giftCard();
        
        // Destinataire : 
        $to  = $email; 
        
        $subject = 'Votre carte cadeau Fleurs d\'ici !';
        $header  = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";    
        $message = "<html>
            <head>
            <title>Votre Carte cadeau Fleurs d'Ici !</title>
            </head>
            <body>
        
                Voici votre code cadeau à offrir : $code
                Pour rappel de votre commande : 
                Bouquet choisi : $productName
                Description : $description
                Abonnement de : $duration mois
                Avec livraison : $mode
            

            </body>
            </html>
        '";
         
        // Envoi
        //mail($to, $subject, $message, $header);
        
    
        return $code;
        
    }
    
    public function giftAction(){
        // On récupère la date du jour :
        $date = $this->app['subscription.repository']->date();
        
        // On vérifie si l'utilisateur connecté a déjà un abonnement en cours
        $abonnement = $this->app['subscription.repository']->findByIdUser($this->app['user.manager']->getUserId());

        
        if($abonnement == false){
            
            if(!empty($_POST) && strlen($_POST['code']) == 20){
            
            // On vérifie si le code existe et si il a déjà été utilisé
            $gift = $this->app['gift.repository']->findByCode($_POST['code']);
            
                if($gift){
                    // on vérifie qu'un bénéficiaire n'a pas déjà été associé à cette carte
                    if(($gift->getIdReceiver()) == 0) {

                        // Enregistrer les nouvelles informations de l'utilisateur sur l'abonnement
                        $gift->setIdReceiver($this->app['user.manager']->getUserId());

                        $gift->setStartDate($date);

                        // On additionne la date de commencement avec la durée de l'abonnement
                        $date_array = explode("/", $date);              
                        $date_end = $date_array[1] + $gift->getDuration();
                        $end_date = $date_array[0 ] .'/' . $date_end.'/'.$date_array[2];

                        $gift->setEndDate($end_date); 

                        $this->app['gift.repository']->update($gift);

                        $subscription = new Subscription();
                         // On ajoute en BDD les informations concernant la commande
                        $subscription
                            ->setIdUser($gift->getIdReceiver())
                            ->setIdProduct($gift->getIdProduct())
                            ->setIdShipping($gift->getIdShipping())
                            ->setStartDate($date)
                            ->setEndDate($gift->getEndDate())
                        ;

                        // Insertion en BDD
                        $this->app['subscription.repository']->insert($subscription);

                        $this->addFlashMessage("Carte cadeau activée !", 'success');
                        return $this->redirectRoute('profil');
                    }
                    else{
                        $this->addFlashMessage("Ce code a déjà été utilisé.", 'error');
                    }
                } else {
                    $this->addflashMessage("Le code n'est pas valide. Veuillez réessayer.", "error");
                }
            }    
           
        } else {
            $this->addflashMessage("Vous avez déjà un abonnement en cours", "error");
        }
        
        return $this->render('gift_card.html.twig'); 
    }
    
    
    
}
