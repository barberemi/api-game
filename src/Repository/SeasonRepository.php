<?php

namespace App\Repository;

use App\Entity\Season;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SeasonRepository extends AbstractRepository
{
    /**
     * SeasonRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Season::class, $validator);
    }
}
