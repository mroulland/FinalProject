<?php

namespace Controller\Admin;

//revoir les uses
use Controller\ControllerAbstract;
use Entity\Article;
use Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;


class ArticleController extends ControllerAbstract{

    public function listAction(){

        $articles = $this->app['article.repository']->findAllArticles();
        
        return $this->render(
            'admin/article/list.html.twig',
            ['articles' => $articles]
                
               
        );
    }

    //Modifier article:
    public function editAction($id){

        $article = $this->app['article.repository']->findById($id);
        $categories = $this->app['category.repository']->findAllCategories();
        

        if (!empty($_POST)){
            $article
                ->setTitle($_POST['title'])
                ->setContent1($_POST['content1'])
                ->setContent2($_POST['content2'])
                ->setQuote($_POST['quote'])
                ->setShortContent($_POST['short_content'])
                ->setPicture($_POST['picture'])
                ->setIdCategory($_POST['id_category']);

                 
            $this->app['article.repository']->update($article); 
            $this->addflashMessage('L\'article a bien été enregistré');
            return $this->redirectRoute('admin_articles');
        }
        

        return $this->render(
            'admin/article/edit.html.twig',
            [
                'article' => $article,              
                'categories' => $categories
            ]
        );
    }


    // Ajout d'un article par les admin:
    public function registerAction(){

        $article = new Article();
        $categories = $this->app['category.repository']->findAllCategories();
        $errors = [];

        if(!empty($_POST)){

             if (!$this->validate($_POST['title'], new Assert\NotBlank())){ 
               $errors['title'] = 'Vous devez donner un titre à l\'article';
            }   

            if (!$this->validate($_POST['content1'], new Assert\NotBlank())){ 
                $errors['content1'] = 'N\'oubliez pas le contenu!';
            }  

            /*if (!$this->validate($_POST['content2'], new Assert\NotBlank())){ 
                $errors['content2'] = 'N\'oubliez pas le contenu!';
            }  

            if (!$this->validate($_POST['quote'], new Assert\NotBlank())){ 
                $errors['quote'] = 'N\'oubliez pas la citation!';
            } */ 

            if (!$this->validate($_POST['short_content'], new Assert\NotBlank())){ 
                $errors['short_content'] = 'N\'oubliez pas d\'écrire un résumé!';
            }  

            if (!$this->validate($_POST['picture'], new Assert\NotBlank())){ 
                $errors['photo'] = 'N\'oubliez pas d\'ajouter une photo!';
            }

            if (!$this->validate($_POST['id_category'], new Assert\NotBlank())){ 
                $errors['id_category'] = 'N\'oubliez pas de choisir une rubrique !';
            }

            if(empty($errors)){

                $article
                    ->setTitle($_POST['title'])
                    ->setContent1($_POST['content1'])
                    ->setContent2($_POST['content2'])
                    ->setQuote($_POST['quote'])
                    ->setShortContent($_POST['short_content'])
                    ->setPicture($_POST['picture'])
                    ->setIdCategory($_POST['id_category'])
                    ->setDate(date('Y/m/d', time()))
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
            return $this->render('admin/article/ajout.html.twig',
                [
                    'article' => $article,              
                    'categories' => $categories
                ]
            );

    }

    //Suppresion Article
    public function deleteAction($id){

        $article = $this->app['article.repository']->findById($id);
        
        $this->app['article.repository']->delete($article);
        $this->addflashMessage('L\'article a bien été supprimé');
        
        return $this->redirectRoute('admin_articles');
    }

}