<?php

// Controller pour la gestion des membres en backoffice

namespace Controller\Admin;

use Controller\ControllerAbstract;


class UsersController extends ControllerAbstract{
    
    public function listAction(){ // vue listée des membres
        
        $users= $this->app['user.repository']->findAll();
        
        return $this->render(
                
            'admin/user/list.html.twig',
            ['users'=> $users]
        );
    }
    
    public function editAction($id = null){ // modification 
        
        if(!is_null($id)){ // si l'id existe => modif
            
            $user= $this->app['user.repository']->find($id);
        }else{ //Si non, création d'un nouveau membre
            
            $user = new User;
        }
        
        if(empty($_POST)){ // création d'un nouvel utilsateur
            $user
                    ->setEmail($_POST['email'])
                    ->setPassword($_POST['password'])
                    ->setLastname($_POST['lastname'])
                    ->setFirstname($_POST['firstname'])
                    ->setAddress($_POST['address'])
                    ->setZipcode($_POST['zipcode'])
                    ->setCity($_POST['city'])
                    ->setPhone($_POST['phone'])
                    ->setStatus($_POST['status']);
            
            $user = $this->app['user.repository']->save($article);
            // save vérifie que l'id existe, si non => insert, si oui => update
            $this->addFlashMessage("Le membre a bien été modifié");
        }
        
    }
    
    public function deleteAction($id){ // suppression
        
        $user = $this->app['user.repository']->find($id);
        
        $this->app['user.repository']->delete($user);
        $this->addFlashMessage("Le membre a bien été supprimé");
        
        return $this->redirectRoute('admin_users');
    }
    
   

}

