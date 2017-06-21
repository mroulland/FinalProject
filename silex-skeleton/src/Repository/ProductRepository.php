<?php

namespace Repository;

use  Entity\Product;
use Entity\User;


class ProductRepository extends RepositoryAbstract{

    /**
     * Retroure la lsite des produits, classé par ordre d'ID
     *
     */

    public function findAllProducts(){
        $query = <<<EOS
        SELECT *
        FROM product
        ORDER BY id_product
EOS;

    $dbProducts = $this -> db -> fetchAll($query);
    $products = [];

    foreach ($dbProducts as $dbProduct){
        $product = $this->buildProductFromArray($dbProduct);
        $products[] = $product;
    }
    
    return $products;
    // Retourne un tableau de produits

}

    /**
     * Retourne le produit qui matche avec l'ID
     *
     *@param int $product_id
     *
     */
    public function find($id_product) {
        $query = <<<EOS
        SELECT *
        FROM product
        WHERE id_product= :id_product
EOS;

    $dbProduct = $this -> db -> fetchAssoc(
            $query,
            [':id_product' => $id_product]
        );
        
        $product = $this->buildProductFromArray($dbProduct);
               
        return $product;
      }



    protected function buildProductFromArray(array $dbProduct){
        $product = new Product();
        $product->setIdProduct($dbProduct['id_product']);
        $product->setProductName($dbProduct['product_name']);
        $product->setDescription($dbProduct['description']);
        $product->setPhoto($dbProduct['photo']);
        $product->setSize($dbProduct['size']);
        $product->setFrequency($dbProduct['frequency']);
        $product->setPrice($dbProduct['price']);
        
        return $product;
    }
    
    public function update(Product $product){ 
        
        $data = [ 
                'product_name' => $product->getProductName(),// valeurs dans la BDD
                'description' => $product->getDescription(),               
                'price' => $product->getPrice(),
                'size' => $product->getSize(),
                'frequency' => $product->getFrequency()           
        ];
        
        if(!empty($_POST['photo'])){
                    $user->setPassword($this->app['user.manager']->encodePassword($_POST['password']));
                    $data = ['photo' => $product->getPhoto()];
                }
        
        $this->db->update(
            'product', // Nom de la table dans laquelle les modifications sont effectuées
            $data, 
                ['id_product' => $product->getIdProduct()] // clause WHERE
        );
        
       
    }
    
    
    public function findChoosenProduct($size, $frequency){
        // On demande à la fonction de trouver le produit correspondant aux deux valeurs obtenues par le client
        $dbSubscription = $this->db->fetchAssoc(
            'SELECT * FROM product WHERE size = :size AND frequency = :frequency',
            [
                ':size' => $size,
                ':frequency' => $frequency
            ]
        );
        
        //var_dump($dbSubscription);
        // Instanciation d'un nouvel objet produit qui correspondra à celui choisi par l'utilisateur
        $product = new Product;
        
        // Initialisation des valeurs dans l'objet product
        $product->setIdProduct($dbSubscription['id_product']);
        $product->setProductName($dbSubscription['product_name']);
        $product->setDescription($dbSubscription['description']);
        $product->setPhoto($dbSubscription['photo']);
        $product->setPrice($dbSubscription['price']);
        $product->setSize($dbSubscription['size']);
        $product->setFrequency($dbSubscription['frequency']);
        
        var_dump($product);
        
        return $product;

    }

}