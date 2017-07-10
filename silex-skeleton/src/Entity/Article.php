<?php

namespace Entity;

class Article{

     /**
    * 
    * @var int
    */
    
    private $id_article;
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
    private $id_category;

    
    
    public function getIdArticle() {
        return $this->id_article;
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
    
    public function getIdCategory() {
        return $this->id_category;
    }


    public function setIdArticle($id_article) {
        $this->id_article = $id_article;
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

    public function setIdCategory($id_category) {
        $this->id_category = $id_category;
        return $this;
    }
    

}