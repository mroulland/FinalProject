<?php

// Remi's work:

namespace Controller;


use Entity\User;

use src\Form\Type\UserType;

use Silex\Application;

use Symfony\component\HttpFondation\Request;

/*

*root Tanguy

*/

use Symfony\Component\Validator\Constraints as Assert;


// class UserController

// {

//     public function profil (Request $request, Application $app)
//     {

//         $user = new User();

//         $errors = [];

//         $now = new \DateTime();

//         $interval  = $now ->diff($user->getCreatedAt());

//         $userSince = $interval->format('depuis  %d jours %H heures %I minutes');

//     }

//     $data = array(



//         'membre' => $user,

//         'membreDepuis' => $userSince,


//     );

//     return $app['twig']->render('profil.html.twig',$data);

//     }

// }


//Tanguy's work


class UserController extends ControllerAbstract{


    public function registerAction(){
        $user = new User();

        $errors = [];

        if(!empty ($_POST)){

             // Validation des champs:

            if (!$this->validate($_POST['lastname'], new Assert\NotBlank())){ 

            // <=> new (Symfony\Component\Validator\Constraints)\NotBlank()
            // ; (Assert=Symfony\Component\Validator\Constraints)
                
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
            
            if (!$this->validate($_POST['password'], new Assert\NotBlank())){ 

                $errors['password'] = 'Le mot de passe est obligatoire';
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
  
     
    // Connexion

    public function loginAction(){

        $email = '';

        if(!empty($_POST)){

            $email = $_POST['email'];

            $user = $this->app['user.repository']->findByEmail($email);

            if(!is_null($user)){ 

                if($this->app['user.manager']->verifyPassword($_POST['password'], $user->getPassword())){
                   $this->app['user.manager']->login($user);
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

       //Déconnexion

        public function logoutAction(){
        $this->app['user.manager']->logout();
        return $this->redirectRoute('homepage');
        }
        /*
        *User Modif infos
        *
        */

        public function editAction($id==null){
            if(!is_null($id)){
                $user= $this->app['user.repository']->find($id);
            }else{
                return $this->redirectRoute('login');
                }

                if(empty($_POST)){
                $user
                    ->setEmail($_POST['email'])
                    ->setPassword($_POST['password'])
                    ->setLastname($_POST['lastname'])
                    ->setFirstname($_POST['firstname'])
                    ->setAdress($_POST['adress'])
                    ->setZipCode($_POST['zipcode'])
                    ->setCity($_POST['city'])
                    ->setPhone($_POST['phone'])
                    ->setStatus($_POST['status'])
                    ;
            $user = $this->app['user.repository']->save($id);
            $this->addFlashMessage('Modifications enregistrées');
                 }
        }
        /*
        *User delete info
        *
        */
        public function deleteAction($id){

         $user = $this->app['user.repository']->find($id);
         $this->addFlashMessage('Modifications enregistrées');

            }

  }  





