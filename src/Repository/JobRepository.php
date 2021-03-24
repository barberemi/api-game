<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class JobRepository extends AbstractRepository
{
    /**
     * JobRepository constructor.
     *
     * @param ManagerRegistry    $registry
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Job::class, $validator);
    }
}
