<?php

namespace Entity;

class Article{

     /**
    * 
    * @var int
    */
    
    private $id;
    /**
    * 
    * @var string
    */

    private $title;
    /**
    * 
    * @var string
    */
    private $content;

    /**
    * 
    * @var string
    */
    private $shortContent;

    /**
    * 
    * @var string
    */
    private $picture;
    


    
    /**
    * 
    * @var Category
    */
    private $category;

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getShortContent() {
        return $this->shortContent;
         
    }

    public function getPicture() {
        return $this->picture;
         
    }



    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function setShortContent($shortContent) {
        $this->shortContent = $shortContent;
        return $this;
    }

    public function setPicture($picture){
        $this->picture = $picture;
        return $this;
    }
    
    public function getCategory() {
        return $this->category;
    }

    public function setCategory(Category $category) {
        $this->category = $category;
        return $this;
    }
    
    /**
     * 
     * @return int|null
     */
    public function getCategoryId() {
        
        if(!is_null($this->category)){
            return $this->category->getId();
        }
        
        return null;
    }
    
    /**
     * 
     * @return string
     */
    public function getCategoryName() {
        
        if(!is_null($this->category)){
            return $this->category->getName();
        }
        
        return '';
    }




















}