<?php

namespace Repository;

use Entity\Article;
use Entity\Category;
use Repository\CategoryRepository;


class ArticleRepository extends RepositoryAbstract{

    public function findAllArticles(){

        $dbArticles = $this -> db -> fetchAll('
            SELECT * 
            FROM article a 
            LEFT JOIN category c 
            ON a.id_category = c.id_category
            ORDER BY date
        ');
        
        $articles = [];

        foreach ($dbArticles as $dbArticle) {
         
           $articles[] = $dbArticle;          
        }      

        return $articles;
        
    }

    
    public function findById($id_article){

        $query = <<<EOS
            SELECT *
            FROM article 
            WHERE id_article = :id
EOS;
        $dbArticle = $this -> db -> fetchAssoc(
            $query,
            [':id' => $id_article]
        );
        
        $article = $this->buildArticleFromArray($dbArticle);   
        
        return $article;

    }

    public function insert(Article $article){

        
          $data= [
                'title' => $article->getTitle(),
                'content' => $article->getContent(),
                'short_content' => $article->getShortContent(),
                'picture' => $article->getPicture(),
                'id_category' => $article->getIdCategory(),
            ];

            $this->db->insert(
            'article',
            $data
        );
        $article->setIdArticle($this->db->lastInsertId());  
    }

    public function update(Article $article){
        
           $data = [
                'short_content' => $article->getShortContent(),
                'content' => $article->getContent(),
                'title' => $article->getTitle(),  
                'id_category' => $article->getIdCategory(),  
            ];

             if(!empty($_POST['picture'])){
            $data = ['picture' => $article->getPicture()];
        }

            $this->db->update(
                'article',
                $data,
                    ['id_article' => $article->getIdArticle()]
        );
    }

    public function findByCategory(Category $category){

        $query = <<<EOS
            SELECT a.*, c.category_name 
            FROM article a 
            JOIN category c 
            ON a.id_category = c.id
            WHERE c.id = :id
EOS;


        $dbArticles = $this -> db -> fetchAll(
            $query,
            [':id' => $category->getIdArticle()]
        );
    
        $articles = [];
        
        foreach ($dbArticles as $dbArticle){
            $article = $this->buildArticleFromArray($dbArticle);
            
            $articles[] = $article;
        }
        
        return $articles;
    }

    public function save(Article $article){
        
        if(!empty($article->getIdArticle())) {
            $this->update($article);
        }else{
            $this->insert($article);
        }
        
    }
    
    public function delete(Article $article ){
        
        $this-> db->delete('article',
                ['id'=> $article->getIdArticle()]
        
        );
        
    }
    /**
     * 
     * @param array $dbArticle
     * @return Article
     */
    private function buildArticleFromArray(array $dbArticle){
    
        $article = new Article(); // $article est un objet instance de la classe Entity article
        $article                
            ->setIdArticle($dbArticle['id_article'])
            ->setTitle($dbArticle['title'])
            ->setContent($dbArticle['content'])
            ->setShortContent($dbArticle['short_content'])
            ->setPicture($dbArticle['picture'])
            ->setIdCategory($dbArticle['id_category'])
        ;


        return $article;
    }

}