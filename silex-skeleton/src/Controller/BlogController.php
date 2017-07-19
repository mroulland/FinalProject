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
        $categories = $this->app['category.repository']->findAllCategories();
        
        return $this->render(
            'article_list.html.twig',
            [
                'articles'=> $articles,
                'categories' => $categories
            ]
        
        );
    }
    
    public function articleAction($id){
        
        $article = $this->app['article.repository']->findById($id);
        
        return $this->render(
            'article.html.twig',
            ['article' => $article]
        );
    }
    
   /* public function categoriesAction(){
        
        $categories = $this->app['category.repository']->findAll();
        
        return $this->render(
            'categories.twig',
            ['categories' => $categories]
        );
      
    }*/
    
    
    public function categorieAction($id){
        
          
        $category = $this->app['category.repository']->findById($id);
         
        $articles = $this->app['article.repository']->findByCategory($category);
        
        $categories = $this->app['category.repository']->findAllCategories();
        
         
        return $this->render(
            'category.html.twig',
            [
                'category' => $category,
                'articles' => $articles,
                'categories' => $categories
            ]
                 
                 
        );
         
    }


}