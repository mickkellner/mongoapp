<?php
namespace App\Repository;

use App\Document\Product;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use Doctrine\ODM\MongoDB\DocumentManager;

class ProductRepository extends DocumentRepository
{   
    
    
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
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