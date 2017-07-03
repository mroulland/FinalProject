<?php

namespace Repository;

use Doctrine\DBAL\Connection;
use Entity\Category;

class CategoryRepository extends RepositoryAbstract{


    public function findAll(){

        $dbCategories = $this -> db -> fetchAll('SELECT * FROM category');
        $categories = [];
        
        foreach ($dbCategories as $dbCategory) {
            $category = new Category(); 
            $category
                ->setId($dbCategory['id'])
                ->setName($dbCategory['name'])
            ;
            
            $categories[] = $category;
           
        }
        
        return $categories;
    }

    public function find($id){
        $dbCategory = $this -> db -> fetchAssoc(
            'SELECT * FROM category id=:id',
            [
                ':id' => $id
            ]
        );

         $category = new Category();
         $category 
            ->setId($dbCategory['id'])
            ->setName($dbCategory['name'])
        ;
        
        return $category;
    }

    public function insert(Category $category){
        
        $this->db->insert(
            'category',
            ['name' => $category->getName()] // valeurs
        );
    }

    public function update(Category $category){
         $this->db->update(
            'category', // nom de la table
            ['name' => $category->getName()], //valeurs
            ['id' => $category->getId()] // clause WHERE
        );
        
    }

     public function save(Category $category){
        
        if(!empty($category->getId())) {
            $this->update($category);
        }else{
            $this->insert($category);
        }
        
    }
    
    public function delete(Category $category ){
        
        $this-> db->delete('category',
                ['id'=> $category->getId()]
        
        );
        
    }
   
}


