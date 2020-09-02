<?php

namespace App\Repository;

use App\Entity\BindCharacteristic;
use App\Entity\Monster;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MonsterRepository extends AbstractRepository
{
    /**
     * MonsterRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Monster::class, $validator);
    }
}
