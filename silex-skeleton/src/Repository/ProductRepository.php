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
        DESC
EOS;

    $dbProducts = $this -> db -> fetchAll($query);
    $products = [];

    foreach ($dbProducts as $dbProduct){
        $products = $this->buildProductsFromArray($dbProducts);
        $products[] = $products;
    }
    return $products;

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
          WHERE id_product=?
EOS;

    $dbRow = $this -> db -> fetchAssoc(
        $query,
        [':id_product' => $id]
        );

        $product = $this->buildArticleFromArray($dbRow);

        return $product;
      }



    protected function BuildProductFromArray(array $dbProduct){
        $product = new Product();
        $product->setIdProduct($product['id_product']);
        $product->setProductName($product['product_name']);
        $product->setDescription($product['description']);
        $product->setPhoto($product['photo']);
        $product->setPrice($product['price']);
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