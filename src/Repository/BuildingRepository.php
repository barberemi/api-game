<?php

namespace App\Repository;

use App\Entity\Building;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BuildingRepository extends AbstractRepository
{
    /**
     * BuildingRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Building::class, $validator);
    }
}
