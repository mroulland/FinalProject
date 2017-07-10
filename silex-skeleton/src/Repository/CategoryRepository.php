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

    public function findById($id){
        $dbCategory = $this -> db -> fetchAssoc(
            'SELECT * FROM category WHERE id_category =:id',
            [
                ':id' => $id
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
    
    public function delete(Category $category ){
        
        $this-> db->delete('category',
                ['id'=> $category->getIdCategory()]
        
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


