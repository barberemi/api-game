<?php

namespace App\Repository;

use App\Entity\MonsterCharacteristic;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MonsterCharacteristicRepository extends AbstractRepository
{
    /**
     * MonsterCharacteristicRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, MonsterCharacteristic::class, $validator);
    }
}
