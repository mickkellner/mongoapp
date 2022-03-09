<?php
namespace App\Repository;

use App\Document\User;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\UnitOfWork;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRepository extends DocumentRepository implements UserLoaderInterface
{
    
        
    
    /**
     * Find a User by the UserIdentifier of the Class
     */
    public function loadUserByIdentifier(string $email): ?UserInterface
    {
       $user = $this->dm->createQueryBuilder(User::class)
            ->field('email')->equals($email)
            ->getQuery()
            ->execute();
        return $user;
    }


}