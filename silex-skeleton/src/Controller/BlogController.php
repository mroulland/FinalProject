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
        
        $articles = $this->app['article.repository']->findAllArticles();
    
        return $this->render(
            'article_list.html.twig',
            ['articles'=> $articles]
        
        );
    }



}