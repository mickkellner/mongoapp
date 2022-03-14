<?php
namespace App\Repository;

use App\Document\User;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;

class UserRepository extends ServiceDocumentRepository implements UserLoaderInterface
{
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

        
    
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