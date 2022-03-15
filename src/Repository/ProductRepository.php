<?php
namespace App\Repository;

use App\Document\Product;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use Doctrine\ODM\MongoDB\DocumentManager;


class ProductRepository extends DocumentRepository
{   
    
    
      
    /** find a Product by the Id */
    public function findOneProductById(string $id)
    {
        return $dm->find(Product::class, $id);
    }

    /** delete a Product by it's id */
    public function deleteProduct(string $id)
    {
        $product = $dm->find(Product::class, $id);
        $dm->remove($product);
    }
}