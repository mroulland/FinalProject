<?php

namespace Controller\Admin;

//revoir les uses
use Controller\ControllerAbstract;
use Entity\Article;
use Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;


class ArticleController extends ControllerAbstract{

    public function listAction(){

        $articles = $this->app['article.repository']->findAll();
        
        return $this->render(
            'admin/article/list.html.twig',
            ['articles' => $articles]
        );
    }

    //Modifier article:
    public function editAction($id=null){

        $categories = $this->app['category.repository']->findAll();
        
        if(!is_null($id)){
            
            $article = $this->app['article.repository']->findById($id);
            
        }else{
            $article = new Article();
            $article->setCategory(new Category());
        }
        if (!empty($_POST)){
            $article
                ->setTitle($_POST['title'])
                ->setContent($_POST['content'])
                ->setShortContent($_POST['short_content'])
                ->setPicture($_POST['picture']);
            
            $article ->getCategory()->setId($_POST['category']);
            ;
                 
            $this->app['article.repository']->save($article); // save vérifie que l'id existe, si non => insert, si oui => update
            $this->addflashMessage('L\'article a bien été enregistré');
            return $this->redirectRoute('admin_articles');
        }
                
        return $this->render(
            'admin/article/edit.html.twig',
            [
                'article' => $article,              
                'categories' => $categories,
            ]
        );
    }


    // Ajout d'un article par les admin:
    public function registerAction(){

        $article = new Article();
        $errors = [];

        if(!empty($_POST)){

             if (!$this->validate($_POST['title'], new Assert\NotBlank())){ 
               $errors['title'] = 'Vous devez donner un titre à l\'article';
            }   

            if (!$this->validate($_POST['content'], new Assert\NotBlank())){ 
                $errors['content'] = 'N\'oubliez pas le contenu!';
            }  

            if (!$this->validate($_POST['short_content'], new Assert\NotBlank())){ 
                $errors['short_content'] = 'N\'oubliez pas de faire résumé!';
            }  

            if (!$this->validate($_POST['picture'], new Assert\NotBlank())){ 
                $errors['photo'] = 'N\'oubliez pas d\'ajouter une photo!';
            }

            if (!$this->validate($_POST['category'], new Assert\NotBlank())){ 
                $errors['category'] = 'N\'oubliez pas de choisir une rubrique !';
            }

            if(empty($errors)){

                $article
                    ->setTitle($_POST['title'])
                    ->setContent($_POST['content'])
                    ->setShortContent($_POST['short_content'])
                    ->setPicture($_POST['picture'])
                    //PB pour catégorie du coup..
            ;

            $this->app['article.repository']->insert($article);           
            $this->addFlashMessage("L'article a bien été ajouté");
            return $this->redirectRoute('admin_articles');
            
            }else{
                $msg = '<strong>L\'article est incomplet!</strong>'; 
                $msg .= '<br>- ' . implode('</br>- ',$errors);

                $this->addFlashMessage($msg,'error');
            }

        }
            return $this->render('admin/article/ajout.html.twig');

    }

    //Suppresion Article
    public function deleteAction($id){

        $article = $this->app['article.repository']->findById($id);
        
        $this->app['article.repository']->delete($article);
        $this->addflashMessage('L\'article a bien été supprimé');
        
        return $this->redirectRoute('admin_articles');
    }

}