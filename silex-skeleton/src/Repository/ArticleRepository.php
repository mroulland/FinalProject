<?php

namespace Repository;

use Entity\Article;
use Entity\Category;


class ArticleRepository extends RepositoryAbstract{

    public function findAll(){

        $query = <<<EOS
            SELECT a.*, c.category_name 
            FROM article a 
            JOIN category c ON a.category_id = c.id_category
EOS;

        $dbArticles = $this -> db -> fetchAll($query);
        $articles = [];
        
        foreach ($dbArticles as $dbArticle) {
            $article = $this->buildArticleFromArray($dbArticle);
            $articles[] = $article;          
        }      
        return $articles;
    }

    
    public function findById($id_article){

        $query = <<<EOS
            SELECT a.*, c.category_name 
            FROM article a 
            JOIN category c ON a.category_id = c.id_category
            WHERE a.id_article = :id_article
EOS;
        $dbArticle = $this -> db -> fetchAssoc(
            $query,
            [':id_article' => $id_article]
        );

        $article = $this->buildArticleFromArray($dbArticle);
          
        return $article;

    }

    public function insert(Article $article){

        $this->db->insert(
            'article',
            [
                'title' => $article->getTitle(),
                'content' => $article->getContent(),
                'short_content' => $article->getShortContent(),
                'picture' => $article->getPicture(),
                'category_id' => $article->getCategoryId(),
            ]
        );
    }

    public function update(Article $article){
        $this->db->update(
            'article',
            [
                'short_content' => $article->getShortContent(),
                'content' => $article->getContent(), //valeurs
                'title' => $article->getTitle(), //valeurs 
                'picture' =>$article->getPicture(),
                'category_id' => $article->getCategoryId(),  
            ],

            ['id_article' => $article->getIdArticle()]
        );
    }

    public function findByCategory(Category $category){

        $query = <<<EOS
            SELECT a.*, c.category_name 
            FROM article a 
            JOIN category c 
            ON a.category_id = c.id
            WHERE c.id = :id
EOS;

        $dbArticles = $this -> db -> fetchAll(
            $query,
            [':id_category' => $category->getIdCategory()]
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
                ['id_article'=> $article->getIdArticle()]
        
        );
        
    }
    /**
     * 
     * @param array $dbArticle
     * @return Article
     */
    private function buildArticleFromArray(array $dbArticle){
        $category = new Category();
            $category
                ->setIdCategory($dbArticle['category_id'])     
                ->setCategoryName($dbArticle['category_name'])
            ;
            
            $article = new Article(); // $article est un objet instance de la classe Entity article
            $article
                ->setIdArticle($dbArticle['id_article'])
                ->setTitle($dbArticle['title'])
                ->setContent($dbArticle['content'])
                ->setShortContent($dbArticle['short_content'])
                ->setPicture($dbArticle['picture'])
                ->setCategory($category)
            ;
            
            return $article;
    }

}