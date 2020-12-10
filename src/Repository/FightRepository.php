<?php

namespace App\Repository;

use App\Entity\Fight;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FightRepository extends AbstractRepository
{
    /**
     * FightRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Fight::class, $validator);
    }
}
