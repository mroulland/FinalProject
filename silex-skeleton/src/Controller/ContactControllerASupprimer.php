<?php



namespace Controller;

use Controller\ControllerAbstract;
use Symfony\Component\Validator\Constraints as Assert;


class ContactController extends ControllerAbstract{
    
    public function contactAction() {
        
        $errors = [];
        
        if(!empty($_POST)){ // Validation des infos
            
             if (!$this->validate($_POST['lastname'], new Assert\NotBlank())){ 
               $errors['lastname'] = 'Le nom est obligatoire';
            }   

            if (!$this->validate($_POST['firstname'], new Assert\NotBlank())){ 
                $errors['firstname'] = 'Le prénom est obligatoire';
            }
            
            if (!$this->validate($_POST['message'], new Assert\NotBlank())){ 
                $errors['message'] = 'Le champ message est obligatoire';
            }
            

            if (!$this->validate($_POST['email'], new Assert\NotBlank())){ 
                $errors['email'] = 'L\'email obligatoire';

            } elseif(!$this->validate($_POST['email'], new Assert\Email())){

                $errors['email'] = "L'email n'est pas valide";
            }
        }
        
        if(isUserConntected()){
            
            $email= $this->app['user.repository']->getEmal();
        }
        
   
        return $this->render(
                
            'contact.html.twig',
            ['email'=> $email]
        );
       
    }
    
          
        
}
