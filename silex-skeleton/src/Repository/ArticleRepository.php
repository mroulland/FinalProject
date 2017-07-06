<?php

namespace Repository;

use Entity\Article;
use Entity\Category;
use Repository\CategoryRepository;


class ArticleRepository extends RepositoryAbstract{

    public function findAll(){

        $query = <<<EOS
            SELECT a.*, c.category_name 
            FROM article a 
            JOIN category c ON a.id_category = c.id


EOS;

        $dbArticles = $this -> db -> fetchAll($query);
        $articles = [];
        
        foreach ($dbArticles as $dbArticle) {
            $article = $this->buildArticleFromArray($dbArticle);
            $articles[] = $article;          
        }      
        return $articles;
    }

    
    public function findById($id){

        $query = <<<EOS
            SELECT a.*, c.category_name 
            FROM article a 
            JOIN category c ON a.id_category = c.id
            WHERE a.id = :id
EOS;
        $dbArticle = $this -> db -> fetchAssoc(
            $query,
            [':id' => $id]
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
        $article->setId($this->db->lastInsertId());  
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
                    ['id' => $article->getId()]
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
            [':id' => $category->getId()]
        );
    
        $articles = [];
        
        foreach ($dbArticles as $dbArticle){
            $article = $this->buildArticleFromArray($dbArticle);
            
            $articles[] = $article;
        }
        
        return $articles;
    }

    public function save(Article $article){
        
        if(!empty($article->getId())) {
            $this->update($article);
        }else{
            $this->insert($article);
        }
        
    }
    
    public function delete(Article $article ){
        
        $this-> db->delete('article',
                ['id'=> $article->getId()]
        
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
                ->setId($dbArticle['id_category'])     
                ->setCategoryName($dbArticle['category_name'])
            ;
            
            $article = new Article(); // $article est un objet instance de la classe Entity article
            $article
                ->setId($dbArticle['id'])
                ->setTitle($dbArticle['title'])
                ->setContent($dbArticle['content'])
                ->setShortContent($dbArticle['short_content'])
                ->setPicture($dbArticle['picture'])
                ->setCategory($category)
            ;
            
            return $article;
    }

}