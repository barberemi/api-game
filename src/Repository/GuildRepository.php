<?php

namespace App\Repository;

use App\Entity\Guild;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GuildRepository extends AbstractRepository
{
    /**
     * GuildRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Guild::class, $validator);
    }
}
