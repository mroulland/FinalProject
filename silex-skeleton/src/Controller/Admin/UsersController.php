<?php

// Controller pour la gestion des membres en backoffice

namespace Controller\Admin;

use Controller\ControllerAbstract;
use Repository\UserRepository;
use Entity\User;
use Symfony\Component\Validator\Constraints as Assert;


class UsersController extends ControllerAbstract{
    
        public function listAction(){ // vue listée des membres
        
        $users= $this->app['user.repository']->findAll();
   
        return $this->render(
                
            'admin/user/list.html.twig',
            ['users'=> $users]
        );
    }
    

    
    // modification 
    
    public function editAction($id = null){ 
        
        if(!is_null($id)){ // si l'id existe => modif           
            $user = $this->app['user.repository']->find($id);
            
        } else{ //Si non, création d'un nouveau membre      
            $user = new User;
        }
     
        $errors = [];
        
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
            
            if (!$this->validate($_POST['address'], new Assert\NotBlank())){ 

                $errors['address'] = "L'adresse est obligatoire";
            }
            
            if (!$this->validate($_POST['zipcode'], new Assert\NotBlank())){ 

                $errors['zipcode'] = "Le code postal est obligatoire";
            }
            
            if (!$this->validate($_POST['city'], new Assert\NotBlank())){ 

                $errors['city'] = "La ville est obligatoire";
            }
            
            if(!$this->validate($_POST['phone'], new Assert\NotBlank())){
                $errors['phone'] = 'Telephone n\'est pas valide';
            }
            
            //var_dump($_POST); 
            
            if(empty($errors)){
                
                $user                
                    ->setLastname($_POST['lastname'])
                    ->setFirstname($_POST['firstname'])
                    ->setEmail($_POST['email'])
                    ->setAddress($_POST['address'])
                    ->setZipcode($_POST['zipcode'])
                    ->setCity($_POST['city'])
                    ->setPhone($_POST['phone'])
                    ->setStatus($_POST['status']);
                           
                if(!empty($_POST['password'])){
                    $user->setPassword($this->app['user.manager']->encodePassword($_POST['password']));
                }
                
                $this->app['user.repository']->update($user);
                // save vérifie que l'id existe, si non => insert, si oui => update
                $this->addFlashMessage("L'utilisateur a bien été modifié");
                

                return $this->redirectRoute('admin_users');
            
            }else{
                $msg = '<strong>Le formulaire contient des erreurs</strong>';
                $msg .='<br>-' . implode('</br>-', $errors);
                
                
                $this->addFlashMessage($msg,'errors');
            }
            
        }
       // var_dump($user);
        return $this->render(
            'admin/user/edit.html.twig',
            ['user' => $user]
        );
    }
    
    
 
    
    // suppression
    public function deleteAction($id){ 
        
        $user = $this->app['user.repository']->find($id);
        
        $this->app['user.repository']->delete($user);
        $this->addFlashMessage("Le membre a bien été supprimé");
        
        return $this->redirectRoute('admin_users');
    }
    
   
    
    
        
    /* public function registerAction() {
        
        $user = new User();
        $errors = [];
        
        if(!empty($_POST)){ // Validation des infos
            
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

            if (!$this->validate($_POST['address'], new Assert\NotBlank())){ 

                $errors['address'] = "L'adresse est obligatoire";
            }
            
            if (!$this->validate($_POST['password'], new Assert\NotBlank())){ 

                $errors['password'] = 'Le mot de passe est obligatoire';
            }
            
            if (!$this->validate($_POST['zipcode'], new Assert\NotBlank())){ 

                $errors['zipcode'] = "Le code postal est obligatoire";
            }
            
            if (!$this->validate($_POST['city'], new Assert\NotBlank())){ 

                $errors['city'] = "La ville est obligatoire";
            }
            
             if(!$this->validate($_POST['phone'], new Assert\NotBlank())){
                $errors['phone'] = 'Telephone n\'est pas valide';

            }

            // Vérifier si l'utilisateur est déjà inscrit via cet email
            $email = $_POST['email'];
            $existingUser = $this->app['user.repository']->findByEmail($email);

            if(!empty($existingUser)){
                $errors['email'] = "L'email est déjà utilisé";
            }
            
            var_dump($_POST); die;
            if(empty($errors)){
            
                $user
                    ->setLastname($_POST['lastname'])             
                    ->setFirstname($_POST['firstname'])
                    ->setEmail($_POST['email'])
                    ->setPassword($_POST['password'])
                    ->setAddress($_POST['address'])
                    ->setZipcode($_POST['zipcode'])
                    ->setCity($_POST['city'])
                    ->setPhone($_POST['phone'])
                    ->setStatus($_POST['status'])
                ;
 
                $this->app['user.repository']->insert($user);           
                $this->app['user.manager']->login($user);

                return $this->redirectRoute('homepage');
                
            }else{
                $msg = '<strong>Le formulaire contient des erreurs</strong>';
                $msg .='<br>-' . implode('</br>-', $errors);
                
                $this->addFlashMessage($msg,'error');
            }
            
            return $this->render('register.html.twig');

        } else{
            return $this->render('admin/user/edit.html.twig');
        }
    } */
}

