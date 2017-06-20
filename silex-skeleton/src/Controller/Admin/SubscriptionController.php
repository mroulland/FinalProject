<?php

// Controller pour la gestion des abonnements en backoffice

namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\User;
use Symfony\Component\Validator\Constraints as Assert;



class SubscriptionController extends ControllerAbstract {


    public function findAll() {
        $sql = "SELECT * FROM subscription ORDER BY id_subscription";
        $result = $this->getDb()->fetchAll($sql);

        $entities = array();
        foreach ($result as $row) {
            $id = $row['id_subscription'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    public function listAction(){

        $subscription = $this->app['subscription.repository']->findAllProducts();

        return $this->render(
            'admin/user/subscription.html.twig',
            ['subscription' => $subscription]
        );
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
                            ->setEndDate($POST['End_date'])
                            ->setFrequency($_POST['frequency'])
                            ->setSize($_POST['size'])
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