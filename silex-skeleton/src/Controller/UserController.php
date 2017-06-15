
<?php



namespace src\Controller;



use src\Entity\User;

use src\Form\Type\UserType;

use Silex\Application;

use Symfony\component\HttpFondation\Request;



class UserController

{

    public function profil (Request $request, Application $app)

    {



        $user = new User();

        $errors = [];

        $now = new \DateTime();

        $interval  = $now ->diff($user->getCreatedAt());

        $userSince = $interval->format('depuis  %d jours %H heures %I minutes');

    }



    $data = array(

        'membre' => $user,

        'membreDepuis' => $userSince,

    );



    return $app['twig']->render('profil.html.twig',$data);



    }

}
?>
<?php

namespace Controller;

use Entity\User;
use Symfony\Component\Validator\Constraints as Assert;


class UserController extends ControllerAbstract{

    public function registerAction(){

        $user = new User();
        $errors = [];

        if(!empty ($_POST)){


             // Validation des champs:
            if (!$this->validate($_POST['lastname'], new Assert\NotBlank())){ 
            // // <=> new (Symfony\Component\Validator\Constraints)\NotBlank()
            // ; (Assert=Symfony\Component\Validator\Constraints)
                $errors['lastname'] = 'Le nom est obligatoire';
            }   
             if (!$this->validate($_POST['firstname'], new Assert\NotBlank())){ 
                $errors['firstname'] = 'Le prénom est obligatoire';
                
             }   
            if (!$this->validate($_POST['email'], new Assert\NotBlank())){ 
                $errors['email'] = 'L\'email obligatoire';
            
            }elseif(!$this->validate($_POST['email'], new Assert\Email())){
                $errors['email'] = "L'email n'est pas valide";
            }

            if(!$this->validate($_POST['telephone'], new Assert\NotBlank())){
                $errors['telephone'] = 'Telephone n\'est pas valide';
            }

            if (!$this->validate($_POST['password'], new Assert\NotBlank())){ 
                $errors['password'] = 'Le mot de passe est obligatoire';
                
            }

             if (empty($errors)){

                 $user
                    ->setLastname($_POST['lastname'])             
                    ->setFirstname($_POST['firstname'])
                    ->setEmail($_POST['email'])
                    ->setTelephone($_POST['telephone'])
                    ->setPassword($this->app['user.manager']->encodePassword($_POST['password'])) //Cryptage
                ;   

                $this->app['user.repository']->insert($user);           
                $this->app['user.manager']->login($user);
                    
                return $this->redirectRoute('homepage');
             }else{
                $msg = '<strong>Le formulaire contient des erreurs</strong>';
                $msg .='<br>-' . implode('</br>-', $errors);
                
                $this->addFlashMessage($msg,'error');
             }
        }
            
            return $this->render('register.html.twig');
            
             }

             //Connexion
    public function loginAction(){

        $email = '';
        if(!empty($_POST)){
            $email = $_POST['email'];
            
            $user = $this->app[user.repository']->findByEmail($email);
            if(!is_null($user)){ // s'il y a un utilisateur en BDD avec cet email
                // si le mdp saisi est celui de l'utilisateur
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
    }   

    

