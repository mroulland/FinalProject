<?php

namespace Repository;

use Doctrine\DBAL\Connection;
use Entity\Category;
use Repository\ArticleRepository;

class CategoryRepository extends RepositoryAbstract{


    public function findAllCategories(){

        $dbCategories = $this->db-> fetchAll('SELECT * FROM category');
        $categories = [];
        
        
        foreach ($dbCategories as $dbCategory) {

            $category = $this->buildCategoryFromArray($dbCategory);
            $categories[] = $category;
        }
              
        return $categories;
        
        
    }
    
    /*public function findAllArticles(){

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
        
    }*/

    public function findById($id_category){
        $dbCategory = $this -> db -> fetchAssoc(
            'SELECT * FROM category WHERE id_category =:id_category',
            [
                ':id_category' => $id_category
            ]
        );

         $category = new Category();
         $category 
            ->setIdCategory($dbCategory['id_category'])
            ->setCategoryName($dbCategory['category_name'])
        ;
        
        return $category;
    }

    public function insert(Category $category){
        
        $this->db->insert(
            'category',
            ['category_name' => $category->getCategoryName()] // valeurs
        );
    }

    public function update(Category $category){
        
        
         $this->db->update(
            'category', // nom de la table
            ['category_name' => $category->getCategoryName()], //valeurs
            ['id_category' => $category->getIdCategory()] // clause WHERE
        );
        
    }
    
    
    public function save(Category $category){
        
        if(!empty($category->getIdCategory())) {
            $this->update($category);
        }else{
            $this->insert($category);
        }
        
    }
    
    public function delete(Category $category ){
        
        $this-> db->delete('category',
                ['id_category'=> $category->getIdCategory()]
        
        );
        
    }
    
    protected function buildCategoryFromArray(array $dbCategory){
        $category = new Category();
        $category
            ->setIdCategory($dbCategory['id_category'])
            ->setCategoryName($dbCategory['category_name'])
        ;
        return $category;
    }
}


