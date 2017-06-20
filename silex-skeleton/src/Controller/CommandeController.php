<?php

namespace Controller;

//USE ????

class CommandeController extends ControllerAbstract{

        public function SendMessage(){

            //Validation champ formulaire pour les commandes ponctuels:
            if(!empty($_POST)){

                if (!$this->validate($_POST['lastname'], new Assert\NotBlank())){ 
                $errors['lastname'] = 'Le nom est obligatoire';
            }   

            if (!$this->validate($_POST['firstname'], new Assert\NotBlank())){ 
                $errors['firstname'] = 'Le prénom est obligatoire';
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


            }

        }







}