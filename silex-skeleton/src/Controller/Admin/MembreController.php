<?php

namespace Controller\Admin;

class MembreController {
    
    public function listAction(){
        
        $users= $this->app['user.repository']->findAll();
        
        return $this->render(
                
            'admin/membre/list.html.twig',
            ['user'=> $users]
        );
    }
    
    public function editAction($id = null){
        
        if(!is_null($id)){
            
            $user= $this->app['user.repository']->find($id);
        }else{
            
            $user = new Membre;
        }
        
        if(empty($_POST)){
            $user
                    ->setEmail($_POST['email'])
                    ->setPassword($_POST['password'])
                    ->setLastname($_POST['lastname'])
                    ->setFirstname($_POST['firstname'])
                    ->setAdress($_POST['adress'])
                    ->setZipCode($_POST['zip_code'])
                    ->setCity($_POST['city'])
                    ->setTelephone($_POST['telephone'])
                    ->setStatuts($_POST['status']);
            
            $user = $this->app['user.repository']->save($article);
            $this->addFlashMessage('Le membre a bien été enregistré');
        }
        
    }
    
    public function deleteAction($id){
        
        $user = $this->app['membre.repository']->finc($id);
        
        $this->app['membre.repository']->delete($user);
        $this->addFlashMessage('Le membre a bien été supprimé');
        
        return $this->redirectRoute('admin_membres');
    }
    
   

}
