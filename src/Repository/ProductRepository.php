<?php
namespace App\Repository;

use App\Document\Product;
//use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
//use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;

class ProductRepository extends ServiceDocumentRepository
{   
    
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
    
    
    
    /** find a Product by the Id */
    public function findOneProductById(string $id)
    {
        return $this->dm->find(Product::class, $id);
    }

    /** delete a Product by it's id */
    public function deleteProduct(string $id)
    {
        $product = $this->dm->find(Product::class, $id);
        $this->dm->remove($product);
    }
}