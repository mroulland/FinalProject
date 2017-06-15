<?php

namespace Controller\Admin;

class userController {
    
    public function listAction(){
        
        $users= $this->app['user.repository']->findAll();
        
        return $this->render(
                
            'admin/user/list.html.twig',
            ['users'=> $users]
        );
    }
    
    public function editAction($id = null){
        
        if(!is_null($id)){
            
            $user= $this->app['user.repository']->find($id);
        }else{
            
            $user = new User;
        }
        
        if(empty($_POST)){
            $user
                    ->setEmail($_POST['email'])
                    ->setPassword($_POST['password'])
                    ->setLastName($_POST['lastname'])
                    ->setFirstName($_POST['firstname'])
                    ->setAdress($_POST['adress'])
                    ->setZipcode($_POST['zipcode'])
                    ->setCity($_POST['city'])
                    ->setPhonenumber($_POST['phonenumber'])
                    ->setStatus($_POST['status']);
            
            $user = $this->app['user.repository']->save($article);
            $this->addFlashMessage("L'utilisateur a bien été modifié");
        }
        
    }
    
    public function deleteAction($id){
        
        $user = $this->app['user.repository']->find($id);
        
        $this->app['user.repository']->delete($user);
        $this->addFlashMessage("L'utilisateur a bien été supprimé");
        
        return $this->redirectRoute('admin_users');
    }
    
   

}
