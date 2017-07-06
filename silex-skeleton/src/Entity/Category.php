<?php

namespace Entity;

class Category{
    /**
    * 
    * @var int
    */
    
    private $id;
    
    
    /**
    * 
    * @var string
    */
    
    private $category_name;
    
    /**
    * 
    * @return int
    */
    public function getId() {
        return $this->id;
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

    public function setId($id) {
        $this->id = $id;
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