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
        Select *
        FROM products
        ORDER BY product_id
        DESC
EOS;

    $dbProducts = $this -> db -> fetchAll($query);
    $products = [];

    foreach ($dbProducts as $dbProduct){
        $products = $this->buildProductsFromArray($dbProducts);
        $products[] = $product;
    }
    return $product;

}
    /**
     * Retourne le produit qui matche avec l'ID
     *
     *@param int $product_id
     *
     */
      public function find($product_id) {
          $query = <<<EOS
          SELECT *
          FROM product
          WHERE product_id=?
EOS;

$dbRow = $this -> db -> fetchAll($query);


protected function BuildProductFromArray(array $dbProduct){
    $product = new Product();
    $product->setIdProduct($product['product_id']);
    $product->setProductName($product['product_name']);
    $product->setDescription($product['description']);
    $product->setPhoto($product['photo']);
    $product->setPrice($product['price']);
}

}