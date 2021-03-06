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
    protected $id;    
    
    /** 
     * @MongoDB\Field(type="string")
    */
    protected $email;

    /** @MongoDB\Field(type="collection") */
    protected $roles = [];

    /** @MongoDB\Field(type="string") */
    protected $password;

    /** @MongoDB\Field(type="string") */
    protected $company;

    /**
     * @MongoDB\ReferenceMany(targetDocument=Product::class, orphanRemoval=true, cascade={"all"})
     */
    protected $products = [];


    /**
     * @MongoDB\EmbedOne(targetDocument=Profile::class) 
     */
    private $profile;


    public function __construct()
    {
        $this->products = new ArrayCollection();        
    }

    /** Add additional profile data to the user is optional */
    public function setProfile(Profile $profile): self
    {
        $this->profile = $profile;
        return $this; 
    }


    public function getProfile(): Profile {return $this->profile; }

    
    /** Add a Product to the Products ArrayCollection */
    public function addProduct(Product $product): void
    {
        if(!$this->products->contains($product) )
        {
            $this->products->add($product);
        }   
    }

    /** Remove a Product from the ArrayCollection */
    public function removeProduct(Product $product): void
    {
        if($this->products->contains($product))
        {
            $this->products->removeElement($product);
        }
    }
    
    /** Get all the products related to the User as an Array */
    public function getProducts(): Array
    {
        return $this->products->toArray();
    }


    /** Find a product by it's id */
    public function getProductById(string $productId): Product    
    {

        foreach($this->getProducts() as $product)
        {
            if($productId == $product->getId() )
            {
                return $product;
            }
        }
    }

   
    public function setCompany(string $companyName): self { $this->company = $companyName; return $this; }

    public function getCompany(): ?string { return $this->company; }

    public function setId($id): self { $this->id = $id; return $this; }
    
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
     * @return string password
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
