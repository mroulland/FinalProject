<?php

namespace Controller;

use Controller\ControllerAbstract;
use Service\UserManager;
use Entity\User;

// La class ProfilController va servir à l'affichage des données dans la page profil

class ProfilController extends ControllerAbstract{

    public function profilAction(){
        
        if($this->app['user.manager']->isUserConnected()){
            $user = $this->app['user.manager']->getUser();
            
            return $this->render(
            'profil.html.twig',
            ['user' => $user]
            );
        }
        else {
            return $this->redirectRoute('login');
        }
   
    }
}
