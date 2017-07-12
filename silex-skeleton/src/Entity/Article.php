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
    private $content1;

    /**
    * 
    * @var string
    */
    private $content2;

    /**
    * 
    * @var string
    */
    private $quote;

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
     * @var string 
     * 
     */
    private $date;
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

    public function getContent1() {
        return $this->content1;
    }

    
    public function getContent2() {
        return $this->content2;
    }

    public function getQuote() {
        return $this->quote;
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
    
    public function getDate() {
        return $this->date;
    }
    


    public function setIdArticle($id_article) {
        $this->id_article = $id_article;
        return $this;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setContent1($content1) {
        $this->content1 = $content1;
        return $this;
    }

    public function setContent2($content2) {
        $this->content2 = $content2;
        return $this;
    }

    public function setQuote($quote) {
        $this->quote = $quote;
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

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }
    

}