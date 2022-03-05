<?php

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\HttpKernel\DependencyInjection\RemoveEmptyControllerArgumentLocatorsPass;

/**
 * @MongoDB\Document(db="myapp", collection="users", repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    
    /** @MongoDB\Id */
    private $id;    
    
    /** 
     * @MongoDB\Field(type="string")
    */
    private $email;

    /** @MongoDB\Field(type="collection") */
    private $roles = [];

    /** @MongoDB\Field(type="string") */
    private $password;

    /** @MongoDB\Field(type="string") */
    private $company;

    /**
     * @MongoDB\ReferenceMany(targetDocument=Product::class, orphanRemoval=true, cascade={"all"})
     */
    private $products = [];


    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * Undocumented function
     *
     * @param Product $product
     * @return void
     */
    public function addProduct(Product $product): void
    {
        $this->products->add($product);        
    }

    
    public function removeProduct(Product $product): void
    {
        $this->products->removeElement($product);
        
    }
    
    /**
     * Undocumented function
     *
     * @return Product
     */
    public function getProducts(): Array
    {
        return $this->products->toArray();
    }


    public function getProductById($id): Product
    {
        foreach($this->products as $product)
        {
            if($id == $product->getId() )
            {
                return $product;
            }
        }
    }

   
    public function setCompany(string $companyName): self { $this->company = $companyName; return $this; }

    public function getCompany(): ?string { return $this->company; }

    public function getId(): ?string { return $this->id; }

    public function getEmail(): ?string { return $this->email; }

    public function setEmail(string $email): self { $this->email = $email; return $this; }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string { return (string) $this->email; }


    /**
     * Undocumented function
     *
     * @return string
     */
    public function getUsername(): string { return $this->email; }

    /**
     * @see UserInterface
     */
    public function getRoles(): array { $roles = $this->roles; return array_unique($roles); }

    public function setRoles(string $role): self { $this->roles[] = $role; return $this; }

    /**
     * @see PasswordAuthenticatedUserInterface
     * @return the hashed password as a string
     */
    public function getPassword(): string { return $this->password; }

    /** Set and hash a plain password for the user */
    public function setPassword(string $password): self 
    { 
        $this->password = $password; return $this; 
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials() { }



}
