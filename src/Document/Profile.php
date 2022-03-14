<?php
namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** 
 * @MongoDB\EmbeddedDocument 
 * 
*/
class Profile {

      
    
    /** @MongoDB\Field(type="string") */    
    private $firstname;

    /** @MongoDB\Field(type="string") */ 
    private $lastname;

    /** @MongoDB\Field(type="string") */ 
    private $second_email;


    public function setProfileId($id): self { $this->id = $id; return $this; }

    public function setFirstname($firstname): self { $this->firstname = $firstname; return $this; }


    public function setLastname($lastname): self { $this->lastname = $lastname; return $this; }


    public function setSecondEmail($second_email): self { $this->second_email = $second_email; return $this; }

    public function getProfileId(): string { return $this->id; }
    
    public function getFirstname(): string { return $this->firstname; }

    public function getLastname(): string { return $this->lastname; }

    public function getSecondEmail(): string { return $this->second_email; }

    public function getProfile(): Profile { return $this;}

}