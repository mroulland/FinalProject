<?php

namespace Controller;

//USE ??

class ContactController extends ControllerAbstract{

    public function sendMessage(){

        $errors = [];

        //Validation des champs du formulaire de contact BtoB
        if(!empty ($_POST)){

            if (!$this->validate($_POST['choice'], new Assert\NotBlank())){ 
                $errors['choice'] = 'Le choix est obligatoire';
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
               
            return $this->render('contact.html.twig');
        }
        else{
            return $this->render('contact.html.twig');
        }

        if(isUserConnected()){
            
            $email= $this->app['user.repository']->getEmail();
        }
        return $this->render(
            'contact.html.twig',
            ['email'=> $email]
        );


    }
          



}