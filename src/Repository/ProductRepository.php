<?php
namespace App\Repository;

use App\Document\Product;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use Doctrine\ODM\MongoDB\DocumentManager;

class ProductRepository extends DocumentRepository
{   
    
    
    public function __construct(DocumentManager $dm)
    {
        $dm = $this->dm;
    }
    
    
    
    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return Product
     */
    public function findOneProductById($id)
    {
        return $dm->find(Product::class, $id);
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public function deleteProduct($id)
    {
        $dm->
    }
}