<?php
namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** 
 * @MongoDB\EmbeddedDocument() 
 * 
*/
class Profile 
{

      
    
    /** @MongoDB\Field(type="string") */    
    private $firstname;

    /** @MongoDB\Field(type="string") */ 
    private $lastname;

    /** @MongoDB\Field(type="string") */ 
    private $second_email;

        
   

    public function setFirstname($firstname): ?self { $this->firstname = $firstname; return $this; }


    public function setLastname($lastname): ?self { $this->lastname = $lastname; return $this; }


    public function setSecondEmail($secondEmail): ?self { $this->second_email = $secondEmail; return $this; }

   
    public function getFirstname(): string { return $this->firstname; }

    public function getLastname(): string { return $this->lastname; }

    public function getSecondEmail(): string { return $this->second_email; }


    
}