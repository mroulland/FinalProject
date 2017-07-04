<?php

namespace Controller\Admin;

//revoir les uses
use Controller\ControllerAbstract;
use Entity\Article;
use Entity\Category;


class ArticleController extends ControllerAbstract{

    public function listAction(){

        $articles = $this->app['article.repository']->findAll();
        
        return $this->render(
            'admin/article/list.html.twig',
            ['articles' => $articles]
        );
    }

    //Modifier article:
    public function editAction($id_article=null){

        $categories = $this->app['category.repository']->findAll();
        
        if(!is_null($id_article)){
            
            $article = $this->app['article.repository']->find($id_article);
            
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
            
            $article ->getCategory()->setIdCategory($_POST['category']);
            ;
                 
            $this->app['article.repository']->save($article); // save vérifie que l'id existe, si non => insert, si oui => update
            $this->addflashMessage('L\'article est enregistré');
            return $this->redirectRoute('admin_article');
        }
                
        return $this->render(
            'admin/article/edit.html.twig',
            [
                'article' => $article,              
                'categories' => $categories,
            ]
        );
    }



    //Suppresion Article
    public function deleteAction($id_article){

        $article = $this->app['article.repository']->find($id_article);
        
        $this->app['article.repository']->delete($article);
        $this->addflashMessage('L\'article est supprimé');
        
        return $this->redirectRoute('admin_article');
    }

}