<?php

namespace App\Repository;

use App\Entity\BindCharacteristic;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BindCharacteristicRepository extends AbstractRepository
{
    /**
     * BindCharacteristicRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, BindCharacteristic::class, $validator);
    }
}
