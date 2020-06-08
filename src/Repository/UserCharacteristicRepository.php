<?php

namespace App\Repository;

use App\Entity\UserCharacteristic;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserCharacteristicRepository extends AbstractRepository
{
    /**
     * UserCharacteristicRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, UserCharacteristic::class, $validator);
    }
}
