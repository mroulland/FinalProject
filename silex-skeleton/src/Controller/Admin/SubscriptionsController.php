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



class SubscriptionsController extends ControllerAbstract {

    
    public function listAction(){

        $subscriptions = $this->app['subscription.repository']->findAllSubscriptions();

        return $this->render(
            'admin/subscription/list.html.twig',
            ['subscriptions' => $subscriptions]
        );
    }


    public function registerAction() {

        $subscription = new Subscription();

        $products = $this->app['product.repository']->findAllProducts();

        $errors = [];


        if(!empty($_POST)){ // Validation des infos

            if(!$this->app['user.repository']->find($_POST['id_user'])){ 
               $errors['id_user'] = 'L\'utilisateur n\'existe pas';
            }   

            if (!$this->app['product.repository']->find($_POST['id_product'])){ 
                $errors['product_name'] = 'Le nom du produit n\'est pas reconnu';
            }  

            if (!$this->app['shipping.repository']->find($_POST['id_shipping'])){ 
                $errors['id_product'] = 'Le mode de livraison n\'est pas indiqué';
            }

            if(!$this->validate($_POST['start_date'], new Assert\Date())){
                $errors['start_date'] = 'La date de début n\'est pas valide';
            }

            if(empty($_POST['end_date'])){
                $_POST['end_date'] = NULL;
            }

            // Il faudra rajouter une option pour rentrer l'email à la place de l'id

            if(empty($errors)){

                $subscription
                    ->setIdUser($_POST['id_user'])             
                    ->setIdProduct($_POST['id_product'])
                    ->setIdShipping($_POST['id_shipping'])
                    ->setStartDate($this->app['subscription.repository']->date())
                    ->setEndDate($_POST['end_date'])                   
                ;

                $this->app['subscription.repository']->insert($subscription);           
                $this->addFlashMessage("La commande a bien été ajouté");
                return $this->redirectRoute('admin_subscription');

            }else{
                $msg = '<strong>Le formulaire contient des erreurs</strong>';
                $msg .='<br>- ' . implode('</br>- ', $errors);

                $this->addFlashMessage($msg,'error');
            }
        } 
        return $this->render(
            'admin/subscription/ajout.html.twig',
            ['products' => $products]
        );

    }
    

    public function editAction($id = null){

            $subscription = $this->app['subscription.repository']->find($id);

            if(!empty($_POST)){ // création d'un nouvel Abonnement
                $subscription
                        ->setIdSubscription($_POST['id_subscription'])
                        ->setIdUser($_POST['id_user'])
                        ->setIdProduct($_POST['id_product'])
                        ->setIdShipping($_POST['id_shipping'])
                        ->setStartDate($_POST['start_date'])
                        ->setEndDate($_POST['end_date'])
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