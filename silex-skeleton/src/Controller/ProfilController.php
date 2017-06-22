<?php

namespace Controller;

use Controller\ControllerAbstract;
use Repository\SubscriptionRepository;
use Repository\ProductRepository;
use Service\UserManager;
use Entity\User;
use Entity\Product;


// La class ProfilController va servir à l'affichage des données dans la page profil

class ProfilController extends ControllerAbstract{

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
