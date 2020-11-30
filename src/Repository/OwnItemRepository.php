<?php

namespace App\Repository;

use App\Entity\OwnItem;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OwnItemRepository extends AbstractRepository
{
    /**
     * BindCharacteristicRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, OwnItem::class, $validator);
    }
}
