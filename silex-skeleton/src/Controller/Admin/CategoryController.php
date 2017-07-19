<?php

namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\Category;

class CategoryController extends ControllerAbstract{

    public function listAction(){

        $categories = $this->app['category.repository']->findAllCategories();
        
        return $this->render(
            'admin/category/list.html.twig',
            ['categories' => $categories]
        );
    }

    public function editAction($id){ //Ajouter / Modifier une catégorie
        
        if(!is_null($id)){ // Si la catégorie existe déjà
            
            $category = $this->app['category.repository']->findById($id); // on la trouve par son id
            
        }else{
            $category = new Category(); // sinon une nouvelle est créée
        }
        
        if (!empty($_POST)){ // si le champ est bien rempli
            $category->setCategoryName($_POST['category_name']);
            
            $this->app['category.repository']->save($category); // on peut soit 
            //créer (insert) soit modifier (update) grâce à la fonction SAVE
            $this->addflashMessage('La catégorie est enregistrée');
            return $this->redirectRoute('admin_categories');
        }
        
        if(!is_null($id)){ // Si la catégorie existe déjà
           return $this->render( // Renvoi vers la page de modification
                'admin/category/edit.html.twig',
                ['category' => $category]
            ); 
        }else{ // Sinon renvoi vers la page d'ajout d'une nouvelle catégorie            
            return $this->render(
                'admin/category/ajout.html.twig',
                ['category' => $category]
            );
        }

        /*$category = $this->app['category.repository']->findById($id);
            
        if (!empty($_POST)){
            
            $category->setCategoryName($_POST['category_name']);
            
            $this->app['category.repository']->update($category); 
            $this->addflashMessage('La rubrique est enregistrée');
            return $this->redirectRoute('admin_categories');
        }
                
        return $this->render(
                'admin/category/edit.html.twig',
                ['category' => $category]
        );*/
    }
    
    
    /*public function registerAction(){

        $category = new Category();
        
        if (!empty($_POST)){
        
        $this->app['category.repository']->insert($category);           
            $this->addFlashMessage("La catégorie a bien été ajoutée");
            return $this->redirectRoute('admin_categories');
            
            
        }
            return $this->render('admin/category/ajout.html.twig');

    }*/
            
    
    
    public function deleteAction($id){
        
         $category = $this->app['category.repository']->findById($id);
        
        $this->app['category.repository']->delete($category);
        $this->addflashMessage('La rubrique est supprimée');
        
        return $this->redirectRoute('admin_categories');
    }
}