<?php

namespace App\Repository;

use App\Entity\Academy;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AcademyRepository extends AbstractRepository
{
    /**
     * AcademyRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Academy::class, $validator);
    }
}
