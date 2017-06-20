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
                $errors['choice'] = 'Le choix n\'est pas bon'; 
            }

            if (!$this->validate($_POST['email'], new Assert\NotBlank())){ 
                $errors['email'] = 'L\'email obligatoire';

            } elseif(!$this->validate($_POST['email'], new Assert\Email())){
                $errors['email'] = "L'email n'est pas valide";
            }
            
            if(!$this->validate($_POST['phone'], new Assert\NotBlank())){
                $errors['phone'] = 'Telephone n\'est pas valide';
            }

            if(!$this->validate($_POST['zipcode'], new Assert\NotBlank())){
                $errors['zipcode'] = 'Le code postal n\'est pas valide';
            }

            if(!$this->validate($_POST['message'], new Assert\NotBlank())){
                $errors['message'] = 'Le message n\'est pas valide';
            }

            if(!empty($errors)){
                $msg = '<strong>Le formulaire contient des erreurs</strong>';
                $msg .='<br>-' . implode('</br>-', $errors);

                $this->addFlashMessage($msg,'error');
             } else {
                $msg = '<strong>Votre message a bien été envoyé !</strong>';
                $this->addFlashMessage($msg);
             }
        }
        return $this->render('contact.html.twig'); 

        }
    
    public function isUserConnected(){

        return $this->render('profil.html.twig'); 
        
    }


}
          