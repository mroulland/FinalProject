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

    public function editAction($id){

        $category = $this->app['category.repository']->findById($id);
            
        if (!empty($_POST)){
            
            $category->setCategoryName($_POST['category_name']);
            
            $this->app['category.repository']->update($category); 
            $this->addflashMessage('La rubrique est enregistrée');
            return $this->redirectRoute('admin_categories');
        }
                
        return $this->render(
                'admin/category/edit.html.twig',
                ['category' => $category]
        );
    }

    public function deleteAction($id){
        
         $category = $this->app['category.repository']->find($id);
        
        $this->app['category.repository']->delete($category);
        $this->addflashMessage('La rubrique est supprimée');
        
        return $this->redirectRoute('admin_categories');
    }
}