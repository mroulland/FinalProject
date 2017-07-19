<?php

namespace Controller;

use Service\UserManager;
use Symfony\Component\Validator\Constraints as Assert;

class ContactController extends ControllerAbstract{

    public function sendMessage(){

        $errors = [];

        //Validation des champs du formulaire de contact 
        if(!empty ($_POST)){

            if ($_POST['choice'] == 'null'){
                $errors['choice'] = 'Vous devez faire un choix'; 
            }

            if (!$this->validate($_POST['email'], new Assert\NotBlank())){ 
                $errors['email'] = 'L\'email est obligatoire';

            } elseif(!$this->validate($_POST['email'], new Assert\Email())){
                $errors['email'] = "L'email n'est pas valide";
            }
            
            //Sécurité téléphone
            if(!$this->validate($_POST['phone'], new Assert\NotBlank())){
                $errors['phone'] = 'Telephone n\'est pas valide';

            }elseif(!$this->validate($_POST['phone'], new Assert\Length(array(
            'min'=> 10, 'max' => 10)))){
                $errors['phone'] = 'Le téléphone doit comporter 10 chiffres';
            }

            if(!$this->validate($_POST['zipcode'], new Assert\NotBlank())){
                $errors['zipcode'] = 'Le code postal n\'est pas valide';

            }elseif(!$this->validate($_POST['zipcode'], new Assert\Length(array(
            'min'=> 5, 'max' => 5)))){
                $errors['zipcode'] = 'Le code postal doit comporter 5 chiffres';
            }

            //Sécurité message:
            if(!$this->validate($_POST['message'], new Assert\NotBlank())){
                $errors['message'] = 'Le message n\'est pas valide';

            }elseif(!$this->validate($_POST['message'], new Assert\Length(array(
            'min'=> 10, 'max'=>150)))){
            $errors['message'] = 'Le message doit comporter entre 10 et 150 caractères';
            }

            if(!empty($errors)){
                $msg = '<strong>Le formulaire contient des erreurs</strong>';
                $msg .='<br>-' . implode('</br>-', $errors);

                $this->addFlashMessage($msg,'error');
             }else{
                $email = $_POST['email'];
                $message = $_POST['message'];
                
                //envoie mail: 
                // Destinataire : 
                $to  = 'morgane.roulland@hotmail.fr'; 
                // Sujet
                $subject = 'Contact Fleursdici.fr';
                // En-têtes
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";         
                $headers .= 'From : ' . $email . "\r\n";

                // Envoi
                $envoi = mail($to, $subject, $message, $headers);
                
                if($envoi == 'true'){
                    $msg = '<strong>Votre message a bien été envoyé !</strong>';
                } else{
                    $msg = 'L\'envoi de votre message a eu un problème';
                }    
                
                $this->addFlashMessage($msg);
             }

        }
             
        return $this->render('contact.html.twig'); 
  
        }
    
 
}
          