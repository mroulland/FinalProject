<?php

namespace Controller;

//chécker les use
use Repository\ArticleRepository;
use Repository\CategoryRepository;
use Entity\Article;
use Entity\Category;

class BlogController extends ControllerAbstract{


    //Afficher article
    public function listAction(){
        
        $articles = $this->app['article.repository']->findAll();
    
        return $this->render(
                
            'article_list.html.twig',
            ['articles'=> $articles]
        );
    }


    public function categorieAction($id){
         
        $category = $this->app['category.repository']->find($id);
         
        $articles = $this->app['article.repository']->findByCategory($category);
         
        return $this->render(
            'category.html.twig',
            [
                'category' => $category,
                'article' => $articles,
            ]
                 
                 
        );
         
    }



}