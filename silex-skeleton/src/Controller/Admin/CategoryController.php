<?php

namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\Category;

class CategoryController extends ControllerAbstract{

    public function listAction(){

        $categories = $this->app['category.repository']->findAll();
        
        return $this->render(
            'admin/category/list.html.twig',
            ['categories' => $categories]
        );
    }

    public function editAction(){

        if(!is_null($id)){
            
            $category = $this->app['category.repository']->find($id);
            
        }else{
            $category = new Category();
        }
        if (!empty($_POST)){
            $category->setName($_POST['name']);
            
            $this->app['category.repository']->save($category); 
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