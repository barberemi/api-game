<?php

namespace App\Repository;

use App\Entity\Construction;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConstructionRepository extends AbstractRepository
{
    /**
     * ConstructionRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Construction::class, $validator);
    }
}
