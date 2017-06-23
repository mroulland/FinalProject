<?php

namespace Controller;

use Entity\User;
use Service\UserManager;
use Symfony\Component\Validator\Constraints as Assert;



class UserController extends ControllerAbstract{

    public function registerAction(){

        if($this->app['user.manager']->isUserConnected){
            $user = new User();

            $errors = [];

            if(!empty ($_POST)){

            // Validation des champs:

                //Sécu nom
                if (!$this->validate($_POST['lastname'], new Assert\NotBlank())){
                    $errors['lastname'] = 'Le nom est obligatoire';

                }elseif(!$this->validate($_POST['lastname'], new Assert\Length(array(
                'min'=>2,'max' =>25,)))){
                $errors['lastname'] = 'Le nom doit comporter entre 2 et 25 caractères';
                }

                //Sécu prénom
                if (!$this->validate($_POST['firstname'], new Assert\NotBlank())){
                    $errors['firstname'] = 'Le prénom est obligatoire';

                }elseif(!$this->validate($_POST['firstname'], new Assert\Length(array(
                'min'=>2,'max' =>25,)))){
                $errors['firstname'] = 'Le prénom doit comporter entre 2 et 25 caractères';
                }

                //Sécurité email:
                if (!$this->validate($_POST['email'], new Assert\NotBlank())){
                    $errors['email'] = 'L\'email obligatoire';

                } elseif(!$this->validate($_POST['email'], new Assert\Email())){
                    $errors['email'] = "L'email n'est pas valide";
                }

                //Sécurité Adresse:
                if(!$this->validate($_POST['address'], new Assert\NotBlank())){
                    $errors['address'] = 'L\'adresse n\'est pas valide';

                }elseif(!$this->validate($_POST['address'], new Assert\Length(array(
                'min' =>5,'max' =>25,)))){
                $errors['address'] = 'L\'adresse doit comporter entre 5 et 25 caractères';
                }

                //Sécurité Code postal:
                if(!$this->validate($_POST['zipcode'], new Assert\NotBlank())){
                    $errors['zipcode'] = 'Le code postal n\'est pas valide';

                }elseif(!$this->validate($_POST['zipcode'], new Assert\Length(array(
                'min'=>5,'max' =>5,)))){
                $errors['zipcode'] = 'Le code postal doit comporter 5 chiffres';
                }

                //Sécurité Ville:
                if(!$this->validate($_POST['city'], new Assert\NotBlank())){
                    $errors['city'] = 'La ville n\'est pas valide';

                }elseif(!$this->validate($_POST['city'], new Assert\Length(array(
                'min' =>2,'max' =>20,)))){
                    $errors['city'] = 'La ville doit comporter entre 2 et 20 caractères';
                }

                //Sécurité téléphone:
                if(!$this->validate($_POST['phone'], new Assert\NotBlank())){
                    $errors['phone'] = 'Le téléphone n\'est pas valide';

                }elseif(!$this->validate($_POST['phone'], new Assert\Length(array(
                'min'=> 10, 'max'=> 10)))){
                $errors['phone'] = 'Le téléphone doit comporter 10 chiffres';
                }

                //Sécurité mot de pase:
                if (!$this->validate($_POST['password'], new Assert\NotBlank())){
                    $errors['password'] = 'Le mot de passe est obligatoire';

                }elseif(!$this->validate($_POST['password'], new Assert\Length(array(
                'min'=>8,'max' =>25,)))){
                $errors['password'] = 'Le mot de passe doit comporter au minimum 8 caractères';
                }

                // Vérifier si l'utilisateur est déjà inscrit via cet email
                $email = $_POST['email'];
                $existingUser = $this->app['user.repository']->findByEmail($email);

                if(!empty($existingUser)){

                    $errors['email'] = "L'email est déjà utilisé";
                }

               if(empty($errors)){

                    $user
                        ->setLastname($_POST['lastname'])
                        ->setFirstname($_POST['firstname'])
                        ->setEmail($_POST['email'])
                        ->setPhone($_POST['phone'])
                        ->setAddress($_POST['address'])
                        ->setZipcode($_POST['zipcode'])
                        ->setCity($_POST['city'])

                        // Cryptage password
                        ->setPassword($this->app['user.manager']->encodePassword($_POST['password']))
                    ;

                    $this->app['user.repository']->insert($user);

                    $this->app['user.manager']->login($user);

                    return $this->redirectRoute('profil');

                 }else{
                    $msg = '<strong>Le formulaire contient des erreurs</strong>';
                    $msg .='<br>-' . implode('</br>-', $errors);

                    $this->addFlashMessage($msg,'error');
                 }
            }
            return $this->render('register.html.twig');
        }
        return $this->redirectRoute('profil');

     }


    // Connexion
    public function loginAction(){
        if(!$this->app['user.manager']->isUserConnected()){
            $email = '';

            if(!empty($_POST)){

                $email = $_POST['email'];

                $user = $this->app['user.repository']->findByEmail($email);

                if(!is_null($user)){
                    // var_dump($this->app['user.manager']->verifyPassword($_POST['password'], $user->getPassword()));
                    if($this->app['user.manager']->verifyPassword($_POST['password'], $user->getPassword())){

                       $this->app['user.manager']->login($user);

                       return $this->redirectRoute('profil');
                    }
                }
                $this->addFlashMessage('Identification incorrecte', 'error');
            }
            return $this->render(
                'login.html.twig',
                ['email' => $email]
            );
        }else{
            return $this->redirectRoute('profil');
        }
    }

    //Déconnexion

     public function logoutAction(){

         $this->app['user.manager']->logout();
         return $this->redirectRoute('homepage');
     }


    // User Modif infos pour le profil

    public function editAction(){
        $id = $this->app['user.manager']->getUser()->getId();
        
        if(!is_null($id)){
            $user = $this->app['user.repository']->find($id);
            $this->render('profil_edition.html.twig', ['user' => $user]);
            
        }else{
            return $this->redirectRoute('login');
        }

        if(!empty($_POST)){

            $user
                ->setEmail($_POST['email'])
                ->setLastname($_POST['lastname'])
                ->setFirstname($_POST['firstname'])
                ->setAddress($_POST['address'])
                ->setZipcode($_POST['zipcode'])
                ->setCity($_POST['city'])
                ->setPhone($_POST['phone'])
            ;

            if(!empty($_POST['password'])){
                    $user->setPassword($this->app['user.manager']->encodePassword($_POST['password']));
                }
            // Update des infos en bdd
            $this->app['user.repository']->update($user);

            // faire un nouveau login pour actualiser la session
            $this->app['user.manager']->login($user);

            return $this->redirectRoute('profil');
        }

        return $this->render('profil_edition.html.twig', ['user' => $user]);
    }

        // User delete info

    public function deleteAction($id){
        $user = $this->app['user.repository']->find($id);
        $this->addFlashMessage('Modifications enregistrées');
    }
    
    public function profilAction(){
        
        if($this->app['user.manager']->isUserConnected()){
            $user = $this->app['user.manager']->getUser();
            $id = $user->getId();
            $profil =  $this->app['subscription.repository']->findProfilInfo($id);

            return $this->render(
            'profil.html.twig',
                [
                    'user' => $user,                  
                    'profil' => $profil
                ]
            );
        }
        else {
            return $this->redirectRoute('login');
        }
    }
    
  }  