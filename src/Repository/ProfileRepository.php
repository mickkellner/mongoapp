<?php
namespace App\Repository;

use App\Document\Profile;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;


class ProfileRepository extends ServiceDocumentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
       parent::__construct($registry, Profile::class);
    }

    
}