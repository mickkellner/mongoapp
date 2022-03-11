<?php
namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** 
 * @MongoDB\Document(db="myapp", collection="products", repositoryClass="App\Repository\ProductRepository") 
 * 
*/
class Product 
{
    /** @MongoDB\Id */
    protected $id;

    /** @MongoDB\Field(type="string") */
    protected $name;

    /** @MongoDB\Field(type="string") */
    protected $cover;

    /** @MongoDB\Field(type="float") */
    protected $price;

    
    public function setId($id): self { $this->id = $id; return $this;}

    public function getId() { return $this->id; }


    public function setName($name): self {$this->name = $name; return $this; }


    public function getName(): ?string { return $this->name; }
    
    public function setCover(string $cover): self  {$this->cover = $cover; return $this; }

    public function getCover(): ?string { return $this->cover; }

    public function setPrice(float $price): self {$this->price = $price; return $this; }

    public function getPrice(): ?float {return $this->price; }

    


}