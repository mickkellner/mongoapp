<?php
namespace App\Repository;

use App\Document\User;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends DocumentRepository implements UserLoaderInterface
{
    

        
    
    /**
     * Find a User by the UserIdentifier of the Class
     */
    public function loadUserByIdentifier(string $email): ?UserInterface
    {
       $user = $dm->createQueryBuilder(User::class)
            ->field('email')->equals($email)
            ->getQuery()
            ->execute();
        return $user;
    }


}