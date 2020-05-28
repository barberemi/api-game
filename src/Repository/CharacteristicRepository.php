<?php

namespace App\Repository;

use App\Entity\Characteristic;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CharacteristicRepository extends AbstractRepository
{
    /**
     * CharacteristicRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Characteristic::class, $validator);
    }
}
