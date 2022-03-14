<?php
namespace App\Repository;

use App\Document\Profile;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;


class ProfileRepository extends DocumentRepository
{
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    
}