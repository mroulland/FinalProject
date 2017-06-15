<?php

namespace Controllers;

use Entity\Membre;
use Symfony\Component\Validator\Constraints as Assert;


class MembreControllers extends ControllerAbstract{

    public function registerAction(){

        $membre = new Membre();
        $errors = [];

        if(!empty ($_POST)){


             // Validation des champs:
            if (!$this->validate($_POST['nom'], new Assert\NotBlank())){ 
            // // <=> new (Symfony\Component\Validator\Constraints)\NotBlank()
            // ; (Assert=Symfony\Component\Validator\Constraints)
                $errors['nom'] = 'Le nom est obligatoire';
            }   
             if (!$this->validate($_POST['prenom'], new Assert\NotBlank())){ 
                $errors['prenom'] = 'Le prénom est obligatoire';
                
             }   
            if (!$this->validate($_POST['email'], new Assert\NotBlank())){ 
                $errors['email'] = 'L\'email obligatoire';
            
            }elseif(!$this->validate($_POST['email'], new Assert\Email())){
                $errors['email'] = "L'email n'est pas valide";
            }

            if(!$this->validate($_POST['telephone'], new Assert\NotBlank())){
                $errors['telephone'] = 'Telephone n\'est pas valide';
            }

            if (!$this->validate($_POST['mdp'], new Assert\NotBlank())){ 
                $errors['mdp'] = 'Le mot de passe est obligatoire';
                
            }

             if (empty($errors)){

                 $membre
                    ->setLastname($_POST['nom'])             
                    ->setFirstname($_POST['prenom'])
                    ->setEmail($_POST['email'])
                    ->setTelephone($_POST['telephone'])
                    ->setPassword($this->app['membre.manager']->encodePassword($_POST['mdp'])) //Cryptage
                ;   

                $this->app['membre.repository']->insert($membre);           
                $this->app['membre.manager']->login($membre);
                    
                return $this->redirectRoute('homepage');
             }else{
                $msg = '<strong>Le formulaire contient des erreurs</strong>';
                $msg .='<br>-' . implode('</br>-', $errors);
                
                $this->addFlashMessage($msg,'error');
             }
        }
            
            return $this->render('register.html.twig');
            
             }


    public function loginAction(){

        $email = '';
        if(!empty($_POST)){
            $email = $_POST['email'];
            
            $membre = $this->app['membre.repository']->findByEmail($email);
            if(!is_null($user)){ // s'il y a un utilisateur en BDD avec cet email
                // si le mdp saisi est celui de l'utilisateur
                if($this->app['membre.manager']->verifyPassword($_POST['mdp'], $membre->getPassword())){
                   $this->app['membre.manager']->login($user);
                   
                   return $this->redirectRoute('homepage');
                }       
            }
            
            $this->addFlashMessage('Identification incorrecte', 'error');
        }
        
        return $this->render(
            'login.html.twig',
            ['email' => $email]
        );

    }

    
        public function logoutAction(){
        
        $this->app['membre.manager']->logout();
                   
        return $this->redirectRoute('homepage');

        }   
    }   

    

