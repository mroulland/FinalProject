<?php

namespace Entity;

class Category{
    /**
    * 
    * @var int
    */
    
    private $id_category;
    
    
    /**
    * 
    * @var string
    */
    
    private $category_name;
    
    /**
    * 
    * @return int
    */
    public function getIdCategory() {
        return $this->id_category;
    }
    
    /**
    * 
    * @return string
    */

    public function getCategoryName() {
        return $this->category_name;
    }
    
    /**
    * 
    * @param int $id
    * @return $this
    */

    public function setIdCategory($id_category) {
        $this->id_category = $id_category;
        return $this;
    }
    
    /**
    * 
    * @param string $name
    * @return $this
    */

    public function setCategoryName($category_name) {
        $this->category_name = $category_name;
        return $this;
    }


}