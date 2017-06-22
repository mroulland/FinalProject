<?php

// Controller pour la gestion des abonnements en backoffice

namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\User;
use Entity\Product;
use Entity\Shipping;
use Entity\Subscription;
use Repository\SubscriptionRepository;
use Symfony\Component\Validator\Constraints as Assert;



class SubscriptionController extends ControllerAbstract {



        public function listAction(){

            $subscription = $this->app['subscription.repository']->findAllSubscriptions();

            return $this->render(
                'admin/subscription/list.html.twig',
                ['subscriptions' => $subscriptions]
            );
        }
        
        
        public function registerAction() {
        
        $subscription = new Subscription();
        $errors = [];
        
        if(!empty($_POST)){ // Validation des infos
            
             if (!$this->validate($_POST['id_user'], new Assert\NotBlank())){ 
               $errors['product_name'] = 'Vous devez donner un nom à votre produit';
            }   

            if (!$this->validate($_POST['id_product'], new Assert\NotBlank())){ 
                $errors['description'] = 'Ajoutez une description';
            }  

            if (!$this->validate($_POST['id_shipping'], new Assert\NotBlank())){ 
                $errors['photo'] = 'La photo est obligatoire';

            } elseif(!$this->validate($_POST['start_date'], new Assert\NotBlank())){
                $errors['price'] = "Vous devez ajouter un prix";
            }

            if (!$this->validate($_POST['size'], new Assert\NotBlank())){ 
                $errors['size'] = "Aucune taille n'est indiquée";
            }
            
            if (!$this->validate($_POST['frequency'], new Assert\NotBlank())){ 
                $errors['frequency'] = 'Aucune fréquence n\'est indiquée';
            }
             
            if(empty($errors)){
            
                $product
                    ->setProductName($_POST['product_name'])             
                    ->setDescription($_POST['description'])
                    ->setPhoto($_POST['photo'])
                    ->setPrice($_POST['price'])
                    ->setSize($_POST['size'])
                    ->setFrequency($_POST['frequency'])
                ;
 
                $this->app['product.repository']->insert($product);           
                $this->addFlashMessage("Le produit a bien été ajouté");
                return $this->redirectRoute('admin_products');
                
            }else{
                $msg = '<strong>Le formulaire contient des erreurs</strong>';
                $msg .='<br>- ' . implode('</br>- ', $errors);
                
                $this->addFlashMessage($msg,'error');
            }
        } 
        return $this->render('admin/product/ajout.html.twig');
        
    }

        public function editAction($id_subscription = null){

                if(!is_null($id_subscription)){
                    $subscription= $this->app['subscription.repository']->find($id_subscription);
                }else{ //Si non, création d'un nouvel abonnement

                    $subscription = new Subscription;
                }

                if(empty($_POST)){ // création d'un nouvel Abonnement
                    $abonnement
                            ->setIdSubscription($_POST['id_subscription'])
                            ->setIdUser($_POST['id_user'])
                            ->setIdProduct($_POST['id_product'])
                            ->setIdShipping($_POST['id_shipping'])
                            ->setStartDate($_POST['start_date'])
                            ->setSoftDelete($_POST['soft_delete']);


                    $this->app['subscription.repository']->save($subscription);
                    $this->addFlashMessage("L'abonnement a bien été modifié");
                    return $this->redirectRoute('admin_subscription');
                }

                return $this->render(
                    'admin/subscription/edit.html.twig',
                    [
                        'subscription' =>$subscription,
                    ]
                );
            }

        //Demander à Julien comment faire pour modifier le status de l'abonmnment snasa le supprimer (pour garder l'historique)

//         public function deleteAction($id_subscription){
//             $product = $this->app['subscription.repository']->find($id_product);

//             $this->app['subscription.repository']->delete($subscription);
//             $this->addflashMessage('l\'abonnement a été supprimé');

//             return $this->redirectRoute('admin_subscription');

//         }
}